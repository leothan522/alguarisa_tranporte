<?php
session_start();
require_once "../../../../vendor/autoload.php";
use app\controller\GuiasController;
use app\resources\fpdf\PDF_WriteTag;
$controller = new GuiasController();
$color = $controller->getColor();

$id = null;
if (!empty($_POST['guias_id'])){
    $id = $_POST['guias_id'];
}

if (!empty($_GET['guias_id'])){
    $id = $_GET['guias_id'];
}

$controller->getGuiaPrint($id);


$qr_texto = "GUÍA DE TRASLADO ALGUARISA \nN°: " .$controller->codigo. " \nFecha: " . $controller->fecha . "\nVehiculo Tipo: " .$controller->vehiculos_tipo. " \nVehiculo Placa Batea: " .$controller->vehiculos_placa_batea. " \nChofer Cedula: " .$controller->choferes_cedula. " \nChofer Nombre: " .$controller->choferes_nombre. " \nDestino: " .$controller->rutas_destino. "";
QRcode::png($qr_texto, 'QRcode.png', '', 2);



// Creación del objeto de la clase heredada ******************************************
$pdf = new PDF_WriteTag();
$pdf->AliasNbPages();
//color azul RGB (0,0,128)
$rojo = $color[0];
$verde = $color[1];
$negro = $color[2];
$pdf->SetTextColor($rojo, $verde, $negro);

//CABECERA ****************************************************************************
$pdf->AddPage('P', 'Letter');
$pdf->SetFont('Times', 'BU', 12);
$pdf->Image('../hoja_membretada.png', 0, 0, 210, 280);
$pdf->Image('QRcode.png', 10, 28, 30, 30);
$pdf->ln(20);
$pdf->Cell(0, 4,$controller->codigo, 0, 1, 'R');
$pdf->Ln(5);
$pdf->Cell(0, 4, verUtf8('AUTORIZACIÓN DE TRASLADO'), 0, 1, 'C');


// TEXTO *****************************************************************************

$texto = "<p>Quien suscribe, <vb>LCDO. HUMBERTO ENRIQUE ALBANI CORTEZ</vb>, venezolano, mayor de edad, titular de la cedula de identidad <vb>Nº V- 19.160.501</vb>, en mi condición de Presidente de <vb>ALIMENTOS DEL GUÁRICO S.A (ALGUARISA) RIF: G-20012864-0</vb>, tal y como consta en Acta de Asamblea Extraordinaria, debidamente registrada de fecha 23 de agosto de 2.021, ante el Registro Mercantil 1ero del Estado Bolivariano Guárico, bajo el número 53 del año 2018,  Tomo 18-A, en el Segundo trimestre del año 2.018, <vb>EMPRESA ADSCRITA A LA SECRETARIA DE DESARROLLO AGROALIMENTARIA DEL ESTADO BOLIVARIANO DE GUÁRICO, QUE SE PRESENTA COMO UNO DE LOS RECURSOS DE ESENCIAL IMPORTANCIA Y VALOR CON LOS QUE CUENTA EL EJECUTIVO REGIONAL, PARA ASÍ GARANTIZAR LA DISTRIBUCIÓN, Y DE ESTA FORMA OFRECER LOS PRODUCTOS QUE INTEGRAN LA CANASTA ALIMENTARIA, ADEMÁS DE AQUELLOS DECLARADOS DE PRIMERA NECESIDAD Y LA ADQUISICIÓN DE LOS MISMOS A PRECIOS JUSTOS Y ACCESIBLES Y A UN TRATO EQUITATIVO Y DIGNO ASÍ COMO LA DEFENSA CONTRA LA ESPECULACIÓN Y EL ACAPARAMIENTO DE LA CESTA BÁSICA</vb>, es por ello que por medio del presente Instrumento se <vb>AUTORIZA</vb>  al  Ciudadano <vb>" .$controller->choferes_nombre. "</vb>, venezolano, mayor de edad, titular de la cédula de identidad <vb>Nº " .$controller->choferes_cedula. "</vb>, conductor de un vehículo identificado con las siguientes características:  <vb>TIPO: " .$controller->vehiculos_tipo. "; MARCA: " .$controller->vehiculos_marca. ", COLOR: " .$controller->vehiculos_color. "; PLACA N°: " .$controller->vehiculos_placa_batea. ". Para que se TRASLADE DESDE LA CIUDAD DE " .$controller->rutas_origen. ", MUNICIPIO " .$controller->origen_municipio. " DEL ESTADO BOLIVARIANO DE GUÁRICO, HASTA LA POBLACIÓN DE " .$controller->rutas_destino. ", MUNICIPIO " .$controller->destino_municipio. " DEL MISMO ESTADO</vb> siguiendo la ruta; " .$controller->trayecto. " hasta llegar a su destino, con el producto alimenticio que presenta las siguientes características:</p>";

