<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://i.imgur.com/BLJohUm.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ValesEA</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1a2639 0%, #1f2937 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 8px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            padding: 2.5rem;
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo img {
            width: 60px;
            height: 60px;
            fill: none;
            stroke: #10b981;
            stroke-width: 2;
        }

        h1 {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: #94a3b8;
            font-size: 0.875rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group svg {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            stroke: #64748b;
        }

        input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            color: #fff;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #10b981;
            background: rgba(255, 255, 255, 0.1);
        }

        input::placeholder {
            color: #64748b;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .remember-me input[type="checkbox"] {
            width: auto;
            margin-right: 0.5rem;
        }

        .remember-me label {
            color: #94a3b8;
            font-size: 0.875rem;
        }

        button {
            width: 100%;
            padding: 0.875rem;
            background: #10b981;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #059669;
        }

        .footer {
            text-align: center;
            margin-top: 1.5rem;
        }

        .footer a {
            color: #10b981;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .security-notice {
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            color: #64748b;
            font-size: 0.75rem;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="header">
        <div class="logo">
            <!-- Shield Icon -->
            <img src="https://i.imgur.com/BLJohUm.png" alt="ValesEA">
        </div>
        <h1>ValesEA</h1>
        <p class="subtitle">Vales Electronicos Automatizados</p>
    </div>
    @if ($errors->any())
        <div style="color: rgba(255,0,0,0.89);">
            <ul>
                @foreach ($errors->all() as $error)
                    <span>{{ $error }}</span>
                @endforeach
            </ul>
        </div>
    @endif
        <form method="POST" action="{{ route('login-user') }}">
            @csrf
            <div class="form-group">
                <!-- Icono de usuario -->
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                <input type="text" name="dni" placeholder="DNI" required>
            </div>

            <div class="form-group">
                <!-- Icono de contraseña -->
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                <input type="password" name="password" placeholder="Contraseña" required>
            </div>

            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Mantener sesión iniciada</label>
            </div>

            <button type="submit">Ingresar</button>
        </form>


        <div class="footer">
            <a href="#">¿Olvidó su contraseña?</a>
        </div>

        <div class="security-notice">
            ValesEA - Todos los derechos reservados.
        </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Al enviar el formulario, ejecutamos el siguiente código
        $('#loginForm').on('submit', function(event) {
            event.preventDefault();  // Prevenir que el formulario se envíe de forma tradicional

            // Recoger los datos del formulario
            var dni = $('#dni').val();
            var password = $('#password').val();
            var remember = $('#remember').prop('checked') ? 1 : 0; // Si está marcado, recordar la sesión

            // Preparar los datos para enviar
            var data = {
                _token: $('meta[name="csrf-token"]').attr('content'),  // Token CSRF
                dni: dni,
                password: password,
                remember: remember
            };

            // Enviar la solicitud AJAX
            $.ajax({
                url: "{{ route('login-user') }}",  // Ruta de login en Laravel
                method: "POST",
                data: data,
                success: function(response) {
                    window.location.href = response.redirectUrl;
                },
                error: function(xhr, status, error) {
                    alert('dsadqasdasdas');
                }
            });
        });
    });

</script>
</body>
</html>
