<?php
//1.conectarme a una bd
include 'conexion.php'
$_REQUEST['']
//2.crear la consulta
$sql="UPDATE MATERIAS SET DNI PROFE=$_REQUEST['dni']HORARIOS=$_REQUEST['hor'],AULA=$_REQUEST['aula'] WHERE NOMBRE=$_REQUEST[''] AND CURSO=$_REQUEST['curso']";
//3.ejecutar la consulta
mysql_query($sql,$cnx) or die("Error al actualizar la materia");

//4.cerrar la consulta
mysql_close($cnx)

header('location:Materias.php');
?<