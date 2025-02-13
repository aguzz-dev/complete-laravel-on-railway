<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://i.imgur.com/BLJohUm.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Contraseña</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background-color: #1e293b;

            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .subtitle {
            color: #94a3b8;
            font-size: 0.875rem;
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

        p {
            color: #10b981;
        }

        h1 {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }


        .container {
            padding: 2rem;
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
            margin: 1rem;
        }

        h2 {
            color: #34d399;

            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #d1d5db;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.2s;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        button {
            width: 100%;
            padding: 0.75rem;
            background-color: #34d399;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        button:hover {
            background-color: #17815b;
        }

        button:disabled {
            background-color: #9ca3af;
            cursor: not-allowed;
        }

        .alert {
            padding: 0.75rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        #verificationSection {
            display: none;
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
    <div id="emailSection">
        <h2>Recuperar contraseña</h2>
        <div id="emailAlert"></div>
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" placeholder="Ingrese su correo electrónico">
        </div>
        <button id="sendEmailBtn"><b>Enviar Correo</b></button>
    </div>

    <div id="verificationSection">
        <h2>¡Email enviado!</h2>
        <p>Enviamos el código a su correo, ingréselo aquí abajo</p>
        <div id="codeAlert"></div>
        <div class="form-group">
            <label for="code">Código de Verificación</label>
            <input type="text" id="code" name="code" placeholder="Ingrese el código recibido">
        </div>
        <button id="verifyCodeBtn">Verificar Código</button>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Configurar el token CSRF en todas las solicitudes AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Manejar el envío del correo
        $('#sendEmailBtn').click(function() {
            const email = $('#email').val().trim();

            if (!email) {
                showAlert('emailAlert', 'Por favor ingrese su correo electrónico', 'error');
                return;
            }

            // Deshabilitar el botón mientras se procesa
            $(this).prop('disabled', true);

            $.ajax({
                url: '/recuperar-password-code', // Ajusta la URL según tu ruta
                method: 'POST',
                data: { email: email },
                success: function(response) {
                    showAlert('emailAlert', 'Código enviado correctamente. Por favor revise su correo.', 'success');
                    $('#emailSection').hide();
                    $('#verificationSection').show();
                },
                error: function(xhr) {
                    showAlert('emailAlert', 'Error, por favor, verifique el correo ingresado.', 'error');
                    $('#sendEmailBtn').prop('disabled', false);
                }
            });
        });

        // Manejar la verificación del código
        $('#verifyCodeBtn').click(function() {
            const email = $('#email').val().trim();
            const code = $('#code').val().trim();

            if (!code) {
                showAlert('codeAlert', 'Por favor ingrese el código de verificación', 'error');
                return;
            }

            // Deshabilitar el botón mientras se procesa
            $(this).prop('disabled', true);

            $.ajax({
                url: '/verificar-password-code',
                method: 'POST',
                data: {
                    email: email,
                    code: code
                },
                success: function(response) {
                    showAlert('codeAlert', 'Código verificado correctamente.', 'success');
                    setTimeout(() => {
                        window.location.href = '/resetpassword?email=' + encodeURIComponent(email) + '&code=' + encodeURIComponent(code)
                    }, 300);
                    // Redirigir o realizar alguna acción adicional
                },
                error: function(xhr) {
                    showAlert('codeAlert', 'Error al verificar el código. Por favor intente nuevamente.', 'error');
                    $('#verifyCodeBtn').prop('disabled', false);
                }
            });
        });

        // Función auxiliar para mostrar alertas
        function showAlert(elementId, message, type) {
            $(`#${elementId}`).html(`
            <div class="alert alert-${type}">
                ${message}
            </div>
        `);
        }
    });
</script>
</body>
</html>
