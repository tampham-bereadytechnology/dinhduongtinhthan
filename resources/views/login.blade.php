@extends('layout')

@section('title', 'Login')

@section('description', 'Verify user account before go to the admin panel')

@section('navbar', view('navbar'))

@section('content')
<div class="w-full my-10">
    <form class="mx-auto flex flex-col gap-7 items-center bg-purple-400 rounded-2xl min-[450px]:max-w-[450px]" method="POST" action="/login/verify-user">
        @csrf
        <h1 class="mt-4 font-semibold text-4xl">Login Form</h1>
        <input class="w-[80%] bg-gray-50 rounded-2xl h-10 pl-6" name="email" type="email" placeholder="Email" value="{{ old('email') }}" required>
        @error('email')
            <span class="text-black">{{$message}}</span>
        @enderror
        <input class="w-[80%] bg-gray-50 rounded-2xl h-10 pl-6" name="password" type="password" placeholder="Password" required>
        @error('password')
            <span class="text-black">{{$message}}</span>
        @enderror
        <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
        @error('g-recaptcha-response')
            <span class="text-black">{{$message}}</span>
        @enderror
        <button class="bg-orange-400 rounded-2xl w-[20%] font-semibold mb-5" type="submit">Login</button>
    </form>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</div>
@endsection