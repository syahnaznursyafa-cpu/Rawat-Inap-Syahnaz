<?php
session_start();
include "connect_syahnaz.php";

if (isset($_POST['login'])) {
$username = $_POST['username'];
$password = $_POST['password'];
$sql =mysqli_query( $conn,"SELECT * FROM user_syahnaz WHERE username = '$username' AND password='$password'");
    if(mysqli_num_rows($sql) > 0){
        $_SESSION['login'] = true;
        header('Location: input_syahnaz.php');
    } else{
        $error = " Username atau Password salah!!";
        header('Location: login_syahnaz.php');
    }
}


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


    h1 {
      text-shadow: 0 0 8px beige, rgb(216, 159, 89);
      font-family: "Poppins", sans-serif;
      text-align: center;
    }

    .container {
      backdrop-filter: blur(15px);
      background: rgba(255, 255, 255, 0.25);
      margin: auto;
      width: 40%;
      border-radius: 25px;
      padding: 20px;
      box-shadow: 0 0 15px rgba(18, 18, 53, 0.3);
      padding-bottom: 40px;
      margin-top:125px;
    }


    p {
      font-weight: bold;
      font-family: "Poppins", sans-serif;
      color: white;
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
</style>

</head>
<body>
    <div class="container">


    <?php if (isset($error)){ ?>
        <div class="errot"><?=$error ?></div>
    <?php } ?>
    <table>
        <form action="" method="post">
            <tr>
                <h1>Login</h1>
            </tr>
            <tr>
                <input type="text" name="username" id="username" placeholder="Username">
            </tr><br>
            <tr>
                <input type="password" name="password" id="password" placeholder="Password">
            </tr><br>
            <tr>
                <input type="submit" name="login" id="submit" value="Login">
            </tr>
        </form>
    </table>
        </div>
</body>
</html>