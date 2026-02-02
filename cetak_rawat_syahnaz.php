<?php 
require("fpdf.php");
include "connect_syahnaz.php";

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Data Transaksi', 0, 1, 'C');
$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30,7,'ID Rawat',1,0,'C');
$pdf->Cell(30,7,'ID Pasien',1,0,'C');
$pdf->Cell(50,7,'No Kamar',1,0,'C');
$pdf->Cell(30,7,'Kelas',1,0,'C');
$pdf->Cell(30,7,'Tanggal Masuk',1,0,'C');
$pdf->Cell(30,7,'Tanggal Keluar',1,0,'C');

$pdf->SetFont('Arial', '', 10);

$sql = "SELECT rawat_inap_syahnaz.*,kamar_syahnaz.* from rawat_inap_syahnaz JOIN kamar_syahnaz ON kamar_syahnaz.id_kamar = rawat_inap_syahnaz.id_kamar";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(30,7,$row['kode_rawat'],1);
    $pdf->Cell(30,7,$row['id_pasien'],1);
    $pdf->Cell(50,7,$row['no_kamar'],1);
    $pdf->Cell(30,7,$row['kelas'],1);
    $pdf->Cell(30,7,$row['tgl_masuk'],1);
    $pdf->Cell(30,7,$row['tgl_keluar'],1);
    $pdf->Ln();
}

$pdf->Output();
?>
