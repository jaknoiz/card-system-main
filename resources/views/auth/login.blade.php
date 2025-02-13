<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบนามบัตรดิจิทัล</title>
    <link rel="icon" type="image/png" href="{{ asset('image/tsu.png') }}">
    <!-- Import Google Font: Prompt -->
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* ใช้ฟอนต์ Prompt กับทั้งหน้า */
        body {
            font-family: 'Prompt', sans-serif;
        }

        /* Keyframe for soft fade-in */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-br from-gray-100 to-gray-200">
    <div class="w-full max-w-md p-8 bg-white rounded-xl shadow-lg"
         style="animation: fadeIn 0.8s ease;">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('image/tsu-logo.png') }}" alt="Logo" class="object-cover">
        </div>

        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">เข้าสู่ระบบ</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                <input type="email" name="email" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Password</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            </div>

            <button type="submit"
                    class="w-full py-3 mt-4 text-white bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700 transition">
                เข้าสู่ระบบ
            </button>
        </form>

        <!-- Footer -->
        <p class="mt-6 text-xs text-center text-gray-400">
            © 2025 Digital Card. All Rights Reserved.
        </p>
    </div>
</body>
</html>
