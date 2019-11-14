<?php

namespace App\Http\Controllers\Ura;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UraCurricula;
use App\UraControlCicloAcademico;

class UraHorarioController extends Controller
{
    /**
     * Obtiene los planes y los ciclos académicos
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function getResult(){
       // $req = $request->get('tipo');
      //  $data =  $request->get('data') ;

       // if (!$data) {
        //    $data = [];
      //  }

      //  DB::enableQueryLog();
        $respuesta = null;
       
       // $respuesta = DB::select('EXECUTE tram.Sp_SEL_CiclosAcademicosMatricXcEstudCodUniv ?', $data);
          $respuesta = \DB::select("EXEC pat.Sp_SEL_locales");

        return response()->json($respuesta);
    }

    public function obtenerPlanesCiclosAcademicos()
    {
        $planes = UraCurricula::all();
        $ciclosAcademicos = UraControlCicloAcademico::orderBy('iControlCicloAcad', 'desc')->get();

        $data = [ 'planes' => $planes, 'ciclosAcademicos' => $ciclosAcademicos ];

        return response()->json($data);
    }

    /**
     * Obtiene los planes y los ciclos académicos
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function obtenerHorariosPorCarreraFilialCiclo(Request $request)
    {
        $horarios = \DB::select('exec ura.Sp_SEL_horariosXiCarreraIdXiFilIdXiControlCicloAcad ?, ?, ?, ?', array($request->iControlCicloAcad, $request->iFilId, $request->iCarreraId, $request->iCurricId));

        return response()->json($horarios);
    }

    /**
     * Obtiene los cursos activos, aulas (disponibles y no) y secciones
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function obtenerCursosAulasSecciones(Request $request)
    {
        $secciones =  \DB::select('exec ura.SP_SEL_secciones');
        $cursos = \DB::select('exec ura.sp_SEL_PlanEstudiosXiCarreraIdXiEstado ?, ?', array($request->carreraId, 1));// 1 para Cursos activos
        $aulas = \DB::select('exec ura.Sp_SEL_Aulas_Disponible_NoDisponible_XiCarreraIdXiFilIdXhIniXhFinXiDiaSemId ?, ?, ?, ?, ?, ?', array($request->carreraId, $request->filialId, $request->horaInicio, $request->horaFin, $request->dia, $request->cicloAcad));

        $data = [ 'cursos' => $cursos, 'aulas' => $aulas, 'secciones' => $secciones ];

        return response()->json($data);
    }

    /**
     * Obtiene los cursos activos, aulas (disponibles y no) y secciones
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function obtenerPlanesConCursosActivosPorCarrera($carreraId)
    {
        $cursos = \DB::select('exec ura.sp_SEL_PlanEstudiosXiCarreraIdXiEstado ?, ?', array($carreraId, 1));// 1 para Cursos activos

        $planes = UraCurricula::all();

        foreach ($planes as $plan) {
            $cursosPlan = [];
            foreach ($cursos as $curso) {
                if ($plan->iCurricId == $curso->iCurricId) {
                    $cursosPlan[] = $curso;
                }
            }
            $plan->cursos = $cursosPlan;
        }

        return response()->json($planes);
    }

    /**
     * Obtiene los docentes
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function obtenerPaginacionDocentesPorCarrera(Request $request)
    {
        $data = \DB::select('exec ura.Sp_SEL_docentesPaginadoXiCarreraIdXcBusquedaXsSortDirXpageNumberXpageSize ?, ?, ?, ?, ?', array($request->carrera, $request->busqueda, $request->orden, $request->pagina, $request->nRegistros));

        return response()->json($data);
    }

    /**
     * Inserta un registro en la tabla horarios
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function insertarBloqueHorario(Request $request)
    {
        $this->validate(
            $request,
            [
                'aulaCod' => 'required',
                'carreraId' => 'required',
                'filialId' => 'required',
                'cicloAcad' => 'required',
                'curriculaId' => 'required',
                'cursoCod' => 'required',
                'seccionId' => 'required',
                'dia' => 'required',
                'horaInicio' => 'required',
                'horaFin' => 'required',

            ],
            [
                'aulaCod.required' => 'Debe seleccionar un aula.',
                'carreraId.required' => 'Hubo un problema al verificar la carrera.',
                'filialId.required' => 'Hubo un problema al verificar la filial.',
                'cicloAcad.required' => 'Hubo un problema al verificar la filial.',
                'curriculaId.required' => 'Hubo un problema al verificar el plan curricular.',
                'cursoCod.required' => 'Debe seleccionar un curso.',
                'seccionId.required' => 'Debe seleccionar una sección.',
                'dia.required' => 'Hubo un problema al verificar el día.',
                'horaInicio.required' => 'Debe seleccionar una hora de inicio.',
                'horaFin.required' => 'Debe seleccionar una hora de término.',
            ]
        );

        $parametros = array(
            $request->aulaCod,
            $request->carreraId,
            $request->filialId,
            $request->cicloAcad,
            $request->curriculaId,
            $request->cursoCod,
            $request->seccionId,
            $request->dia,
            $request->horaInicio,
            $request->horaFin,
            'user',
            //auth()->user()->cCredUsuario,
            'equipo',
            $request->server->get('REMOTE_ADDR'),
            'mac'
        );

        try {
            $data = \DB::select('exec ura.Sp_HORA_INS_HorarioCurso ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?', $parametros);

            if ($data[0]->id > 0) {
                $response = ['validated' => true, 'mensaje' => 'Se guardó el horario exitosamente.'];
                $codeResponse = 200;
            } else {
                $response = ['validated' => true, 'mensaje' => 'No se ha podido guardar el horario.'];
                $codeResponse = 500;
            }
        } catch (\Exception $e) {
            $response = ['validated' => true, 'mensaje' => substr($e->errorInfo[2], 54), 'code' => $e->getCode()];

            $codeResponse = 500;
        }

        return response()->json($response, $codeResponse);
    }

    /**
     * Obtiene la configuración de horario por carrera y filial
     */
    public function obtenerConfigHorarioCarrera(Request $request)
    {
        $data = \DB::select('exec ura.Sp_HORA_SEL_horariosConfig ?, ?', array($request->carreraId, $request->filialId));

        return response()->json($data);
    }

