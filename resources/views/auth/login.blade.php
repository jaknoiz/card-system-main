<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gradient-to-r from-blue-400 to-blue-600">
    <div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-lg">
        <!-- Logo -->
        <div class="flex justify-center mb-4">
            <img src="{{ asset('image/tsu-logo.png') }}" alt="Logo" >
        </div>

        <h2 class="text-2xl font-semibold text-center text-gray-700 mb-4">เข้าสู่ระบบ</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
            </div>

            <button type="submit" class="w-full px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 transition">Login</button>
        </form>
    </div>
</body>
</html>
