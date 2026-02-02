<?php
session_start();
include "connect_syahnaz.php";

$sql = mysqli_query($conn, "
    SELECT 
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
    ORDER BY t.id_transaksi DESC
");

if (!$sql) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Rawat Inap</title>
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
      width: 90%;
      border-radius: 25px;
      padding: 20px;
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
      position: fixed;
      z-index: 1000;
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
      text-shadow: 0 0 8px beige;
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      text-align: center;
      color: white;
      font-size: 14px;
    }

    th, td {
      padding: 12px 8px;
      border-bottom: 1px dashed rgba(255,255,255,0.5);
    }

    th {
      background-color: rgba(35, 76, 106, 0.8);
      font-weight: bold;
    }

    td {
      background-color: rgba(69, 104, 130, 0.8);
    }

    tr:hover td {
      background-color: rgba(69, 104, 130, 1);
    }

    .status-lunas {
      background-color: #4CAF50;
      padding: 5px 10px;
      border-radius: 5px;
      display: inline-block;
    }

    .status-belum {
      background-color: #FF9800;
      padding: 5px 10px;
      border-radius: 5px;
      display: inline-block;
    }

    .status-cicilan {
      background-color: #2196F3;
      padding: 5px 10px;
      border-radius: 5px;
      display: inline-block;
    }

    .btn-tambah {
      display: inline-block;
      background-color: #456882;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
      margin-top: 20px;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn-tambah:hover {
      background-color: rgba(226, 190, 146, 1);
      box-shadow: 0 0 10px rgb(185, 136, 75);
    }

    .action-links {
      font-size: 12px;
    }

    .action-links a {
      color: #FFD700;
      text-decoration: none;
      margin: 0 5px;
    }

    .action-links a:hover {
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
          <li><a href="rawat_inap_syahnaz.php">Rawat Inap</a></li>
          <li><a href="transaksi_syahnaz.php" class="active">Transaksi</a></li>
        </ul>
      </div>

    <div class="container">
      <h2>📊 Data Transaksi Rawat Inap</h2>

      <table>
        <tr>
          <th>ID Transaksi</th>
          <th>ID Pasien</th>
          <th>Nama Pasien</th>
          <th>Harga/Hari</th>
          <th>Status Pembayaran</th>
          <th>Total Biaya</th>
          <th>Tanggal Transaksi</th>
          <th>Aksi</th>
        </tr>

        <?php 
        $data_exists = false;
        while ($row = mysqli_fetch_assoc($sql)) { 
          $data_exists = true;

          $total_biaya = $row['total_biaya'];
          
          $status = isset($row['status_pembayaran']) ? $row['status_pembayaran'] : 'Belum Bayar';
          if ($status == 'Lunas') {
            $status_class = 'status-lunas';
          } elseif ($status == 'Cicilan') {
            $status_class = 'status-cicilan';
          } else {
            $status_class = 'status-belum';
          }
        ?>
          <tr>
            <td><?= $row['kode'] ?></td>
            <td><?= $row['id_pasien'] ?></td>
            <td><?= $row['nama'] ?></td>
            <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
            <td><span class="<?= $status_class ?>"><?= $status ?></span></td>
            <td><strong>Rp <?= number_format($total_biaya, 0, ',', '.') ?></strong></td>
            <td><?= date('d-m-Y', strtotime($row['tgl'])) ?></td>
            <td class="action-links">
              <a href="edit_syahnaz.php?id_transaksi=<?= $row['id_transaksi']; ?>">✏️ Edit</a> | 
              <a href="hapus_syahnaz.php?id_transaksi=<?= $row['id_transaksi']; ?>" onclick="return confirm('Yakin hapus?')">🗑️ Hapus</a>
            </td>
          </tr>
        <?php } ?>
        
        <?php if (!$data_exists) { ?>
          <tr><td colspan="8" style="color: #FFD700;">📭 Belum ada data transaksi</td></tr>
        <?php } ?>
      </table>

      <a href="input_syahnaz.php" class="btn-tambah"> ➕ Tambah Data</a>
      <a href="cetak_transaksi_syahnaz.php" class="btn-tambah">🖨️ Cetak</a>
    </div>
</body>
</html>