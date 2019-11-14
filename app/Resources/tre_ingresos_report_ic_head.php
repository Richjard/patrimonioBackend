<?php
$this->SetFillColor(192, 192, 192);  $this->SetTextColor(0, 0, 0);
//$this->write1DBarcode($GLOBALS["_ah"][0]["doc_id"].fnZerosLeft($GLOBALS["_ah"][0]["orden_id"],9), "EAN13", 148, 8, 36, 11);
//$this->write2DBarcode($_SESSION["scUsursess_key"]." - ".$_SESSION["scUsuracce_key"], "QRCODE,L", 188, 3, 16, 16, "", "" , true);

$_h = 4;
$this->axisX = 14;  $this->axisY = 20;
$this->fnSetAxes($this->axisY, $this->axisX );
$this->SetFont("helvetica", "B", 10);
$this->Cell(190, $_h, "RESUMEN REGISTRO DIARIO DE INGRESO", 0, 0, "C");

$this->axisY += 6;  $this->fnSetAxes( $this->axisY, $this->axisX );
if ($GLOBALS["_fechaini"]!="" && $GLOBALS["_fechafin"]!=""){ $_periodo = $GLOBALS["_fn"]->fnDateDDMMAAAA($GLOBALS["_fechaini"]) ." al ".$GLOBALS["_fn"]->fnDateDDMMAAAA($GLOBALS["_fechafin"]); }
else if ($GLOBALS["_fechaini"]!=""){ $_periodo = "Desde el ".$GLOBALS["_fn"]->fnDateDDMMAAAA($GLOBALS["_fechaini"]); }
else if ($GLOBALS["_fechafin"]!=""){ $_periodo = "Hasta el ".$GLOBALS["_fn"]->fnDateDDMMAAAA($GLOBALS["_fechafin"]); }
$this->SetFont("helvetica", "B", 7);
$this->Cell(13, $_h, " Periodo:", "", 0, "L");
$this->SetFont("helvetica", "", 7);
$this->Cell(30, $_h, $_periodo, "", 0, "L");
$this->axisY += 4;  $this->fnSetAxes( $this->axisY, $this->axisX );
$this->SetFont("helvetica", "B", 7);
$this->Cell(13, $_h, " Cajero:", "", 0, "L");
$this->SetFont("helvetica", "", 7);
if ( isset($GLOBALS["_au"][0]["cPersDocumento"]) ) {
    $this->Cell(120, $_h, $GLOBALS["_au"][0]["cPersDocumento"] ." - ".$GLOBALS["_au"][0]["cPersApeNom"], "", 0, "L");
}
$this->axisY += 5;  $this->fnSetAxes( $this->axisY, $this->axisX );  $_h = 5;
$this->SetFont("helvetica", "B", 7);
$this->Cell(8, $_h, "Item", 1, 0, "C", 1);
$this->Cell(21, $_h, "Documento", 1, 0, "C", 1);
$this->Cell(16, $_h, "Fecha", 1, 0, "C", 1);
$this->Cell(10, $_h, "Sede", 1, 0, "C", 1);
$this->Cell(15, $_h, "Dco. Ident.", 1, 0, "C", 1);
$this->Cell(55, $_h, "Apellidos y Nombres", 1, 0, "C", 1);
$this->Cell(16, $_h, "Cod. Univ.", 1, 0, "C", 1);
$this->Cell(10, $_h, "Ciclo", 1, 0, "C", 1);
$this->Cell(16, $_h, "N° Oper", 1, 0, "C", 1);
$this->Cell(16, $_h, "Importe", 1, 0, "C", 1);

//$this->setXY(14,60);
if ($this->PageNo()*1 > 1 ) { $this->axisY += 6;  $this->fnSetAxes( $this->axisY, $this->axisX );  $_h = 5; }