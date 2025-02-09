<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Selección de Comidas</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        :root {
            --primary-color: #0f172a;
            --secondary-color: #1b2637;
            --accent-color: #34d399;
            --text-color: #ffffff;
            --border-radius: 12px;
        }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background-color: var(--primary-color);
            color: var(--text-color);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .dashboard-container {
            max-width: 480px;
            margin: 0 auto;
            min-height: 100vh;
            backdrop-filter: blur(10px);
        }

        h1 {
            text-align: center;
            margin-bottom: 10px;
            font-size: 2rem;
        }

        .subtitle {
            text-align: center;
            color: #94a3b8;
            margin-bottom: 30px;
        }

        .day-card {
            background-color: var(--secondary-color);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .day-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .day-name {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .date {
            color: #94a3b8;
        }

        .meal-option {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .meal-option:last-child {
            border-bottom: none;
        }

        .custom-checkbox {
            appearance: none;
            -webkit-appearance: none;
            width: 30px;
            height: 30px;
            border: 2px solid #4a5568;
            border-radius: 4px;
            margin-right: 12px;
            cursor: pointer;
            position: relative;
            background-color: transparent;
        }

        .custom-checkbox:checked {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .custom-checkbox:checked::after {
            content: '✓';
            position: absolute;
            color: white;
            font-size: 25px;
            left: 4px;
            top: -1px;
        }

        .toggle-week {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: var(--border-radius);
            color: var(--text-color);
            cursor: pointer;
            margin: 20px 0;
            font-size: 1rem;
            transition: background-color 0.2s;
        }

        .toggle-week:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }

        .submit-button {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: var(--accent-color);
            border: none;
            border-radius: var(--border-radius);
            color: var(--text-color);
            cursor: pointer;
            margin: 20px 0;
            font-size: 1rem;
            transition: background-color 0.2s;
        }

        .submit-button:hover {
            background-color: #00a583;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
<div class="dashboard-container">
    @include('menu')
    <h1>Selección de raciones</h1>
    <p class="subtitle">Seleccione sus comidas para la semana</p>

    <div id="days-container"></div>

    <button class="toggle-week" id="toggleWeek">Mostrar semana completa</button>
    <button class="submit-button" id="submitMeals">Guardar selección</button>
</div>

<script>
    let comidas = @json($comidasCreadasByUnidad);
    let seleccionadas = @json($comidasByUsuario);

    $(document).ready(function() {
        function formatDate(date) {
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            return `${day}-${month}`;
        }

        function formatDateForAPI(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        function createDayCard(date, isHidden = false) {
            const formattedDate = formatDate(date);
            const dayName = date.toLocaleDateString('es-ES', { weekday: 'long' });
            const isToday = new Date().toDateString() === date.toDateString();

            console.log('Creando card para fecha:', formattedDate);

            let cardHtml = `
                <div class="day-card ${isHidden ? 'hidden' : ''}" data-date="${formattedDate}">
                    <div class="day-header">
                        <span class="day-name">${capitalizeFirstLetter(dayName)}${isToday ? ' (hoy)' : ''}</span>
                        <span class="date">${formattedDate}</span>
                    </div>
            `;

            for (const [comida, id] of Object.entries(comidas)) {
                const seleccionadaParaEsteDia = seleccionadas.find(s => {

                    return s.date === formattedDate && s.comida === comida;
                });

                cardHtml += `
                    <div class="meal-option">
                        <input type="checkbox"
                            class="custom-checkbox"
                            id="${formattedDate}-${comida}"
                            data-date="${formattedDate}"
                            data-meal="${comida}"
                            data-meal-id="${id}"
                            ${seleccionadaParaEsteDia ? 'checked' : ''}>
                        <label for="${formattedDate}-${comida}">
                            ${capitalizeFirstLetter(comida)}
                        </label>
                    </div>
                `;
            }

            cardHtml += '</div>';
            return cardHtml;
        }

        function initializeCalendar() {
            const today = new Date();
            let html = '';

            for (let i = 0; i < 7; i++) {
                const date = new Date(today);
                date.setDate(today.getDate() + i);
                html += createDayCard(date, i > 0);
            }

            $('#days-container').html(html);
        }

        function submitMealPlan() {
            const today = new Date();
            const mealPlan = [];

            $('.day-card').each(function() {
                const cardDate = $(this).data('date');

                $(this).find('.custom-checkbox').each(function() {
                    const meal = $(this).data('meal');
                    const mealId = $(this).data('meal-id');
                    const isChecked = $(this).prop('checked');

                    if (isChecked) {
                        const [day, month] = cardDate.split('-').map(Number);
                        const currentDate = new Date(today.getFullYear(), month - 1, day);

                        mealPlan.push({
                            date: formatDateForAPI(currentDate),
                            comida: meal,
                            food_id: mealId
                        });
                    }
                });
            });


            $.ajax({
                url: '{{ route("saveSeleccion") }}',
                type: 'POST',
                data: JSON.stringify({
                    userId: {{ auth()->user()->id ?? 1 }},
                    mealPlan: mealPlan
                }),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert('Selección guardada exitosamente');
                    console.log('Respuesta del servidor:', response);
                },
                error: function(xhr, status, error) {
                    alert('Error al guardar la selección');
                    console.error('Error:', xhr.responseText);
                }
            });
        }

        initializeCalendar();

        $(document).on('change', '.custom-checkbox', function() {
            const date = $(this).data('date');
            const meal = $(this).data('meal');
            const mealId = $(this).data('meal-id');
            const isChecked = $(this).prop('checked');

            console.log('Cambio en selección:', {
                date,
                meal,
                mealId,
                isChecked
            });
        });

        let weekVisible = false;
        $('#toggleWeek').click(function() {
            weekVisible = !weekVisible;
            $('.day-card:not(:first-child)').toggleClass('hidden');
            $(this).text(weekVisible ? 'Ocultar semana completa' : 'Mostrar semana completa');
        });

        $('#submitMeals').click(submitMealPlan);
    });
</script>
</body>
</html>
