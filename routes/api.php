<?php
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



//Route::get('locales','Patrimonio/Locales@getResult')->name("getResult");

//Route::middleware('api')->get('locales', 'Patrimonio\Locales@getResult');
Route::group(['middleware' => 'api','prefix' => 'pat'],function($router){//$skip,$top,$inlinecount,$format
         Route::post('locales/combo', 'Patrimonio\Locales@getCombo');   
         Route::post('locales/result', 'Patrimonio\Locales@getResult');
         Route::post('locales', 'Patrimonio\Locales@guardarLocal');
         Route::put('locales/{id}', 'Patrimonio\Locales@modificarLocal');
         Route::delete('locales/{id}', 'Patrimonio\Locales@eliminarLocal');

         Route::post('areas/result', 'Patrimonio\Areas@getResult');
         Route::post('areas/combo', 'Patrimonio\Areas@getCombo');
         Route::post('areas', 'Patrimonio\Areas@guardar');
         Route::put('areas/{id}', 'Patrimonio\Areas@modificar');
         Route::delete('areas/{id}', 'Patrimonio\Areas@eliminar');



         Route::post('oficinas/result', 'Patrimonio\Oficinas@getResult');
         Route::post('oficinas', 'Patrimonio\Oficinas@guardar');
         Route::put('oficinas/{id}', 'Patrimonio\Oficinas@modificar');
         Route::delete('oficinas/{id}', 'Patrimonio\Oficinas@eliminar');


         //-----CATALOGO SPN
         Route::post('grupos/result', 'Patrimonio\GruposGenericoSBN@getResult');
          Route::post('grupos/combo', 'Patrimonio\GruposGenericoSBN@getCombo');
         Route::post('grupos', 'Patrimonio\GruposGenericoSBN@guardar');
         Route::put('grupos/{id}', 'Patrimonio\GruposGenericoSBN@modificar');
         Route::delete('grupos/{id}', 'Patrimonio\GruposGenericoSBN@eliminar');


         Route::post('clases/result', 'Patrimonio\ClasesGenericoSBN@getResult');
         Route::post('clases/combo', 'Patrimonio\ClasesGenericoSBN@getCombo');
         Route::post('clases', 'Patrimonio\ClasesGenericoSBN@guardar');
         Route::put('clases/{id}', 'Patrimonio\ClasesGenericoSBN@modificar');
         Route::delete('clases/{id}', 'Patrimonio\ClasesGenericoSBN@eliminar');


         Route::post('grupos_clases/result', 'Patrimonio\GruposClasesGenericoSBN@getResult');
          Route::post('grupos_clases/combo', 'Patrimonio\GruposClasesGenericoSBN@getCombo');
         Route::post('grupos_clases', 'Patrimonio\GruposClasesGenericoSBN@guardar');
         Route::put('grupos_clases/{id}', 'Patrimonio\GruposClasesGenericoSBN@modificar');
         Route::delete('grupos_clases/{id}', 'Patrimonio\GruposClasesGenericoSBN@eliminar');



         Route::post('catalogoSBN/result', 'Patrimonio\CatalogoSBN@getResult');
         Route::post('catalogoSBN', 'Patrimonio\CatalogoSBN@guardar');
         Route::put('catalogoSBN/{id}', 'Patrimonio\CatalogoSBN@modificar');
         Route::delete('catalogoSBN/{id}', 'Patrimonio\CatalogoSBN@eliminar');


         //tablas generales


    
         Route::post('marcas/result', 'Patrimonio\Marcas@getResult');
         Route::post('marcas/combo', 'Patrimonio\Marcas@getCombo');
         Route::post('marcas', 'Patrimonio\Marcas@guardar');
         Route::put('marcas/{id}', 'Patrimonio\Marcas@modificar');
         Route::delete('marcas/{id}', 'Patrimonio\Marcas@eliminar');

         Route::post('modelos/result', 'Patrimonio\Modelos@getResult');
         Route::post('modelos/combo', 'Patrimonio\Modelos@getCombo');
         Route::post('modelos', 'Patrimonio\Modelos@guardar');
         Route::put('modelos/{id}', 'Patrimonio\Modelos@modificar');
         Route::delete('modelos/{id}', 'Patrimonio\Modelos@eliminar');


         Route::post('tipos/result', 'Patrimonio\Tipos@getResult');
         Route::post('tipos/combo', 'Patrimonio\Tipos@getCombo');
         Route::post('tipos', 'Patrimonio\Tipos@guardar');
         Route::put('tipos/{id}', 'Patrimonio\Tipos@modificar');
         Route::delete('tipos/{id}', 'Patrimonio\Tipos@eliminar');





         Route::post('documentos/result', 'Patrimonio\Documentos@getResult');
         Route::post('documentos/combo', 'Patrimonio\Documentos@getCombo');
         Route::post('documentos', 'Patrimonio\Documentos@guardar');
         Route::put('documentos/{id}', 'Patrimonio\Documentos@modificar');
         Route::delete('documentos/{id}', 'Patrimonio\Documentos@eliminar');


         Route::post('calogosNoPatrimoniales/result', 'Patrimonio\CalogosNoPatrimoniales@getResult');
         Route::post('calogosNoPatrimoniales/combo', 'Patrimonio\CalogosNoPatrimoniales@getCombo');
         Route::post('calogosNoPatrimoniales', 'Patrimonio\CalogosNoPatrimoniales@guardar');
         Route::put('calogosNoPatrimoniales/{id}', 'Patrimonio\CalogosNoPatrimoniales@modificar');
         Route::delete('calogosNoPatrimoniales/{id}', 'Patrimonio\CalogosNoPatrimoniales@eliminar');


         Route::post('planes/result', 'Patrimonio\Planes@getResult');
         Route::post('planes/combo', 'Patrimonio\Planes@getCombo');
         Route::post('planes', 'Patrimonio\Planes@guardar');
         Route::put('planes/{id}', 'Patrimonio\Planes@modificar');
         Route::delete('planes/{id}', 'Patrimonio\Planes@eliminar');   



        Route::post('bienes/result', 'Patrimonio\Bienes@getResult');
         Route::post('bienes/combo', 'Patrimonio\Bienes@getCombo');
         Route::post('bienes', 'Patrimonio\Bienes@guardar');
         Route::put('bienes/{id}', 'Patrimonio\Bienes@modificar');
         Route::delete('bienes/{id}', 'Patrimonio\Bienes@eliminar');  

      
         Route::post('formas_adquisicion/combo', 'Patrimonio\Formas_adquisicion@getCombo'); 

         Route::post('estados_bien/combo', 'Patrimonio\Estados_bien@getCombo'); 
         Route::put('estados_bien/combo2', 'Patrimonio\Estados_bien@getCombo2'); 
         Route::post('colores/combo', 'Patrimonio\Colores@getCombo'); 




         Route::post('documentos_tramite/result', 'Patrimonio\DocumentosTramite@getResult');
         Route::post('oc/result', 'Patrimonio\Oc@getResult');
         Route::post('oc_item/result', 'Patrimonio\OcItem@getResult');

         Route::post('cargos/combo', 'Patrimonio\Cargos@getCombo');
         Route::post('anios/combo', 'Patrimonio\Anios@getCombo');

         Route::post('empleados/result', 'Patrimonio\Empleado@getResult');
         Route::post('empleados/combo', 'Patrimonio\Empleado@getCombo');
         Route::post('empleados', 'Patrimonio\Empleado@guardar');
         Route::put('empleados/{id}', 'Patrimonio\Empleado@modificar');
         Route::delete('empleados/{id}', 'Patrimonio\Empleado@eliminar');


         Route::post('centro_costo_pat/result', 'Patrimonio\CentroCostoPat@getResult');
         Route::post('centro_costo_pat/combo', 'Patrimonio\CentroCostoPat@getCombo');
        
         Route::post('centro_costo_pat', 'Patrimonio\CentroCostoPat@guardar');
         Route::put('centro_costo_pat/{id}', 'Patrimonio\CentroCostoPat@modificar');
         Route::delete('centro_costo_pat/{id}', 'Patrimonio\CentroCostoPat@eliminar');


           Route::post('centro_costo_empleado/result', 'Patrimonio\CentroCostoEmpleado@getResult');
         Route::post('centro_costo_empleado/combo', 'Patrimonio\CentroCostoEmpleado@getCombo');
         Route::post('centro_costo_empleado', 'Patrimonio\CentroCostoEmpleado@guardar');
         Route::put('centro_costo_empleado/{id}', 'Patrimonio\CentroCostoEmpleado@modificar');
         Route::delete('centro_costo_empleado/{id}', 'Patrimonio\CentroCostoEmpleado@eliminar');



        // Route::get('centro_costo_empleado/combo/{id}', 'Patrimonio\CentroCostoPat@getComboAndroid');



         Route::post('centro_costo/combo', 'Patrimonio\CentroCosto@getCombo');//corregir es get
       
         Route::post('tipo_desplazamiento/combo', 'Patrimonio\TipoDesplazamiento@getCombo'); 
         Route::put('desplazamiento/result', 'Patrimonio\DesplazamientoBienes@getResult');
         Route::post('desplazamiento/combo', 'Patrimonio\DesplazamientoBienes@getCombo');
         Route::post('desplazamiento', 'Patrimonio\DesplazamientoBienes@guardar');
         Route::put('desplazamiento/{id}', 'Patrimonio\DesplazamientoBienes@modificar');
         Route::delete('desplazamiento/{id}', 'Patrimonio\DesplazamientoBienes@eliminar');





         Route::post('empleado_bienes/result', 'Patrimonio\EmpleadoBienes@getResult');
         Route::post('empleado_bienes/data/{iCentroCostoEmpleadoId}', 'Patrimonio\EmpleadoBienes@getData');
         Route::post('empleado_bienes', 'Patrimonio\EmpleadoBienes@guardar');
         Route::put('empleado_bienes/{id}', 'Patrimonio\EmpleadoBienes@modificar');
         Route::delete('empleado_bienes/{id}', 'Patrimonio\EmpleadoBienes@eliminar');



         Route::post('doc_verificacion/result', 'Patrimonio\DocVerificacionBienes@getResult');
         Route::post('doc_verificacion/data/{iCentroCostoEmpleadoId}', 'Patrimonio\DocVerificacionBienes@getData');
         Route::post('doc_verificacion', 'Patrimonio\DocVerificacionBienes@guardar');
         Route::put('doc_verificacion/{id}', 'Patrimonio\DocVerificacionBienes@modificar');
         Route::delete('doc_verificacion/{id}', 'Patrimonio\DocVerificacionBienes@eliminar');
         Route::get('doc_verificacion/combo', 'Patrimonio\DocVerificacionBienes@getCombo');



         Route::post('android/login', 'Patrimonio\LoginAndroid@login');
         Route::get('subDependencia/combo/{id}', 'Patrimonio\CentroCostoPat@getComboAndroid');

         Route::get('centro_costo_empleado/combo_x_dependencia/{id}', 'Patrimonio\CentroCostoEmpleado@getCombo_x_Dependencia_Android');
         Route::get('centro_costo_empleado/combo_x_subdependencia/{id}/{idsub}', 'Patrimonio\CentroCostoEmpleado@getCombo_x_Subdependencia_Android');
         Route::get('dependencia/combo', 'Patrimonio\CentroCosto@getComboAndroid');

         Route::get('bienes/shear_x_codigo/{cBienCodigo}/{idCentroCostoEmpleado}', 'Patrimonio\Bienes@shear_x_codigoAndroid');
         Route::get('estados_bien/comboAndroid', 'Patrimonio\Estados_bien@getComboAndroid'); 



         Route::post('verificar/guardar', 'Patrimonio\Verificar@guardar'); 
         Route::get('verificar/resultAdroid/{iYearId}/{iDepenId}/{idCentroCostoEmpleado}', 'Patrimonio\Verificar@getResultAndroid');
         Route::get('verificar/resultBienesDesverificadosAndroid/{iYearId}/{iDepenId}/{idCentroCostoEmpleado}', 'Patrimonio\Verificar@getResultBienesDesverificadosAndroid');

         //por sub dependencia
          Route::get('verificar/result_x_sub_depemdemcoa_Adroid/{iYearId}/{iDepenId}/{iCentroCostoId}/{idCentroCostoEmpleado}', 'Patrimonio\Verificar@getResult_x_sub_depemdemcoa_Android');
          Route::get('verificar/result_x_sub_depemdemcoa_BienesDesverificadosAndroid/{iYearId}/{iDepenId}/{iCentroCostoId}/{idCentroCostoEmpleado}', 'Patrimonio\Verificar@getResult_x_sub_depemdemcoa_BienesDesverificadosAndroid');


         Route::post('verificar/result', 'Patrimonio\Verificar@getResult');

       //  Route::patch('calendarioacademico/{id}', 'Api\Ura\CalendarioAcademicoController@update')->name('api.calendario.update');

});

