<?php
$server = "mysql:host=localhost;dbname=decor";
$user ="root";
$pass = "" ;
try {
    $pdo = new PDO($server , $user , $pass);
    // echo "<script>alert ('connected')</script>";
}
catch (Exception $e) {
    echo $e->getMessage();
}
?>

