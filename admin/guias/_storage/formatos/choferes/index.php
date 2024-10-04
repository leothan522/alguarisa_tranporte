<?php
session_start();
require_once "../../../../../vendor/autoload.php";
use app\controller\ChoferesController;
use app\resources\fpdf\PDF_WriteTag;

$controller = new ChoferesController();
$listarChoferes = $controller->getAllChoferes();


// Creación del objeto de la clase heredada ******************************************
$pdf = new PDF_WriteTag();

$pdf->AddPage('P', 'Letter');
$pdf->SetFont('Times', 'BU', 12);
$pdf->Image('../../hoja_membretada.png', 0, 0, 210, 280);

$pdf->Ln(20);
$pdf->Cell(0, 4, verUtf8(mb_strtoupper("Lista QR de Choferes")), 0, 1, 'C');
$pdf->Ln(2);


//$pdf->Cell(0, 5, '', 1, 1, 'C');
//$pdf->Cell(196, '5', '', 1, 1, 'C');
//$pdf->SetFillColor(0,0,234);


$x1 = $pdf->GetX();
$y1 = $pdf->GetY();
$pagina = 0;
$i = 0;
foreach ($listarChoferes as $chofer){
    $i++;
    $qr_texto = "Conductor: " .verUtf8( mb_strtoupper($chofer['nombre'])) . " \nC.I: " . formatoMillares($chofer['cedula']) . " \nVehiculo: " . verUtf8(mb_strtoupper($controller->getTipoPrint($chofer['rowquid']))) . " \nMarca: " . verUtf8(mb_strtoupper($controller->getVehiculo($chofer['rowquid'], 'marca'))) . " \nPlaca: " . verUtf8(mb_strtoupper($controller->getVehiculo($chofer['rowquid']))) . " \nColor: " . verUtf8(mb_strtoupper($controller->getVehiculo($chofer['rowquid'], 'color'))) . " \nTlf: ".$chofer['telefono']."   \nModulos: " . $controller->getVehiculo($chofer['rowquid'], 'capacidad') . " ";

    if ($pagina == 10){
        $pagina = 0;

        $pdf->AddPage('P', 'Letter');
        $pdf->SetFont('Times', 'BU', 12);
        $pdf->Image('../../hoja_membretada.png', 0, 0, 210, 280);
        $pdf->Ln(20);
        $pdf->Cell(0, 4, verUtf8(mb_strtoupper("Lista QR de Choferes")), 0, 1, 'C');
        $pdf->Ln(2);

        $x1 = $pdf->GetX();
        $y1 = $pdf->GetY();
    }
    $pagina++;
   if (($i % 2) == 0){
       $pdf->SetXY($x2, $y2);
       $pdf->Cell(30, 5, '', 0, 0, 'C');
       $pdf->Cell(68, 5, 'C.I: '.formatoMillares($chofer['cedula']), 0, 1);

       $pdf->Cell(128, 5, '', 0, 0, 'C');
       $pdf->Cell(68, 5, verUtf8(mb_strtoupper($chofer['nombre'])), 0, 1);

       $pdf->Cell(128, 5, '', 0, 0, 'C');
       $pdf->Cell(68, 5, verUtf8(mb_strtoupper($controller->getTipoPrint($chofer['rowquid']))), 0, 1);

       $pdf->Cell(128, 5, '', 0, 0, 'C');
       $pdf->Cell(68, 5, 'MARCA: '.verUtf8(mb_strtoupper($controller->getVehiculo($chofer['rowquid'], 'marca'))), 0, 1);

       $pdf->Cell(128, 5, '', 0, 0, 'C');
       $pdf->Cell(68, 5, 'PLACA: '.verUtf8(mb_strtoupper($controller->getVehiculo($chofer['rowquid']))), 0, 1);

       $pdf->Cell(128, 5, '', 0, 0, 'C');
       $pdf->Cell(68, 5, 'COLOR: '.verUtf8(mb_strtoupper($controller->getVehiculo($chofer['rowquid'], 'color'))), 0, 1);

       $pdf->Cell(128, 5, '', 0, 0, 'C');
       $pdf->Cell(68, 5, 'TLF: '.$chofer['telefono'], 0, 1);

       $pdf->Cell(128, 5, '', 0, 0, 'C');
       $pdf->Cell(68, 5, 'MODULOS: '.mb_strtoupper($controller->getVehiculo($chofer['rowquid'], 'capacidad')), 0, 1);



       $pdf->SetXY($x2, $y2);
       QRcode::png(verUtf8($qr_texto), 'qr_chofer/QRcodeChofer_'.$chofer['id'].'.png', '', 2);
       $pdf->Image('qr_chofer/QRcodeChofer_'.$chofer['id'].'.png');
   }else{
       $pdf->SetXY($x1, $y1);
       $pdf->Cell(30, 5, '', 0, 0, 'C');
       $pdf->Cell(68, 5, 'C.I: '.formatoMillares($chofer['cedula']), 0, 0);
       $x2 = $pdf->GetX();
       $y2 = $pdf->GetY();
       $pdf->Cell(98, 5, '', 0, 1);
       $pdf->Cell(30, 5, '', 0, 0, 'C');
       $pdf->Cell(68, 5, verUtf8(mb_strtoupper($chofer['nombre'])), 0, 1);
       $pdf->Cell(30, 5, '', 0, 0, 'C');
       $pdf->Cell(68, 5, verUtf8(mb_strtoupper($controller->getTipoPrint($chofer['rowquid']))), 0, 1);
       $pdf->Cell(30, 5, '', 0, 0, 'C');
       $pdf->Cell(68, 5, 'MARCA: '.verUtf8(mb_strtoupper($controller->getVehiculo($chofer['rowquid'], 'marca'))), 0, 1);
       $pdf->Cell(30, 5, '', 0, 0, 'C');
       $pdf->Cell(68, 5, 'PLACA: '.verUtf8(mb_strtoupper($controller->getVehiculo($chofer['rowquid']))), 0, 1);
       $pdf->Cell(30, 5, '', 0, 0, 'C');
       $pdf->Cell(68, 5, 'COLOR: '.verUtf8(mb_strtoupper($controller->getVehiculo($chofer['rowquid'], 'color'))), 0, 1);
       $pdf->Cell(30, 5, '', 0, 0, 'C');
       $pdf->Cell(68, 5, 'TLF: '.$chofer['telefono'], 0, 1);
       $pdf->Cell(30, 5, '', 0, 0, 'C');
       $pdf->Cell(68, 5, 'MODULOS: '.mb_strtoupper($controller->getVehiculo($chofer['rowquid'], 'capacidad')), 0, 1);

       $pdf->Ln(5);
       $x3 = $pdf->GetX();
       $y3 = $pdf->GetY();

       $pdf->SetXY($x1, $y1);
       QRcode::png(verUtf8($qr_texto), 'qr_chofer/QRcodeChofer_'.$chofer['id'].'.png', '', 2);
       $pdf->Image('qr_chofer/QRcodeChofer_'.$chofer['id'].'.png');
   }

    $x1 = $x3;
    $y1 = $y3;
}



















$pdf->Output('I', 'Choferes.pdf', true,);