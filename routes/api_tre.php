<?php
Route::group([ 'prefix' => 'tre' ], function ($router) {
    Route::post('bud_especificas_det_select', 'Tre\bud_especificas_detController@bud_especificas_det_select');

    Route::post('grl_conceptos_select', 'Tre\grl_conceptosController@grl_conceptos_select');
    Route::post('grl_conceptos_importes_select', 'Tre\grl_conceptos_importesController@grl_conceptos_importes_select');
    Route::post('grl_conceptos_requisitos_update', 'Tre\grl_conceptos_requisitosController@grl_conceptos_requisitos_update');
    Route::post('grl_conceptos_requisitos_select', 'Tre\grl_conceptos_requisitosController@grl_conceptos_requisitos_select');
    //Route::post('getReporteRequisito/{funcion}', 'Reporte\ReporteController@getReporteRequisito'); /* pdf para conceptos requisitos*/
    Route::post('grl_conceptos_importes_select', 'Tre\grl_conceptos_importesController@grl_conceptos_importes_select');
    Route::post('grl_dependencias_select', 'Tre\grl_dependenciasController@grl_dependencias_select');
    Route::post('grl_documentos_series_select', 'Tre\grl_documentos_seriesController@grl_documentos_series_select');
    Route::post('grl_filiales_select', 'Tre\grl_filialesController@grl_filiales_select');
    Route::post('grl_personas_select', 'Tre\grl_personasController@grl_personas_select');
    Route::post('grl_personas_update', 'Tre\grl_personasController@grl_personas_update');
    Route::post('grl_reportes_select', 'Tre\grl_reportesController@grl_reportes_select');
    Route::post('grl_tablas_mixtas_select', 'Tre\grl_tablas_mixtasController@grl_tablas_mixtas_select');

    Route::post('seg_credenciales_dependencias_select', 'Tre\seg_credenciales_dependenciasController@seg_credenciales_dependencias_select');
    Route::post('seg_credenciales_dependencias_update', 'Tre\seg_credenciales_dependenciasController@seg_credenciales_dependencias_update');
    Route::post('seg_sessions_update', 'Tre\seg_sessionsController@seg_sessions_update');
    Route::post('seg_sessions_validate', 'Tre\seg_sessionsController@seg_sessions_validate');
    
    Route::post('tre_adeudos_select', 'Tre\tre_adeudosController@tre_adeudos_select');
    Route::post('tre_adeudos_cab_select', 'Tre\tre_adeudos_cabController@tre_adeudos_cab_select');
    Route::post('tre_adeudos_cab_delete', 'Tre\tre_adeudos_cabController@tre_adeudos_cab_select');
    Route::post('tre_conceptos_enlaces_select', 'Tre\tre_conceptos_enlacesController@tre_conceptos_enlaces_select');
    Route::post('tre_cuentas_bancarias_select', 'Tre\tre_cuentas_bancariasController@tre_cuentas_bancarias_select');
    Route::post('tre_ingresos_delete', 'Tre\tre_ingresosController@tre_ingresos_delete');
    Route::post('tre_ingresos_select', 'Tre\tre_ingresosController@tre_ingresos_select');
    Route::post('tre_ingresos_update', 'Tre\tre_ingresosController@tre_ingresos_update');
    Route::post('tre_ingresos_det_select', 'Tre\tre_ingresos_detController@tre_ingresos_det_select');
    Route::post('tre_ingresos_especificas_det_select', 'Tre\tre_ingresos_especificas_detController@tre_ingresos_especificas_det_select');
    Route::post('tre_ingresos_especificas_det_update', 'Tre\tre_ingresos_especificas_detController@tre_ingresos_especificas_det_update');
    Route::post('tre_operaciones_update', 'Tre\tre_operacionesController@tre_operaciones_update');

    Route::post('ura_academicos_select', 'Tre\ura_academicosController@ura_academicos_select');
    Route::post('ura_estudiantes_select', 'Tre\ura_estudiantesController@ura_estudiantes_select');
});

Route::group([ 'prefix' => 'tre/reports' ], function ($router) {
    Route::post('grl_conceptos_requisitos_report', 'Tre\Report\grl_conceptos_requisitos_reportController@report');

    Route::post('tre_ingresos_report_di', 'Tre\Report\tre_ingresos_reportDIController@report');
    Route::post('tre_ingresos_report_ic', 'Tre\Report\tre_ingresos_reportICController@report');

    Route::post('tre_ingresos_report_id', 'Tre\Report\tre_ingresos_reportIDController@report');
    Route::post('tre_ingresos_report_cpt', 'Tre\Report\tre_ingresos_reportCPTController@report');
    Route::post('tre_ingresos_report_rrd', 'Tre\Report\tre_ingresos_reportRRDController@report');
    Route::post('tre_ingresos_report_rrdc', 'Tre\Report\tre_ingresos_reportRRDCController@report');
    Route::post('tre_ingresos_report_rrccr', 'Tre\Report\tre_ingresos_reportRRCCRController@report');
});