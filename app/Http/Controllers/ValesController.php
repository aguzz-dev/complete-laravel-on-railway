<?php


namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodUser;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ValesController extends Controller
{
    public function goToValesView()
    {
        return view('comidas');
    }

    public function getVales(Request $request)
    {
        $vales = Food::where('unit_id', auth()->user()->unit_id)->get();
      return response()->json($vales);
    }
}
