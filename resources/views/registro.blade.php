<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://i.imgur.com/BLJohUm.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            background: #1a2332;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            color: #fff;
        }

        .register-container {
            width: 100%;
            max-width: 480px;
            background: rgba(30, 41, 59, 0.5);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            padding: 2rem;
        }

        .header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .logo {
            width: 64px;
            height: 64px;
            background: #353F4E;
            border-radius: 50%;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo img {
            width: 50px;
            height: 50px;
            stroke: #10b981;
        }

        h1 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #fff;
        }

        .subtitle {
            color: #94a3b8;
            font-size: 0.875rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
            position: relative;
        }

        .form-group label {
            display: block;
            color: #94a3b8;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            width: 20px;
            height: 20px;
            stroke: #64748b;
            stroke-width: 1.5;
            pointer-events: none;
        }

        select,
        input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: #fff;
            font-size: 1rem;
            transition: all 0.2s ease;
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1.5em;
            padding-right: 2.5rem;
        }

        select option {
            background: #1f2937;
            color: #fff;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #10b981;
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        input::placeholder {
            color: #4b5563;
        }

        button {
            width: 100%;
            padding: 0.875rem;
            background: #10b981;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 1.5rem;
        }

        button:hover {
            background: #059669;
            transform: translateY(-1px);
        }

        button:active {
            transform: translateY(0);
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #94a3b8;
            font-size: 0.875rem;
        }

        .login-link a {
            color: #10b981;
            text-decoration: none;
            margin-left: 0.5rem;
            font-weight: 500;
        }

        .login-link a:hover {
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
            .register-container {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
<div class="register-container">
    <div class="header">
        <div class="logo">
            <img src="https://i.imgur.com/BLJohUm.png" alt="ValesEA">
        </div>
        <h1>ValesEA</h1>
        <p class="subtitle">Complete el formulario con sus datos personales</p>
    </div>

    <form id="registroForm">
        <div class="form-group">
            @csrf
            <label for="grado">Grado Militar</label>
            <div class="input-wrapper">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <select id="grado" name="grado" required>
                    <option value="">Seleccione su grado</option>
                    <option value="coronel">Coronel</option>
                    <option value="teniente_coronel">Teniente Coronel</option>
                    <option value="mayor">Mayor</option>
                    <option value="capitan">Capitán</option>
                    <option value="teniente">Teniente</option>
                    <option value="subteniente">Subteniente</option>
                    <option value="sargento_primero">Sargento Primero</option>
                    <option value="sargento">Sargento</option>
                    <option value="cabo_primero">Cabo Primero</option>
                    <option value="cabo">Cabo</option>
                    <option value="soldado">Soldado</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <div class="input-wrapper">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                <input type="text" id="nombre" name="nombre" placeholder="Ingrese su nombre" required>
            </div>
        </div>

        <div class="form-group">
            <label for="apellido">Apellido</label>
            <div class="input-wrapper">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                <input type="text" id="apellido" name="apellido" placeholder="Ingrese su apellido" required>
            </div>
        </div>

        <div class="form-group">
            <label for="dni">DNI</label>
            <div class="input-wrapper">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <rect x="3" y="4" width="18" height="16" rx="2"/>
                    <line x1="7" y1="12" x2="17" y2="12"/>
                </svg>
                <input type="text" id="dni" name="dni" placeholder="Ingrese su DNI" required pattern="[0-9]{8}" maxlength="8">
            </div>
        </div>

        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <div class="input-wrapper">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
                <input type="email" id="email" name="email" placeholder="Ingrese su correo electrónico" required>
            </div>
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <div class="input-wrapper">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required minlength="8">
            </div>
        </div>

        <button type="submit">Registrar Usuario</button>

        <div class="login-link">
            ¿Ya tiene una cuenta? <a href="{{route('login')}}">Iniciar Sesión</a>
        </div>

        <div class="security-notice">
            ValesEA - Todos los derechos reservados.
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    let codigo = @json($code);
    $(document).ready(function() {
        $('#registroForm').on('submit', function(event) {
            event.preventDefault();

            let grado = $('#grado').val();
            let nombre = $('#nombre').val();
            let apellido = $('#apellido').val();
            let dni = $('#dni').val();
            let email = $('#email').val();
            let password = $('#password').val();

            // Hacer la solicitud POST a tu API
            $.ajax({
                url: '{{route('registro-user')}}',  // Cambia esto por la URL del endpoint
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',  // Para manejar CSRF en Laravel
                    grado: grado,
                    nombre: nombre,
                    apellido: apellido,
                    dni: dni,
                    email: email,
                    password: password,
                    unit_id: codigo
                },
                success: function(response) {
                    // Manejar la respuesta del servidor
                    alert('Registro exitoso');
                    window.location.href = '{{route('login')}}';
                },
                error: function(xhr, status, error) {
                    // Manejar errores
                    alert('Hubo un error en el registro');
                    console.error(error);
                }
            });
        });
    });
</script>

</body>
</html>
