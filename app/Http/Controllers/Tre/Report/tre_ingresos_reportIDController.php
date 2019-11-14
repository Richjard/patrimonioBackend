<?php
namespace App\Http\Controllers\Tre\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Resources\Functions;
use App\Resources\Pdf;
//use TCPDF;

class tre_ingresos_reportIDController extends Controller{ 
    public $_fechaini = ""; public $_fechafin = "";

    public function report(Request $data){
        $_rec = app('App\Http\Controllers\Tre\tre_ingresosController')->tre_ingresos_select($data);
        $_ac = json_decode($_rec->getContent(), TRUE);
        $_fechaini = $data->get("DocFechaIni"); 
        $_fechafin = $data->get("DocFechaFin");
    
        $_fn = new Functions();
        $pdf = new PDF("P", "mm", "A4", true, "UTF-8", false);
        $pdf->setFile_header("tre_ingresos_report_id_head.php");
        $pdf->SetFillColor(192, 192, 192);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetAutoPageBreak(true, 52);
        $pdf->h_row = 5;  $pdf->max = 240;  $_nro = 0;  $_item = 0;  $_impt = 0; 
        //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        $pdf->fnNewPage(2500);  $pdf->SetFont("helvetica", "", 6);
        foreach ($_ac as $row) { 
            $pdf->axisY += ($pdf->h_row + ( $_nro == "0" ? 1 : 0)); $pdf->fnNewPage(); $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX ); $_nro++;
    		$pdf->Cell(8, $pdf->h_row, $_nro, 1, 0, "R");
    		$pdf->Cell(21, $pdf->h_row, $row["cIngDocument"], 1, 0, "L");
            $pdf->Cell(16, $pdf->h_row, $_fn->fnDateDDMMAAAA($row["dDocFecha"]), 1, 0, "C");
            $pdf->Cell(10, $pdf->h_row, $row["cFilAbrev"], 1, 0, "L");
            $pdf->Cell(15, $pdf->h_row, $row["cPersDocumento"], 1, 0, "L");
            $pdf->Cell(55, $pdf->h_row, substr($row["cPersApeNom"],0,35), 1, 0, "L");
            $pdf->Cell(16, $pdf->h_row, "DANYER", 1, 0, "L");
            $pdf->Cell(16, $pdf->h_row, "", 1, 0, "L");
            //$pdf->Cell(16, $pdf->h_row, $data->get("DocFechaIni"), 1, 0, "L");
            //$pdf->Cell(16, $pdf->h_row, $data[0]["DocFechaIni"], 1, 0, "L");
            $pdf->Cell(10, $pdf->h_row, "", 1, 0, "L");
		    $pdf->Cell(16, $pdf->h_row, $_fn->fnNumFormat($row["nIngImpt"]), 1, 0, "R");
            $_impt += $row["nIngImpt"];
        }

    	$pdf->axisY += $pdf->h_row + ( $_nro == "0" ? 1 : 0);  $pdf->fnNewPage();  $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX ); $_nro++;
	    $pdf->SetFont("helvetica", "B", 6);
	    $pdf->Cell(167, $pdf->h_row, "TOTAL  IMPORTE  ", "TR", 0, "R");
	    $pdf->Cell(16, $pdf->h_row, $_fn->fnNumFormat($_impt*1), 1, 0, "R", 1);

        header('Content-type: application/pdf'); header('Content-Disposition: attachment; filename="ingresos_IC.pdf"');
        return $pdf->Output('ingresos_IC.pdf', 'S');
    }
}