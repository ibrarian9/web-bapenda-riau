<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>

<body class="flex items-center justify-center min-h-screen bg-linear-to-b from-blue-300 to-blue-500">

    <div class="bg-white/80 w-[380px] rounded-lg shadow-xl border border-gray-300 p-6">

        <div class="flex justify-center mb-4">
            <img src="{{ asset('images/logo-bapenda.png') }}" alt="Logo" class="h-20">
        </div>

        <h2 class="text-center text-xl font-semibold text-gray-800 mb-4">LOGIN</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-md border border-red-400 bg-red-100 text-red-700 text-sm">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="email" value="{{ old('email') }}"
                    class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Username">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password"
                    class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Password">
            </div>

            <button type="submit" class="w-full bg-gray-900 text-white py-2 rounded-md hover:bg-gray-800 transition">
                Sign In
            </button>

        </form>

        <div class="mt-4 text-center">
            <a href="#" class="text-sm text-gray-700 underline hover:text-gray-900">
                Forgot password?
            </a>
        </div>

    </div>

</body>

</html>