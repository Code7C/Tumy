<?php
	$dni=$_REQUEST['dni'];
	$ape=$_REQUEST['ape'];
	$nom=$_REQUEST['nom'];
	$tel=$_REQUEST['tel'];
	$mail=$_REQUEST['mail'];
	$nac=$_REQUEST['nac'];
	$cur=$_REQUEST['cur'];

	include 'conexion.php'

	$sql="INSERT INTO usuarios(dni,apellido,nombre,telefono,mail,nacimiento,curso) VALUES('sid','$ape','$nom','$tel','$mail','$nac','$cur')";
	mysql_query($cnx,$sql) or die("Error al intentar guardar el nuevo usuario");
	echo "El usuario se registro con exito";
	mysql_close($cnx);
?>