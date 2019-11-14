<?php

namespace App\Http\Controllers\Generales;

use App\GrlConfiguracionGeneral;
use App\GrlPersona;
use App\GrlReniec;
use App\Http\Controllers\PideController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GrlPersonasController extends Controller
{
    //
    public function getFotografia(Request $request) {
        if (($request->code) && is_numeric($request->code) ) {

            $configGrl = GrlConfiguracionGeneral::get();


            $persona = GrlPersona::where('iPersId', $request->code)->first();

            $jsonRespuesta = [];
            if ($persona) {
                if ($persona->cPersFotografia) {
                    $configGrlFotoPath = $configGrl->where('cConfigGrlesNombre', 'rutaPersonas')->first();
                    $jsonRespuesta = [
                        'src' => $configGrlFotoPath->cConfigGrlesValor . $persona->cPersFotografia
                    ];
                }
                else {
                    $reniecP = GrlReniec::where('iPersId', $request->code)->first();
                    $configGrlFotoPath = $configGrl->where('cConfigGrlesNombre', 'rutaReniec')->first();
                    if (isset($reniecP->cReniecFotografia)) {
                        $jsonRespuesta = [
                            'src' => $configGrlFotoPath->cConfigGrlesValor . $reniecP->cReniecFotografia
                        ];
                    }
                    else {
                        $retApi = PideController::consultar($request, 'reniec', $request->code, true);
                        if (!$retApi['error']) {
                            $jsonRespuesta = [
                                'src' => $configGrlFotoPath->cConfigGrlesValor . $retApi['data']->cReniecFotografia
                            ];
                        }
                    }
                }
            }
        }
        return response()->json($jsonRespuesta);
    }

    public function getFotoReniec(Request $request, $local = false)
    {
        if (($request->code) && is_numeric($request->code) ) {

            $configGrl = GrlConfiguracionGeneral::get();

            $reniecP = GrlReniec::where('iPersId', $request->code)->first();
            $configGrlFotoPath = $configGrl->where('cConfigGrlesNombre', 'rutaReniec')->first();

            $jsonRespuesta = [ 'src' => null ];

            if (isset($reniecP->cReniecFotografia)) {
                $jsonRespuesta = [
                    'src' => $configGrlFotoPath->cConfigGrlesValor . $reniecP->cReniecFotografia
                ];
            }
            else {
                $retApi = PideController::consultar($request, 'reniec', $request->code, true);
                if (!$retApi['error']) {
                    $jsonRespuesta = [
                        'src' => $configGrlFotoPath->cConfigGrlesValor . $retApi['data']->cReniecFotografia
                    ];
                }
                else {
                    $jsonRespuesta = [ 'src' => null, 'error' => $retApi['error'], 'msg' => $retApi['msg'] ];
                }
            }
        }

        if ($local) {
            return $jsonRespuesta;
        }
        else {
            return response()->json($jsonRespuesta);
        }
    }
}