//Route::middleware('auth:api')->get('ii', 'Patrimonio\Locales@getResult');

//Route::middleware('auth:api')->get('ii/{moduloId}', 'Patrimonio\Locales@getResult');

Route::group([ 'middleware' => 'api', 'prefix' => 'auth' ], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});
Route::middleware('auth:api')->any('fotografia', 'Generales\GrlPersonasController@getFotografia');

Route::middleware('auth:api')->get('obtenerInfoCredencial', 'Seguridad\SegCredencialController@obtenerInfoCredencial');
Route::middleware('auth:api')->get('verificarLogueo/{moduloId}', 'Seguridad\SegCredencialController@verificarLogueo');

Route::group([ 'middleware' => 'api', 'prefix' => 'ura/estudiante' ], function ($router) {
    Route::get('obtenerPlanCurricularEstudiante/{codigoEstudiante}', 'Ura\UraPlanCurricularController@obtenerPlanCurricularEstudiante');

    Route::get('obtenerRecordAcademicoEstudiante/{codigoEstudiante}', 'Ura\UraPlanCurricularController@obtenerRecordAcademicoEstudiante');

    Route::get('obtenerFichasMatriculasEstudiante/{codigoEstudiante}', 'Ura\UraFichaMatriculaController@obtenerFichasMatriculasEstudiante');

    Route::get('cambioplan/{codigo}/{carrera}/{plan}', 'Ura\UraCambioPlanController@cambioPlan');
    Route::get('cambioplanN/{codigo}/{carrera}/{plan}', 'Ura\UraCambioPlanController@cambioPlanN');
    Route::get('cambioPlanActiva/{codigo}/{carrera}/{plan}', 'Ura\UraCambioPlanController@cambioPlanActiva');

    Route::get('obtenerFichaMatriculaVigente/{estudId}/{cicloAcad}', 'Ura\UraFichaMatriculaController@obtenerFichaMatriculaVigente');
});

