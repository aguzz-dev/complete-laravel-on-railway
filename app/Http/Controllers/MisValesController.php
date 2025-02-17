<?php
namespace App\Http\Controllers;
use App\Models\Food;
use Carbon\Carbon;
use Illuminate\Http\Request;


class MisValesController extends Controller
{
    public function goToMisValesView()
    {
        $user = auth()->user();
        $datosUsuario = $user->grado . ' ' . ucwords(strtolower($user->apellido)) . ' ' . ucwords(strtolower($user->nombre)) . ' - ' . $user->dni;

        $foodsDisponibles = Food::where('unit_id', '=', $user->unit_id)
            ->pluck('descripcion', 'id');

        $mealPlans = $user->foods()
            ->wherePivot('date', '>=', Carbon::today())
            ->get();

        $mealPlanData = $mealPlans->map(function ($meal) {
            return [
                'date' => Carbon::parse($meal->pivot->date)->format('d-m'),
                'food_id' => $meal->id,
            ];
        })->toArray();

        return view('misVales', compact('mealPlanData', 'foodsDisponibles', 'datosUsuario'));
    }
}