$pdf->SetStyle("p", "times", "N", 10, "$rojo,$verde,$negro", 15);
$pdf->SetStyle("vb", "times", "B", 0, "$rojo,$verde,$negro");
$pdf->Ln(14);
//$pdf->SetDrawColor(102,0,102);
$pdf->WriteTag(0, 5, verUtf8($texto), 0, "J", 0, 0);
$pdf->Ln(2);

//CARGA *******************************************************************************

/*$pdf->SetFillColor($r, $g, $b);
$pdf->SetFont('times', 'B', 10);
if (!$guia['precinto'] && !$guia['precinto_2']){
    $pdf->Cell(30, 7, "", 0, 0, 'C');
    $pdf->Cell(47, 7, textoUTF8('CANTIDAD'), 1, 0, 'C', 1);
    $pdf->Cell(83, 7, textoUTF8('DESCRIPCIÓN DEL RUBRO'), 1, 0, 'C', 1);
    $pdf->Cell(30, 7, "", 0, 1, 'C');
    $pdf->SetFont('times', '', 10);

    foreach ($listarCargamento as $carga) {
        $pdf->Cell(30, 7, "", 0, 0, 'C');
        $pdf->Cell(47, 7, textoUTF8(strtoupper($carga['cantidad'])), 1, 0, 'C');
        $pdf->Cell(83, 7, textoUTF8(strtoupper($carga['descripcion'])), 1, 0, 'C');
        $pdf->Cell(30, 7, "", 0, 1, 'C');
    }
}else{
    //con precinto
    $pdf->Cell(24, 7, "PRECINTO:", 1, 0, 'L',1);
    $pdf->Cell(48, 7, textoUTF8(strtoupper($guia['precinto'])), 1, 0, 'C');
    $pdf->Cell(5, 7, "", 0, 0, 'C');

    $pdf->Cell(30, 7, textoUTF8('CANTIDAD'), 1, 0, 'C', 1);
    $pdf->Cell(83, 7, textoUTF8('DESCRIPCIÓN DEL RUBRO'), 1, 1, 'C', 1);
    $pdf->SetFont('times', '', 10);


    $mostrar_precinto_2 = true;
    foreach ($listarCargamento as $carga) {
        if ($guia['precinto_2'] && $mostrar_precinto_2){
            $pdf->SetFont('times', 'B', 10);
            $pdf->Cell(24, 7, "PRECINTO 2:", 1, 0, 'L',1);
            $pdf->Cell(48, 7, textoUTF8(strtoupper($guia['precinto_2'])), 1, 0, 'C');
            $pdf->Cell(5, 7, "", 0, 0, 'C');
            $mostrar_precinto_2 = false;
        }else{
            $pdf->Cell(77, 7, "", 0, 0, 'C');
        }
        $pdf->SetFont('times', '', 10);
        $pdf->Cell(30, 7, textoUTF8(strtoupper($carga['cantidad'])), 1, 0, 'C');
        $pdf->Cell(83, 7, textoUTF8(strtoupper($carga['descripcion'])), 1, 1, 'C');



    }
}*/


// notas ********************************************************************************************
$pdf->Ln(2);

$texto2 = "               Así mismo se expresa que los productos alimenticios identificados no podrán ser desviados por ningún concepto al destino señalado, sin la autorización expresa del Presidente de ALGUARISA.";
$texto3 = "Nota: Se agradece a las autoridades Civiles y Militares de la República Bolivariana de Venezuela la mayor colaboración posible al portador de esta autorización en el traslado respectivo.";

