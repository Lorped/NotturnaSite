<?php
	include ('../session_start.inc.php');
	include ('../db_start.inc.php');

	if (!isset ($_SESSION['idutente'])) die ("Errore, nessuna sessione attiva!");

	$idutente=$_SESSION['idutente'];

	$idother=$_SESSION['idother'];

	$Mysql = "SELECT *  FROM personaggio WHERE idutente = $idother ";

	$Result = mysql_query($Mysql);
	$res = mysql_fetch_array($Result);

 $oldbp=$res['bloodp'];

	$generazione=$res['generazione'];




	if (!isset($_POST) ) die ( "No post!");


		$Mysql = "UPDATE personaggio SET generazione = generazione-1 WHERE idutente = $idother";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$azione="MASTER generazione da ".$generazione." a ".($generazione-1);
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idother, 0, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$Mysql = "SELECT * from generazione WHERE generazione = $generazione-1 ";
		$Result = mysql_query($Mysql);
		$res = mysql_fetch_array($Result);

		$bloodpmin=$res['bloodpmin'];

		if ($bloodpmin > $oldbp) {
			$Mysql = "UPDATE personaggio SET bloodp = $bloodpmin WHERE idutente = $idother";
			$Result = mysql_query($Mysql);
		}


	session_write_close();
	header("Location: ../bg2.php", true);











?>
