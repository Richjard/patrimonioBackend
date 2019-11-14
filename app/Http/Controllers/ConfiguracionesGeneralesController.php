<?php

namespace App\Http\Controllers;

use App\GrlConfiguracionGeneral;
use Illuminate\Http\Request;

class ConfiguracionesGeneralesController extends Controller
{
    //
    public function configuracion(){
        $conf = GrlConfiguracionGeneral::first();
        return response()->json($conf);
    }
}
