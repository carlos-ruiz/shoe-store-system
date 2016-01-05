<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'FPDF.php');
class ImprimirEtiqueta extends FPDF{

	function Header(){

	}

	function cabeceraHorizontal($datos)
	{
    
    }

    function contenido($datos){
    	$this->SetTextColor(0, 0, 0); //Letra color blanco
    	$this->SetFont('Arial','',8);

    	$y = 0.5;
        $this->SetXY(1, .75);
        $this->Cell(2,$y,'Modelo',1,0,'C');
        $this->Cell(4,$y,$datos['modelo'],1,1,'C');
        $this->Cell(2,$y,'Color',1,0,'C');
        $this->Cell(4,$y,$datos['color'],1,1,'C');
        $this->Cell(2,$y,'Número',1,0,'C');
        $this->Cell(4,$y,$datos['numero'],1,1,'C');
        $this->Cell(2,4,'Foto',1,0,'C');
        $url = str_replace('/controlbom/control', '', Yii::getPathOfAlias('webroot'));
        $this->Cell(4,4,$this->Image($url.$datos['foto'],$this->GetX(),$this->getY(),3),1,1,'C', false);
    }

    function Footer()
    {
    }
}
