<?php
namespace App\Http\Controllers\Tre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class grl_conceptosController extends Controller{
    public function grl_conceptos_select(Request $data){
        $ConcepId      = $data->get("ConcepId");
        $UniEjeId      = $data->get("UniEjeId");
        $DocGestId     = $data->get("DocGestId");
        $ConcepNombre  = $data->get("ConcepNombre");
        $ConcepAbrev   = $data->get("ConcepAbrev");
        $ConcepCodigo  = $data->get("ConcepCodigo");
        $DepenId       = $data->get("DepenId");
        $DepenIniciaId = $data->get("DepenIniciaId");
        $ConcepEstado  = $data->get("ConcepEstado");
        $TipDocGestId  = $data->get("TipDocGestId");
        $DocGestYear   = $data->get("DocGestYear");
        $SessKey     = $data->get("SessKey");
        $MenuId      = $data->get("MenuId");
        $TypeRecord  = $data->get("TypeRecord"); 
        $TypeQuery   = $data->get("TypeQuery"); 
        $OrderBy     = $data->get("OrderBy");
        $RecordLimit = $data->get("RecordLimit"); 
        $RecordStart = $data->get("RecordStart");

        $_records = \DB::select('exec grl.[conceptos_sp_select] ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?', array($ConcepId,$UniEjeId,$DocGestId,$ConcepNombre,$ConcepAbrev,$ConcepCodigo,$DepenId,$DepenIniciaId,$ConcepEstado,$TipDocGestId,$DocGestYear,$SessKey,$MenuId,$TypeRecord,$TypeQuery,$OrderBy,$RecordLimit,$RecordStart));
        return response()->json($_records);
    }
    public function grl_conceptos_update(Request $data){
        $TypeEdit     = ($data->get("ConcepId")*1 > 0 ? 2 : 1);
        $ConcepId     = $data->get("ConcepId");
        $ConcepKey    = $data->get("ConcepKey");
        $DocGestId    = $data->get("DocGestId");
        $ConcepNombre = $data->get("ConcepNombre");
        $ConcepCode   = $data->get("ConcepCode");
        $DepenId      = $data->get("DepenId");
        $ConcepObserv = $data->get("ConcepObserv");
        $ConcepEstado = $data->get("ConcepEstado");
        $SessKey = $data->get("SessKey");
        $MenuId  = $data->get("MenuId");

        $_id = \DB::select('exec grl.[conceptos_sp_update] ?,?,?,?,?,?,?,?,?,?,?,?',array($TypeEdit,$ConcepId,$ConcepKey,$DocGestId,$ConcepNombre,$ConcepCode,$DepenId,$ConcepObserv,$ConcepEstado,$SessKey,$MenuId));
        return $_id;
    }
}