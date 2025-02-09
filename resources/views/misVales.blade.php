<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://i.imgur.com/BLJohUm.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ValesEA</title>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', system-ui, sans-serif;
    }

    body {
        min-height: 100vh;
        background-color: #0f172a;
        color: #fff;
        padding: 1rem;
    }

    .dashboard-container {
        max-width: 480px;
        margin: 0 auto;
        backdrop-filter: blur(10px);
        padding: 1.5rem;
    }

    .date-display {
        font-size: 1.4rem;
        color: #10b981;
        margin-bottom: 1rem;
        font-weight: 500;
    }

    .header {
        text-align: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .title {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .subtitle {
        color: #94a3b8;
        font-size: 1.2rem;
    }

    #meals-container {
        margin: 0 auto;
    }

    .meal-card {
        background-color: #1b2637;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .date {
        color: white;
        font-size: 1.2rem;
        font-weight: 600;
    }

    .meal-count {
        color: #34d399;
        font-size: 1rem;
    }

    .meal-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        font-size: 1.1rem;
    }

    .meal-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .meal-dot {
        width: 0.6rem;
        height: 0.6rem;
        background-color: #34d399;
        border-radius: 50%;
    }

    .meal-name {
        color: #cbd5e1;
    }

    .buttons {
        max-width: 28rem;
        margin: 1.5rem auto 0;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .btn {
        width: 100%;
        padding: 0.75rem;
        border: none;
        border-radius: 0.375rem;
        color: white;
        cursor: pointer;
        font-size: 1rem;
    }

    .btn-secondary {
        background-color: #334155;
    }

    .btn-primary {
        background-color: #10b981;
    }
</style>

<body>
<div class="dashboard-container">
    @include('menu')
    <div class="meal-selection">
        <div class="header">
            <div class="date-display"></div>
            <h1 class="title">Mis Vales</h1>
            <p class="subtitle"></p>
        </div>
        <div id="meals-container">
            <!-- Cards will be inserted here -->
        </div>

        <div class="buttons">
            <a href="{{route('seleccionar')}}">

                <button class="btn btn-primary">
                    <b>Editar vales</b></button>
            </a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let mealPlanData = @json($mealPlanData);
    $(document).ready(function() {
        const MEAL_TYPES = @json($foodsDisponibles)

        // Group meals by date
        const groupedMeals = mealPlanData.reduce((acc, curr) => {
            if (!acc[curr.date]) {
                acc[curr.date] = [];
            }
            acc[curr.date].push(curr.food_id);
            return acc;
        }, {});

        // Format date and get day name
        function formatDate(dateStr) {
            const [day, month] = dateStr.split('-');
            // Create date with the correct year and time zone
            const date = new Date(2024, month - 1, parseInt(day));
            const dayNames = ['Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo', 'Lunes'];
            return `${dayNames[date.getDay()]} ${day}/${month}`;
        }

        // Sort dates in ascending order and generate HTML
        Object.entries(groupedMeals)
            .sort(([dateA], [dateB]) => {
                const [dayA, monthA] = dateA.split('-').map(Number);
                const [dayB, monthB] = dateB.split('-').map(Number);
                return monthA !== monthB ? monthA - monthB : dayA - dayB;
            })
            .forEach(([date, meals]) => {
                const cardHtml = `
                    <div class="meal-card">
                        <div class="card-header">
                            <span class="date">${formatDate(date)}</span>
                            <span class="meal-count">${meals.length} comidas</span>
                        </div>
                        <div class="meal-list">
                            ${meals.sort().map(mealId => `
                                <div class="meal-item">
                                    <div class="meal-dot"></div>
                                    <span class="meal-name">${MEAL_TYPES[mealId]}</span>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
                $('#meals-container').append(cardHtml);
            });
    });
</script>
</body>
</html>
