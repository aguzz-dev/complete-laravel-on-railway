<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://i.imgur.com/BLJohUm.png" type="image/x-icon">
    <title>ValesEA - Reporte {{ str_replace('/', ' ', ucwords($nombreMesYear)) }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; font-size: 12px; }
        .report-title { text-align: center; margin-bottom: 20px; font-size: 16px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f8f9fa; font-weight: bold; }
        .user-name { text-align: left; font-weight: bold; }
    </style>
</head>
<body>

@php
    use Illuminate\Support\Str;
    $tiposComida = collect($meals)->first() ? array_keys(collect($meals)->first()) : [];
@endphp

<div class="report-title">Reporte del {{ $nombreMesYear }}</div>

<table>
    <thead>
    <tr>
        <th>Usuario</th>
        @foreach($tiposComida as $comida)
            <th title="{{ $comida }}">{{ Str::limit($comida, 15) }}</th>
        @endforeach
        <th>Total $</th>
    </tr>
    </thead>
    <tbody>
    @foreach($meals as $user => $userMeals)
        <tr>
            <td class="user-name" title="{{ $user }}">{{ Str::limit($user, 20) }}</td>
            @foreach($tiposComida as $comida)
                <td>{{ $userMeals[$comida]['cantidad'] ?? 0 }}</td>
            @endforeach
            <td>
                ${{ number_format(
                    collect($userMeals)->sum(fn($c) => $c['precio_total'] ?? 0), 2)
                }}
            </td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th>Total</th>
        @foreach($tiposComida as $comida)
            <td>{{ collect($meals)->sum(fn($user) => $user[$comida]['cantidad'] ?? 0) }}</td>
        @endforeach
        <td>
            ${{ number_format(
                collect($meals)->sum(fn($user) =>
                    collect($user)->sum(fn($c) => $c['precio_total'] ?? 0)
                ), 2)
            }}
        </td>
    </tr>
    </tfoot>
</table>

<div style="font-size: 10px; text-align: right;">
    ValesEA Reportes - Fecha de generación: {{ $fechaDeGeneracion }}
</div>

</body>
</html>
