<?php 
require("fpdf.php");
include "connect_syahnaz.php";

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'DATA PASIEN', 0, 1, 'C');
$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30,7,'ID Pasien',1,0,'C');
$pdf->Cell(50,7,'Nama',1,0,'C');
$pdf->Cell(70,7,'Alamat',1,0,'C');
$pdf->Cell(30,7,'Kontak',1,1,'C');

$pdf->SetFont('Arial', '', 10);

$sql = "SELECT * FROM pasien_syahnaz";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(30,7,$row['id_pasien'],1);
    $pdf->Cell(50,7,$row['nama'],1);
    $pdf->Cell(70,7,$row['alamat'],1);
    $pdf->Cell(30,7,$row['kontak'],1);
    $pdf->Ln();
}

$pdf->Output();
?>
