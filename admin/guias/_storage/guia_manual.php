<?php
function textoUTF8($string)
{
    return mb_convert_encoding($string, 'ISO-8859-1', 'UTF-8');
}
include('../../../../phpqrcode/qrlib.php');
require '../../../../fpdf/WriteTag.php';



$qr_texto = "GUIA DE TRASLADO MANUAL\nALIMENTOS DEL GUARICO S.A (ALGUARISA)  \nELABORADA POR EVENTUALIDAD EN EL \nDEPARTAMENTO DE TRANSPORTE  \nESTE DOCUMENTO SIN FIRMA Y SELLO \nNO TIENE VALIDEZ ";
QRcode::png($qr_texto, 'QRcodeManual.png', '', 2);


// Creación del objeto de la clase heredada ******************************************
$pdf = new PDF_WriteTag();
$pdf->AliasNbPages();
//color azul RGB (0,0,128)
$rojo = 0;
$verde = 0;
$negro = 128;
$pdf->SetTextColor($rojo, $verde, $negro); //color azul
//color negro
/*$pdf->SetTextColor(0, 0, 0);*/

//CABECERA ****************************************************************************
$pdf->AddPage('P', 'Letter');
$pdf->SetFont('Times', 'BU', 12);
$pdf->Image('../../../../img/hoja_membretada.png', 0, 0, 210, 280);
$pdf->Image('QRcodeManual.png', 10, 28, 30, 30);
$pdf->ln(20);
$pdf->Cell(0, 4, textoUTF8("N°________________________-" . date('Y')), 0, 1, 'R');
$pdf->Ln(5);
$pdf->Cell(0, 4, textoUTF8('AUTORIZACIÓN DE TRASLADO'), 0, 1, 'C');

// TEXTO *****************************************************************************

$texto = "<p>Quien suscribe, <vb>LCDO. HUMBERTO ENRIQUE ALBANI CORTEZ</vb>, venezolano, mayor de edad, titular de la cedula de identidad <vb>Nº V- 19.160.501</vb>, en mi condición de Presidente de <vb>ALIMENTOS DEL GUÁRICO S.A (ALGUARISA) RIF: G-20012864-0</vb>, tal y como consta en Acta de Asamblea Extraordinaria, debidamente registrada de fecha 23 de agosto de 2.021, ante el Registro Mercantil 1ero del Estado Bolivariano Guárico, bajo el número 53 del año 2018,  Tomo 18-A, en el Segundo trimestre del año 2.018, <vb>EMPRESA ADSCRITA A LA SECRETARIA DE DESARROLLO AGROALIMENTARIA DEL ESTADO BOLIVARIANO DE GUÁRICO, QUE SE PRESENTA COMO UNO DE LOS RECURSOS DE ESENCIAL IMPORTANCIA Y VALOR CON LOS QUE CUENTA EL EJECUTIVO REGIONAL, PARA ASÍ GARANTIZAR LA DISTRIBUCIÓN, Y DE ESTA FORMA OFRECER LOS PRODUCTOS QUE INTEGRAN LA CANASTA ALIMENTARIA, ADEMÁS DE AQUELLOS DECLARADOS DE PRIMERA NECESIDAD Y LA ADQUISICIÓN DE LOS MISMOS A PRECIOS JUSTOS Y ACCESIBLES Y A UN TRATO EQUITATIVO Y DIGNO ASÍ COMO LA DEFENSA CONTRA LA ESPECULACIÓN Y EL ACAPARAMIENTO DE LA CESTA BÁSICA</vb>, es por ello que por medio del presente Instrumento se <vb>AUTORIZA</vb>  al  Ciudadano <vb>__________________________________________________________</vb>, venezolano, mayor de edad, titular de la cédula de identidad <vb>Nº_________________________</vb>, conductor de un vehículo identificado con las siguientes características:  <vb>TIPO:______________________, MARCA:_________________, COLOR:_____________, PLACA N°:____________________. Para que se TRASLADE DESDE LA CIUDAD DE SAN JUAN DE LOS MORROS, MUNICIPIO JUAN GERMÁN ROSCIO NIEVES CAPITAL DEL ESTADO BOLIVARIANO DE GUÁRICO, HASTA LA POBLACIÓN DE:_______________________________________________________________________________ DEL MISMO ESTADO</vb>, con el producto alimenticio que presenta las siguientes características:</p>";

//color negro
/*$pdf->SetStyle("p", "times", "N", 10, "0,0,0", 15);
$pdf->SetStyle("vb", "times", "B", 0, "0,0,0");*/

//color azul
$pdf->SetStyle("p", "times", "N", 10, "$rojo,$verde,$negro", 15);
$pdf->SetStyle("vb", "times", "B", 0, "$rojo,$verde,$negro");

$pdf->Ln(14);
$pdf->WriteTag(0, 5, textoUTF8($texto), 0, "J", 0, 0);
$pdf->Ln(2);

//CARGA *******************************************************************************

//CARGA *******************************************************************************
$r = 51;
$g = 246;
$b = 255;
$pdf->SetFillColor($r, $g, $b);
$pdf->SetFont('times', 'B', 10);
//con precinto
$pdf->Cell(24, 7, "", 0, 0, 'L');
$pdf->Cell(48, 7, "", 0, 0, 'C');
$pdf->Cell(5, 7, "", 0, 0, 'C');

$pdf->Cell(30, 7, textoUTF8('CANTIDAD'), 1, 0, 'C', 1);
$pdf->Cell(83, 7, textoUTF8('DESCRIPCIÓN DEL RUBRO'), 1, 1, 'C', 1);
$pdf->SetFont('times', '', 10);

