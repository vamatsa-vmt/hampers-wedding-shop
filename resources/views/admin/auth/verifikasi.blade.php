<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        h1 {
            font-size: 28px;
            color: #1d4ed8;
            font-weight: bold;
            margin-bottom: 10px;
        }

        p {
            color: #6b7280;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .button {
            padding: 12px 30px;
            background-color: #3b82f6;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #2563eb;
        }

        .small-text {
            font-size: 14px;
            color: #6b7280;
            margin-top: 20px;
        }

        .small-text a {
            color: #3b82f6;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Verifikasi Email Anda</h1>
        <p>Halo, Terima kasih telah mendaftar di platform kami!</p>
        <p>Silakan klik tombol di bawah untuk memverifikasi email Anda:</p>
        <a href="{{ $url }}" class="button">Verifikasi Email</a>
        <p class="small-text">Jika Anda tidak mendaftar di platform kami, Anda dapat mengabaikan email ini.</p>
    </div>
</body>
</html>
