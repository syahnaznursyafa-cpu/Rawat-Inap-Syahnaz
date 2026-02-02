<?php
session_start();
include "connect_syahnaz.php";

$sql = mysqli_query($conn, "SELECT * FROM pasien_syahnaz");


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien</title>
    <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap");

    body {
      background-image: url('wp.jpg');
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
      background-color: rgba(96, 146, 182, 0.8);
    }

    td {
      background-color: rgba(116, 165, 202, 0.8);
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


    
    .btn {
    background-color: rgba(116, 165, 202, 0.8);
    padding: 8px 15px;
    border-radius: 5px;
    border : none;
    color:white;
    font-family: "Poppins", sans-serif;
    box-shadow: 0 0 15px rgba(18, 18, 53, 0.3);
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
      <h2 style="text-align:center; color:white;">Data Pasien</h2>

      <table>
        <tr>
          <th>ID Pasien</th>
          <th>Nama Pasien</th>
          <th>Alamat</th>
          <th>Kontak</th>
        </tr>

          <?php 
          $Data = false;
          while ($row = mysqli_fetch_assoc($sql)){ 
            $Data = true;

            
          ?>
            <tr>
              <td><?= $row['id_pasien'] ?></td>
              <td><?= $row['nama'] ?></td>
              <td><?= $row['alamat'] ?></td>
              <td><?= $row['kontak'] ?></td>
            </tr>
          <?php } ?>
          
          <?php if (!$Data) { ?>
            <tr><td colspan="7">Belum ada data Pasien</td></tr>
          <?php } ?>
        
      </table>
        <br><a href="cetak_syahnaz.php" target="_blank" class="btn">Cetak</a>

    </div>
</body>
</html>