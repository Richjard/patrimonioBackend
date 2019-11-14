<?php
namespace App\Http\Controllers\Tre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class tre_operacionesController extends Controller{
    public function tre_operaciones_select(Request $data){
        $IngId          = $data->get("IngId");
        $UniEjeId       = $data->get("UniEjeId");
        $FilId          = $data->get("FilId");
        $DocId          = $data->get("DocId");
        $DocSerie       = $data->get("DocSerie");
        $DocNro         = $data->get("DocNro");
        $DocFechaIni    = $data->get("DocFechaIni");
        $DocFechaFin    = $data->get("DocFechaFin");
        $PersId         = $data->get("PersId");
        $EstudId        = $data->get("EstudId");
        $TipPagId       = $data->get("TipPagId");
        $IngCredDepen   = $data->get("IngCredDepen");
        $SessKey     = $data->get("SessKey");
        $MenuId      = $data->get("MenuId");
        $TypeRecord  = $data->get("TypeRecord"); 
        $TypeQuery   = $data->get("TypeQuery"); 
        $OrderBy     = $data->get("OrderBy");
        $RecordLimit = $data->get("RecordLimit");
        $RecordStart = $data->get("RecordStart");

        $_records = \DB::select("exec tre.[operaciones_sp_select] ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?",array($IngId,$UniEjeId,$FilId,$DocId,$DocSerie,$DocNro,$DocFechaIni,$DocFechaFin,$PersId,$EstudId,$TipPagId,$IngCredDepen,$SessKey,$MenuId,$TypeRecord,$TypeQuery,$OrderBy,$RecordLimit,$RecordStart));
        return response()->json( $_records );
    }

    public function tre_operaciones_update(Request $data){
        $OperId      = $data->get("OperId");
        $OperKey     = $data->get("OperKey");
        $Type        = $data->get("Type");
        $OperFecha   = $data->get("OperFecha");
        $Password    = $data->get("Password");
        $OperObserv  = $data->get("OperObserv");
        $SessKey     = $data->get("SessKey");
        $MenuId      = 0; //$data->get("MenuId");

        $_id = \DB::select('exec tre.[operaciones_sp_update] ?,?,?,?,?,?,?,?',array($OperId,$OperKey,$Type,$OperFecha,$Password,$OperObserv,$SessKey,$MenuId));
        return $_id;
    }
}