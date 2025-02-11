<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://i.imgur.com/BLJohUm.png" type="image/x-icon">
    <title>ValesEA - Reporte {{ str_replace('/', ' ', ucwords($nombreMesYear)) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }
        .report-title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 16px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .user-name {
            text-align: left;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="report-title">
    Reporte {{ str_replace('/', ' ', ucwords($nombreMesYear)) }}
</div>

<table>
    <thead>
    <tr>
        <th>Usuario</th>
        <th>Desayuno</th>
        <th>Almuerzo</th>
        <th>Cena</th>
    </tr>
    </thead>
    <tbody>
    @foreach($meals as $user => $userMeals)
        <tr>
            <td class="user-name">{{ $user }}</td>
            <td>{{ $userMeals['Desayno'] ?? 0 }}</td>
            <td>{{ $userMeals['Almuerzo'] ?? 0 }}</td>
            <td>{{ $userMeals['Cena'] ?? 0 }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th>Total</th>
        <td>
            {{ collect($meals)->sum(function($user) {
                return $user['Desayno'] ?? 0;
            }) }}
        </td>
        <td>
            {{ collect($meals)->sum(function($user) {
                return $user['Almuerzo'] ?? 0;
            }) }}
        </td>
        <td>
            {{ collect($meals)->sum(function($user) {
                return $user['Cena'] ?? 0;
            }) }}
        </td>
    </tr>
    </tfoot>
</table>

<div style="font-size: 10px; text-align: right;">
    ValesEA Reportes - Fecha de generación: {{ $fechaDeGeneracion }}
</div>
</body>
</html>
