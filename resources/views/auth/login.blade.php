@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="auth-card">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Welcome Back</h2>
            <p class="text-gray-600 mb-8">Sign in to your account</p>
        </div>

        <form id="loginForm">
            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" id="email" name="email" required
                    class="input-field" placeholder="john@doe.com">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" id="password" name="password" required
                    class="input-field" placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox"
                        class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                </div>

            </div>

            <button type="submit" class="w-full btn-primary mb-6">Sign In</button>

            <div class="text-center text-sm text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-medium text-primary hover:text-blue-700">Sign up</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', async (e) => {
        e.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        try {
            const user = await auth.login(email, password);
            window.location.href = '/dashboard';
        } catch (error) {
            alert(error);
        }
    });
</script>
@endsection