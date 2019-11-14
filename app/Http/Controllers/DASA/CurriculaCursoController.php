<?php

namespace App\Http\Controllers\DASA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UraCurriculaCursoDetalle;

class CurriculaCursoController extends Controller
{   
    /**
     * 
     */
    public function obtenerCarrerasPlanes()
    {
        $carreras = \DB::select('exec ura.Sp_GRAL_SEL_RegistrosXcShemaXcNombreTabla ?, ?',array('ura', 'carreras'));

        $planes = \DB::select('exec ura.Sp_GRAL_SEL_RegistrosXcShemaXcNombreTabla ?, ?',array('ura', 'curriculas'));

        $secciones = \DB::select('exec ura.Sp_GRAL_SEL_RegistrosXcShemaXcNombreTabla ?, ?',array('ura', 'secciones'));

        $data = ['carreras' => $carreras, 'planes' => $planes, 'secciones' => $secciones]; 

        return response()->json( $data );
    }

    /**
     * 
     */
    public function obtenerCurriculaPorCarreraPlan($carreraId, $curricId)
    {
        $cursos = UraCurriculaCursoDetalle::select('iCurricDetId','iCurricCursoId','iCurricDetTtcurso', 'cCurricDetCicloCurso','cCurricDetActi','iCurricDetActiSecc')->where('iCarreraId', $carreraId)->where('iCurricId', $curricId)->with(['uraCurriculaCurso'])->orderBy('cCurricDetCicloCurso', 'asc')->get();

        return response()->json( $cursos );
    }

    /**
     * 
     */
    public function guardarEstadoCheckCurso(Request $request)
    {
        $this->validate(
            $request, 
            [
                'cursoId' => 'required|integer',
                'check' => 'required|boolean',
                'secciones' => 'required|integer',
            ], 
            [
                'cursoId.required' => 'Hubo un problema al obtener información del curso.',
                'check.required' => 'Hubo un problema al obtener información del Checkbox.',
                'secciones.required' => 'Hubo un problema al obtener información del Checkbox.',
            ]
        );

        $parametros = [
            $request->cursoId, 
            $request->check,
            $request->secciones, 
            'user'/*auth()->user()->cCredUsuario*/, 
            'equipo', 
            $request->server->get('REMOTE_ADDR'), 
            'mac'
        ];

        try {
            $data = \DB::select('exec ura.[Sp_DASA_UPD_activaCursosPlan] ?, ?, ?, ?, ?, ?, ?', $parametros);

            $response = ['validated' => true, 'mensaje' => 'Datos actualizados exitosamente.', 'data' => $data];
            $codeResponse = 200;

        } catch (\Exception $e) {

            $response = ['validated' => true, 'mensaje' => substr($e->errorInfo[2], 54), 'code' => $e->getCode()];
            $codeResponse = 500; 
        }

        return response()->json($response, $codeResponse);
    }

    /**
     * 
     */
    public function obtenerCurriculaCursoDetalle($carreraId, $curricId)
    {
        $cursos = \DB::select('exec ura.[Sp_DASA_SEL_curriculasCursosDetalles] ?, ?', array( $carreraId, $curricId ));

        return response()->json( $cursos );
    }
}
