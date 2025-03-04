<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Vales</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #0f172a;
            color: #ffffff;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            min-height: 100vh;
            backdrop-filter: blur(10px);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #ffffff;
            font-size: 2.5em;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
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

        .select-container {
            display: flex;
            align-content: center;
            justify-content: center;
            margin-bottom: 30px;
        }

        select {
            width: 30%;
            padding: 12px;
            border: 2px solid #34d399;
            border-radius: 8px;
            background-color: #1e293b;
            color: #ffffff;
            font-size: 1em;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        select:focus {
            outline: none;
            border-color: #3ee6a8;
            box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.2);
        }

        .filters-container {
            display: none; /* Oculto por defecto */
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .filters-container.visible {
            display: flex;
            opacity: 1;
            transform: translateY(0);
        }

        .filter-button {
            padding: 8px 16px;
            border: 2px solid #34d399;
            border-radius: 6px;
            background-color: transparent;
            color: #ffffff;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .dataTables_length label select option {
            background-color: #0F0F17;
        }

        .filter-button:hover {
            background-color: #34d399;
            color: #1e293b;
        }

        .filter-button.active {
            background-color: #34d399;
            color: #1e293b;
        }

        .table-container {
            background-color: #1e293b;
            border-radius: 12px;
            border: 2px solid #34d399;
            overflow: hidden;
            margin-top: 20px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .table-container.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* DataTables Custom Styling */
        .dataTables_wrapper {
            color: #ffffff;
        }

        .dataTables_filter input,
        .dataTables_length select {
            background-color: #1e293b;
            color: #ffffff;
            border: 1px solid #34d399;
            border-radius: 6px;
            padding: 8px 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .dataTables_filter input:focus,
        .dataTables_length select:focus {
            outline: none;
            border-color: #3ee6a8;
            box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.2);
        }

        table.dataTable {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background-color: #1e293b;
            margin-top: 20px !important;
            border-radius: 8px;
        }

        table.dataTable thead th {
            background-color: #34d399;
            color: #1e293b;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 16px;
            border-bottom: 2px solid #34d399;
        }

        table.dataTable tbody td {
            padding: 16px;
            border-bottom: 1px solid rgba(52, 211, 153, 0.2);
            color: #ffffff;
        }

        table.dataTable tbody tr:hover {
            background-color: rgba(52, 211, 153, 0.1);
        }

        .dataTables_info,
        .dataTables_paginate {
            margin-top: 15px;
            color: #ffffff;
        }

        .dataTables_paginate .paginate_button {
            padding: 8px 12px;
            margin: 0 5px;
            border: 1px solid #34d399;
            border-radius: 6px;
            color: #ffffff !important;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .dataTables_paginate .paginate_button.current {
            background-color: #34d399;
            color: #1e293b !important;
            border-color: #34d399;
        }

        .dataTables_paginate .paginate_button:hover {
            background-color: #34d399;
            color: #1e293b !important;
            border-color: #34d399;
        }

        /* Toggle Switch */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ef4444;
            transition: .4s;
            border-radius: 34px;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        input:checked + .slider {
            background-color: #34d399;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        .estado-text {
            margin-left: 70px;
            font-weight: bold;
        }

        .estado-disponible {
            color: #34d399;
        }

        .estado-usado {
            color: #ef4444;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .new-row {
            animation: fadeIn 0.5s ease-out;
        }

        @media (max-width: 768px) {
            select {
                width: 70%;
            }
        }
    </style>
</head>
<body>
<div class="container">
    @include('menu')
    <br>
    <h1>CONTROL<br>DE VALES</h1>
    <br>
    <hr>
    <br>

    <div class="select-container">
        <select id="valeSelect">
            <option value="">⬇️Seleccione un vale⬇️</option>
            @foreach($vales as $vale)
                <option value="{{ $vale['id'] }}">{{ $vale['descripcion'] }}</option>
            @endforeach
        </select>
    </div>

    <div class="filters-container">
        <button class="filter-button active" data-filter="all">Todos</button>
        <button class="filter-button" data-filter="oficiales">Oficiales</button>
        <button class="filter-button" data-filter="suboficiales">Suboficiales</button>
        <button class="filter-button" data-filter="soldados">Soldados</button>
    </div>

    <div class="table-container" style="display: none;">
        <table id="valesTable" class="display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>Datos</th>
                <th>Vale</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <!-- Los vales se cargarán aquí dinámicamente -->
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        let dataTable = null;
        let currentFilter = 'all';

        // Configurar el filtro personalizado
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

        // Manejar clicks en los botones de filtro
        $('.filter-button').click(function() {
            $('.filter-button').removeClass('active');
            $(this).addClass('active');
            currentFilter = $(this).data('filter');
            if (dataTable) {
                dataTable.draw();
            }
        });

        $('#valeSelect').change(function() {
            const valeId = $(this).val();
            if (valeId) {
                cargarValesDiarios(valeId);
                // Mostrar los filtros con animación
                $('.filters-container').addClass('visible');
            } else {
                // Ocultar tabla y filtros con animación
                $('.table-container').removeClass('visible').fadeOut();
                $('.filters-container').removeClass('visible');
                if (dataTable) {
                    dataTable.destroy();
                    dataTable = null;
                }
            }
        });

        function cargarValesDiarios(valeId) {
            $.ajax({
                url: `/getValesDiarios/${valeId}`,
                method: 'GET',
                success: function(vales) {
                    if (dataTable) {
                        dataTable.destroy();
                    }

                    const tbody = $('#valesTable tbody');
                    tbody.empty();

                    vales.forEach(function(vale) {
                        const row = $(`
                            <tr class="new-row" data-id="${vale.id}">
                                <td>${vale.nombre}</td>
                                <td>${vale.descripcion}</td>
                                <td>${vale.fecha}</td>
                                <td class="estado-text ${vale.estado === 'disponible' ? 'estado-disponible' : 'estado-usado'}">
                                    ${vale.estado}
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox"
                                               ${vale.estado === 'disponible' ? 'checked' : ''}
                                               onchange="cambiarEstado('${vale.id}', this.checked)">
                                        <span class="slider"></span>
                                    </label>
                                </td>
                            </tr>
                        `);
                        tbody.append(row);
                    });

                    // Mostrar la tabla con animación
                    $('.table-container').show().addClass('visible');

                    // Inicializar DataTable con configuración en español
                    dataTable = $('#valesTable').DataTable({
                        responsive: true,
                        language: {
                            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                        },
                        pageLength: 10,
                        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                        order: [[2, 'desc']], // Ordenar por fecha descendente
                        columnDefs: [
                            {
                                targets: -1, // Última columna (Acciones)
                                orderable: false,
                                searchable: false
                            }
                        ]
                    });

                    // Aplicar el filtro actual
                    dataTable.draw();
                },
                error: function(xhr) {
                    alert('Error al cargar los vales diarios');
                }
            });
        }
    });

    function cambiarEstado(valeId, isDisponible) {
        const nuevoEstado = isDisponible ? 'disponible' : 'usado';

        $.ajax({
            url: '{{ route('cambiarEstadoVale') }}',
            method: 'POST',
            data: {
                id: valeId,
                estado: nuevoEstado,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                const row = $(`tr[data-id="${valeId}"]`);
                const estadoText = row.find('.estado-text');

                estadoText.text(nuevoEstado);
                estadoText.removeClass('estado-disponible estado-usado').addClass(`estado-${nuevoEstado}`);
            },
            error: function(xhr) {
                alert('Error al cambiar el estado del vale');
            }
        });
    }
</script>
</body>
</html>
