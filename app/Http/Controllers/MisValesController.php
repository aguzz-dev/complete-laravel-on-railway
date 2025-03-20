<?php
namespace App\Http\Controllers;
use App\Models\Food;
use App\Models\FoodUser;
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
            ->wherePivot('date', '>=', Carbon::now()->subHour(3)->setTime(0, 0)->format('Y-m-d H:i:s'))
            ->get();
        $mealPlanData = $mealPlans->map(function ($meal) {
            return [
                'date' => Carbon::parse($meal->pivot->date)->format('d-m'),
                'food_id' => $meal->id,
                'status' => FoodUser::where('food_id', $meal->id)
                    ->where('date', $meal->pivot->date)
                    ->where('user_id', auth()->user()->id)
                    ->value('status')
            ];
        })->toArray();

        return view('misVales', compact('mealPlanData', 'foodsDisponibles', 'datosUsuario'));
    }
}
