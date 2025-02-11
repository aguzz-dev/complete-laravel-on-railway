<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de usuarios</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Base styles */
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
            padding: 0 15px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #34d399;
            font-size: 24px;
        }

        /* Table Container */
        .table-container {
            background-color: rgba(30, 41, 59, 0.8);
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        #users-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        #users-table th, #users-table td {
            color: white;
            background-color: #0f172a;
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #1e293b;
        }

        #users-table th {
            background-color: #1e293b;
            color: #34d399;
            font-weight: bold;
            white-space: nowrap;
        }

        /* Buttons */
        .btn-ver, .btn-eliminar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s;
            font-weight: bold;
            font-size: 12px;
            margin: 2px;
            white-space: nowrap;
        }

        .btn-ver {
            background-color: #34d399;
            color: #0f172a;
        }

        .btn-eliminar {
            background-color: rgba(255, 0, 0, 0.89);
            color: #f8f8f8;
        }

        .btn-ver:hover {
            background-color: #10b981;
        }

        .btn-eliminar:hover {
            background-color: rgba(176, 0, 0, 0.89);
        }

        .btn-ver i, .btn-eliminar i {
            margin-right: 4px;
        }

        /* DataTables Responsive */
        .dataTables_wrapper {
            color: #cbd5e1;
            font-size: 14px;
        }

        .dataTables_length,
        .dataTables_filter,
        .dataTables_info,
        .dataTables_paginate {
            margin-bottom: 10px;
            color: #cbd5e1;
        }

        .dataTables_length select,
        .dataTables_filter input {
            background-color: #1e293b;
            color: #ffffff;
            border: 1px solid #475569;
            border-radius: 4px;
            padding: 4px;
            margin: 0 4px;
        }

        .dataTables_filter {
            width: 100%;
            margin-bottom: 15px;
        }

        .dataTables_filter input {
            width: calc(100% - 70px);
            max-width: 200px;
        }

        /* Status Badge */
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        /* Pagination Responsive */
        .dataTables_paginate {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 15px;
        }

        .paginate_button {
            padding: 5px 10px !important;
            min-width: 30px;
            text-align: center;
        }

        /* DataTables Responsive Styles */
        .dtr-details {
            width: 100%;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .dtr-details li {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #1e293b;
        }

        .dtr-details li:last-child {
            border-bottom: none;
        }

        .dtr-title {
            font-weight: bold;
            color: #34d399;
            margin-right: 10px;
        }

        .dtr-data {
            text-align: right;
        }

        /* Fix for DataTables responsive view */
        table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control::before,
        table.dataTable.dtr-inline.collapsed > tbody > tr > th.dtr-control::before {
            background-color: #34d399;
            color: #0f172a;
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

        /* Media Queries */
        @media screen and (max-width: 640px) {
            body {
                padding: 10px;
            }

            h1 {
                font-size: 20px;
                margin-bottom: 20px;
            }

            .table-container {
                padding: 10px;
            }

            #users-table {
                font-size: 12px;
            }

            .btn-ver, .btn-eliminar {
                padding: 4px 8px;
                font-size: 11px;
            }

            .dataTables_wrapper {
                font-size: 12px;
            }

            .dataTables_length,
            .dataTables_filter {
                float: none;
                text-align: left;
            }

            .dataTables_filter input {
                width: calc(100% - 50px);
            }
        }

        @media screen and (min-width: 641px) and (max-width: 1024px) {
            h1 {
                font-size: 22px;
            }

            .btn-ver, .btn-eliminar {
                padding: 5px 10px;
                font-size: 12px;
            }
        }

        @media screen and (min-width: 1025px) {
            h1 {
                font-size: 28px;
            }

            #users-table {
                font-size: 16px;
            }

            .btn-ver, .btn-eliminar {
                padding: 8px 15px;
                font-size: 14px;
            }

            .dataTables_wrapper {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
@include('menu')
<h1>Usuarios de la unidad</h1>
<div class="table-container">
    <table id="users-table" class="display responsive nowrap" style="width:100%">
        <thead>
        <tr>
            <th>Nombre</th>
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
        const users = @json($users);

        const table = $('#users-table').DataTable({
            data: users,
            columns: [
                {
                    data: null,
                    className: 'all', // Always visible
                    render: function(data) {
                        return `${data.grado} ${data.apellido} ${data.nombre}`;

                    }
                },
                {
                    data: 'dni',
                    className: 'min-tablet'
                },
                {
                    data: 'email',
                    className: 'min-tablet'
                },
                {
                    data: 'status',
                    className: 'min-tablet',
                    render: function(data) {
                        return `<span class="status-badge status-${data.toLowerCase()}">${data}</span>`;
                    }
                },
                {
                    data: null,
                    className: 'all', // Always visible
                    orderable: false,
                    render: function(data) {
                        return `
                            <button onclick="window.location.href='/perfil/${data.id}'" class="btn-ver">
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
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.childRow,
                    type: 'inline',
                    renderer: function(api, rowIdx, columns) {
                        let html = '<ul class="dtr-details">';
                        for (let i = 0; i < columns.length; i++) {
                            if (columns[i].hidden) {
                                html += '<li>' +
                                    '<span class="dtr-title">' + columns[i].title + '</span> ' +
                                    '<span class="dtr-data">' + columns[i].data + '</span>' +
                                    '</li>';
                            }
                        }
                        html += '</ul>';
                        return html;
                    }
                }
            },
            order: [[0, 'asc']],
            pageLength: 10,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]]
        });

        // Handle window resize
        $(window).resize(function() {
            table.columns.adjust().responsive.recalc();
        });

        // Función para ver perfil
        window.viewProfile = function(userId) {
            window.location.href = `/perfil/${userId}`;
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
                            Swal.fire(
                                'Eliminado!',
                                'El usuario ha sido eliminado.',
                                'success'
                            );
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000); // 1000 ms = 1 segundo
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
