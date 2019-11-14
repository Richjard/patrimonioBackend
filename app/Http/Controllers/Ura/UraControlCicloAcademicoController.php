<?php

namespace App\Http\Controllers\Ura;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\UraControlCicloAcademico;

class UraControlCicloAcademicoController extends Controller
{
    /**
     * Obtiene el ciclo académico activo
     */
    public function obtenerCicloAcademicoActivo()
    {
        $data = \DB::select('exec ura.[Sp_GRAL_cicloAcademicoActivo]');

        return response()->json( $data[0] );
    }
}