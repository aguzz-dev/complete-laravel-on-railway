<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Vales de Comida</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="https://i.imgur.com/BLJohUm.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .filter-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-btn {
            background-color: #1e293b;
            color: #ffffff;
            border: 1px solid #34d399;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .filter-btn:hover {
            background-color: #34d399;
            color: #0f172a;
        }

        .filter-btn.active {
            background-color: #34d399;
            color: #0f172a;
        }
        /* Base styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #0f172a;
            color: #ffffff;
            margin: 0;
            padding: 20px;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            min-height: 100vh;
            backdrop-filter: blur(10px);
        }
        .dashboard {
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            position: relative;
            text-align: center;
            margin-bottom: 10px;
            font-size: 2rem;
        }

        .subtitle {
            text-align: center;
            color: #94a3b8;
            margin-bottom: 30px;
        }

        hr {
            opacity: 0.1;
        }

        /* Cards Container */
        .cards-container {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background-color: rgba(30, 41, 59, 0.8);
            border-radius: 12px;
            padding: 20px;
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
            font-size: 1.2em;
        }

        .card p {
            margin: 5px 0 0;
            font-size: 1em;
            color: #ffffff;
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

        @if(auth()->user()->status === 'superadmin')
        .btn-editar {
            background-color: #34d399;
            color: #0f172a;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s;
            font-weight: bold;
            font-size: 12px;
            white-space: nowrap;
        }

        @else
       .btn-editar {
            display: none;
        }
        @endif


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
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        /* Modal Styles */
        .modal-content {
            position: relative;
            background-color: #1e293b;
            margin: 14% auto;
            padding: 20px;
            border-radius: 12px;
            width: 80%;
            max-width: 500px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal-header h2 {
            font-size: 1.2em;
        }

        .meal-option {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #0f172a;
            border-radius: 8px;
        }

        .meal-option input[type="checkbox"] {
            margin-right: 10px;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }


        .meal-option label {
            font-size: 1em;
        }

        .modal-footer {
            flex-wrap: wrap;
            gap: 8px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        /* Media Queries */
        @media screen and (min-width: 640px) {
            .cards-container {
                grid-template-columns: repeat(2, 1fr);
            }

            h1 {
                font-size: 28px;
            }

            .btn-editar {
                font-size: 14px;
                padding: 8px 15px;
            }
        }

        @media screen and (min-width: 1024px) {
            .cards-container {
                grid-template-columns: repeat(3, 1fr);
            }

            h1 {
                font-size: 32px;
            }

            #users-table {
                font-size: 16px;
            }

            .dataTables_wrapper {
                font-size: 16px;
            }

            .modal-content {
                padding: 20px;
            }

            .btn {
                font-size: 16px;
            }
        }

        /* DataTables Responsive Styles */
        .dtr-details {
            width: 100%;
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

        .btn-save {
            background-color: #34d399;
            color: #0f172a;
        }

        .btn-save:hover {
            background-color: #10b981;
        }

        .btn-cancel {
            background-color: #475569;
            color: #ffffff;
        }

        .btn-cancel:hover {
            background-color: #334155;
        }
    </style>
</head>
<body>
<div class="dashboard-container">
    @include('menu')
    <br>
    <h1>Listado de<br>Vales</h1>
    <hr>
{{--    TODO Cambiar a semana completa cuando se implemente el control de vales--}}
{{--    <p class="subtitle">Cantidad de vales de Hoy</p>--}}
    <br>
    <div class="cards-container">
        <!-- Cards will be generated here -->
    </div>
{{--    <p class="subtitle">Vales de la semana completa</p>--}}

    <div class="filter-buttons">
        <button class="filter-btn active" data-filter="all">Todos</button>
        <button class="filter-btn" data-filter="oficiales">Oficiales</button>
        <button class="filter-btn" data-filter="suboficiales">Suboficiales</button>
        <button class="filter-btn" data-filter="soldados">Soldados</button>
    </div>
    <div class="table-container">
        <table id="users-table" class="display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>Nombre y Apellido</th>
                <!-- Meal columns will be generated dynamically -->
                @if(auth()->user()->status === 'superadmin')
                <th>Acciones</th>
                @endif
            </tr>
            </thead>
            <tbody>
            <!-- Data will be loaded dynamically -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal remains the same -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Editar Comidas</h2>
        </div>
        <div class="modal-body">
            <!-- Meal options will be generated here -->
        </div>
        <div class="modal-footer">
            <button class="btn btn-cancel" id="cancelEdit">Cancelar</button>
            <button class="btn btn-save" id="saveChanges">Guardar Cambios</button>
        </div>
    </div>
</div>

<script>
    const spanishLanguage = {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":           "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
        "buttons": {
            "copy": "Copiar",
            "colvis": "Visibilidad"
        }
    };

    function formatDate(dateString) {
        const days = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
        // const months = ['ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC'];

        const date = new Date(dateString);
        const dayName = days[date.getDay()];
        const day = date.getDate();
        // const month = months[date.getMonth()];

        return `${dayName} ${day}`;
    }

    $(document).ready(function() {
        // Your provided data
        const comidas = @json($comidas);
        const usuarios = @json($usuarios);
        let currentFilter = 'all';

        // Custom filtering function
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            if (currentFilter === 'all') return true;

            const nombreCompleto = data[0];
            const grado = nombreCompleto.split(' ')[0];

            switch(currentFilter) {
                case 'oficiales':
                    return ['ST', 'TT', 'TP', 'CT', 'MY', 'TC', 'CR', 'CY', 'GB', 'GD', 'TG'].some(prefix => grado.startsWith(prefix));
                case 'suboficiales':
                    return ['CB', 'CI', 'SG', 'SI', 'SA', 'SP', 'SM'].some(prefix => grado.startsWith(prefix));
                case 'soldados':
                    return ['VS', 'VP'].some(prefix => grado.startsWith(prefix));
                default:
                    return true;
            }
        });

        // Generate cards
        const $cardsContainer = $('.cards-container');
        $cardsContainer.empty();

        Object.values(comidas).forEach(comida => {
            const cardHtml = `
                <div class="card">
                    <h3>${comida.nombre}</h3>
                    <p>Cantidad: ${comida.cantidad}</p>
                </div>
            `;
            $cardsContainer.append(cardHtml);
        });

        // Generate table columns
        const $thead = $('#users-table thead tr');
        $thead.find('th:not(:first-child):not(:last-child)').remove();

        Object.values(comidas).forEach(comida => {
            $thead.find('th:last').before(`<th>${comida.nombre}</th>`);
        });

        // Add the date column before actions
        $thead.find('th:last').before('<th>Fecha</th>');

        // Store original dates for sorting
        const dataSet = usuarios.map(usuario => {
            const row = [usuario.nombre];
            Object.values(comidas).forEach(comida => {
                const tieneComida = usuario[comida.nombre] ? '✅' : '❌';
                row.push(tieneComida);
            });
            // Add both the formatted date for display and the original date for sorting
            const originalDate = new Date(usuario.date);
            row.push({
                display: formatDate(usuario.date),
                timestamp: originalDate.getTime()
            });
            row.push('<button class="btn-editar">Editar</button>');
            return row;
        });

        // Initialize DataTable with responsive features
        const table = $('#users-table').DataTable({
            data: dataSet,
            language: spanishLanguage,
            responsive: true,
            order: [[dataSet[0].length - 2, 'asc']], // Sort by date column in descending order
            columns: [
                { title: "Nombre y Apellido" },
                ...Object.values(comidas).map(comida => ({
                    title: comida.nombre,
                    className: 'all'
                })),
                {
                    title: "Fecha",
                    className: 'all',
                    render: function(data, type) {
                        // Use the timestamp for sorting and the formatted date for display
                        return type === 'sort' ? data.timestamp : data.display;
                    }
                },
                @if(auth()->user()->status === 'superadmin')
                {
                    title: "Acciones",
                    orderable: false,
                    searchable: false,
                    className: 'all',
                    render: function(data, type, row, meta) {
                        return `<button class="btn-editar" data-user-id="${usuarios[meta.row].id}">Editar</button>`;
                    }
                }
                @endif
            ],
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
                                    '<span class="dtr-data">' +
                                    (columns[i].data && columns[i].data.display ? columns[i].data.display : columns[i].data) +
                                    '</span>' +
                                    '</li>';
                            }
                        }
                        html += '</ul>';
                        return html;
                    }
                }
            }
        });

        // Add filter button click handlers
        $('.filter-btn').click(function() {
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');
            currentFilter = $(this).data('filter');
            table.draw();
        });

        function openModal(userId) {
            currentUserId = userId;
            $.get(`/dashboard/vales/${userId}`, function(data) {
                const modalBody = $('.modal-body');
                modalBody.empty();

                Object.entries(data).forEach(([mealName, isSelected]) => {
                    const checkbox = `
                        <div class="meal-option">
                            <input type="checkbox" id="${mealName}"
                                   name="${mealName}"
                                   ${isSelected === "true" ? 'checked' : ''}>
                            <label for="${mealName}">${mealName}</label>
                        </div>
                    `;
                    modalBody.append(checkbox);
                });

                $('#editModal').show();
            });
        }

        function closeModal() {
            $('#editModal').hide();
            currentUserId = null;
        }

        // Event handlers
        $(document).on('click', '.btn-editar', function() {
            const userId = $(this).data('user-id');
            openModal(userId);
        });

        $('#cancelEdit').click(function() {
            closeModal();
        });

        $('#saveChanges').click(function() {
            if (!currentUserId) return;

            const selections = {};
            $('.meal-option input[type="checkbox"]').each(function() {
                selections[$(this).attr('name')] = $(this).is(':checked').toString();
            });

            $.ajax({
                url: '/dashboard/vales/editar',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    userId: currentUserId,
                    selections: selections
                },
                success: function(response) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'Las selecciones han sido actualizadas',
                        icon: 'success',
                        confirmButtonColor: '#34d399'
                    }).then(() => {
                        closeModal();
                        window.location.reload();
                    });
                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'No se pudieron guardar los cambios',
                        icon: 'error',
                        confirmButtonColor: '#34d399'
                    });
                }
            });
        });

        $(window).click(function(event) {
            if ($(event.target).is('#editModal')) {
                closeModal();
            }
        });

        // Handle window resize
        $(window).resize(function() {
            table.columns.adjust().responsive.recalc();
        });
    });
</script>
</body>
</html>
