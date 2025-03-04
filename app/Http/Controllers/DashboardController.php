<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodUser;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function goToDashboardView()
    {
        $fechaHoy = Carbon::now()->subHour(3)->format('Y-m-d') . ' 00:00:00';

        // Obtener la cantidad de cada comida seleccionada
        $cantidadPorComida = FoodUser::where('date', '=', $fechaHoy)
            ->selectRaw('food_id, COUNT(*) as cantidad')
            ->groupBy('food_id')
            ->pluck('cantidad', 'food_id');

        // Obtener las comidas creadas por la unidad del usuario autenticado
        $comidasCreadasByUnidad = Food::where('unit_id', auth()->user()->unit_id)
            ->pluck('descripcion', 'id');

        // Estructura de comidas con cantidad
        $comidasList = [];
        foreach ($comidasCreadasByUnidad as $id => $nombre) {
            $comidasList[$id] = [
                'nombre' => $nombre,
                'cantidad' => $cantidadPorComida[$id] ?? 0, // Si no existe, se pone 0
            ];
        }

        // Obtener las comidas seleccionadas por usuario
        $comidasSeleccionadasByUsuario = FoodUser::where('date', '>=', $fechaHoy)
            ->whereHas('user', function ($query) {
                $query->where('unit_id', auth()->user()->unit_id);
            })
            ->with(['user', 'food'])
            ->get();

        $comidasSeleccionadasByUsuarioFormatted = [];

        foreach ($comidasSeleccionadasByUsuario as $comida) {
            $userId = $comida->user->id;
            $userKey = $comida->date . '-' . $comida->user->dni;

            if (!isset($comidasSeleccionadasByUsuarioFormatted[$userKey])) {
                $comidasSeleccionadasByUsuarioFormatted[$userKey] = [
                    'id' => $userId,
                    'date' => $comida->date,
                    'dni' => $comida->user->dni,
                    'nombre' => $comida->user->grado . ' ' . $comida->user->apellido . ' ' . $comida->user->nombre,
                    'estado' => 'pendiente', // Valor por defecto
                    'comida_usada' => [],   // Inicializamos como array
                ];
            }

            // Marcar estado como "usado" si alguna comida tiene ese estado
            $estadoActual = FoodUser::where('user_id', $userId)
                ->where('date', $comida->date)
                ->where('status', 'usado')
                ->exists();

            if ($estadoActual) {
                $comidasSeleccionadasByUsuarioFormatted[$userKey]['estado'] = 'usado';
            }

            // Agregar comida usada si su estado es "usado"
            if ($comida->status === 'usado') {
                $comidaDescripcion = $comida->food->descripcion;
                if (!in_array($comidaDescripcion, $comidasSeleccionadasByUsuarioFormatted[$userKey]['comida_usada'])) {
                    $comidasSeleccionadasByUsuarioFormatted[$userKey]['comida_usada'][] = $comidaDescripcion;
                }
            }

            // Registrar si el usuario seleccionó esta comida
            foreach ($comidasCreadasByUnidad as $id => $descripcion) {
                $comidasSeleccionadasByUsuarioFormatted[$userKey][$descripcion] =
                    $comida->food->id == $id || ($comidasSeleccionadasByUsuarioFormatted[$userKey][$descripcion] ?? false);
            }
        }

        // Convertimos los valores en un array indexado
        $result = array_values($comidasSeleccionadasByUsuarioFormatted);

        return view('dashboard', [
            'fechaHoy' => Carbon::now()->subHour(3)->format('Y-m-d'),
            'comidas' => $comidasList,
            'usuarios' => $result
        ]);
    }

    public function filtroByDate($date)
    {
        $formattedDate = Carbon::parse($date)->format('Y-m-d') . ' 00:00:00';

        $cantidadPorComida = FoodUser::where('date', '=', $formattedDate)
            ->selectRaw('food_id, COUNT(*) as cantidad')
            ->groupBy('food_id')
            ->pluck('cantidad', 'food_id');

        $comidasCreadasByUnidad = Food::where('unit_id', auth()->user()->unit_id)
            ->pluck('descripcion', 'id');

        $comidasList = [];
        foreach ($comidasCreadasByUnidad as $id => $nombre) {
            $comidasList[$id] = [
                'nombre' => $nombre,
                'cantidad' => $cantidadPorComida[$id] ?? 0,
            ];
        }

        return $comidasList;
    }
}