$pdf->SetFont('times', 'B', 10);
$pdf->Cell(24, 7, "PRECINTO 1:", 1, 0, 'L', 1);
$pdf->Cell(48, 7, "", 1, 0, 'C');
$pdf->Cell(5, 7, "", 0, 0, 'C');

$pdf->SetFont('times', '', 10);
$pdf->Cell(30, 7, "", 1, 0, 'C');
$pdf->Cell(83, 7, "", 1, 1, 'C');

$pdf->SetFont('times', 'B', 10);
$pdf->Cell(24, 7, "PRECINTO 2:", 1, 0, 'L', 1);
$pdf->Cell(48, 7, "", 1, 0, 'C');
$pdf->Cell(5, 7, "", 0, 0, 'C');

$pdf->SetFont('times', '', 10);
$pdf->Cell(30, 7, "", 1, 0, 'C');
$pdf->Cell(83, 7, "", 1, 1, 'C');

// notas ********************************************************************************************
$pdf->Ln(2);

$texto2 = "               Así mismo se expresa que los productos alimenticios identificados no podrán ser desviados por ningún concepto al destino señalado, sin la autorización expresa del Presidente de ALGUARISA.";
$texto3 = "Nota: Se agradece a las autoridades Civiles y Militares de la República Bolivariana de Venezuela la mayor colaboración posible al portador de esta autorización en el traslado respectivo.";

$pdf->MultiCell(0, 5, textoUTF8($texto2), 0, 1);
$pdf->MultiCell(0, 5, textoUTF8($texto3), 0, 1,);
$pdf->SetFont('times', 'B', 10);
//$pdf->Cell(0, 5, textoUTF8('A los VEINTITRES (23) DIAS DEL MES DE MARZO DEL AÑO 2023.'), 0, 1, 'L');
$pdf->Cell(0, 5, textoUTF8('A los _________________ DÍAS DEL MES DE ___________________ DEL AÑO' . date(' Y')), 0, 1, 'L');
$pdf->SetFont('times', '', 10);
$pdf->Ln(15);

$pdf->Cell(10, 5, textoUTF8(''), 0, 0, 'C');
$pdf->Cell(76, 5, textoUTF8('______________________________'), 0, 0, 'C');
$pdf->Cell(18, 5, textoUTF8(''), 0, 0, 'C');
$pdf->Cell(76, 5, textoUTF8('______________________________'), 0, 0, 'C');
$pdf->Cell(10, 5, textoUTF8(''), 0, 1, 'C');

$pdf->Cell(10, 5, textoUTF8(''), 0, 0, 'C');
$pdf->Cell(76, 5, textoUTF8('ECON. ORLANDO SANDOVAL'), 0, 0, 'C');
$pdf->Cell(18, 5, textoUTF8(''), 0, 0, 'C');
$pdf->Cell(76, 5, textoUTF8('JESUS CASTILLO'), 0, 0, 'C');
$pdf->Cell(10, 5, textoUTF8(''), 0, 1, 'C');

$pdf->Cell(10, 5, textoUTF8(''), 0, 0, 'C');
$pdf->Cell(76, 5, textoUTF8('C.I: 15.300.194'), 0, 0, 'C');
$pdf->Cell(18, 5, textoUTF8(''), 0, 0, 'C');
$pdf->Cell(76, 5, textoUTF8('C.I: 16.100.266'), 0, 0, 'C');
$pdf->Cell(10, 5, textoUTF8(''), 0, 1, 'C');


$pdf->Cell(10, 5, textoUTF8(''), 0, 0, 'C');
$pdf->Cell(76, 5, textoUTF8('Gerente de Operaciones y Logística'), 0, 0, 'C');
$pdf->Cell(18, 5, textoUTF8(''), 0, 0, 'C');
$pdf->Cell(76, 5, textoUTF8('Jefe de la Unidad de Trasporte'), 0, 0, 'C');
$pdf->Cell(10, 5, textoUTF8(''), 0, 1, 'C');

$pdf->Cell(10, 5, textoUTF8(''), 0, 0, 'C');
$pdf->Cell(76, 5, textoUTF8('ALIMENTOS DEL GUÁRICO S.A(ALGUARISA)'), 0, 0, 'C');
$pdf->Cell(18, 5, textoUTF8(''), 0, 0, 'C');
$pdf->Cell(76, 5, textoUTF8('ALIMENTOS DEL GUÁRICO S.A(ALGUARISA)'), 0, 0, 'C');
$pdf->Cell(10, 5, textoUTF8(''), 0, 1, 'C');

$pdf->Ln(5);

$pdf->Cell(62, 5, textoUTF8('FIRMA SUPERVISOR DE ALGUARISA:'), 0, 0, 'R');
$pdf->Cell(40, 5, textoUTF8('____________________'), 0, 0, 'C');
$pdf->Cell(55, 5, textoUTF8('FIRMA DEL CONDUCTOR:'), 0, 0, 'R');
$pdf->Cell(37, 5, textoUTF8('____________________'), 0, 1, 'C');

$pdf->Cell(62, 5, textoUTF8('TELÉFONO:'), 0, 0, 'R');
$pdf->Cell(40, 5, textoUTF8('____________________'), 0, 0, 'C');
$pdf->Cell(55, 5, textoUTF8('TELÉFONO:'), 0, 0, 'R');
$pdf->Cell(37, 5, textoUTF8('____________________'), 0, 1, 'C');

$pdf->Output('D', 'Guia_Manual.pdf', true,);
