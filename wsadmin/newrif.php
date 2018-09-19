<?php
	include ('../session_start.inc.php');
	include ('../db_start.inc.php');

	if (!isset ($_SESSION['idutente'])) die ("Errore, nessuna sessione attiva!");

	$idutente=$_SESSION['idutente'];

	$idother=$_SESSION['idother'];

if (!isset($_POST) ) die ( "No post!");

	if ( isset($_POST['rifugio'] )) {
		$rifugio=mysql_real_escape_string($_POST['rifugio']);

		$Mysql = "UPDATE personaggio SET rifugio = '$rifugio' WHERE idutente = $idother";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
	}



	session_write_close();
	header("Location: ../bg2.php", true);











?>
