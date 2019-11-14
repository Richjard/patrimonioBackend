<?php
namespace App\Http\Controllers\Tre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class tre_ingresosController extends Controller{
    public function tre_ingresos_delete(Request $data){
        $IngId     = $data->get("IngId");
        $IngKey    = $data->get("IngKey");
        $IngObserv = $data->get("IngObserv");
        $Password  = $data->get("Password");
        $SessKey = $data->get("SessKey");
        $MenuId  = 0; //$data->get("MenuId");

        $_id = \DB::select('exec tre.[ingresos_sp_delete] ?,?,?,?,?,?', array($IngId,$IngKey,$IngObserv,$Password,$SessKey,$MenuId));
        return $_id;
    }

    public function tre_ingresos_select(Request $data){
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
        $CredDepenKey   = $data->get("CredDepenKey");
        $SessKey     = $data->get("SessKey");
        $MenuId      = $data->get("MenuId");
        $TypeRecord  = $data->get("TypeRecord");
        $TypeQuery   = $data->get("TypeQuery");
        $OrderBy     = $data->get("OrderBy");
        $RecordLimit = $data->get("RecordLimit");
        $RecordStart = $data->get("RecordStart");

        $_records = \DB::select("exec tre.[ingresos_sp_select] ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?",array($IngId,$UniEjeId,$FilId,$DocId,$DocSerie,$DocNro,$DocFechaIni,$DocFechaFin,$PersId,$EstudId,$TipPagId,$CredDepenKey,$SessKey,$MenuId,$TypeRecord,$TypeQuery,$OrderBy,$RecordLimit,$RecordStart));
        return response()->json( $_records );
    }

    public function tre_ingresos_update(Request $data){
        $TypeEdit       = 1; //$data->get("TypeEdit");
        $IngId          = 0; //$data->get("IngId");
        $IngKey         = $data->get("IngKey");
        $UniEjeId       = 1230; //$data->get("UniEjeId");
        $FilId          = 0; //$data->get("FilId");
        $DocId          = $data->get("DocId");
        $DocSerie       = $data->get("DocSerie");
        $DocNro         = 0; //$data->get("DocNro");
        $DocFecha       = $data->get("DocFecha");
        $PersId         = $data->get("PersId");
        $EstudId        = $data->get("EstudId");
        $TipPagId       = $data->get("TipPagId");
        $CueBancId      = $data->get("CueBancId");
        $OperFecha      = $data->get("OperFecha");
        $OperNro        = $data->get("OperNro");
        $IngImpt        = $data->get("IngImpt");
        $IngObserv      = $data->get("IngObserv");
        $json           = $data->get("data");
        $SessKey        = $data->get("SessKey");
        $MenuId         = $data->get("MenuId");

        $_id = \DB::select('exec tre.[ingresos_sp_update] ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array($TypeEdit,$IngId,$IngKey,1230,$FilId,$DocId,$DocSerie,$DocNro,$DocFecha,$PersId,$EstudId,$TipPagId,$CueBancId,$OperFecha,$OperNro,$IngImpt,$IngObserv,($json),$SessKey,$MenuId));
        return $_id;
    }
}