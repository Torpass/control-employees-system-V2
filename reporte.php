<?php
require('fpdf/fpdf.php');
require('dbConnections/db.php');
require('dbConnections/dbEmployees.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    $fechaActual = date('d-m-Y');
    $this->SetTextColor(0, 0, 0);
    $this->SetFont('Times','B',20);
    $this->Image('img/growsLogo.png',10,15,40);
    $this->setXY(70,20);
    $this->Cell(74,8, 'Reporte Empleados Grows 2023',3,0,'C',0);
    $this->SetTitle ('Report Empleados Grows');
    $this->setXY(70,30);
    $this->Cell(74,8, 'Fecha de emision',3,0,'C',0);
    $this->Cell(-70,28, $fechaActual ,3,0,'C',0);
    $this->ln(20);
}


function Footer()
{
       $this->SetTextColor(0, 0, 0);
       $this->SetY(-15);
       // Arial italic 8
       $this->SetFont('Arial','B',8);
       // Número de página
       $this->Cell(0,10,utf8_decode('Pagina').$this->PageNo().'/{nb}',0,1,'C');
       $this->Image('img/GrowsOtro.png',175,280,30);  
       $this->Cell(0,1,'Grows System',0,0,'C');
}
}
/**********************************************************/
class PDF_MC_Table extends FPDF
{
    protected $widths;
    protected $aligns;

    function SetWidths($w)
    {
        // Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        // Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data,$setX)
    {
        // Calculate the height of the row
        $nb = 0;
        for($i=0;$i<count($data);$i++)
            $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h = 5*$nb;
        // Issue a page break first if needed
        $this->CheckPageBreak($h,$setX);
        // Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            // Draw the border
            $this->Rect($x,$y,$w,$h,'DF');
            // Print the text
            $this->MultiCell($w,5,$data[$i],0,$a);
            // Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        // Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        // If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        // Compute the number of lines a MultiCell of width w will take
        if(!isset($this->CurrentFont))
            $this->Error('No font has been set');
        $cw = $this->CurrentFont['cw'];
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',(string)$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while($i<$nb)
        {
            $c = $s[$i];
            if($c=="\n")
            {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep = $i;
            $l += $cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i = $sep+1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }
}

//************************************************************************************ */

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(10,10,10); // Margenes 
$pdf->SetAutoPageBreak(true,20);

// Obtener el ancho de la página
$pageWidth = $pdf->GetPageWidth();

// Obtener el ancho de la tabla
$tableWidth = 100; // Ajustar este valor según el ancho de tu tabla

// Calcular la cantidad de espacio a la izquierda de la tabla
$leftSpace = ($pageWidth - $tableWidth) / 2;

// Establecer la posición X para centrar la tabla


$pdf->Ln(5);
$pdf->SetX(30);
$pdf->SetFont('Helvetica','B',12);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(27, 73, 101);
$pdf->Cell(10,7,'ID',1,0,'C', true); 
$pdf->Cell(35,7,'Nombre',1,0,'C', true);
$pdf->Cell(35,7,'Apellido',1,0,'C',true);
$pdf->Cell(35,7,utf8_decode ('Trabajo'),1,0,'C',true);
$pdf->Cell(35,7,'Fecha de inicio',1,1,'C',true);
$pdf->SetFont('Times','',12);

try{
    $connect = new EmployeeCrud();
    $tbl_employees = $connect->getEmployees();
}catch(Exception $e){
    echo "Error: ".$e->getMessage();
}

$par = true;
    foreach($tbl_employees as $employeesRegister){
        
        if($par){
            $pdf->SetFillColor(98, 182, 203);
            $par = false;
        }
        else{
            $pdf->SetFillColor(108, 117, 125);
            $par = true;
        }
        $pdf->SetX(30);
        $pdf->Cell(10,7,$employeesRegister['id'],1,0,'C',true);
        $pdf->Cell(35,7,$employeesRegister['firstName'],1,0,'C',true);
        $pdf->Cell(35,7,utf8_decode($employeesRegister['lastName']),1,0,'C',true);
        $pdf->Cell(35,7,$employeesRegister['job'],1,0,'C',true);
        $pdf->Cell(35,7,$employeesRegister['startedAt'],1,0,'C',true);
        $pdf->Ln();
    }
$pdf->AddPage();
$pdf->Output('I', 'Empleados Grows.pdf');
header('Content-Disposition: attachment; filename="Empleados Grows.pdf"');
?>