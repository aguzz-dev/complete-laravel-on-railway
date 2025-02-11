<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://i.imgur.com/BLJohUm.png" type="image/x-icon">
    <style>body { visibility: hidden; }</style>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" onload="document.body.style.visibility='visible'">
    <link rel="preload" href="https://i.imgur.com/BLJohUm.png" as="image">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ValesEA</title>
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
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';

                        errorMessage += `DNI: ${errors}\n`;

                        Swal.fire({
                            title: 'Error en el registro',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonColor: '#ef4444'
                        });
                    }
                }

            });
        });
    });

</script>
</body>
</html>
