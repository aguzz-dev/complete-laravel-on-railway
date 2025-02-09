<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://i.imgur.com/BLJohUm.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ValesEA - Perfil</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            color: #fff;
        }

        .dashboard-container {
            max-width: 480px;
            margin: 0 auto;
            min-height: 100vh;
            backdrop-filter: blur(10px);
        }

        .profile-header {
            padding: 2rem 1.5rem;
            text-align: center;
            position: relative;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 60px;
            margin: 0 auto 1rem;
            background-color: #1e293b;
            border: 4px solid #10b981;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile-avatar img {
            display: block;
            margin: auto;
            width: 80%;
            height: auto;
        }

        .profile-name {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .profile-role {
            display: inline-block;
            background-color: #10b981;
            color: white;
            padding: 0.25rem 1rem;
            border-radius: 1rem;
            font-size: 0.875rem;
        }

        .profile-details {
            padding: 1.5rem;
        }

        .detail-section {
            background-color: #0f172a;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #10b981;
        }

        .detail-item {
            margin-bottom: 1rem;
        }

        .detail-label {
            font-size: 0.875rem;
            color: #94a3b8;
            margin-bottom: 0.25rem;
        }

        .detail-value {
            font-size: 1rem;
            color: #fff;
            width: 100%;
            padding: 0.5rem;
            background-color: #1e293b;
            border: 1px solid #334155;
            border-radius: 0.25rem;
            transition: all 0.3s ease;
        }

        .detail-value[readonly] {
            border-color: transparent;
            background-color: transparent;
            padding-left: 0;
        }

        .profile-actions {
            padding: 0 1.5rem 1.5rem;
        }

        .btn {
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 0.5rem;
            color: white;
            cursor: pointer;
            font-size: 1rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-primary {
            background-color: #10b981;
        }

        .btn-secondary {
            background-color: #334155;
        }

        .btn-cancel {
            background-color: #ef4444;
            display: none;
        }

        .editing .btn-cancel {
            display: flex;
        }

        /* SweetAlert2 Custom Styles */
        .swal2-popup {
            background: #1e293b !important;
            color: #fff !important;
        }

        .swal2-title, .swal2-html-container {
            color: #fff !important;
        }

        .swal2-confirm {
            background: #10b981 !important;
        }

        .swal2-cancel {
            background: #334155 !important;
        }
    </style>
</head>
<body>
<div class="dashboard-container">
    @include('menu')
    <div class="profile-header">
        <div class="profile-avatar">
            <img src="https://i.imgur.com/BLJohUm.png" alt="Profile">
        </div>
        <h1 class="profile-name">{{ ucwords($user->grado) }} {{  ucwords($user->nombre) }} {{  ucwords($user->apellido) }}</h1>
        <div class="profile-role">{{ $user->status === 'admin' ? 'Administrador' :  'Usuario' }}</div>
    </div>

    <div class="profile-details">
        <form id="edit-profile-form">
            @csrf
            <div class="detail-section">
                <h2 class="section-title">Información Personal</h2>
                <div class="detail-item">
                    <div class="detail-label">Grado</div>
                    <input type="text" name="grado" class="detail-value" value="{{ ucwords($user->grado) }}" readonly>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Nombre</div>
                    <input type="text" name="nombre" class="detail-value" value="{{ ucwords($user->nombre) }}" readonly>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Apellido</div>
                    <input type="text" name="apellido" class="detail-value" value="{{ ucwords($user->apellido) }}" readonly>
                </div>
                <div class="detail-item">
                    <div class="detail-label">DNI</div>
                    <input type="text" name="dni" class="detail-value" value="{{ $user->dni }}" readonly>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Mail</div>
                    <input type="email" name="email" class="detail-value" value="{{ $user->email }}" readonly>
                </div>
            </div>
            <div class="profile-actions">
                <button type="button" id="editButton" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    Editar Perfil
                </button>
                <button type="button" id="cancelButton" class="btn btn-cancel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('edit-profile-form');
        const editButton = document.getElementById('editButton');
        const cancelButton = document.getElementById('cancelButton');
        const inputs = form.querySelectorAll('.detail-value');
        let isEditing = false;
        let originalValues = {};

        function enableEditing() {
            inputs.forEach(input => {
                originalValues[input.name] = input.value;
                input.removeAttribute('readonly');
                input.style.backgroundColor = '#1e293b';
                input.style.borderColor = '#334155';
                input.style.paddingLeft = '0.5rem';
            });
            form.classList.add('editing');
            editButton.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    Guardar Cambios
                `;
            isEditing = true;
        }

        function disableEditing() {
            inputs.forEach(input => {
                input.setAttribute('readonly', true);
                input.style.backgroundColor = 'transparent';
                input.style.borderColor = 'transparent';
                input.style.paddingLeft = '0';
            });
            form.classList.remove('editing');
            editButton.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    Editar Perfil
                `;
            isEditing = false;
        }

        function cancelEditing() {
            inputs.forEach(input => {
                input.value = originalValues[input.name];
            });
            disableEditing();
        }

        editButton.addEventListener('click', function () {
            if (!isEditing) {
                enableEditing();
            } else {
                Swal.fire({
                    title: '¿Guardar cambios?',
                    text: '¿Estás seguro de que deseas guardar los cambios realizados?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    cancelButtonText: 'Cancelar',
                    background: '#1e293b',
                    color: '#fff'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Obtener los valores de los inputs
                        let grado = document.querySelector('input[name="grado"]').value;
                        let nombre = document.querySelector('input[name="nombre"]').value;
                        let apellido = document.querySelector('input[name="apellido"]').value;
                        let dni = document.querySelector('input[name="dni"]').value;
                        let email = document.querySelector('input[name="email"]').value;
                        let password = document.querySelector('input[name="password"]')?.value || ''; // Si no existe, asigna una cadena vacía

                        $.ajax({
                            url: '{{ route('perfil.actualizar') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                grado: grado,
                                nombre: nombre,
                                apellido: apellido,
                                dni: dni,
                                email: email,
                                password: password
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Éxito',
                                    text: 'Perfil actualizado exitosamente',
                                    icon: 'success',
                                    background: '#1e293b',
                                    color: '#fff'
                                }).then(() => {
                                    window.location.href = '{{ route('perfil') }}';
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Hubo un problema al actualizar el perfil',
                                    icon: 'error',
                                    background: '#1e293b',
                                    color: '#fff'
                                });
                                console.error(error);
                            }
                        });
                    }
                });
            }
        });


        cancelButton.addEventListener('click', function() {
            Swal.fire({
                title: '¿Cancelar edición?',
                text: 'Se perderán todos los cambios realizados.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, cancelar',
                cancelButtonText: 'No, continuar editando',
                background: '#1e293b',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    cancelEditing();
                }
            });
        });
    });
</script>
</body>
</html>
