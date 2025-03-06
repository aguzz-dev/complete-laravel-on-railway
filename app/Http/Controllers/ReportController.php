<?php


namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodUser;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function goToDescargarReportesView()
    {
        $reporteHoy = Carbon::now()->subHour(3)->format('d/m/Y');
        $meses = FoodUser::selectRaw('DATE_FORMAT(date, "%Y-%m-%d") as formatted_date')
            ->distinct()
            ->pluck('formatted_date');
        return view('descargarReportes', compact('meses', 'reporteHoy'));
    }

    public function generatePDF(Request $request)
    {
        $mes = $request->mes;
        $unidad = $request->unit_id;

        $tiposComida = Food::where('unit_id', $unidad)->pluck('descripcion', 'id');
        $comidasPorUsuario = FoodUser::where('date', 'like', $mes . '%')
            ->join('foods', 'food_users.food_id', '=', 'foods.id')
            ->join('users', 'food_users.user_id', '=', 'users.id')
            ->where('foods.unit_id', $unidad)
            ->where('users.unit_id', $unidad)
            ->with(['user', 'food'])
            ->get()
            ->groupBy(['user_id', 'food_id']);

        $meals = [];

        foreach ($comidasPorUsuario as $userId => $comidas) {
            $usuario = $comidas->first()->first()->user;
            $nombreUsuario = $usuario->grado . ' ' . $usuario->apellido . ' ' . $usuario->nombre;

            $meals[$nombreUsuario] = [];

            foreach ($comidas as $foodId => $comidasTipo) {
                $tipoComida = $tiposComida[$foodId] ?? 'Otro'; // Si no existe el tipo de comida, asignar 'Otro'
                $precioTotal = (float) ($comidasTipo->first()->food->precio ?? 0);
                $meals[$nombreUsuario][$tipoComida] = [
                    'cantidad' => $comidasTipo->count(),
                    'precio_total' => $precioTotal * $comidasTipo->count() // Precio por cantidad
                ];
            }
        }
        $fechaDeGeneracion = Carbon::now()->subHour(3)->format('d/m/Y H:i:s');

        Carbon::setLocale('es');
        $fecha = Carbon::createFromFormat('Y-m', $request->mes);
        $nombreMesYear = $fecha->translatedFormat('F Y');

        $pdf = PDF::loadView('report', compact(['meals', 'fechaDeGeneracion', 'nombreMesYear']));

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Reporte-ValesEA.pdf"');
    }

    public function generatePDFHoy(Request $request)
    {
        $fechaHoy = Carbon::createFromFormat('d/m/Y', $request->mes)->format('Y-m-d ') . ' 00:00:00';
        $unidad = $request->unit_id;

        $tiposComida = Food::where('unit_id', $unidad)->pluck('descripcion', 'id');

        $comidasPorUsuario = FoodUser::where('date', $fechaHoy)
            ->with(['user', 'food'])
            ->get()
            ->groupBy(['user_id', 'food_id']);

        $meals = [];

        foreach ($comidasPorUsuario as $userId => $comidas) {
            $usuario = $comidas->first()->first()->user;
            $nombreUsuario = $usuario->grado . ' ' . $usuario->apellido . ' ' . $usuario->nombre;

            $meals[$nombreUsuario] = [];

            foreach ($comidas as $foodId => $comidasTipo) {
                $tipoComida = $tiposComida[$foodId] ?? 'Otro'; // Si no existe el tipo de comida, asignar 'Otro'

                // Calcular el total del precio por cantidad
                $precioTotal = (float) ($comidasTipo->first()->food->precio ?? 0);
                $meals[$nombreUsuario][$tipoComida] = [
                    'cantidad' => $comidasTipo->count(),
                    'precio_total' => $precioTotal * $comidasTipo->count() // Precio por cantidad
                ];
            }
        }

        $fechaDeGeneracion = Carbon::now()->subHour(3)->format('d/m/Y H:i:s');
        $nombreMesYear = Carbon::now()->subHour(3)->format('d/m/Y');

        $pdf = PDF::loadView('reportHoy', compact(['meals', 'fechaDeGeneracion', 'nombreMesYear']));

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Reporte-ValesEA.pdf"');
    }

    public function generatePDFFecha(Request $request)
    {
        $fecha = Carbon::parse($request->fecha)->format('Y-m-d ') . ' 00:00:00';
        $unidad = $request->unit_id;

        // Obtener los tipos de comida
        $tiposComida = Food::where('unit_id', $unidad)->pluck('descripcion', 'id');

        // Obtener las comidas agrupadas por usuario y tipo de comida
        $comidasPorUsuario = FoodUser::where('date', $fecha)
            ->with(['user', 'food'])
            ->get()
            ->groupBy(['user_id', 'food_id']);

        $meals = [];

        foreach ($comidasPorUsuario as $userId => $comidas) {
            $usuario = $comidas->first()->first()->user;
            $nombreUsuario = $usuario->grado . ' ' . $usuario->apellido . ' ' . $usuario->nombre;

            $meals[$nombreUsuario] = [];

            foreach ($comidas as $foodId => $comidasTipo) {
                $tipoComida = $tiposComida[$foodId] ?? 'Otro'; // Si no existe el tipo de comida, asignar 'Otro'

                // Calcular el total del precio por cantidad
                $precioTotal = (float) ($comidasTipo->first()->food->precio ?? 0);
                $meals[$nombreUsuario][$tipoComida] = [
                    'cantidad' => $comidasTipo->count(),
                    'precio_total' => $precioTotal * $comidasTipo->count() // Precio por cantidad
                ];
            }
        }
        $fechaDeGeneracion = Carbon::now()->subHour(3)->format('d/m/Y H:i:s');

        $nombreMesYear = Carbon::parse($request->fecha)->format('d/m/y');

        $pdf = PDF::loadView('reportFecha', compact(['meals', 'fechaDeGeneracion', 'nombreMesYear']));

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Reporte-ValesEA.pdf"');
    }
}
