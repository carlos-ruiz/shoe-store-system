<?php

class ImprimirEtiquetasPedido extends FPDF{

	function contenido($etiquetas){
		$this->SetTextColor(0, 0, 0); //Letra color blanco
		$this->SetFont('Arial','',8);
		$this->SetAutoPageBreak(true, 0.75);
		$this->SetTopMargin(0.75);
		$y = 0.7;
		$posY = 0.75;
		$this->SetXY(1, $posY);

		// -------------------------------------------------- //
		//                  PROPERTIES
		// -------------------------------------------------- //

		$fontSize = 0.175;
		$marge    = 0.175;   // between barcode and hri in pixel
		$height   = 0.875;   // barcode height in 1D ; module size in 2D
		$width    = 0.035;    // barcode height in 1D ; not use in 2D
		$angle    = 0;   // rotation in degrees

		$code     = '123456789012'; // barcode, of course ;)
		$type     = 'ean13';
		$black    = '000000'; // color in hexa

		$this->SetFontSize(10);
		
		foreach ($etiquetas as $i => $datos) {
			if(($i%2)!=0){
				$this->SetLeftMargin(11);
				$this->SetY($posY);
			}else{
				$this->SetLeftMargin(1);
				$this->setX(1);
				$posY = $this->GetY();
				if ($posY>24) {
					$posY = 0.75;
				}
			}
			$url = str_replace('/controlbom/control', '', Yii::getPathOfAlias('webroot'));
			$this->Cell(3,3,'','LT',0, 'C');
			$this->Image($url.$datos['foto'],$this->GetX()+0.5-3,$this->getY()+0.5,2);
			$code = $datos['codigo'];
			Barcode::fpdf($this, $black, $this->GetX()+1.7,$this->getY()+0.8, $angle, $type, array('code'=>$code), $width, $height);
			$this->Cell(3.5,3,$datos['codigo'],'T',0,'C');
			$this->Cell(3,3,$this->Image($url.'/controlbom/control/images/icons/logo.png',$this->GetX()+0.5,$this->getY()+0.7,2),'TR',1,'C');
			$this->Cell(2,$y,'Modelo',1,0,'C');
			$this->Cell(7.5,$y,$datos['modelo'],1,1,'L');
			$this->Cell(2,$y,'Color',1,0,'C');
			$this->Cell(7.5,$y,$datos['color'],1,1,'L');
			$this->Cell(2,$y,'Número',1,0,'C');
			$this->Cell(7.5,$y,$datos['numero'],1,1,'L');
			$this->ln(0.2);
		}
	}
}