    /**
     * Obtiene la configuración de horario por carrera y filial
     */
    public function guardarConfigHorarioCarrera(Request $request)
    {
        $this->validate(
            $request,
            [
                'horaInicio' => 'required',
                'horaFin' => 'required',
                'carreraId' => 'required',
                'filialId' => 'required',
                'lunes' => 'boolean',
                'martes' => 'boolean',
                'miercoles' => 'boolean',
                'jueves' => 'boolean',
                'viernes' => 'boolean',
                'sabado' => 'boolean',
                'domingo' => 'boolean',
            ],
            [
                'horaInicio.required' => 'Debe ingresar una hora de inicio.',
                'horaFin.required' => 'Debe ingresar una hora de término.',
                'carreraId.required' => 'Hubo un problema al verificar la carrera.',
                'filialId.required' => 'Hubo un problema al verificar la filial.',
            ]
        );

        $parametros = [
            $request->horaInicio,
            $request->horaFin,
            $request->lunes,
            $request->martes,
            $request->miercoles,
            $request->jueves,
            $request->viernes,
            $request->sabado,
            $request->domingo,
            $request->carreraId,
            $request->filialId,
            'user',
            //auth()->user()->cCredUsuario,
            'equipo',
            $request->server->get('REMOTE_ADDR'),
            'mac'
        ];


        $data = \DB::select('exec ura.Sp_HORA_INS_UPD_ConfigHoraria ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?', $parametros);

        if ($data[0]->resultado == 1) {
            $response = ['validated' => true, 'mensaje' => 'Se guardó la configuración de horario exitosamente.'];
            $codeResponse = 200;
        } elseif ($data[0]->resultado == 2) {
            $response = ['validated' => true, 'mensaje' => 'Se editó la configuración de horario exitosamente.'];
            $codeResponse = 200;
        } else {
            $response = ['validated' => true, 'mensaje' => 'Hubo un problema al editar o gurdar.'];
            $codeResponse = 500;
        }

        return response()->json($response, $codeResponse);
    }

    /**
     * Elimina un bloque de horario
     */
    public function eliminarBloqueHorario($id)
    {
        $data = \DB::select('exec ura.Sp_HORA_DEL_HorarioCurso ?', array($id));
        if ($data[0]->eliminados > 0) {
            $response = [ 'validated' => true, 'mensaje' => 'Se eliminó el horario exitosamente.', 'eliminados' => $data[0]->eliminados ];
            $codeResponse = 200;
        } else {
            $response = [ 'validated' => true, 'mensaje' => 'El horario no se ha podido eliminar o no existe.', 'eliminados' => $data[0]->eliminados ];
            $codeResponse = 500;
        }

        return response()->json($response, $codeResponse);
    }