Route::group([ 'middleware' => 'api', 'prefix' => 'ura/docente' ], function ($router) {
    Route::get('obtenerPlanCurricularCarrera/{codigoCarrera}', 'Ura\UraPlanCurricularController@obtenerPlanCurricularCarrera');

    Route::get('obtenerPlanesCiclosAcademicos', 'Ura\UraHorarioController@obtenerPlanesCiclosAcademicos');

    Route::get('obtenerHorariosPorCarreraFilialCiclo', 'Ura\UraHorarioController@obtenerHorariosPorCarreraFilialCiclo');

    Route::get('obtenerCursosAulasSecciones', 'Ura\UraHorarioController@obtenerCursosAulasSecciones');

    Route::get('obtenerPlanesConCursosActivosPorCarrera/{carreraId}', 'Ura\UraHorarioController@obtenerPlanesConCursosActivosPorCarrera');

    Route::get('obtenerPaginacionDocentesPorCarrera', 'Ura\UraHorarioController@obtenerPaginacionDocentesPorCarrera');

    Route::post('insertarBloqueHorario', 'Ura\UraHorarioController@insertarBloqueHorario');

    Route::delete('eliminarBloqueHorario/{id}', 'Ura\UraHorarioController@eliminarBloqueHorario');

    Route::get('obtenerConfigHorarioCarrera', 'Ura\UraHorarioController@obtenerConfigHorarioCarrera');

    Route::post('guardarConfigHorarioCarrera', 'Ura\UraHorarioController@guardarConfigHorarioCarrera');

    Route::post('guardarCargaHoraria', 'Ura\UraHorarioController@guardarCargaHoraria');

    Route::get('obtenerPlanesConCargasAcademicas', 'Ura\UraHorarioController@obtenerPlanesConCargasAcademicas');

    Route::get('obtenerSelectsCargaHoraria', 'Ura\UraHorarioController@obtenerSelectsCargaHoraria');

    Route::get('generarReporte', 'Ura\UraPlanCurricularController@generarReporte');

    Route::get('obtenerHorarioDocente/{idDocente}/{IdCiclo}','Docente\DocenteController@HorarioDocente');
      
    Route::post('InsertarAsistenciaCurso','Docente\DocenteController@InsertarAsistenciaCurso');

});

