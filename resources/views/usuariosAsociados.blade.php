<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de usuarios</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #0f172a;
            color: #ffffff;
            margin: 0;
            padding: 20px;
        }
        .table-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #34d399;
        }
        .cards-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            gap: 20px;
        }
        .card {
            background-color: rgba(30, 41, 59, 0.8);
            border-radius: 12px;
            padding: 20px;
            width: 30%;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card h3 {
            margin-top: 0;
            color: #34d399;
            font-size: 1.5em;
        }
        .card p {
            margin: 5px 0 0;
            font-size: 1.2em;
            color: #ffffff;
        }
        .table-container {
            background-color: rgba(30, 41, 59, 0.8);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        /* Aseguramos que el id coincida con el de la tabla */
        #users-table {
            width: 100%;
            border-collapse: collapse;
        }
        #users-table th, #users-table td {
            color: white;
            background-color: #0f172a;
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #1e293b;
        }
        #users-table th {
            background-color: #1e293b;
            color: #34d399;
            font-weight: bold;
        }
        #users-table tbody tr:hover {
            background-color: rgba(52, 211, 153, 0.1);
        }
        .btn-ver {
            background-color: #34d399;
            color: #0f172a;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s;
            font-weight: bold;
            margin-right: 5px;
        }

        .btn-eliminar {
            background-color: rgba(255, 0, 0, 0.89);
            color: #f8f8f8;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s;
            font-weight: bold;
            margin-right: 5px;
        }
        .btn-ver:hover {
            background-color: #10b981;
        }

        .btn-eliminar:hover {
            background-color: rgba(176, 0, 0, 0.89);
        }

        /* DataTables customization */
        .dataTables_wrapper {
            color: #cbd5e1;
        }
        .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate {
            margin-bottom: 10px;
            color: #cbd5e1;
        }
        .dataTables_length select, .dataTables_filter input {
            background-color: #1e293b;
            color: #ffffff;
            border: 1px solid #475569;
            border-radius: 4px;
            padding: 5px;
        }
        .dataTables_length label, .dataTables_filter label {
            color: white;
        }
        .dataTables_info {
            color: #34d399 !important;
        }
        .dataTables_paginate .paginate_button {
            color: #cbd5e1 !important;
            background-color: #1e293b !important;
            border: 1px solid #475569 !important;
            transition: background-color 0.2s ease-in-out;
        }
        .dataTables_paginate .paginate_button:hover {
            background-color: #34d399 !important;
            color: #1f172a !important;
        }
        .dataTables_paginate .paginate_button.current {
            background-color: #34d399 !important;
            color: #1f172a !important;
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
@include('menu')
<h1>Usuarios de la unidad</h1>
<div class="table-container">
    <table id="users-table" class="display" style="width:100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Grado</th>
            <th>Nombre Completo</th>
            <th>DNI</th>
            <th>Email</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        </thead>
    </table>
</div>

<script>
    $(document).ready(function() {
        // Datos de ejemplo: en Laravel normalmente los pasarías desde el controlador
        const users = @json($users);

        const table = $('#users-table').DataTable({
            data: users,
            columns: [
                { data: 'id' },
                {
                    data: 'grado',
                    render: function(data) {
                        return `<span class="user-grade">${data}</span>`;
                    }
                },
                {
                    data: null,
                    render: function(data) {
                        return `${data.nombre} ${data.apellido}`;
                    }
                },
                { data: 'dni' },
                { data: 'email' },
                {
                    data: 'status',
                    render: function(data) {
                        return `<span class="status-badge status-${data.toLowerCase()}">${data}</span>`;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    render: function(data) {
                        return `
                <button onclick="viewProfile(${data.id})" class="btn-ver">
                  <i class="fas fa-eye"></i> Ver perfil
                </button>
                <button onclick="deleteUser(${data.id})" class="btn-eliminar">
                  <i class="fas fa-trash"></i> Eliminar
                </button>
              `;
                    }
                }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
            responsive: true,
            order: [[0, 'asc']],
            pageLength: 10,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]]
        });

        // Función para ver perfil
        window.viewProfile = function(userId) {
            window.location.href = `/usuario/${userId}/perfil`;
        }

        // Función para eliminar usuario con SweetAlert2
        window.deleteUser = function(userId) {
            Swal.fire({
                title: '¿Está seguro?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#334155',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/usuario/${userId}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            table.ajax.reload();
                            Swal.fire(
                                'Eliminado!',
                                'El usuario ha sido eliminado.',
                                'success'
                            );
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'Error al eliminar el usuario.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    });
</script>
</body>
</html>
