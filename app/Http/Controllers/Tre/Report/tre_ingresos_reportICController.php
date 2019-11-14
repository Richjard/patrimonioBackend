<?php
namespace App\Http\Controllers\Tre\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Resources\Functions;
use App\Resources\Pdf;

$_au = ""; $_fechaini = ""; $_fechafin = ""; $_fn = "";
class tre_ingresos_reportICController extends Controller{ 
    public function report(Request $data){
        $GLOBALS["_fechaini"] = $data->get("DocFechaIni");
        $GLOBALS["_fechafin"] = $data->get("DocFechaFin");
        $GLOBALS["_fn"] = new Functions();

        if ( $data->get("CredDepenKey") != "" ) {
            $_rec = app("App\Http\Controllers\Tre\seg_credenciales_dependenciasController")->seg_credenciales_dependencias_select($data, Array("CredDepenKey"=>$data->get("CredDepenKey"),"TypeRecord"=>"headApeNom"));
            $GLOBALS["_au"] = json_decode($_rec->getContent(), TRUE);
        }

        $_rec = app('App\Http\Controllers\Tre\tre_ingresosController')->tre_ingresos_select($data);
        $_ac = json_decode($_rec->getContent(), TRUE);

        $pdf = new PDF("P", "mm", "A4", true, "UTF-8", false);
        $pdf->setFile_header("tre_ingresos_report_ic_head.php");
        $pdf->SetFillColor(192, 192, 192);
        $pdf->SetTextColor(0, 0, 0);
        //$pdf->SetAutoPageBreak(true, 52);
        $pdf->h_row = 5;  $pdf->max = 270;  $_nro = 0;  $_item = 0;  $_impt = 0;

        $pdf->fnNewPage(2500);  $pdf->SetFont("helvetica", "", 6);
        foreach ($_ac as $row) { 
            $pdf->axisY += ($pdf->h_row + ( $_nro == "0" ? 1 : 0)); $pdf->fnNewPage(); $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX ); $_nro++;
            if ( $row["nIngImpt"]*1 > 0 ){ $pdf->SetTextColor(0, 0, 0); }else{ $pdf->SetTextColor(236, 0, 0); }
    		$pdf->Cell(8, $pdf->h_row, $_nro, 1, 0, "R");
    		$pdf->Cell(21, $pdf->h_row, $row["cIngDocument"], 1, 0, "L");
            $pdf->Cell(16, $pdf->h_row, $GLOBALS["_fn"]->fnDateDDMMAAAA($row["dDocFecha"]), 1, 0, "C");
            $pdf->Cell(10, $pdf->h_row, $row["cFilAbrev"], 1, 0, "L");
            $pdf->Cell(15, $pdf->h_row, $row["cPersDocumento"], 1, 0, "L");
            $pdf->Cell(55, $pdf->h_row, substr($row["cPersApeNom"],0,35), 1, 0, "L");
            $pdf->Cell(16, $pdf->h_row, $row["cEstudCodUniv"], 1, 0, "L");
            $pdf->Cell(10, $pdf->h_row, "", 1, 0, "L");
            $pdf->Cell(16, $pdf->h_row, "", 1, 0, "L");
		    $pdf->Cell(16, $pdf->h_row, $GLOBALS["_fn"]->fnNumFormat($row["nIngImpt"]), 1, 0, "R");
            $_impt += $row["nIngImpt"];
        }

    	$pdf->axisY += $pdf->h_row + ( $_nro == "0" ? 1 : 0);  $pdf->fnNewPage();  $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX ); $_nro++;
	    $pdf->SetFont("helvetica", "B", 6);
	    $pdf->Cell(167, $pdf->h_row, "TOTAL  IMPORTE  ", "TR", 0, "R");
	    $pdf->Cell(16, $pdf->h_row, $GLOBALS["_fn"]->fnNumFormat($_impt*1), 1, 0, "R", 1);

        header('Content-type: application/pdf'); header('Content-Disposition: attachment; filename="ingresos_IC.pdf"');
        return $pdf->Output('ingresos_IC.pdf', 'S');
    }
}