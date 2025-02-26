<?php
namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodUser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ControlValesController extends Controller
{
    public function goToControlValesView()
    {
        $today = Carbon::now()->subHour(3)->format('Y-m-d') . ' 00:00:00';

        $Allvales = FoodUser::where('date', $today)
            ->get()
            ->map(function ($vale) {
                return [
                    'id' => $vale->food->id,
                    'descripcion' => $vale->food->descripcion ?? 'Sin descripción', // Asegúrate de tener una relación `food`
                    'fecha' => Carbon::parse($vale->date)->format('Y-m-d'),
                    'estado' => $vale->status,
                ];
            });

        $vales = $Allvales->unique('id');

        return view('controlVales', compact('vales'));
    }

    public function getValesDiarios($valeId)
    {
        $hoy = Carbon::now()->subHour(3)->format('Y-m-d') . ' 00:00:00';
        $nombreVale = Food::where('id', $valeId)->value('descripcion');

        $vales = FoodUser::where('food_id', $valeId)
            ->where('date', $hoy)
            ->whereHas('user', function ($query) {
                $query->where('unit_id', auth()->user()->unit_id);
            })
            ->with('user')
            ->get()
            ->map(function ($vale) use ($hoy, $nombreVale) {
                return [
                    'id' => $vale->id,
                    'nombre' => $vale->user->grado . ' ' . $vale->user->apellido . ' ' . $vale->user->nombre . ' - ' . $vale->user->dni,
                    'descripcion' => $nombreVale,
                    'fecha' => Carbon::parse($vale->date)->format('d/m/Y'),
                    'estado' => $vale->status,
                ];
            });


        return response()->json($vales);
    }

    public function cambiarEstadoVale(Request $request)
    {
        $vale = FoodUser::where('id', $request->id)->first();
        if ($vale) {
            $vale->status = $request->estado;
            $vale->save();
            return response()->json(['Estado del vale cambiado a ' . $request->estado . ' con exito']);
        }
        return response()->json(['Error al cambiar estado del vale a ' . $request->estado], 500);
    }
}
