<?php
include "connect_syahnaz.php";

$pasien = mysqli_query($conn, "SELECT * FROM pasien_syahnaz");
if (!$pasien) {
    die("Error pasien: " . mysqli_error($conn));
}

$kamar_dropdown = mysqli_query($conn, "SELECT * FROM kamar_syahnaz");
if (!$kamar_dropdown) {
    die("Error kamar: " . mysqli_error($conn));
}

$kode_rawat = '';
$kode_transaksi = '';

if (isset($_POST['simpan'])) {
    $id_pasien  = mysqli_real_escape_string($conn, $_POST['id_pasien']);
    $id_kamar   = mysqli_real_escape_string($conn, $_POST['id_kamar']);
    $tgl_masuk  = mysqli_real_escape_string($conn, $_POST['tgl_masuk']);
    $tgl_keluar = mysqli_real_escape_string($conn, $_POST['tgl_keluar']);
    $status_pembayaran = mysqli_real_escape_string($conn, $_POST['status_pembayaran']);
    $tgl = date('Y-m-d');

    if (empty($id_pasien) || empty($id_kamar) || empty($tgl_masuk) || empty($tgl_keluar)) {
        die("❌ Semua field harus diisi!");
    }

    if (empty($status_pembayaran)) {
        die("❌ Status Pembayaran harus dipilih");
    }

    if ($tgl_keluar < $tgl_masuk) {
        die("❌ Tanggal keluar tidak boleh lebih kecil dari tanggal masuk");
    }

    $prefix_rawat = "RWT";
    $sql_kode_rawat = "SELECT kode_rawat FROM rawat_inap_syahnaz ORDER BY id_rawat DESC LIMIT 1";
    $result_rawat = mysqli_query($conn, $sql_kode_rawat);

    if (mysqli_num_rows($result_rawat) > 0) {
        $row_rawat = mysqli_fetch_array($result_rawat);
        $lastNumber_rawat = (int) substr($row_rawat['kode_rawat'], -4);
        $newNumber_rawat = $lastNumber_rawat + 1;
    } else {
        $newNumber_rawat = 1;
    }
    $kode_rawat = $prefix_rawat . str_pad($newNumber_rawat, 4, "0", STR_PAD_LEFT);

    $tgl_masuk_ = new DateTime($tgl_masuk);
    $tgl_keluar_ = new DateTime($tgl_keluar);
    $durasi = $tgl_keluar_->diff($tgl_masuk_)->days;
    
    $durasi = $durasi == 0 ? 1 : $durasi;

    $sql_harga = "SELECT harga FROM kamar_syahnaz WHERE id_kamar = '$id_kamar'";
    $result_harga = mysqli_query($conn, $sql_harga);
    $row_harga = mysqli_fetch_assoc($result_harga);
    $harga_kamar = $row_harga['harga'];

    $total_bayar = $durasi * $harga_kamar;

    $sql_rawat = "INSERT INTO rawat_inap_syahnaz 
                  (kode_rawat, id_pasien, id_kamar, tgl_masuk, tgl_keluar) 
                  VALUES ('$kode_rawat', '$id_pasien', '$id_kamar', '$tgl_masuk', '$tgl_keluar')";

    if (!mysqli_query($conn, $sql_rawat)) {
        die("❌ Error rawat inap: " . mysqli_error($conn));
    }

    $id_rawat = mysqli_insert_id($conn);  

    $prefix_transaksi = "TR";
    $sql_kode_transaksi = "SELECT kode FROM transaksi_syahnaz ORDER BY id_transaksi DESC LIMIT 1";
    $result_transaksi = mysqli_query($conn, $sql_kode_transaksi);

    if (mysqli_num_rows($result_transaksi) > 0) {
        $row_transaksi = mysqli_fetch_array($result_transaksi);
        $lastNumber_transaksi = (int) substr($row_transaksi['kode'], -4);
        $newNumber_transaksi = $lastNumber_transaksi + 1;
    } else {
        $newNumber_transaksi = 1;
    }
    $kode_transaksi = $prefix_transaksi . str_pad($newNumber_transaksi, 4, "0", STR_PAD_LEFT);

    $sql_transaksi = "INSERT INTO transaksi_syahnaz 
                      (kode, id_pasien, tgl, status_pembayaran, total_biaya) 
                      VALUES ('$kode_transaksi', '$id_pasien', '$tgl', '$status_pembayaran', '$total_bayar')";

    if (!mysqli_query($conn, $sql_transaksi)) {
        die("❌ Error transaksi: " . mysqli_error($conn));
    }

    echo "<script>alert('✅ Data rawat inap berhasil disimpan!' 
    0.
    ); window.location='transaksi_syahnaz.php';</script>";
}


// Kode Rawat Inap
$prefix_rawat = "RWT";
$sql_kode_rawat = "SELECT kode_rawat FROM rawat_inap_syahnaz ORDER BY id_rawat DESC LIMIT 1";
$result_rawat = mysqli_query($conn, $sql_kode_rawat);

if (mysqli_num_rows($result_rawat) > 0) {
    $row_rawat = mysqli_fetch_array($result_rawat);
    $lastNumber_rawat = (int) substr($row_rawat['kode_rawat'], -4);
    $newNumber_rawat = $lastNumber_rawat + 1;
} else {
    $newNumber_rawat = 1;
}
$kode_rawat = $prefix_rawat . str_pad($newNumber_rawat, 4, "0", STR_PAD_LEFT);