Route::group([ 'middleware' => 'api', 'prefix' => 'ura/general' ], function ($router) {
    Route::get('obtenerCicloAcademicoActivo', 'Ura\UraControlCicloAcademicoController@obtenerCicloAcademicoActivo');

    Route::get('buscarDocentes/{parametro}', 'Ura\UraDocenteController@buscarDocentes');
    Route::get('buscarEstudiantes', 'Ura\UraEstudianteController@buscarEstudiantes');
    Route::get('buscarEstudiantesDocentes/{parametro}/{carreraId?}/{filialId?}', 'Ura\GeneralController@buscarEstudiantesDocentes');

    Route::get('obtenerDatosEstudiante/{codigo}', 'Ura\GeneralController@obtenerDatosEstudiante');
    Route::get('obtenerHorarioEstudiante/{codigo}/{cicloAcad}', 'Ura\GeneralController@obtenerHorarioEstudiante');

    Route::get('obtenerFilialesCarreras', 'Ura\GeneralController@obtenerFilialesCarreras');
    Route::get('obtenerPlanesCarrera/{carreraFilialId}', 'Ura\GeneralController@obtenerPlanesCarrera');

    Route::get('obtenerTiposMatricula', 'Ura\UraFichaMatriculaController@obtenerTiposMatricula');
});

