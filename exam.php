<?php
/// Powered by Evilnapsis go to http://evilnapsis.com
include "fpdf/fpdf.php";

include "core/controller/Core.php";
include "core/controller/Database.php";
include "core/controller/Model.php";
include "core/controller/Executor.php";
include "core/controller/Extra.php";

include "core/app/model/ExamData.php";
include "core/app/model/PersonData.php";
include "core/app/model/ItemData.php";
include "core/app/model/ResultData.php";


$exam = ExamData::getById($_GET["id"]);
$pacient = PersonData::getById($exam->person_id);
$items = ItemData::getAllBy("lab_id",$exam->lab_id);

$pdf = new FPDF($orientation='P',$unit='mm');
$pdf->AddPage();
$pdf->SetFont('Arial','B',20);    
$textypos = 5;
$pdf->setY(12);
$pdf->setX(10);
// Agregamos los datos del consultorio medico
$pdf->Cell(5,$textypos,"ESTUDIO DE LABORATORIO");
$pdf->SetFont('Arial','B',8);    
$pdf->setY(18);$pdf->setX(10);
$pdf->Cell(5,$textypos,"Laboratorio Medico No. 12345");
$pdf->setY(21);$pdf->setX(10);
$pdf->Cell(5,$textypos,"Direccion: Calle 1234, CDMX, Mexico, Cp. 98765");
$pdf->setY(24);$pdf->setX(10);
$pdf->Cell(5,$textypos,"Telefono: 6574839292");

$pdf->SetFont('Arial','',10);    
$pdf->setY(35);$pdf->setX(10);
$pdf->Cell(5,$textypos,"Folio Estudio: #$exam->id");
$pdf->setY(40);$pdf->setX(10);
$pdf->Cell(5,$textypos,"Medico/Doctor: _____________________________________________");
$pdf->setY(45);$pdf->setX(10);
$pdf->Cell(5,$textypos,"Paciente: $pacient->name $pacient->lastname");
$pdf->setY(50);$pdf->setX(10);
$pdf->Cell(5,$textypos,"Fecha: ".date("d/m/Y",strtotime($exam->created_at)));


/// Apartir de aqui empezamos con la tabla de medicamentos
$pdf->setY(60);$pdf->setX(135);
    $pdf->Ln();
/////////////////////////////
//// Array de Cabecera
$header = array("No.", "Parametro","Valor","Unidad","Referencia");
//// Arrar de Productos
$products = array(

);

foreach($items as $it){
    $ie = ResultData::getByIE( $it->id, $exam->id);
    $products[] = array(
        "",
        $it->name,
        $ie->val,
        $it->unit,
        "$it->minimum - $it->maximum",
    );
}

    // Column widths
    $w = array(20, 95, 20, 25, 25);
    // Header
    for($i=0;$i<count($header);$i++)
        $pdf->Cell($w[$i],7,$header[$i],1,0,'C');
    $pdf->Ln();
    // Data
    $total = 0;
    foreach($products as $row)
    {
        $pdf->Cell($w[0],6,$row[0],1);
        $pdf->Cell($w[1],6,$row[1],1);
        $pdf->Cell($w[2],6,$row[2],'1',0,'R');
        $pdf->Cell($w[3],6,$row[3],'1',0,'R');
        $pdf->Cell($w[4],6,$row[3],'1',0,'R');

        $pdf->Ln();

    }
$yposdinamic = 80 + (count($products)*10);

$pdf->SetFont('Arial','B',10);    

$pdf->setY($yposdinamic);
$pdf->setX(75);
$pdf->Cell(5,$textypos,"FIRMA Y SELLO");
$pdf->SetFont('Arial','',10);    

$pdf->setY($yposdinamic+20);
$pdf->setX(50);
$pdf->Cell(5,$textypos,"_________________________________________");
$pdf->setY($yposdinamic+25);
$pdf->setX(70);
$pdf->Cell(5,$textypos,"Nombre del Medico/Doctor");
$pdf->setY($yposdinamic+55);
$pdf->setX(80);


$pdf->output();
?>