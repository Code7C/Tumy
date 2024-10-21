<?php
$bd="tumy";
$pass="";
$server="localhost";
$usr="root";
$cnx=mysqli_connect($server,$usr,$pass,$bd) or die("Error al intentar conectarse a la base de datos $bd");
?>