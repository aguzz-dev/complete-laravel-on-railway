<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="https://i.imgur.com/BLJohUm.png" type="image/x-icon">
    <title>Reportes</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #0f172a;
            color: #ffffff;
            margin: 0;
            padding: 20px;
        }

        .dashboard-container {
            max-width: 480px;
            margin: 0 auto;
            min-height: 100vh;
            backdrop-filter: blur(10px);
        }

        h1 {
            text-align: center;
            color: white;
            margin-bottom: 40px;
            font-size: 2.5em;
            font-weight: 700;
        }
        hr {
            opacity: 0.1;
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

        .select-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .select-label {
            display: block;
            margin-bottom: 15px;
            font-size: 1.2em;
            color: #94a3b8;
        }

        select {
            width: 100%;
            max-width: 400px;
            padding: 12px 20px;
            font-size: 1.1em;
            background-color: #1e293b;
            color: #ffffff;
            border: 2px solid #34d399;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%2334d399' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 16px;
        }

        select:hover {
            border-color: #10b981;
            box-shadow: 0 0 0 2px rgba(52, 211, 153, 0.2);
        }

        select:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.3);
        }

        .btn-generate {
            display: block;
            width: 100%;
            max-width: 400px;
            margin: 30px auto 0;
            padding: 14px 28px;
            font-size: 1.1em;
            font-weight: 600;
            color: #0f172a;
            background-color: #34d399;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-generate:hover {
            background-color: #10b981;
            transform: translateY(-2px);
        }

        .btn-generate:active {
            transform: translateY(0);
        }

        /* Media Queries */
        @media screen and (max-width: 640px) {
            .reports-container {
                padding: 20px;
                margin: 20px;
            }

            h1 {
                font-size: 2em;
                margin-bottom: 30px;
            }

            .select-label {
                font-size: 1.1em;
            }

            select {
                font-size: 1em;
                padding: 10px 16px;
            }

            .btn-generate {
                padding: 12px 24px;
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
<div class="dashboard-container">
    @include('menu')
    <br>
    <h1>Reportes</h1>
    <p class="subtitle"></p>
    <hr><br><br>

    <div class="select-container">
        <label for="month-select" class="select-label">Descargar reporte de Hoy</label>
        <button class="btn-generate" id="generate-report-hoy">Generar Reporte ({{ $reporteHoy }})</button>
        <br><br><hr><br><br>
        <label for="month-select" class="select-label">Descargar reportes del mes de</label>
        <select id="month-select">
            <option value="">Seleccione un mes</option>
        </select>
    </div>

    <button class="btn-generate" id="generate-report">Generar Reporte</button>
</div>

<script>
    $(document).ready(function() {
        const meses = @json($meses);
        const monthNames = {
            '01': 'Enero',
            '02': 'Febrero',
            '03': 'Marzo',
            '04': 'Abril',
            '05': 'Mayo',
            '06': 'Junio',
            '07': 'Julio',
            '08': 'Agosto',
            '09': 'Septiembre',
            '10': 'Octubre',
            '11': 'Noviembre',
            '12': 'Diciembre'
        };

        // Process dates and create unique months
        const uniqueMonths = new Set();
        meses.forEach(date => {
            const [year, month] = date.split('-');
            uniqueMonths.add(`${year}-${month}`);
        });

        // Populate select with available months
        const $select = $('#month-select');
        Array.from(uniqueMonths)
            .sort()
            .forEach(yearMonth => {
                const [year, month] = yearMonth.split('-');
                const monthName = monthNames[month];
                $select.append(`<option value="${yearMonth}">${monthName} ${year}</option>`);
            });

        // Handle report generation
        $('#generate-report').click(function() {
            const selectedMonth = $('#month-select').val();

            if (!selectedMonth) {
                Swal.fire({
                    title: 'Error',
                    text: 'Por favor seleccione un mes',
                    icon: 'warning',
                    confirmButtonColor: '#34d399'
                });
                return;
            }

            const [year, month] = selectedMonth.split('-');
            const formattedDate = `${year}-${month}`;
            const unitId = {{ auth()->user()->unit_id }};

            $.ajax({
                url: '/generar-pdf',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    unit_id: unitId,
                    mes: formattedDate
                },
                xhrFields: {
                    responseType: 'blob' // Indicar que la respuesta es un archivo binario
                },
                success: function(response) {
                    // Crear un enlace temporal para descargar el PDF
                    const url = window.URL.createObjectURL(response);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'reporte.pdf';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(url);

                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'Se ha descargado el reporte correctamente!',
                        icon: 'success',
                        confirmButtonColor: '#34d399'
                    });
                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'No se pudo generar el reporte',
                        icon: 'error',
                        confirmButtonColor: '#34d399'
                    });
                }
            });
        });

        // Handle report generation
        $('#generate-report-hoy').click(function() {
            const unitId = {{ auth()->user()->unit_id }};

            $.ajax({
                url: '/generar-pdf-hoy',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    unit_id: unitId,
                    mes: @json($reporteHoy)
                },
                xhrFields: {
                    responseType: 'blob' // Indicar que la respuesta es un archivo binario
                },
                success: function(response) {
                    // Crear un enlace temporal para descargar el PDF
                    const url = window.URL.createObjectURL(response);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'reporte.pdf';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(url);

                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'Se ha descargado el reporte correctamente!',
                        icon: 'success',
                        confirmButtonColor: '#34d399'
                    });
                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'No se pudo generar el reporte',
                        icon: 'error',
                        confirmButtonColor: '#34d399'
                    });
                }
            });
        });
    });
</script>
</body>
</html>