$pdf->MultiCell(0, 5, verUtf8($texto2), 0, 1);
$pdf->MultiCell(0, 5, verUtf8($texto3), 0, 1,);
$pdf->SetFont('times', 'B', 10);
//$pdf->Cell(0, 5, textoUTF8('A los VEINTITRES (23) DIAS DEL MES DE MARZO DEL AÑO 2023.'), 0, 1, 'L');
$pdf->Cell(0, 5, $controller->fecha, 0, 1, 'L');
$pdf->SetFont('times', '', 10);
$pdf->Ln(15);

$pdf->Cell(10, 5, verUtf8(''), 0, 0, 'C');
$pdf->Cell(76, 5, verUtf8('______________________________'), 0, 0, 'C');
$pdf->Cell(18, 5, verUtf8(''), 0, 0, 'C');
$pdf->Cell(76, 5, verUtf8('______________________________'), 0, 0, 'C');
$pdf->Cell(10, 5, verUtf8(''), 0, 1, 'C');

$pdf->Cell(10, 5, verUtf8(''), 0, 0, 'C');
$pdf->Cell(76, 5, verUtf8('ECON. ORLANDO SANDOVAL'), 0, 0, 'C');
$pdf->Cell(18, 5, verUtf8(''), 0, 0, 'C');
$pdf->Cell(76, 5, verUtf8('JESUS CASTILLO'), 0, 0, 'C');
$pdf->Cell(10, 5, verUtf8(''), 0, 1, 'C');

$pdf->Cell(10, 5, verUtf8(''), 0, 0, 'C');
$pdf->Cell(76, 5, verUtf8('C.I: 15.300.194'), 0, 0, 'C');
$pdf->Cell(18, 5, verUtf8(''), 0, 0, 'C');
$pdf->Cell(76, 5, verUtf8('C.I: 16.100.266'), 0, 0, 'C');
$pdf->Cell(10, 5, verUtf8(''), 0, 1, 'C');


$pdf->Cell(10, 5, verUtf8(''), 0, 0, 'C');
$pdf->Cell(76, 5, verUtf8('Gerente de Operaciones y Logística'), 0, 0, 'C');
$pdf->Cell(18, 5, verUtf8(''), 0, 0, 'C');
$pdf->Cell(76, 5, verUtf8('Jefe de la Unidad de Trasporte'), 0, 0, 'C');
$pdf->Cell(10, 5, verUtf8(''), 0, 1, 'C');

$pdf->Cell(10, 5, verUtf8(''), 0, 0, 'C');
$pdf->Cell(76, 5, verUtf8('ALIMENTOS DEL GUÁRICO S.A(ALGUARISA)'), 0, 0, 'C');
$pdf->Cell(18, 5, verUtf8(''), 0, 0, 'C');
$pdf->Cell(76, 5, verUtf8('ALIMENTOS DEL GUÁRICO S.A(ALGUARISA)'), 0, 0, 'C');
$pdf->Cell(10, 5, verUtf8(''), 0, 1, 'C');

$pdf->Ln(5);

$pdf->Cell(62, 5, verUtf8('FIRMA SUPERVISOR DE ALGUARISA:'), 0, 0, 'R');
$pdf->Cell(40, 5, verUtf8('____________________'), 0, 0, 'C');
$pdf->Cell(55, 5, verUtf8('FIRMA DEL CONDUCTOR:'), 0, 0, 'R');
$pdf->Cell(37, 5, verUtf8('____________________'), 0, 1, 'C');

$pdf->Cell(62, 5, verUtf8('TELÉFONO:'), 0, 0, 'R');
$pdf->Cell(40, 5, verUtf8('____________________'), 0, 0, 'C');
$pdf->Cell(55, 5, verUtf8('TELÉFONO:'), 0, 0, 'R');
$pdf->Cell(37, 5, $controller->choferes_telefono, 0, 1, 'C');

$pdf->Output('I', 'Guia-'.$controller->codigo.'.pdf', true,);
