<?php
	include ('../session_start.inc.php');
	include ('../db_start.inc.php');

	if (!isset ($_SESSION['idutente'])) die ("Errore, nessuna sessione attiva!");

	$idutente=$_SESSION['idutente'];

	$idother=$_SESSION['idother'];

if (!isset($_POST) ) die ( "No post!");

	$chance=$_POST['chance'];
	$Mysql="UPDATE chanceviolazione SET chance=$chance";
	mysql_query($Mysql);




	session_write_close();
	header("Location: ../main.php", true);











?>
