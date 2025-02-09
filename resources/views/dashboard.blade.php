<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Vales de Comida</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
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

        .dashboard {
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

        .btn-editar {
            background-color: #34d399;
            color: #0f172a;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s;
            font-weight: bold;
        }

        .btn-editar:hover {
            background-color: #10b981;
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
            color: #1e293b !important;
        }

        .dataTables_paginate .paginate_button.current {
            background-color: #34d399 !important;
            color: #1e293b !important;
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
        /* Previous styles remain unchanged */

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

        .modal-content {
            position: relative;
            background-color: #1e293b;
            margin: 15% auto;
            padding: 20px;
            border-radius: 12px;
            width: 80%;
            max-width: 500px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            margin-bottom: 20px;
        }

        .modal-header h2 {
            color: #34d399;
            margin: 0;
        }

        .modal-body {
            margin-bottom: 20px;
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
            color: #ffffff;
            font-size: 1.1em;
            cursor: pointer;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
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

        /* Previous styles remain unchanged */
    </style>
</head>
<body>
<div class="dashboard">
    @include('menu')
    <h1>Vales activos hoy</h1>

    <div class="cards-container">
        <!-- Cards will be generated here -->
    </div>

    <div class="table-container">
        <table id="users-table" class="display">
            <thead>
            <tr>
                <th>Nombre y Apellido</th>
                <!-- Meal columns will be generated dynamically -->
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <!-- Data will be loaded dynamically -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
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
    $(document).ready(function() {
        // Your provided data
        const comidas = @json($comidas);

        const usuarios = @json($usuarios);
        console.log(usuarios);

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
        const dataSet = usuarios.map(usuario => {
            const row = [usuario.nombre];
            Object.values(comidas).forEach(comida => {
                const tieneComida = usuario[comida.nombre] ? '✅' : '❌';
                row.push(tieneComida);
            });
            row.push('<button class="btn-editar">Editar</button>');
            return row;
        });
        // Initialize DataTable with modified click handler
        const table = $('#users-table').DataTable({
            data: dataSet,
            language: spanishLanguage,
            responsive: true,
            columns: [
                { title: "Nombre y Apellido" },
                ...Object.values(comidas).map(comida => ({ title: comida.nombre })),
                {
                    title: "Acciones",
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return `<button class="btn-editar" data-user-id="${usuarios[meta.row].id}">Editar</button>`;
                    }
                }
            ]
        });

        // Modal functionality
        function openModal(userId) {
            currentUserId = userId;
            // Fetch user's meal selections
            $.get(`/dashboard/vales/${userId}`, function(data) {
                const modalBody = $('.modal-body');
                modalBody.empty();

                // Generate checkboxes for each meal
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

        // Event Handlers
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

            // Send updated selections
            $.ajax({
                url: '/api/update-meals',
                method: 'POST',
                data: {
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
                        // Refresh the table
                        table.ajax.reload();
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

        // Close modal when clicking outside
        $(window).click(function(event) {
            if ($(event.target).is('#editModal')) {
                closeModal();
            }
        });
    });
</script>
</body>
</html>
