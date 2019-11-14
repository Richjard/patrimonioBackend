<?php
use Illuminate\Http\Request;

Route::group([ /* 'middleware' => 'auth:api' ,*/ 'prefix' => 'docente' ], function ($router) {

    Route::group([ 'prefix' => 'control' ], function ($router) {

        Route::get('asistencia/{a}/{b}/{c}/{d}/{e}/{f}', 'Docente\DocenteController@asistenciaCabecera');

        Route::get('asistencialist/{a}/{b}/{c}/{d}/{e}/{f}', 'Docente\DocenteController@asistenciaList');

        Route::get('listestudiante/{a}/{b}/{c}/{d}/{e}/{f}/{g}', 'Docente\DocenteController@listadoEstudiantes');

        Route::get('downloadestudiante/{a}/{b}/{c}/{d}/{e}/{f}/{g}', 'Docente\DocenteController@exportlistEstudiantes');

        Route::get('descargaestudiante/{a}/{b}/{c}/{d}/{e}/{f}/{g}', 'Docente\DocenteController@exportlistEstudiantesXls');

        Route::get('descargahorario/{a}/{b}', 'Docente\DocenteController@exportHorarioDocenteXls');

        Route::post('NotasEstudiante/', 'Docente\DocenteController@NotasEstudiante');

        Route::get('descargaAsistenciaExcel/{a}/{b}', 'Docente\DocenteController@exportlistAsistenciaExcel');

        Route::get('descargaAsistenciaPdf/{a}/{b}', 'Docente\DocenteController@exportlistAsistenciaPdf');
    });
    Route::group([ 'prefix' => 'datos' ], function ($router) {
        Route::get('datosdocente/{id}', 'Docente\AsistenciaController@datosDocente');
    });

    Route::group([ 'prefix' => 'asistencia' ], function ($router) {

        Route::get('generar/{a}/{b}/{c}/{d}/{e}/{f}/{g}', 'Docente\AsistenciaController@generarAsistencia');

        Route::get('faltan/{a}/{b}/{c}/{d}/{e}/{f}/{g}', 'Docente\AsistenciaController@faltantesAsistencia');
    });



});