Route::group([ 'middleware' => 'auth:api', 'prefix' => 'dasa' ], function ($router) {
    Route::group([ 'prefix' => 'matricula' ], function ($router) {
        Route::get('obtenerCarrerasPlanes', 'DASA\CurriculaCursoController@obtenerCarrerasPlanes');
        Route::get('obtenerCurriculaPorCarreraPlan/{carreraId}/{curricId}', 'DASA\CurriculaCursoController@obtenerCurriculaPorCarreraPlan');
        Route::post('guardarEstadoCheckCurso', 'DASA\CurriculaCursoController@guardarEstadoCheckCurso');

        Route::get('obtenerCarrerasAutorizaciones/{cicloAcad}', 'DASA\CarreraController@obtenerCarrerasAutorizaciones');
        Route::post('guardarEstadoCheckEscuela', 'DASA\CarreraController@guardarEstadoCheckEscuela');
    });

    Route::group([ 'prefix' => 'procesar' ], function ($router) {
        Route::get('obtenerEstudiantesObservados', 'ura\UraEstudianteController@obtenerEstudiantesObservados');
        Route::get('obtenerEstudiantesAEgresarPorCarreraPlan/{carreraId}/{curricId}', 'ura\UraEstudianteController@obtenerEstudiantesAEgresarPorCarreraPlan');
        Route::get('obtenerEstudiantesPPA/{carreraId}', 'ura\UraEstudianteController@obtenerEstudiantesPPA');
        Route::get('obtenerEstudiantesPPS/{carreraId}/{cicloAcad}', 'ura\UraEstudianteController@obtenerEstudiantesPPS');
        Route::get('obtenerEstudiantesReservaExcedida', 'DASA\ProcesoEstudianteController@obtenerEstudiantesReservaExcedida');
        Route::get('obtenerEstudiantesCuartaDesaprobada/{carreraId}/{cicloAcad}', 'DASA\ProcesoEstudianteController@obtenerEstudiantesCuartaDesaprobada');
        Route::get('obtenerEstudiantescambioPlan/{carreraId}/{plan}', 'DASA\ProcesoEstudianteController@obtenerEstudiantescambioPlan');
        Route::get('obtenerEstudiantesASancionar/{carreraId}/{cicloAcad}', 'DASA\ProcesoEstudianteController@obtenerEstudiantesASancionar');
        Route::get('obtenerEstudiantesSinMatricula/{carreraId}/{cicloAcad}', 'DASA\ProcesoEstudianteController@obtenerEstudiantesSinMatricula');

        Route::post('actualizarEstadoEstudiante', 'DASA\ProcesoEstudianteController@actualizarEstadoEstudiante');
    });

    Route::group([ 'prefix' => 'estado' ], function ($router) {
        Route::get('obtenerEstadosEstudiante', 'DASA\EstudianteController@obtenerEstadosEstudiante');
        Route::post('cambiarEstadoEstudiante', 'DASA\EstudianteController@cambiarEstadoEstudiante');
    });

    Route::group([ 'prefix' => 'estudiante' ], function ($router) {
        Route::post('resetearContraseniaEstudiante', 'DASA\EstudianteController@resetearContraseniaEstudiante');
        Route::post('cambiarContraseniaEstudiante', 'DASA\EstudianteController@cambiarContraseniaEstudiante');

        Route::get('obtenerFichasMatriculas/{codigo}', 'DASA\EstudianteController@obtenerFichasMatriculas');
        Route::get('obtenerCurriculaCursoDetalle/{carreraId}/{curricId}', 'DASA\CurriculaCursoController@obtenerCurriculaCursoDetalle');
        Route::get('getObservacionesEstudiante/{codigo}', 'DASA\EstudianteController@getObservacionesEstudiante');
        Route::post('guardarObservacionEstudiante', 'DASA\EstudianteController@guardarObservacionEstudiante');

        Route::get('obtenerDatosFichaMatricula/{codigo}/{libre?}', 'DASA\EstudianteController@obtenerDatosFichaMatricula');
        Route::post('guardarReservaMatricula', 'DASA\EstudianteController@guardarReservaMatricula');

        Route::get('getPdfReserva/{matricId}', 'DASA\EstudianteController@getPdfReserva');

        Route::post('rectificarMatricula', 'DASA\EstudianteController@rectificarMatricula');

        Route::post('verificarCruceHorarioRectificacion', 'DASA\EstudianteController@verificarCruceHorarioRectificacion');

    });

    Route::group([ 'prefix' => 'reportes' ], function ($router) {
        Route::get('obtenerReporteMatriculados/{cicloAcad}', 'DASA\ReporteController@obtenerReporteMatriculados');

        Route::get('matriculadosPorCurso/{carrFilId}/{curricId}', 'DASA\ReporteController@matriculadosPorCurso');
        Route::get('matriculadosPorCursoFilial/{carreraId}/{filialId}/{curricId}', 'DASA\ReporteController@matriculadosPorCursoFilial');
        Route::post('matriculadosPorCursoFilialDetallado', 'DASA\ReporteController@matriculadosPorCursoFilialDetallado');
        Route::get('matriculadosPorCarrera/{carreraId}/{semestre}', 'DASA\ReporteController@matriculadosPorCarrera');
        Route::get('matriculadosPorSemestre/{semestre}', 'DASA\ReporteController@matriculadosPorSemestre');
    });



    /**
     *
     * Api para el Mantenimineto de Calenario Academico modulo dasa
     * route: /api/dasa/mantenimiento/{prefix}
     */
    Route::group(['prefix' => 'mantenimiento'], function ($router) {
        Route::get('filial', 'Api\Grl\FilialController@index')->name('api.filial.index');

        Route::get('periodo', 'Api\Grl\PeriodoController@index')->name('api.periodo.index');

        Route::get('semestre', 'Api\Ura\SemestreController@index')->name('api.semestre.index');

        Route::get('tipocalendario', 'Api\Ura\TipoCalendarioController@index')->name('api.tipocalendario.index');

        Route::get('tipoactividad', 'Api\Ura\TipoActividadController@index')->name('api.tipoactividad.index');

        Route::get('actividad', 'Api\Ura\ActividadCalendarioController@index')->name('api.actividad.index');

        Route::get('calendarioacademico', 'Api\Ura\CalendarioAcademicoController@index')->name('api.calendario.index');

        Route::post('calendarioacademico', 'Api\Ura\CalendarioAcademicoController@store')->name('api.calendario.store');

        Route::get('calendarioacademico/{id}/edit', 'Api\Ura\CalendarioAcademicoController@edit')->name('api.calendario.edit');

        Route::patch('calendarioacademico/{id}', 'Api\Ura\CalendarioAcademicoController@update')->name('api.calendario.update');

        Route::delete('calendarioacademico/{id}', 'Api\Ura\CalendarioAcademicoController@destroy')->name('api.calendario.destroy');

        Route::get('calendariodetalle/{id}/edit', 'Api\Ura\CalendarioAcadDetController@edit')->name('api.caldetalle.edit');

        Route::get('calendariodetalle', 'Api\Ura\CalendarioAcadDetController@index')->name('api.caldetalle.index');

        Route::post('calendariodetalle', 'Api\Ura\CalendarioAcadDetController@store')->name('api.caldetalle.store');
    });
});

