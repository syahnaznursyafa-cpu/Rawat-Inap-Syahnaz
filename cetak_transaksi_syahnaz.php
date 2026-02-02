<?php 
require("fpdf.php");
include "connect_syahnaz.php";

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Data Transaksi', 0, 1, 'C');
$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30,7,'ID Transaksi',1,0,'C');
$pdf->Cell(30,7,'ID Pasien',1,0,'C');
$pdf->Cell(50,7,'Nama',1,0,'C');
$pdf->Cell(30,7,'Harga/hari',1,0,'C');
$pdf->Cell(30,7,'Total Biaya',1,0,'C');
$pdf->Cell(30,7,'tanggal',1,1,'C');

$pdf->SetFont('Arial', '', 10);

$sql = "SELECT 
        t.id_transaksi,
        t.kode,
        t.id_pasien,
        t.tgl,
        t.status_pembayaran,
        t.total_biaya,
        p.nama,
        k.harga,
        ri.tgl_masuk,
        ri.tgl_keluar
    FROM transaksi_syahnaz t
    JOIN pasien_syahnaz p ON t.id_pasien = p.id_pasien
    JOIN rawat_inap_syahnaz ri ON t.id_pasien = ri.id_pasien
    JOIN kamar_syahnaz k ON ri.id_kamar = k.id_kamar
    GROUP BY t.id_transaksi
    ORDER BY t.id_transaksi DESC";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(30,7,$row['kode'],1);
    $pdf->Cell(30,7,$row['id_pasien'],1);
    $pdf->Cell(50,7,$row['nama'],1);
    $pdf->Cell(30,7,$row['harga'],1);
    $pdf->Cell(30,7,$row['total_biaya'],1);
    $pdf->Cell(30,7,$row['tgl'],1);
    $pdf->Ln();
}

$pdf->Output();
?>
