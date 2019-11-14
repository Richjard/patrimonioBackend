<?php
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

Route::group(['prefix' => 'tram'/*, 'middleware' => 'auth:api'*/], function () {
    Route::any('dataexistente', 'Tram\TramitesController@leerData');
    Route::any('guardar', 'Tram\TramitesController@guardarData');

    Route::group(['prefix' => 'dasa'/*, 'middleware' => 'auth:api'*/], function () {
        Route::any('dataexistente', 'Tram\DasaController@leerData');
        Route::any('guardar', 'Tram\DasaController@guardarData');
    });
});



/**
 * Traminte online para el estudiante [module estudiante]
 * route: /api/tramite/{prefix}
 *
 */
Route::group([ 'middleware' => 'api', 'prefix' => 'tramite'], function ($router) {
    Route::get('conceptosTramites/{iEntId}/{cEstudCodUniv}', 'Tram\TramiteOnController@conceptosTramites');

    Route::get('tiposDocumentos/{iConcepId}', 'Tram\TramiteOnController@tiposDocumentos');

    Route::get('conceptosimporte/{iConcepId}/{iCantidad}', 'Tram\TramiteOnController@conceptosImportes');

    Route::get('tramiteslist/{cEstudCodUniv}', 'Tram\TramiteOnController@listTramite');

    Route::post('tramitesestudiante', 'Tram\TramiteOnController@tramitesEstudCodUniv');

    Route::delete('deletetramite/{iTramId}', 'Tram\TramiteOnController@deleteTramite');

    Route::get('docestudiantedasa/{iTramId}', 'Tram\TramiteOnController@documentosEstudiantesDASA');

    Route::get('seguimientotramite/{iTramId}', 'Tram\TramiteOnController@seguimientoTraminte');

    Route::get('tramites_DASA_por_Recepcionar/', 'Tram\TramiteOnController@tramites_DASA_por_Recepcionar');

    Route::get('tramites_RecepcionadoDASA/{iTramMovId}/{iCredId}/{cEquipoSis}/{cIpSis}/{cMacNicSis}', 'Tram\TramiteOnController@tramites_RecepcionadoDASA');

    Route::get('documentos_estudiantes_DASAXiDocId/{iDocId}', 'Tram\TramiteOnController@documentos_estudiantes_DASAXiDocId');

    Route::get('documentos_estudiantes_DASAXcConsultaVariablesCampos/{iEntId}/{iTramId}/{cEstudCodUniv}/{iTipoDocId}/{cFecha}/{iYear}/{iMonth}/{cFechaDesde}/{cFechaHasta}/{iDias}', 'Tram\TramiteOnController@documentos_estudiantes_DASAXcConsultaVariablesCampos');

    Route::get('tramites_DASA_Recibidos_SinDocumento/{iTramId}/{cEstudCodUniv}/{iConcepId}/{cFecha}/{iYear}/{iMonth}/{cFechaDesde}/{cFechaHasta}/{iDias}', 'Tram\TramiteOnController@tramites_DASA_Recibidos_SinDocumento');
});





Route::get('pdfcertificados/{id}', 'Tram\ReportePdfController@Pdf_certificados')->name('Pdf_certificados');
