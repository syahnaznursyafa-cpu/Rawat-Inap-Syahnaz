<?php
session_start();
include "connect_syahnaz.php";

$sql = mysqli_query($conn, "SELECT rawat_inap_syahnaz.*,kamar_syahnaz.* from rawat_inap_syahnaz JOIN kamar_syahnaz ON kamar_syahnaz.id_kamar = rawat_inap_syahnaz.id_kamar");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

    form {
      text-align: left;
      font-size: 500;
      padding: 6px 35px;
      width: 90%;
      border-radius: 15px;
      margin: auto;
      list-style-type: none;
    }

    input {
      text-align: center;
      border: none;
      background-color: #456882;
      color: white;
      border-radius: 50px;
      font-size: large;
      margin-top: 20px;
      display: block;
      padding: 12px 35px;
      width: 85%;
      font-family: "Poppins", sans-serif;
      transition: 0.3s;
      position: relative;
      overflow: hidden;
      transform: translateY(30px) scale(0.95);
      box-shadow: 0 0 15px rgba(18, 18, 53, 0.3);
    }

    input::placeholder {
      color: white;
    }

    .button:hover {
      box-shadow: 0 0 10px rgb(185, 136, 75), 0 0 8px rgb(219, 151, 68);
      background-color: rgba(226, 190, 146, 1);
    }

    input[type="submit"] {
      width: 99%;
    }

    hr {
      border-style: dashed;
      width: 100%;
      border-color: grey;
    }

    h2,
    h3 {
      color: rgba(35, 76, 106, 0.8);
      text-shadow: 0 0 15px rgba(11, 11, 31, 0.3);
      text-align: center;
    }

    h1 {
      text-shadow: 0 0 8px beige, rgb(216, 159, 89);
      font-family: "Poppins", sans-serif;
    }

    .container {
      backdrop-filter: blur(15px);
      background: rgba(255, 255, 255, 0.25);
      margin: auto;
      width: 70%;
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
      margin:0;
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

    p {
      font-weight: bold;
      font-family: "Poppins", sans-serif;
      color: white;
    }

    .output {
      text-align: center;
      background-color: rgba(226, 190, 146, 0.8);
      color: white;
      border-radius: 25px;
      font-size: large;
      padding: 20px;
      width: 85%;
      margin: 20px auto;
      box-shadow: 0 0 15px rgba(18, 18, 53, 0.3);
    }

    a.back {
      display: block;
      text-align: center;
      margin-top: 30px;
      text-decoration: none;
      font-weight: bold;
      color: rgba(35, 76, 106, 0.8);
    }

    a.back:hover {
      text-decoration: underline;
    }

    label {
      color: white;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      text-align: center;
      color: white;
    }

    th, td {
      padding: 12px 15px;
      border-bottom: 1px dashed rgba(255,255,255,0.5);
    }

    th {
      background-color: rgba(35, 76, 106, 0.8);
    }

    td {
      background-color: rgba(69, 104, 130, 0.8);
    }

    a{
      text-align: center;
      color: white;
      font-size: large;
      width: 85%;
      text-decoration: none;
    }

    .data{
      text-align: center;
      background-color:#456882;
      color: white;
      border-radius: 7px;
      font-size: medium;
      padding: 10px;
      width: 85%;
      margin-right: 50%;
      box-shadow: 0 0 15px rgba(18, 18, 53, 0.3);
      text-decoration: none;
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
      width: 140px;
      font-size:medium;
    }

        .btn-tambah:hover {
      background-color: rgba(226, 190, 146, 1);
      box-shadow: 0 0 10px rgb(185, 136, 75);
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
        <li><a href="transaksi_syahnaz.php">Transaksi</a></li>
      </ul>
    </div>
    <div class="container">
<h2 style="text-align:center; color:white;">📊 Data Rawat Inap</h2>

  <table>

    <tr>
      <th>ID Rawat</th>
      <th>ID Pasien</th>
      <th>No Kamar</th>
      <th>Kelas</th>
      <th>Tanggal Masuk</th>
      <th>Tanggal keluar</th>
      <th>Action</th>
    </tr>

      <?php while ($row = mysqli_fetch_assoc($sql)){ ?>
        <tr>
          <td><?= $row['kode_rawat'] ?></td>
          <td><?= $row['id_pasien'] ?></td>
          <td><?= $row['no_kamar'] ?></td>
          <td><?= $row['kelas'] ?></td>
          <td><?= $row['tgl_masuk'] ?></td>
          <td><?= $row['tgl_keluar'] ?></td>

          <td>
                <a href="edit_rawat_syahnaz.php?id_rawat=<?php echo $row['id_rawat']; ?>">✏️ Edit | </a>
                <a href="hapus_rawat_syahnaz.php?id_rawat=<?php echo $row['id_rawat']; ?>">🗑️ Hapus</a>
            </td>
        </tr>
    <?php } ?>
    
  </table>

      <a href="input_syahnaz.php" class="btn-tambah"> ➕ Tambah Data</a>
      <a href="cetak_rawat_syahnaz.php" class="btn-tambah">🖨️ Cetak</a>

    </div>
</body>
</html>   