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
        <th>Total $</th>  <!-- Nueva columna para el total en dinero -->
    </tr>
    </thead>
    <tbody>
    @foreach($meals as $user => $userMeals)
        <tr>
            <td class="user-name">{{ $user }}</td>
            <td>{{ $userMeals['Desayuno']['cantidad'] ?? 0 }}</td>
            <td>{{ $userMeals['Almuerzo']['cantidad'] ?? 0 }}</td>
            <td>{{ $userMeals['Cena']['cantidad'] ?? 0 }}</td>
            <td>
                ${{ number_format(
                    (float) ($userMeals['Desayuno']['precio_total'] ?? 0) +
                    (float) ($userMeals['Almuerzo']['precio_total'] ?? 0) +
                    (float) ($userMeals['Cena']['precio_total'] ?? 0), 2)
                 }}
            </td> <!-- Total en dinero por usuario -->
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th>Total</th>
        <td>
            {{ collect($meals)->sum(function($user) {
                return $user['Desayuno']['cantidad'] ?? 0;
            }) }}
        </td>
        <td>
            {{ collect($meals)->sum(function($user) {
                return $user['Almuerzo']['cantidad'] ?? 0;
            }) }}
        </td>
        <td>
            {{ collect($meals)->sum(function($user) {
                return $user['Cena']['cantidad'] ?? 0;
            }) }}
        </td>
        <td>
            ${{ number_format(collect($meals)->sum(function($user) {
                return ($user['Desayuno']['precio_total'] ?? 0) +
                       ($user['Almuerzo']['precio_total'] ?? 0) +
                       ($user['Cena']['precio_total'] ?? 0);
            }), 2) }}
        </td> <!-- Total en dinero de todas las comidas -->
    </tr>
    </tfoot>
</table>

<div style="font-size: 10px; text-align: right;">
    ValesEA Reportes - Fecha de generación: {{ $fechaDeGeneracion }}
</div>
</body>
</html>
