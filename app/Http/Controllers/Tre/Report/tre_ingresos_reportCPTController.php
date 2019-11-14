<?php
namespace App\Http\Controllers\Tre\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Resources\Functions;
use App\Resources\Pdf;

$_au = ""; $_fn = "";
class tre_ingresos_reportCPTController extends Controller{ 
    public function report(Request $data){
        $GLOBALS["_fn"] = new Functions();
        $_dia = ""; $_mes = ""; $_yea = "";
        if ($data->get("DocFechaIni") == $data->get("DocFechaFin")) { $_date = $GLOBALS["_fn"]->fnDateDDMMAAAA($data->get("DocFechaIni"));
            $_dia = substr($_date, 0, 2);
            $_mes = substr($_date, 3, 2);
            $_yea = substr($_date, 6, 4);
        }

        if ( $data->get("CredDepenKey") != "" ) {
            $_rec = app("App\Http\Controllers\Tre\seg_credenciales_dependenciasController")->seg_credenciales_dependencias_select($data, Array("CredDepenKey"=>$data->get("CredDepenKey"),"TypeRecord"=>"headApeNom"));
            $GLOBALS["_au"] = json_decode($_rec->getContent(), TRUE);
        }

        $_rec = app('App\Http\Controllers\Tre\tre_ingresos_detController')->tre_ingresos_det_select($data);
        $_ac = json_decode($_rec->getContent(), TRUE);

        $pdf = new PDF("P", "mm", "A4", true, "UTF-8", false);
        $pdf->SetFillColor(192, 192, 192);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->h_row = 3;  $pdf->max = 270;  $_nro = 0;  $_item = 0;  $_impt = 0;

        $pdf->fnNewPage(2500);  $pdf->SetFont("helvetica", "B", 6);  $pdf->SetTextColor(0, 0, 0); 
        
        $pdf->axisY = 16;
        $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX );
        $pdf->Cell(185, $pdf->h_row, "RECIBO DE INGRESOS CONSOLIDADO", 0, 0, "C");
        
