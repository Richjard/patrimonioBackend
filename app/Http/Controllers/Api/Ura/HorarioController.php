<?php

namespace App\Http\Controllers\Api\Ura;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

use DB;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $cicloact =
            DB::select(
                'EXEC ura.Sp_HORA_SEL_ciclosActivosXiCarreraIdXiCurricId ?,?',
                array($request->iCarreraId, $request->iCurricId)
            );

        return response()->json($cicloact);
    }

    /**
     * [docente ver la situacion o estado]
     *
     * @param   Request  $request  [$request description]
     *
     * @return  [json]             [return description]
     */
    public function docente(Request $request)
    {
        $docentesit =
            DB::select(
                'EXEC ura.Sp_HORA_SEL_docenteSituacionXiDocenteIdXiControlCicloAcadXiFilId ?,?,?',
                [$request->iDocenteId,$request->iControlCicloAcad,$request->iFilId]
            );
        return response()->json($docentesit, 200);
    }


    public function cursos(Request $request)
    {
        $docentesit =
            DB::select(
                'EXEC  ura.Sp_HORA_SEL_cursosXiCarreraIdXiCurricIdXcCurricDetCicloCurso ?,?,?',
                [$request->iCarreraId,$request->iCurricId,$request->cCurricDetCicloCurso]

            );
        return response()->json($docentesit, 200);
    }

    public function secciones(Request $request)
    {
        $docentesit =
            DB::select(
                'EXEC  ura.Sp_HORA_SEL_seccionesXiCarreraIdXiCurricIdXcCurricDetCicloCursoXcCurricCursoCod ?,?,?,?',
                [$request->iCarreraId,$request->iCurricId,$request->cCurricDetCicloCurso, $request->cCurricCursoCod]

            );
        return response()->json($docentesit, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