// Kode Transaksi
$prefix_transaksi = "TR";
$sql_kode_transaksi = "SELECT kode FROM transaksi_syahnaz ORDER BY id_transaksi DESC LIMIT 1";
$result_transaksi = mysqli_query($conn, $sql_kode_transaksi);

if (mysqli_num_rows($result_transaksi) > 0) {
    $row_transaksi = mysqli_fetch_array($result_transaksi);
    $lastNumber_transaksi = (int) substr($row_transaksi['kode'], -4);
    $newNumber_transaksi = $lastNumber_transaksi + 1;
} else {
    $newNumber_transaksi = 1;
}
$kode_transaksi = $prefix_transaksi . str_pad($newNumber_transaksi, 4, "0", STR_PAD_LEFT);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Rawat Inap</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap");

        body {
            background-image: url('https://i.pinimg.com/1200x/87/07/bd/8707bd5921379b7798e92bb0d049b0b8.jpg');
            font-family: "Poppins", sans-serif;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            margin: 0;
        }

        .container {
            backdrop-filter: blur(15px);
            background: rgba(255, 255, 255, 0.25);
            margin: auto;
            width: 50%;
            border-radius: 25px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(18, 18, 53, 0.3);
            padding-bottom: 40px;
            margin-top: 125px;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            backdrop-filter: blur(30px);
            background: rgba(255, 255, 255, 0.25);
            width: 100%;
        }

        ul li {
            float: right;
            padding-right: 20px;
        }

        ul li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        ul li a:hover:not(.active) {
            background: rgba(94, 91, 91, 0.25);
        }

        ul li a.active {
            backdrop-filter: blur(30px);
            background: rgba(94, 91, 91, 0.25);
        }

        h2 {
            color: white;
            text-shadow: 0 0 15px rgba(11, 11, 31, 0.3);
            text-align: center;
        }

        label {
            color: white;
            display: block;
            margin-top: 15px;
            font-weight: 500;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: none;
            background-color: #456882;
            color: white;
            border-radius: 8px;
            font-size: 14px;
            font-family: "Poppins", sans-serif;
            box-sizing: border-box;
            transition: 0.3s;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            box-shadow: 0 0 10px #456882;
        }

        input::placeholder, textarea::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        select option {
            background-color: #456882;
            color: white;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background-color: #456882;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: rgba(226, 190, 146, 1);
            box-shadow: 0 0 10px rgb(185, 136, 75);
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .info-box {
            background-color: rgba(69, 104, 130, 0.8);
            padding: 10px;
            border-radius: 5px;
            margin-top: 8px;
            color: #FFD700;
            font-weight: bold;
            font-size: 13px;
        }

        .info-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .info-row label {
            margin-top: 15px;
        }

        @media (max-width: 768px) {
            .info-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="nav">
        <ul>
            <li><a href="logout_syahnaz.php">Logout</a></li>
            <li><a href="tampilan_pasien_syahnaz.php">Data Pasien</a></li>
            <li><a href="input_syahnaz.php" class="active">Input Data</a></li>
            <li><a href="rawat_inap_syahnaz.php">Rawat Inap</a></li>
            <li><a href="transaksi_syahnaz.php">Transaksi</a></li>
        </ul>
    </div>

    <div class="container">
        <h2>📝 Input Data Rawat Inap</h2>

        <form method="POST">
            <div class="info-row">
                <div>
                    <label for="kode_rawat">Kode Rawat Inap </label>
                    <input type="text" id="kode_rawat" readonly value="<?= $kode_rawat ?>">
                </div>

                <div>
                    <label for="kode_transaksi">Kode Transaksi </label>
                    <input type="text" id="kode_transaksi" readonly value="<?= $kode_transaksi ?>">
                </div>
            </div>

            <label>👤 Pasien</label>
            <select name="id_pasien" required>
                <option value="">-- Pilih Pasien --</option>
                <?php 
                mysqli_data_seek($pasien, 0);
                while ($p = mysqli_fetch_assoc($pasien)) { ?>
                    <option value="<?= $p['id_pasien']; ?>">
                        [<?= $p['id_pasien']; ?>] <?= $p['nama']; ?>
                    </option>
                <?php } ?>
            </select>

            <label>🏥 Kelas Kamar</label>
            <select name="id_kamar" required>
                <option value="">-- Pilih Kelas Kamar --</option>
                <?php 
                mysqli_data_seek($kamar_dropdown, 0);
                while ($k = mysqli_fetch_assoc($kamar_dropdown)) { ?>
                    <option value="<?= $k['id_kamar']; ?>">
                        <?= $k['kelas']; ?> - Rp <?= number_format($k['harga']); ?>/hari
                    </option>
                <?php } ?>
            </select>

            <div class="info-row">
                <div>
                    <label>📅 Tanggal Masuk</label>
                    <input type="date" name="tgl_masuk" required>
                </div>

                <div>
                    <label>📅 Tanggal Keluar</label>
                    <input type="date" name="tgl_keluar" required>
                </div>
            </div>

            <label>💳 Status Pembayaran</label>
            <select name="status_pembayaran" required>
                <option value="">-- Pilih Status Pembayaran --</option>
                <option value="Belum Bayar">Belum Bayar</option>
                <option value="Lunas">Lunas</option>
                <option value="Cicilan">Cicilan</option>
            </select>

            <button type="submit" name="simpan">💾 SIMPAN DATA</button>
        </form>

        <a href="transaksi_syahnaz.php">← Kembali ke Data</a>
    </div>

</body>
</html>
