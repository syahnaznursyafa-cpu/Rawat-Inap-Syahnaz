<?php
include "connect_syahnaz.php";

if (isset($_GET['id_rawat'])) {
    $kode = $_GET['id_rawat'];
    $hapus = mysqli_query($conn, "DELETE FROM rawat_inap_syahnaz WHERE id_rawat='$kode'");
        echo "<script>
        alert('Data Berhasil Di hapus');
        window.location='rawat_inap_syahnaz.php';
        </script>";
} else {
    echo "<script>
        alert('ID Rawat tidak ditemukan');
        window.location='rawat_inap_syahnaz.php';
        </script>";
}
?>