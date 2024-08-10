@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Dashboard</h1>
                <p>Welcome, {{ Auth::user()->name }}!</p>
            </div>
            <div class="col-md-12">
                <a href="{{ route('logout') }}" class="btn btn-primary">Logout</a>
            </div>
        </div>
    </div>
@endsection