Route::group([ 'middleware' => 'api', 'prefix' => 'escuela' ], function ($router) {

    /**
     *
     * Api para la Carga Horaria [Modulo Escuela]
     * route: /api/escuela/horario/{prefix}
     */

    Route::group(['prefix' => 'horario'], function ($router) {
        Route::get('carga', 'Api\Ura\HorarioController@index')->name('api.horario.index');

        Route::get('docente', 'Api\Ura\HorarioController@docente')->name('api.horario.docente');

        Route::get('cursos', 'Api\Ura\HorarioController@cursos')->name('api.horario.cursos');
        Route::get('secciones', 'Api\Ura\HorarioController@secciones')->name('api.horario.secciones');
    });
});

Route::group([ 'middleware' => 'api', 'prefix' => 'estudiante' ], function ($router) {
    Route::group([ 'prefix' => 'matricula' ], function ($router) {
        Route::get('verificarRequisitosOBU/{codUniv}/{dni}', 'ura\UraEstudianteController@verificarRequisitosOBU');
        Route::get('obtenerCursosDisponiblesMatricula/{codUniv}', 'Estudiante\MatriculaController@obtenerCursosDisponiblesMatricula');
        Route::get('obtenerHorarios/{codigoUniv}/{cicloAcad}', 'Estudiante\MatriculaController@obtenerHorarios');
        Route::get('obtenerSemestresAcademicosEstudiante/{codigoUniv}', 'Estudiante\MatriculaController@obtenerSemestresAcademicosEstudiante');

        Route::post('guardarProforma', 'Estudiante\MatriculaController@guardarProforma');
        Route::delete('eliminarProforma/{idProforma}/{codigo}', 'Estudiante\MatriculaController@eliminarProforma');
    });

    Route::group([ 'prefix' => 'pdf' ], function ($router) {
        Route::get('documentos/{tipo}/{codigo}/{cicloAcad}', 'Estudiante\ReportePDFController@getDocumentoPDF');
    });

    Route::get('obtenerDatosContacto/{codigo}', 'Estudiante\EstudianteController@obtenerDatosContacto');

    Route::post('editarDatosContacto', 'Estudiante\EstudianteController@editarDatosContacto');
});

