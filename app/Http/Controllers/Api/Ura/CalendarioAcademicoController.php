<?php

namespace App\Http\Controllers\Api\Ura;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ura\CalendarioAcademicoRequest;
use App\Model\Ura\CalendarioAcademico as CalAcad;
use DB;

class CalendarioAcademicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $filial = $request->get('filial');

        $calacad = CalAcad::hydrate(
            DB::select(
                'EXEC ura.Sp__DASA_SEL_calendariosPaginadoXiFilIdXcBusquedaXsSortDirXpageNumberXpageSize ?,?',
                ["{$filial}", "%{$keyword}%"]
            )
        );
        return response()->json($calacad);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Ura\CalendarioAcademicoRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(CalendarioAcademicoRequest $request)
    {
        $data = $request->all();

        $calacad = CalAcad::hydrate(
            DB::select(
                'EXEC ura.Sp_DASA_INS_calendariosAcademicos ?,?,?,?,?,?,?,?,?,?',
                $data
            )
        );

        // return $this->response->item($calacad);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Ura\CalendarioAcademico  $calendarioAcademico
     * @return \Illuminate\Http\Response
     */
    public function show(CalendarioAcademico $calendarioAcademico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $calacad = CalAcad::withoutGlobalScope(DraftScope::class)->findOrFail($id);

        return response()->json($calacad);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Ura\CalendarioAcademico  $calendarioAcademico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CalendarioAcademico $calendarioAcademico)
    {
        $calacad = CalAcad::hydrate(
            DB::update(
                'Exec ura.Sp_DASA_UPD_calendariosAcademicos',
                ["{$id}"]
            )
        );

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $calacad = CalAcad::hydrate(
            DB::select(
                'EXEC ura.Sp_DASA_DEL_calendariosAcademicos ?',
                ["{$id}"]
            )
        );
        if ($calacad[0]->eliminados > 0) {
            $response = [
                'validated' => true,
                'mensaje'   => 'Se eliminó el Registro exitosamente.','eliminados' => $calacad[0]->eliminados
             ];
            $codeResponse = 200;
        } else {
            $response = [
                'validated' => true,
                'mensaje' => 'El Registro no se ha podido eliminar o no existe.',
                'eliminados' => $calacad[0]->eliminados ];
            $codeResponse = 500;
        }

        return response()->json($response, $codeResponse);
    }
}
