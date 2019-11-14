<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('reporteMatriculados/{carreraId}', 'Ura\GeneralController@reporteMatriculados');

Route::get('storage/{carpeta}/{archivo}', function ($carpeta, $archivo) {
    $path = storage_path("app/{$carpeta}/{$archivo}");

    // return $path;
    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

/*
Route::get('storage/fotos/{tipo}/{hash}', function ($tipo, $hash) {
    $urlFoto = 'http://200.48.160.218:8081/storage/fotos/' . $tipo . '/'. $hash;
    $ch = curl_init($urlFoto);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:image/jpeg'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    header("Content-type: image/jpg");
    echo $result;
    die;
});
*/

Route::any('genDocs/{iDocIdEncoded}', 'Tram\ReportePdfController@getPdfFromUrl')->name('tramites.pdfPublico');