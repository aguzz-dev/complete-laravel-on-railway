<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://i.imgur.com/BLJohUm.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #34d399;
            --error-color: #E74C3C;
            --success-color: #2ECC71;
            --background-color: #0f172a;
            --text-color: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
            padding: 1rem;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }


        .container {
            width: 100%;
            max-width: 400px;
            background: #0f172a;
            padding: 2rem;
            border-radius: 12px;
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

        h2 {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--primary-color);
            font-size: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            font-size: 0.9rem;
        }

        input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #E0E0E0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            padding-right: 40px;
        }

        input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        button {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #357ABD;
        }

        button:active {
            transform: scale(0.98);
        }

        .alert {
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: none;
        }

        .alert-error {
            background-color: #FDEDEC;
            color: var(--error-color);
            border: 1px solid var(--error-color);
        }

        .alert-success {
            background-color: #E8F8F5;
            color: var(--success-color);
            border: 1px solid var(--success-color);
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 70%;
            transform: translateY(-50%);
            border: none;
            background: none;
            cursor: pointer;
            padding: 0;
            color: #666;
            width: auto;
            font-size: 1.1rem;
        }

        .toggle-password:hover {
            color: var(--primary-color);
            background: none;
        }

        @media (min-width: 768px) {
            .container {
                padding: 2.5rem;
            }

            h2 {
                font-size: 1.75rem;
            }

            input {
                padding: 0.875rem;
                padding-right: 40px;
            }

            button[type="submit"] {
                padding: 0.875rem;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="logo">
            <!-- Shield Icon -->
            <img src="https://i.imgur.com/BLJohUm.png" alt="ValesEA">
        </div>
        <h1>ValesEA</h1>
        <p class="subtitle">Vales Electronicos Automatizados</p>
    </div>
    <h2>Restablecer Contraseña</h2>
    <div id="alertMessage" class="alert"></div>
    <form id="resetPasswordForm">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="code" value="{{ $code }}">

        <div class="form-group">
            <label for="password">Nueva Contraseña:</label>
            <input type="password" id="password" name="password" required>
            <button type="button" class="toggle-password" data-target="password">
                <i class="fas fa-eye"></i>
            </button>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirmar Contraseña:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <button type="button" class="toggle-password" data-target="confirm_password">
                <i class="fas fa-eye"></i>
            </button>
        </div>

        <button type="submit">Cambiar Contraseña</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        // Función para mostrar alertas
        function showAlert(message, type) {
            const alertElement = $('#alertMessage');
            alertElement.removeClass('alert-error alert-success')
                .addClass(`alert-${type}`)
                .text(message)
                .css('display', 'block');
        }

        // Toggle password visibility
        $('.toggle-password').click(function() {
            const targetId = $(this).data('target');
            const input = $(`#${targetId}`);
            const icon = $(this).find('i');

            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        // Form submission
        $('#resetPasswordForm').submit(function(e) {
            e.preventDefault();

            const password = $('#password').val();
            const confirmPassword = $('#confirm_password').val();

            if (password !== confirmPassword) {
                showAlert('Las contraseñas no coinciden.', 'error');
                return;
            }

            $.ajax({
                url: '/resetear-password',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    showAlert('Contraseña cambiada exitosamente.', 'success');
                    setTimeout(() => {
                        window.location.href = '/login';
                    }, 2000);
                },
                error: function(xhr) {
                    showAlert('Error al cambiar la contraseña. Inténtalo de nuevo.', 'error');
                }
            });
        });
    });
</script>
</body>
</html>
