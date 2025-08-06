@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="auth-card">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Create Account</h2>
            <p class="text-gray-600 mb-8">Join our social todo community</p>
        </div>

        <form id="registerForm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <input type="text" id="name" name="name" required
                        class="input-field" placeholder="John Doe">
                </div>

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <input type="text" id="username" name="username" required
                        class="input-field" placeholder="johndoe">
                </div>
            </div>

            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" id="email" name="email" required
                    class="input-field" placeholder="john@doe.com">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" id="password" name="password" required
                        class="input-field" placeholder="••••••••">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="input-field" placeholder="••••••••">
                </div>
            </div>

            <div class="mb-6">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Account Type</label>
                <select id="type" name="type" class="input-field">
                    <option value="user">Regular User</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>

            <div class="flex items-center mb-6">
                <input id="terms" name="terms" type="checkbox" required
                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                <label for="terms" class="ml-2 block text-sm text-gray-700">
                    I agree to the <a href="#" class="text-primary hover:text-blue-700">Terms of Service</a> and <a href="#" class="text-primary hover:text-blue-700">Privacy Policy</a>
                </label>
            </div>

            <button type="submit" class="w-full btn-primary mb-6">Create Account</button>

            <div class="text-center text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="font-medium text-primary hover:text-blue-700">Sign in</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('registerForm').addEventListener('submit', async (e) => {
        e.preventDefault();

        const payload = {
            name: document.getElementById('name').value,
            username: document.getElementById('username').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            password_confirmation: document.getElementById('password_confirmation').value,
            type: document.getElementById('type').value
        };

        try {
            const user = await auth.register(payload);
            window.location.href = 'c';
        } catch (error) {
            if (typeof error === 'object') {
                let errorMsg = 'Please fix the following errors:\n';
                for (const field in error) {
                    errorMsg += `\n• ${error[field].join(', ')}`;
                }
                alert(errorMsg);
            } else {
                alert(error);
            }
        }
    });
</script>
@endsection