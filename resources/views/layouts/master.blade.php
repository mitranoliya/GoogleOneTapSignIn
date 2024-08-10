<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- Css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    <!-- Toastr Message -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">

    <!-- Include Google One Tap library -->
    <script src="https://accounts.google.com/gsi/client" async defer></script>

    <!-- Custom Css -->
    @yield('css')
</head>

<body>
    <!-- Loader -->
    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>

    <!-- Load Main Content -->
    @yield('content')

    <!-- Jquery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Toastr Message -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- Script to trigger Google One Tap popup login -->
    <script>
        function showGoogleOneTap() {
            google.accounts.id.initialize({
                client_id: "{{ env('GOOGLE_CLIENT_ID') }}", // Your Google API Client ID
                callback: handleCredentialResponse,
            });

            google.accounts.id.prompt(
                (notification) => {
                    console.log(notification);
                },
                (credential) => {
                    handleCredentialResponse(credential);
                }
            );
        }

        // Handle the response from Google One Tap
        function handleCredentialResponse(response) {
            $("#overlay").fadeIn(300);

            // Verify the user details
            fetch('/google/verify', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content') // For Laravel CSRF token
                    },
                    body: JSON.stringify({
                        id_token: response.credential
                    })
                })
                .then(response => response.json())
                .then(data => {
                    $("#overlay").fadeOut(300);

                    if (data.error) {
                        toastr.error(data.message, 'Error');
                    }
                    toastr.success(data.message, 'Success');
                    return window.location.href = data.redirectUrl;
                })
                .catch(error => {
                    $("#overlay").fadeOut(300);
                    toastr.error(error, 'Error');
                });
        }
    </script>

    <!-- Custom Script -->
    @stack('script')
</body>

</html>
