<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña ValesEA</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f8;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 40px 20px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #1e293b;
        }
        .logo img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
        }
        h1 {
            color: #2d3748;
            font-size: 24px;
            margin: 20px 0;
            font-weight: 700;
        }
        .code-container {
            background-color: #f8f7fd;
            border: 2px solid #1e293b;
            border-radius: 12px;
            padding: 20px;
            margin: 30px 0;
            text-align: center;
        }
        .verification-code {
            color: #1e293b;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 4px;
            margin: 0;
        }
        p {
            color: #4a5568;
            font-size: 16px;
            margin: 16px 0;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #edf2f7;
            color: #718096;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="logo">
            <img src="https://i.imgur.com/BLJohUm.png" alt="logo ValesEA">
        </div>
        <h1>Restablecer contraseña de ValesEA</h1>
    </div>

    <p>Gracias por utilizar ValesEA. Para completar el restablecimiento de contraseña, por favor introduce el siguiente código en la app:</p>

    <div class="code-container">
        <h2 class="verification-code">{{ $code }}</h2>
    </div>

    <div class="footer">
        <p>&copy; 2025 ValesEA. Todos los derechos reservados.</p>
    </div>
</div>
</body>
</html>
