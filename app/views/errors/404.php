<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0f172a;
            color: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
        }
        .error-page h1 { font-size: 6rem; font-weight: 700; color: #6366f1; }
        .error-page p { font-size: 1.2rem; margin: 1rem 0 2rem; color: #94a3b8; }
        .error-page a {
            display: inline-block;
            padding: 0.75rem 2rem;
            background: #6366f1;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s;
        }
        .error-page a:hover { background: #4f46e5; }
    </style>
</head>
<body>
    <div class="error-page">
        <h1>404</h1>
        <p>The page you're looking for doesn't exist.</p>
        <a href="<?= defined('BASE_URL') ? BASE_URL : '/' ?>">Back to Dashboard</a>
    </div>
</body>
</html>