Route::group([ 'middleware' => 'api', 'prefix' => 'dbu' ], function ($router) {
    Route::group([ 'prefix' => 'control' ], function ($router) {
        Route::post('guardarActualizarChecksObu/', 'DBU\UraCheckObuController@guardarActualizarChecksObu');
    });
});


Route::group([ 'middleware' => 'auth:api', 'prefix' => 'docente' ], function ($router) {




    Route::group([ 'prefix' => 'cursos' ], function ($router) {
        Route::get('obternerCursosDocente/{ciclo}/{id}', 'Docente\DocenteController@CursosDocente');

        Route::get('obtenerDatosContacto/{codigo}', 'Docente\DocenteController@obtenerDatosContacto');
        
        Route::post('editarDatosContacto', 'Docente\DocenteController@editarDatosContacto');
        
        Route::get('obtenerDatosCargaHorariaDocente/{id}/{ciclo}', 'Docente\DocenteController@obtenerDatosCargaHorariaDocente');


    });



    Route::group([ 'prefix' => 'cursossilabo' ], function ($router) {
        Route::get('obternerCursosDocenteSilabo/{cicloa}/{cursoa}', 'Docente\DocenteSilaboController@CursosDocenteSilabo');

        Route::get('obtenerSilaboProcedimientosTecnicas', 'Docente\DocenteSilaboController@obtenerSilaboProcedimientosTecnicas');
        Route::get('obtenerSilaboEquipos', 'Docente\DocenteSilaboController@obtenerSilaboEquipos');
        Route::get('obtenerSilaboMateriales', 'Docente\DocenteSilaboController@obtenerSilaboMateriales');
        Route::get('obtenerSilaboEvaluacionPermanente', 'Docente\DocenteSilaboController@obtenerSilaboEvaluacionPermanente');

        Route::get('obtenerSilaboClaseSilabo', 'Docente\DocenteSilaboController@obtenerSilaboClaseSilabo');
        Route::get('obtenerSilaboSemanaSilabo', 'Docente\DocenteSilaboController@obtenerSilaboSemanaSilabo');


        Route::post('insertarDetalleCompetencias', 'Docente\DocenteSilaboController@insertarDetalleCompetencias');

        Route::post('insertarDetalleUnidad', 'Docente\DocenteSilaboController@insertarDetalleUnidad');
        Route::post('insertarDetalleConceptuales', 'Docente\DocenteSilaboController@insertarDetalleConceptuales');
        Route::post('insertarDetalleActitudinales', 'Docente\DocenteSilaboController@insertarDetalleActitudinales');
        Route::post('insertarDetalleProcedimentales', 'Docente\DocenteSilaboController@insertarDetalleProcedimentales');


        Route::post('insertarDetalleProcedimientos', 'Docente\DocenteSilaboController@insertarDetalleProcedimientos');

        Route::post('insertarAprendizajes', 'Docente\DocenteSilaboController@insertarAprendizajes');

        Route::post('insertarDetalleEquipos', 'Docente\DocenteSilaboController@insertarDetalleEquipos');
        Route::post('insertarDetalleMateriales', 'Docente\DocenteSilaboController@insertarDetalleMateriales');

        Route::post('insertarDetalleEvaluacion', 'Docente\DocenteSilaboController@insertarDetalleEvaluacion');

        Route::post('insertarFuenteTextoBase', 'Docente\DocenteSilaboController@insertarFuenteTextoBase');
        Route::post('insertarFuenteBibliografiaComplementaria', 'Docente\DocenteSilaboController@insertarFuenteBibliografiaComplementaria');
        Route::post('insertarFuenteElectronicas', 'Docente\DocenteSilaboController@insertarFuenteElectronicas');


 
    });

});