    /**
     * Guarda una carga horaria
     */
    public function guardarCargaHoraria(Request $request)
    {
        $this->validate(
            $request,
            [
                'docenteId' => 'required|integer',
                'filialId' => 'required|integer',
                'carreraId' => 'required|integer',
                'curriculaId' => 'required|integer',
                'cursoCod' => 'required',
                'seccionId' => 'required|integer',
                'condicionId' => 'required|integer',
                'categoriaId' => 'required|integer',
                'dedicId' => 'required|integer',
                'dedicHoras' => 'required|integer',
                'docApru' => 'required',
            ],
            [
                'docenteId.required' => 'Debe seleccionar un docente',
                'filialId.required' => 'Hubo un problema al verificar la filial.',
                'carreraId.required' => 'Hubo un problema al verificar la carrera.',
                'curriculaId.required' => 'Hubo un problema al verificar el plan curricular.',
                'cursoCod.required' => 'Debe seleccionar un curso.',
                'seccionId.required' => 'Debe seleccionar una sección.',
                'condicionId.required' => 'Seleccione la Clasificación del Docente',
                'categoriaId.required' => 'Seleccione la Sub Clasificación del Docente',
                'dedicId.required' => 'Seleccione la Dedicación del Docente',
                'dedicHoras.required' => 'Ingrese el Numero de Horas de dedicación',
                'docApru.required' => 'Ingrese el Documento de aprobación.',
            ]
        );

        $parametros = [
            $request->docenteId,
            $request->filialId,
            $request->carreraId,
            $request->curriculaId,
            $request->cursoCod,
            $request->seccionId,
            $request->condicionId,
            $request->categoriaId,
            $request->dedicId,
            $request->dedicHoras,
            $request->docApru,
            'user',
            //auth()->user()->cCredUsuario,
            'equipo',
            $request->server->get('REMOTE_ADDR'),
            'mac'
        ];

        try {
            $data = \DB::select('exec ura.Sp_HORA_INS_cargasHorarias ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?', $parametros);

            $response = ['validated' => true, 'mensaje' => 'Se guardó la carga horaria  exitosamente.'];
            $codeResponse = 200;
        } catch (\Exception $e) {
            $response = ['validated' => true, 'mensaje' => substr($e->errorInfo[2], 54), 'code' => $e->getCode()];

            $codeResponse = 500;
        }

        return response()->json($response, $codeResponse);
    }

    /**
     * Selecciona los planes con cargas académicas
     */
    public function obtenerPlanesConCargasAcademicas(Request $request)
    {
        $cargas = \DB::select('exec ura.Sp_HORA_SEL_cargaAcademica ?, ?', array($request->carreraId, $request->filialId));

        $planes = UraCurricula::all();

        foreach ($planes as $plan) {
            $cargasPlan = [];
            foreach ($cargas as $carga) {
                if ($plan->iCurricId == $carga->iCurricId) {
                    $cargasPlan[] = $carga;
                }
            }
            $plan->cargas = $cargasPlan;
        }

        return response()->json($planes);
    }

    /**
     * Obtiene condiciones, categorías, dedicación, estados de Acta para la Carga horaria
     */
    public function obtenerSelectsCargaHoraria()
    {
        $condiciones = \DB::select('exec ura.Sp_GRAL_SEL_RegistrosXcShemaXcNombreTabla ?, ?', array('grl', 'condicion'));

        $categorias = \DB::select('exec ura.Sp_GRAL_SEL_RegistrosXcShemaXcNombreTabla ?, ?', array('grl', 'categoria'));

        $dedicacion = \DB::select('exec ura.Sp_GRAL_SEL_RegistrosXcShemaXcNombreTabla ?, ?', array('grl', 'dedicacion'));

        //$estadosActa = \DB::select('exec ura.Sp_GRAL_SEL_RegistrosXcShemaXcNombreTabla ?, ?',array('ura', 'estado_acta'));

        $data = ['condiciones' => $condiciones, 'categorias' => $categorias, 'dedicacion' => $dedicacion];

        return response()->json($data);
    }
}
