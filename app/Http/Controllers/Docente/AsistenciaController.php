<?php

namespace App\Http\Controllers\Docente;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Docente\Docente;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Generales\GrlPersonasController;
use App\GrlConfiguracionGeneral;
use App\GrlPersona;
use GuzzleHttp\Client;
use DB;

class AsistenciaController extends Controller
{
    public function datosDocente($iPersId) {

        $docente = Docente::findOrFail($iPersId);
        $docente = $docente->load('categoria','condicion','dedicacion');

        $reniec = DB::select('EXEC grl.Sp_SEL_reniecXcReniecDni ?',[$docente->cDoceDni]);

       /*  $client = new Client([
                'base_uri' => 'http://200.48.160.218:8081/api/pide/',
                'timeout'  => 2.0,
        ]);
        //\print_r($docente->cDoceDni);
        $response = $client->request('GET','reniec',[
            'query' => ['reniec' => $docente->cDoceDni]
        ]);

        $pide = json_decode ($response->getBody()->getContents()); */

        $rutas = GrlConfiguracionGeneral::all();
        $persona = GrlPersona::findOrFail($iPersId);

        return Response::json(['results' => $docente, 'reniec' => $reniec, 'rutas' => $rutas, 'persona' => $persona],200);

    }

    public function generarAsistencia($iDocenteId,$ControlCicloAcad,$iCurricId,$iFilId,$iCarreraId,$cCurricCursoCod,$iSeccionId){

       /*  $asistencia = DB::select('exec ura.Sp_DOCE_INS_Asistencia_Genera_TodosListados_UnicaVez ?,?,?,?,?,?,?', array($iDocenteId,$ControlCicloAcad,$iCurricId,$iFilId,$iCarreraId,$cCurricCursoCod,$iSeccionId));
        dump($asistencia); */

         try {
            $asistencia = DB::select('exec ura.Sp_DOCE_INS_Asistencia_Genera_TodosListados_UnicaVez ?,?,?,?,?,?,?', array($iDocenteId,$ControlCicloAcad,$iCurricId,$iFilId,$iCarreraId,$cCurricCursoCod,$iSeccionId));

            $response = ['validated' => true, 'mensaje' => 'Sp_DOCE_INS_Asistencia_Genera_TodosListados_UnicaVez.'];

        } catch (\Exception $e) {
            $response = ['validated' => true, 'mensaje' => substr($e->errorInfo[2], 54), 'code' => $e->getCode()];
        }

        return response()->json($asistencia);

    }

     public function faltantesAsistencia($iDocenteId,$ControlCicloAcad,$iCurricId,$iFilId,$iCarreraId,$cCurricCursoCod,$iSeccionId){

       /*  $asistencia = DB::select('exec ura.Sp_DOCE_INS_Asistencia_Genera_TodosListados_UnicaVez ?,?,?,?,?,?,?', array($iDocenteId,$ControlCicloAcad,$iCurricId,$iFilId,$iCarreraId,$cCurricCursoCod,$iSeccionId));
        dump($asistencia); */

         try {
            $faltan = DB::select('exec ura.Sp_DOCE_UPD_Asistencia_ActualizaListadoAPendiente ?,?,?,?,?,?,?', array($iDocenteId,$ControlCicloAcad,$iCurricId,$iFilId,$iCarreraId,$cCurricCursoCod,$iSeccionId));

            $response = ['validated' => true, 'mensaje' => 'Sp_DOCE_UPD_Asistencia_ActualizaListadoAPendiente.'];

        } catch (\Exception $e) {
            $response = ['validated' => true, 'mensaje' => substr($e->errorInfo[2], 54), 'code' => $e->getCode()];
        }

        return response()->json(['faltan' => $faltan, 'res' => $response]);

    }




}
