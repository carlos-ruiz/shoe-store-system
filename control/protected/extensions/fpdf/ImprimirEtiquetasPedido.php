<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'FPDF.php');
class ImprimirEtiquetasPedido extends FPDF{

	function Header(){

	}

	function cabeceraHorizontal($datos)
	{
	
	}

	function contenido($etiquetas){
		$this->SetTextColor(0, 0, 0); //Letra color blanco
		$this->SetFont('Arial','',8);

		$y = 1;
		$this->SetXY(1, .75);
		foreach ($etiquetas as $datos) {
			$url = str_replace('/controlbom/control', '', Yii::getPathOfAlias('webroot'));
			$this->Cell(3,3,$this->Image($url.$datos['foto'],$this->GetX()+0.5,$this->getY()+0.5,2),'LT',0, 'C');
			$this->Cell(2,3,$datos['codigo'],'T',0,'C');
			$this->Cell(3,3,$this->Image($url.'/controlbom/control/images/icons/logo.png',$this->GetX()+0.5,$this->getY()+0.7,2),'TR',1,'C');
			$this->Cell(2,$y,'Modelo',1,0,'C');
			$this->Cell(6,$y,$datos['modelo'],1,1,'C');
			$this->Cell(2,$y,'Color',1,0,'C');
			$this->Cell(6,$y,$datos['color'],1,1,'C');
			$this->Cell(2,$y,'Número',1,0,'C');
			$this->Cell(6,$y,$datos['numero'],1,1,'C');
			$this->ln(0.5);
		}
	}

	function Footer()
	{
	}
}
