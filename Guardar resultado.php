<?php
	$equipo1=$_REQUEST['e1'];
	$golesE1=$_REQUEST['g1'];
	$ganadoE1=0;
	$perdidoE1=0;
	$empatadoE1=0;
	$equipo2=$_REQUEST['e2'];
	$golesE2=$_REQUEST['g2'];
	$ganadoE2=0;
	$perdidoE2=0;
	$empatadoE2=0;

	if($golesE1==$golesE2)
	{
		$empatadoE1=1;
		$empatadoE2=1;
	}
	elseif($golesE1>$golesE2) 
	{
		$ganadoE1=1;
		$perdidoE2=1;
	}
	else
	{
		$ganadoE2=1;
		$perdidoE1=1;
	}

	include "conexion.php";
	$sql1="UPDATE posiciones 
		     SET GANADOS=GANADOS+$ganadoE1,
		     	 EMPATADOS=EMPATADOS+$empatadoE1,
		     	 PERDIDOS=PERDIDOS+$perdidoE1,
		     	 GOLES_A_FAVOR=GOLES_A_FAVOR+$golesE1,
		     	 GOLES_EN_CONTRA=GOLES_EN_CONTRA+$golesE2
		   WHERE EQUIPO='$equipo1'";
	$sql2="UPDATE posiciones 
		     SET GANADOS=GANADOS+$ganadoE2,
		     	 EMPATADOS=EMPATADOS+$empatadoE2,
		     	 PERDIDOS=PERDIDOS+$perdidoE2,
		     	 GOLES_A_FAVOR=GOLES_A_FAVOR+$golesE2,
		     	 GOLES_EN_CONTRA=GOLES_EN_CONTRA+$golesE1
		   WHERE EQUIPO='$equipo2'";
	mysqli_query($cnx,$sql1) or die("No se puede cargar el partido.");
	mysqli_query($cnx,$sql2) or die("No se puede cargar el partido.");
	mysqli_close($cnx);	

?>