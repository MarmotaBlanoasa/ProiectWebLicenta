<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
require ("checkLogin.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pagina proiect parolata</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet"
          href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body class="loggedin">
<nav class="navtop">
    <div>
        <h1>TITLU WEBSITE</h1>
        <a href="home.php"><i class="fas fa-sign-outalt"></i>Home</a>
        <a href="logout.php"><i class="fas fa-sign-outalt"></i>Logout</a>
    </div>
</nav>
<div class="content">
    <h2>Pagina cu parola</h2>
    <p>Bine ati revenit, <?=$_SESSION['email']?>!</p>
</div>
</body>
</html>