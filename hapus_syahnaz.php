<?php
include "connect_syahnaz.php";

if (isset($_GET['id_transaksi'])) {
    $id_transaksi = $_GET['id_transaksi'];
    
    $id_transaksi = mysqli_real_escape_string($conn, $id_transaksi);
    
    $hapus_rawat = mysqli_query($conn, "DELETE FROM rawat_inap_syahnaz WHERE id_pasien='$id_pasien'");
    
    $hapus_transaksi = mysqli_query($conn, "DELETE FROM transaksi_syahnaz WHERE id_transaksi='$id_transaksi'");
    
    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>
            alert('Data berhasil dihapus');
            window.location='transaksi_syahnaz.php';
        </script>";
    } else {
        echo "<script>
            alert('Data tidak ditemukan');
            window.location='transaksi_syahnaz.php';
        </script>";
    }
} else {
    echo "<script>
        alert('ID Transaksi tidak ditemukan');
        window.location='transaksi_syahnaz.php';
    </script>";
}
?>