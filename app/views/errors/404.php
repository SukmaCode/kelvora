<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', '-apple-system', 'BlinkMacSystemFont', 'sans-serif'],
                    },
                },
            },
        }
    </script>
</head>
<body class="font-sans bg-[#0f172a] text-slate-200 flex items-center justify-center min-h-screen text-center px-4">
    <div>
        <h1 class="text-6xl sm:text-7xl md:text-8xl font-bold text-indigo-500">404</h1>
        <p class="text-base sm:text-lg md:text-xl mt-3 sm:mt-4 mb-6 sm:mb-8 text-slate-400">The page you're looking for doesn't exist.</p>
        <a href="<?= defined('BASE_URL') ? BASE_URL : '/' ?>" class="inline-block px-6 sm:px-8 py-3 bg-indigo-500 text-white rounded-lg no-underline font-medium transition-colors duration-200 hover:bg-indigo-600 text-sm sm:text-base">Back to Dashboard</a>
    </div>
</body>
</html>
