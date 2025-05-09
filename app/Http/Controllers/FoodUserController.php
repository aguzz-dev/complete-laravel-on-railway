<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoodUserController extends Controller
{
    public function goToSeleccionarView()
    {
        $user = auth()->user();

        $comidasCreadasByUnidad = Food::where('unit_id', auth()->user()->unit_id)->pluck('id','descripcion');

        $comidasSeleccionadasByUsuario = $user->foods()
            ->get();

        $comidasByUsuario = [];

        $fh = Carbon::now()->subHours(3);
        $horaLimite = Carbon::now()->subHours(3)->setTime(9, 30);

        foreach ($comidasSeleccionadasByUsuario as $comida) {
            $date = Carbon::parse($comida->pivot->date)->format('d-m');
            $comidasByUsuario[] = [
                'date' => $date,
                'comida' => $comida->descripcion,
                'food_id' => $comida->id,
            ];
        }
        return view('seleccionar', compact(['comidasByUsuario', 'comidasCreadasByUnidad', 'fh', 'horaLimite']));
    }

    public function guardarRacionesSeleccionadas(Request $request)
    {
        // Convertir indexDay y limitDay a formato válido (YYYY-MM-DD)
        $year = now()->year;
        $indexDay = Carbon::createFromFormat('d-m', $request->indexDay)->format("$year-m-d");
        $limitDay = Carbon::createFromFormat('d-m', $request->limitDay)->format("$year-m-d");

        // Eliminar solo las raciones dentro del rango de fechas
        FoodUser::where('user_id', $request->userId)
            ->whereBetween('date', [$indexDay, $limitDay])
            ->delete();

        // Insertar las nuevas selecciones
        $comidasSeleccionadas = collect($request->mealPlan)->map(function ($item) use ($request) {
            return [
                'user_id' => $request->userId,
                'food_id' => $item['food_id'],
                'date' => $item['date'],
            ];
        })->toArray();

        FoodUser::insert($comidasSeleccionadas);
    }

    public function valesTodayByUser($userId)
    {
        $comidasCreadasByUnidad = Food::where('unit_id', auth()->user()->unit_id)->pluck('descripcion', 'id');

        $comidasHoy = FoodUser::where('user_id', $userId)
            ->whereDate('date', Carbon::today())
            ->get();

        $resultado = $comidasHoy->mapWithKeys(function ($foodUser) use ($comidasCreadasByUnidad) {
            $descripcion = $comidasCreadasByUnidad[$foodUser->food_id] ?? 'Desconocido';
            return [$descripcion => 'true'];
        })->toArray();

        $comidasFinales = $comidasCreadasByUnidad->mapWithKeys(fn($desc) => [$desc => 'false'])->merge($resultado);

        return response()->json($comidasFinales);
    }

    public function valesTodayByDate($userId, Request $request)
    {
        $fechaRegistro = $request->date;
        $comidasCreadasByUnidad = Food::where('unit_id', auth()->user()->unit_id)->pluck('descripcion', 'id');

        $comidasHoy = FoodUser::where('user_id', $userId)
            ->where('date', $fechaRegistro)
            ->get();

        $resultado = $comidasHoy->mapWithKeys(function ($foodUser) use ($comidasCreadasByUnidad) {
            $descripcion = $comidasCreadasByUnidad[$foodUser->food_id] ?? 'Desconocido';
            return [$descripcion => 'true'];
        })->toArray();

        $comidasFinales = $comidasCreadasByUnidad->mapWithKeys(fn($desc) => [$desc => 'false'])->merge($resultado);

        return response()->json($comidasFinales);
    }

    public function editValesByUser(Request $request)
    {
        $fechaRegistro = $request->date;
        // Eliminar vales previos del usuario para hoy
        FoodUser::where('date', $fechaRegistro)
            ->where('user_id', $request->userId)
            ->delete();

        // Obtener los IDs de comidas disponibles en la unidad
        $comidasCreadasByUnidad = Food::where('unit_id', auth()->user()->unit_id)->pluck('id', 'descripcion');

        // Recorrer las selecciones del usuario
        foreach ($request->selections as $comida => $seleccion) {
            if ($seleccion === "true" && isset($comidasCreadasByUnidad[$comida])) {
                FoodUser::create([
                    'date' => $fechaRegistro,
                    'user_id' => $request->userId,
                    'food_id' => $comidasCreadasByUnidad[$comida], // Asociar el ID correcto
                ]);
            }
        }
    }
}