        $pdf->SetFont("helvetica", "", 5);
        $pdf->axisY += 4; $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX );
        $pdf->Cell(20, $pdf->h_row, "NUMERACION", "LTR", 0, "C", 1);
        $pdf->Cell(121, $pdf->h_row, "", "", 0, "C");
        $pdf->Cell(22, $pdf->h_row, "REGISTRO", "LTR", 0, "C", 1);
        $pdf->Cell(6, 6, "DIA", 1, 0, "C", 1);
        $pdf->Cell(6, 6, "MES", 1, 0, "C", 1);
        $pdf->Cell(10, 6, "AÑO", 1, 0, "C", 1);

        $pdf->axisY += $pdf->h_row; $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX );
        $pdf->Cell(20, $pdf->h_row, "TESORERO", "LBR", 0, "C", 1);
        $pdf->Cell(121, $pdf->h_row, "", "", 0, "C");
        $pdf->Cell(22, $pdf->h_row, "SIAF N°", "LBR", 0, "C", 1);

        $pdf->axisY += $pdf->h_row; $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX ); $pdf->h_row = 4;
        $pdf->Cell(20, $pdf->h_row, "", 1, 0, "C");
        $pdf->Cell(121, $pdf->h_row, "", "", 0, "C");
        $pdf->Cell(22, $pdf->h_row, "", 1, 0, "C");
        $pdf->Cell(6, $pdf->h_row, $_dia, 1, 0, "C");
        $pdf->Cell(6, $pdf->h_row, $_mes, 1, 0, "C");
        $pdf->Cell(10, $pdf->h_row, $_yea, 1, 0, "C");

        $pdf->SetFont("helvetica", "B", 5);
        $pdf->axisY += $pdf->h_row + 1; $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX );
        $pdf->Cell(20, 6, "CLASIFICADOR", 1, 0, "C", 1);
        $pdf->Cell(121, 6, "DESCRIPCION", 1, 0, "C", 1);
        $pdf->Cell(44, 3, "IMPORTE", 1, 0, "C", 1);

        $pdf->h_row = 3;
        $pdf->axisX = 155; $pdf->axisY += 3; $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX );
        $pdf->Cell(22, $pdf->h_row, "PARCIAL", 1, 0, "C", 1);
        $pdf->Cell(22, $pdf->h_row, "TOTAL", 1, 0, "C", 1);

        $pdf->axisX = 14; $pdf->SetFont("helvetica", "B", 5);

        $pdf->h_row = 2.5; $pdf->axisY += 0.5;
        $pdf->axisY += $pdf->h_row; $pdf->fnNewPage(); $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX );
        $pdf->Cell(20, $pdf->h_row, "1", "LTR", 0, "L");
        $pdf->Cell(121, $pdf->h_row, "Ingresos Presupuestales", "LTR", 0, "L");
        $pdf->Cell(22, $pdf->h_row, "", "LTR", 0, "R");
        $pdf->Cell(22, $pdf->h_row, "", "LTR", 0, "R");

        $pdf->SetFont("helvetica", "", 5);
        $pdf->axisY += $pdf->h_row; $pdf->fnNewPage(); $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX );
        $pdf->Cell(20, $pdf->h_row, "", "LR", 0, "L");
        $pdf->Cell(121, $pdf->h_row, "Por los ingresos captados de Recursos Directamente Recaudados en la", "LR", 0, "L");
        $pdf->Cell(22, $pdf->h_row, "", "LR", 0, "R");
        $pdf->Cell(22, $pdf->h_row, "", "LR", 0, "R");

        $pdf->axisY += $pdf->h_row; $pdf->fnNewPage(); $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX );
        $pdf->Cell(20, $pdf->h_row, "", "LR", 0, "L");
        $pdf->Cell(121, $pdf->h_row, "Universidad Nacional de Moquegua.", "LR", 0, "L");
        $pdf->Cell(22, $pdf->h_row, "", "LR", 0, "R");
        $pdf->Cell(22, $pdf->h_row, "", "LR", 0, "R");

        $_GeneCode = ""; $_SubGeneCode = ""; $_SubGeneDetCode = ""; $_EspeCode = "";
        foreach ($_ac as $row) {
            if ( $row["cGeneCodigo"] != $_GeneCode ) {
                $pdf->axisY += $pdf->h_row; $pdf->fnNewPage(); $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX ); $_nro++;
                $pdf->SetFont("helvetica", "B", 5);
                $pdf->Cell(20, $pdf->h_row, $row["cGeneCodigo"], "LR", 0, "L");
                $pdf->Cell(121, $pdf->h_row, $row["cGeneNombre"], "LR", 0, "L");
                $pdf->Cell(22, $pdf->h_row, "", "LR", 0, "R");
                $pdf->Cell(22, $pdf->h_row, "", "LR", 0, "R");            
            }
            if ( $row["cSubGeneCodigo"] != $_SubGeneCode ) {
                $pdf->axisY += $pdf->h_row; $pdf->fnNewPage(); $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX ); $_nro++;
                $pdf->SetFont("helvetica", "B", 5);
                $pdf->Cell(20, $pdf->h_row, $row["cSubGeneCodigo"], "LR", 0, "L");
                $pdf->Cell(121, $pdf->h_row, $row["cSubGeneNombre"], "LR", 0, "L");
                $pdf->Cell(22, $pdf->h_row, "", "LR", 0, "R");
                $pdf->Cell(22, $pdf->h_row, $GLOBALS["_fn"]->fnNumFormat($row["nSubGeneImpt"]), "LR", 0, "R");
            }
            $pdf->SetFont("helvetica", "", 5);
            if ( $row["cSubGeneDetCodigo"] != $_SubGeneDetCode ) {
                $pdf->axisY += $pdf->h_row; $pdf->fnNewPage(); $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX ); $_nro++;
                $pdf->Cell(20, $pdf->h_row, $row["cSubGeneDetCodigo"], "LR", 0, "L");
                $pdf->Cell(121, $pdf->h_row, $row["cSubGeneDetNombre"], "LR", 0, "L");
                $pdf->Cell(22, $pdf->h_row, "", "LR", 0, "R");
                $pdf->Cell(22, $pdf->h_row, "", "LR", 0, "R");
            }
            if ( $row["cEspeCodigo"] != $_EspeCode ) {
                $pdf->axisY += $pdf->h_row; $pdf->fnNewPage(); $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX ); $_nro++;
                $pdf->Cell(20, $pdf->h_row, $row["cEspeCodigo"], "LR", 0, "L");
                $pdf->Cell(121, $pdf->h_row, $row["cEspeNombre"], "LR", 0, "L");
                $pdf->Cell(22, $pdf->h_row, "", "LR", 0, "R");
                $pdf->Cell(22, $pdf->h_row, "", "LR", 0, "R");     
            }

            $pdf->axisY += $pdf->h_row; $pdf->fnNewPage(); $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX ); $_nro++;
            $pdf->Cell(20, $pdf->h_row, $row["cEspeDetCodigo"], "LR", 0, "L");
            $pdf->Cell(121, $pdf->h_row, $row["cEspeDetNombre"], "LR", 0, "L");
            $pdf->Cell(22, $pdf->h_row, $GLOBALS["_fn"]->fnNumFormat($row["nEspeDetImpt"]), "LR", 0, "R");
            $pdf->Cell(22, $pdf->h_row, "", "LR", 0, "R");
            
            $_GeneCode = $row["cGeneCodigo"]; $_SubGeneCode = $row["cSubGeneCodigo"]; $_SubGeneDetCode = $row["cSubGeneDetCodigo"]; $_EspeCode = $row["cEspeCodigo"];
            $_impt += $row["nEspeDetImpt"];
        }

    	$pdf->axisY += $pdf->h_row;  $pdf->fnNewPage();  $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX );
	    $pdf->SetFont("helvetica", "B", 5);
	    $pdf->Cell(163, $pdf->h_row, "TOTAL  IMPORTE  ", 1, 0, "R");
	    $pdf->Cell(22, $pdf->h_row, $GLOBALS["_fn"]->fnNumFormat($_impt*1), 1, 0, "R", 1);

    	$pdf->axisY += $pdf->h_row;  $pdf->fnNewPage();  $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX );
	    $pdf->SetFont("helvetica", "", 5);
	    $pdf->Cell(145, $pdf->h_row, "CODIGO DE CONTABILIDAD GUBERNAMENTAL", 0, 0, "C");
	    $pdf->Cell(40, $pdf->h_row, "PROGRAMATICA DE GASTO", 0, 0, "C");

        $pdf->axisY += $pdf->h_row;  $pdf->fnNewPage();  $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX ); $pdf->h_row = 3;
	    $pdf->SetFont("helvetica", "", 5);
	    $pdf->Cell(37, $pdf->h_row, "CUENTA MAYOR", 1, 0, "C");
        $pdf->Cell(19, 6, "", 1, 0, "C");
        $pdf->Cell(19, 6, "SECTOR", 1, 0, "C");
        $pdf->Cell(19, 6, "PLIEGO", 1, 0, "C");
        $pdf->Cell(10, 6, "U.G.", 1, 0, "C");
        $pdf->Cell(18, 6, "U.E.", 1, 0, "C");
        $pdf->Cell(19, 6, "FUNC", 1, 0, "C");
        $pdf->Cell(22, 6, "FUENTE FINANC", 1, 0, "C");
        $pdf->Cell(22, $pdf->h_row, "CTA. CTE. V°B°", "LTR", 0, "C");

        $pdf->axisY += 3;  $pdf->fnNewPage();  $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX );
	    $pdf->SetFont("helvetica", "", 5);
	    $pdf->Cell(18, $pdf->h_row, "DEBE", 1, 0, "C");
        $pdf->Cell(19, $pdf->h_row, "HABER", 1, 0, "C");
        $pdf->axisX = 177;
        $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX );
        $pdf->Cell(22, $pdf->h_row, "SUB CUENTA", "LBR", 0, "C");

        $pdf->axisX = 14;
        $pdf->axisY += $pdf->h_row;  $pdf->fnNewPage();  $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX );
	    $pdf->SetFont("helvetica", "", 5);
        $pdf->Cell(18, $pdf->h_row, "", 1, 0, "C");
        $pdf->Cell(19, $pdf->h_row, "", 1, 0, "C");
        $pdf->Cell(19, $pdf->h_row, "", 1, 0, "C");
        $pdf->Cell(19, $pdf->h_row, "", 1, 0, "C");
        $pdf->Cell(19, $pdf->h_row, "", 1, 0, "C");
        $pdf->Cell(10, $pdf->h_row, "", 1, 0, "C");
        $pdf->Cell(18, $pdf->h_row, "", 1, 0, "C");
        $pdf->Cell(19, $pdf->h_row, "", 1, 0, "C");
        $pdf->Cell(22, $pdf->h_row, "R.D.R.", 1, 0, "C");
        $pdf->Cell(22, $pdf->h_row, "0141-028154", 1, 0, "C");

        $pdf->axisY += 4;  $pdf->fnNewPage();  $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX );
        $pdf->Cell(94, 3, "CONTABILIDAD PATRIMONIAL", 1, 0, "C", 1);
        $pdf->Cell(28, 3, "", "LR", 0, "C");
        $pdf->Cell(63, 16, "", 1, 0, "C");

        $pdf->axisY += 3;  $pdf->fnNewPage();  $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX );
        $pdf->Cell(56, 3, "CODIGO", 1, 0, "C", 1);
        $pdf->Cell(38, 3, "IMPORTE", 1, 0, "C", 1);

        $pdf->axisY += 3;  $pdf->fnNewPage();  $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX );
        $pdf->Cell(18, 3, "CUENTA", "LTR", 0, "C", 1);
        $pdf->Cell(38, 3, "SUB", "LTR", 0, "C", 1);
        $pdf->Cell(19, 6, "DEBE", 1, 0, "C", 1);
        $pdf->Cell(19, 6, "HABER", 1, 0, "C", 1);

        $pdf->axisY += 3;  $pdf->fnNewPage();  $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX );
        $pdf->Cell(18, 3, "MAYOR", "LBR", 0, "C", 1);
        $pdf->Cell(38, 3, "CUENTAS", "LBR", 0, "C", 1);

        $pdf->axisY += 3;  $pdf->fnNewPage();  $pdf->fnSetAxes( $pdf->axisY, $pdf->axisX );
        $pdf->Cell(18, 2.5, "110103", "LTR", 0, "C");
        $pdf->Cell(19, 2.5, "", "LBR", 0, "C");
        $pdf->Cell(19, 2.5, "", "LBR", 0, "C");
        $pdf->Cell(19, 2.5, "", "LBR", 0, "C");

        header('Content-type: application/pdf'); header('Content-Disposition: attachment; filename="ingresos_IC.pdf"');
        return $pdf->Output('ingresos_IC.pdf', 'S');
    }
}