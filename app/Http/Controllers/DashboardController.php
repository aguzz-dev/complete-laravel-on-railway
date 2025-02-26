<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function goToDashboardView()
    {

        $cantidadPorComida = FoodUser::where('date', '=', Carbon::today()->subHour(3)->format('Y-m-d') . ' 00:00:00')
            ->selectRaw('food_id, COUNT(*) as cantidad')
            ->groupBy('food_id')
            ->pluck('cantidad', 'food_id');

        $comidasCreadasByUnidad = Food::where('unit_id', auth()->user()->unit_id)->pluck('descripcion', 'id');

        $comidasList = [];
        foreach ($comidasCreadasByUnidad as $id => $nombre) {
            $comidasList[$id] = [
                'nombre' => $nombre,
                'cantidad' => $cantidadPorComida[$id] ?? 0, // Si no existe en $cantidadPorComida, se pone 0
            ];
        }

        $comidasSeleccionadasByUsuario = FoodUser::where('date', '>=', Carbon::today()->subHour(3)->format('Y-m-d') . ' 00:00:00')
            ->with(['user', 'food'])
            ->get();

        $comidasSeleccionadasByUsuarioFormatted = [];

        foreach ($comidasSeleccionadasByUsuario as $comida) {
            $comidaArray = [
                'id' => $comida->user->id,
                'date' => $comida->date,
                'dni' => $comida->user->dni,
                'nombre' => $comida->user->grado . ' ' . $comida->user->apellido . ' ' . $comida->user->nombre,
                'estado' => FoodUser::where('id', $comida->id)->pluck('status')[0],
                'comida_usada' => Food::where('id', $comida->food->id)->pluck('descripcion')[0]
            ];

            foreach ($comidasCreadasByUnidad as $id => $descripcion) {
                // Si el usuario seleccionó esta comida, marcamos true, de lo contrario false
                $comidaArray[$descripcion] = $comida->food->id == $id;
            }

            $comidasSeleccionadasByUsuarioFormatted[] = $comidaArray;
        }


        $groupedData = [];

        foreach ($comidasSeleccionadasByUsuarioFormatted as $entry) {
            $key = $entry['date'] . '-' . $entry['dni'];

            if (!isset($groupedData[$key])) {
                $groupedData[$key] = $entry;
            } else {
                // Iterar dinámicamente sobre las claves de comidas
                foreach ($comidasCreadasByUnidad as $comida) {
                    if (isset($entry[$comida])) {
                        $groupedData[$key][$comida] |= $entry[$comida];
                    }
                }
            }
        }

        $result = array_values($groupedData);


        $fechaHoy = Carbon::today()->subHour(3)->format('Y-m-d');

        return view('dashboard', [
            'fechaHoy' => $fechaHoy,
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

        $comidasCreadasByUnidad = Food::where('unit_id', auth()->user()->unit_id)->pluck('descripcion', 'id');

        $comidasList = [];
        foreach ($comidasCreadasByUnidad as $id => $nombre) {
            $comidasList[$id] = [
                'nombre' => $nombre,
                'cantidad' => $cantidadPorComida[$id] ?? 0,
            ];
        }
//        dd($comidasList);
        return $comidasList;
    }
}
