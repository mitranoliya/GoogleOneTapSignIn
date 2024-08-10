<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Google_Client;
use Illuminate\Support\Facades\Log;

class GoogleAuthController extends Controller
{
    public function verifyToken(Request $request)
    {
        try {
            $idToken = $request->input('id_token');

            $client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
            $payload = $client->verifyIdToken($idToken);

            if ($payload) {
                $socialId = $payload['sub'];
                $email = $payload['email'];
                $name = $payload['name'];

                // Find or create the user
                $user = User::updateOrCreate(
                    [
                        'is_social' => true,
                        'social_type' => 1,
                        'social_id' => $socialId
                    ],
                    [
                        'name' => $name,
                        'email' => $email,
                        'password' => Hash::make(Str::random(8)),   // Generate a random password
                        'is_social' => true,
                        'social_type' => 1,     // 1 = Google
                        'social_id' => $socialId,
                        'remember_token' => Str::random(10),
                    ]
                );

                // Log in the user
                Auth::login($user);

                return response()->json(['error' => false, 'message' => 'Authentication Success.', 'redirectUrl' => route('dashboard')], 200);
            } else {
                return response()->json(['error' => true, 'message' => 'Authentication Failed'], 422);
            }
        } catch (Exception $e) {
            Log::emergency($e->getMessage());
            return response()->json(['error' => true, 'message' => 'Something went wrong. Please try later.'], 422);
        }
    }
}
