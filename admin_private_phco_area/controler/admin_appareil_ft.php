<?php
include_once(PATH_LIBS.'lib_admin_appareil.php');
require(PATH_LIBS.'lib_fpdf/fpdf.php');



class PDF extends FPDF
{
// En-t�te
function Header()
{
	// Logo
	$this->Image(WWW_IMG."logo_phoneAndCo.png",10,6,30);
	// Police Arial gras 15
	$this->SetFont('Arial','B',15);
	// D�calage � droite
	$this->Cell(80);
	// Titre
	$this->Cell(100,10,$post_ap_titre_fr,1,0,'C');
	// Saut de ligne
	$this->Ln(20);
}

// Pied de page
function Footer()
{
	// Positionnement � 1,5 cm du bas
	$this->SetY(-15);
	// Police Arial italique 8
	$this->SetFont('Arial','N',8);
	// Num�ro de page
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'R');
}
}

// Instanciation de la classe d�riv�e
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,$post_desc_fr,0,1);
$pdf->Output();

?>