//report PDF





/*
Route::group(['prefix' => 'pide', ], function () {
    Route::post('{tipo}/{persona_id?}', function (Request $request, $tipo, $usuario_id=null) {
        $servActivos = ['reniec', 'seguro', 'sms'];

        if (in_array($tipo, $servActivos)) {
            $ch = curl_init('http://200.48.160.218:8081/api/pide/' . $tipo);
            $payload = json_encode($request->toArray());
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($result);

            Route::group(['prefix' => 'horario'], function ($router) {
                Route::get('carga', 'Api\Ura\HorarioController@index')->name('api.horario.index');
            });

            if (isset($data->error) && isset($data->msg)) {
                $jsonResponse = [
                    'error' => $data->error,
                    'msg' => $data->msg,
                    'data' => $data->data
                ];
            } else {
                $jsonResponse = [
                    'error' => false,
                    'msg' => '',
                    'data' => $data
                ];
            }
        } else {
            $jsonResponse = [
                'error' => true,
                'msg' => 'El servicio no esta activo o no existe',
                'data' => null
            ];
        }

        return response()->json($jsonResponse);
    });
});
*/

Route::group(['prefix' => 'pide', /*'middleware' => 'auth:api'*/], function (){
    Route::any('{tipo}/{persona_id?}', 'PideController@consultar');
});



