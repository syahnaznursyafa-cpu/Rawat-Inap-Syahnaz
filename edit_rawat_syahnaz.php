<?php
include "connect_syahnaz.php";

// ============================================
// AMBIL ID RAWAT DARI URL
// ============================================
if (!isset($_GET['id_rawat'])) {
    die("❌ ID Rawat tidak ditemukan");
}

$id_rawat = mysqli_real_escape_string($conn, $_GET['id_rawat']);

// ✅ AMBIL DATA RAWAT YANG AKAN DIEDIT
$sql_get = "SELECT ri.*, k.harga, k.kelas 
            FROM rawat_inap_syahnaz ri
            JOIN kamar_syahnaz k ON ri.id_kamar = k.id_kamar
            WHERE ri.id_rawat = '$id_rawat'";

$result_get = mysqli_query($conn, $sql_get);

if (mysqli_num_rows($result_get) == 0) {
    die("❌ Data rawat inap tidak ditemukan");
}

$data = mysqli_fetch_assoc($result_get);
$kamar_list = mysqli_query($conn, "SELECT * FROM kamar_syahnaz");

// ============================================
// PROSES UPDATE
// ============================================
if (isset($_POST['ubah'])) {
    $id_kamar = mysqli_real_escape_string($conn, $_POST['id_kamar']);
    $tgl_masuk = mysqli_real_escape_string($conn, $_POST['tgl_masuk']);
    $tgl_keluar = mysqli_real_escape_string($conn, $_POST['tgl_keluar']);

    // ✅ VALIDASI
    if (empty($id_kamar) || empty($tgl_masuk) || empty($tgl_keluar)) {
        die("❌ Semua field harus diisi!");
    }

    if ($tgl_keluar < $tgl_masuk) {
        echo "<script>alert('❌ Tanggal keluar tidak boleh lebih kecil dari tanggal masuk'); history.back();</script>";
        exit();
    }

    // ✅ UPDATE RAWAT_INAP_SYAHNAZ (GUNAKAN WHERE id_rawat)
    $query_rawat = "UPDATE rawat_inap_syahnaz 
                    SET id_kamar='$id_kamar', tgl_masuk='$tgl_masuk', tgl_keluar='$tgl_keluar' 
                    WHERE id_rawat='$id_rawat'";

    if (!mysqli_query($conn, $query_rawat)) {
        echo "<script>alert('❌ Error: " . mysqli_error($conn) . "'); history.back();</script>";
        exit();
    }

    echo "<script>alert('✅ Data berhasil diperbarui'); window.location='rawat_inap_syahnaz.php';</script>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Rawat Inap</title>

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
            top: 0;
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
    </style>
</head>

<body>
    <div class="nav">
        <ul>
            <li><a href="logout_syahnaz.php">Logout</a></li>
            <li><a href="tampilan_pasien_syahnaz.php">Data Pasien</a></li>
            <li><a href="input_syahnaz.php">Input Data</a></li>
            <li><a href="rawat_inap_syahnaz.php" class="active">Rawat Inap</a></li>
            <li><a href="transaksi_syahnaz.php">Transaksi</a></li>
        </ul>
    </div>

    <div class="container">
        <h2>Edit Data Rawat Inap</h2>
        <form action="" method="POST">

            <label for="id_rawat">ID Rawat</label>
            <input type="text" name="id_rawat" id="id_rawat" readonly value="<?= $data['id_rawat']; ?>">

            <label for="id_pasien">ID Pasien</label>
            <input type="text" name="id_pasien" id="id_pasien" readonly value="<?= $data['id_pasien']; ?>">

            <label for="kelas">Kelas Kamar Sekarang</label>
            <input type="text" name="kelas" id="kelas" readonly value="<?= $data['kelas']; ?> - Rp <?= number_format($data['harga']); ?>/hari">

            <label for="id_kamar">Ganti Kamar</label>
            <select name="id_kamar" id="id_kamar" required>
                <option value="">-- Pilih Kelas Kamar --</option>
                <?php while ($k = mysqli_fetch_assoc($kamar_list)) { ?>
                    <option value="<?= $k['id_kamar']; ?>" <?= $k['id_kamar'] == $data['id_kamar'] ? 'selected' : ''; ?>>
                        <?= $k['kelas']; ?> - Rp <?= number_format($k['harga']); ?>/hari
                    </option>
                <?php } ?>
            </select>

            <label for="tgl_masuk">Tanggal Masuk</label>
            <input type="date" name="tgl_masuk" id="tgl_masuk" value="<?= $data['tgl_masuk']; ?>" required>

            <label for="tgl_keluar">Tanggal Keluar</label>
            <input type="date" name="tgl_keluar" id="tgl_keluar" value="<?= $data['tgl_keluar']; ?>" required>

            <button type="submit" name="ubah">💾 SIMPAN PERUBAHAN</button>
        </form><br>

        <a href="rawat_inap_syahnaz.php">← Kembali ke Data</a>
    </div>
</body>
</html>