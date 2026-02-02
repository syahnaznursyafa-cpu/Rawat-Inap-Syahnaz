<?php
include "connect_syahnaz.php";  

if (isset($_GET['id_transaksi'])) {
    $id_transaksi = $_GET['id_transaksi'];
    $result = mysqli_query($conn, "SELECT transaksi_syahnaz.*, pasien_syahnaz.id_pasien, pasien_syahnaz.nama,
                                          rawat_inap_syahnaz.id_kamar, rawat_inap_syahnaz.tgl_masuk, rawat_inap_syahnaz.tgl_keluar
                                          FROM transaksi_syahnaz 
                                          JOIN pasien_syahnaz ON transaksi_syahnaz.id_pasien = pasien_syahnaz.id_pasien
                                          JOIN rawat_inap_syahnaz ON transaksi_syahnaz.id_pasien = rawat_inap_syahnaz.id_pasien
                                          WHERE transaksi_syahnaz.id_transaksi = '$id_transaksi'");
    
    $row = mysqli_fetch_assoc($result);
    
    if (!$row) {
        header("Location: index_syahnaz.php");
        exit();
    }
} else {
    header("Location: index_syahnaz.php");
    exit();
}

$pasien_list = mysqli_query($conn, "SELECT * FROM pasien_syahnaz");

$kamar_list = mysqli_query($conn, "SELECT * FROM kamar_syahnaz");

if (isset($_POST['ubah'])) {
  $id_pasien = $_POST['id_pasien'];
  $id_kamar = $_POST['id_kamar'];
  $tgl_masuk = $_POST['tgl_masuk'];
  $tgl_keluar = $_POST['tgl_keluar'];
  $status_pembayaran = $_POST['status_pembayaran'];
  
  if (empty($id_pasien) || empty($id_kamar) || empty($status_pembayaran)) {
    echo "<script>alert('Semua field harus diisi'); history.back();</script>";
    exit();
  }

  if ($tgl_keluar < $tgl_masuk) {
    echo "<script>alert('Tanggal keluar tidak boleh lebih kecil dari tanggal masuk'); history.back();</script>";
    exit();
  }
  
  $id_pasien = mysqli_real_escape_string($conn, $id_pasien);
  $id_kamar = mysqli_real_escape_string($conn, $id_kamar);
  $tgl_masuk = mysqli_real_escape_string($conn, $tgl_masuk);
  $tgl_keluar = mysqli_real_escape_string($conn, $tgl_keluar);
  $status_pembayaran = mysqli_real_escape_string($conn, $status_pembayaran);
  $id_transaksi = mysqli_real_escape_string($conn, $id_transaksi);
  

  $query_transaksi = "UPDATE transaksi_syahnaz SET id_pasien='$id_pasien', status_pembayaran='$status_pembayaran' WHERE id_transaksi='$id_transaksi'";
  $update_transaksi = mysqli_query($conn, $query_transaksi);
  
  if (!$update_transaksi) {
    echo "<script>alert('Error: " . mysqli_error($conn) . "'); history.back();</script>";
    exit();
  }


  $query_rawat = "UPDATE rawat_inap_syahnaz SET id_kamar='$id_kamar', tgl_masuk='$tgl_masuk', tgl_keluar='$tgl_keluar' WHERE id_pasien='$id_pasien'";
  $update_rawat = mysqli_query($conn, $query_rawat);
  
  if (!$update_rawat) {
    echo "<script>alert('Error: " . mysqli_error($conn) . "'); history.back();</script>";
    exit();
  }
  
  echo "<script>alert('Data berhasil diperbarui'); window.location='transaksi_syahnaz.php';</script>";
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
      margin:0;
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
      margin-top:125px;
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
        <li><a href="transaksi_syahnaz.php">Transaksi</a></li>
        <li><a href="rawat_inap_syahnaz.php">Rawat Inap</a></li>
        <li><a href="input_syahnaz.php">Input Data</a></li>
        <li><a href="logout_syahnaz.php">Logout</a></li>
      </ul>
    </div>
  <div class="container">
    <h2>Edit Data Rawat Inap</h2>
    <form action="" method="POST">
    

    <label>Pasien</label>
    <select name="id_pasien" required>
      <option value="">-- Pilih Pasien --</option>
      <?php 
      mysqli_data_seek($pasien_list, 0);
      while ($p = mysqli_fetch_assoc($pasien_list)) { ?>
        <option value="<?= $p['id_pasien']; ?>" <?= ($p['id_pasien'] == $row['id_pasien']) ? 'selected' : ''; ?>>
          <?= $p['nama']; ?>
        </option>
      <?php } ?>
    </select>


    <label>Kelas Kamar</label>
    <select name="id_kamar" required>
      <option value="">-- Pilih Kelas Kamar --</option>
      <?php 
      mysqli_data_seek($kamar_list, 0);
      while ($k = mysqli_fetch_assoc($kamar_list)) { ?>
        <option value="<?= $k['id_kamar']; ?>" <?= ($k['id_kamar'] == $row['id_kamar']) ? 'selected' : ''; ?>>
          <?= $k['kelas']; ?> - Rp <?= number_format($k['harga']); ?>
        </option>
      <?php } ?>
    </select>


    <label>Tanggal Masuk</label>
    <input type="date" name="tgl_masuk" value="<?= $row['tgl_masuk']; ?>" required>


    <label>Tanggal Keluar</label>
    <input type="date" name="tgl_keluar" value="<?= $row['tgl_keluar']; ?>" required>


    <label>Status Pembayaran</label>
    <select name="status_pembayaran" required>
      <option value="">-- Pilih Status --</option>
      <option value="Belum Bayar" <?= (isset($row['status_pembayaran']) && $row['status_pembayaran'] == 'Belum Bayar') ? 'selected' : ''; ?>>Belum Bayar</option>
      <option value="Lunas" <?= (isset($row['status_pembayaran']) && $row['status_pembayaran'] == 'Lunas') ? 'selected' : ''; ?>>Lunas</option>
      <option value="Cicilan" <?= (isset($row['status_pembayaran']) && $row['status_pembayaran'] == 'Cicilan') ? 'selected' : ''; ?>>Cicilan</option>
    </select>



    <button type="submit" name="ubah">SIMPAN PERUBAHAN</button>
    </form><br>

    <a href="index_syahnaz.php">← Kembali ke Data</a>
  </div>
</body>
</html>