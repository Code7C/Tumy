<?
	$cnx=mysql_connect("localhost","root","bdNotis");
	$sql="SELECT * FROM usuarios WHERE usuario='$_REQUEST[usr]' and contra='spass'";
	$resultado=mysql_query($cnx,$sql);
	mysql_close($cnx);

	if (mysql_num_rows(resultado))>0
	{	
		echo "Contraseña correcta";
	<?

	?>
	}
	else
	{
		echo "Usuario o contraseña incorrecta";
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

</body>
</html>