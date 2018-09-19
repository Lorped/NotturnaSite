<?php
	include ('../session_start.inc.php');
	include ('../db_start.inc.php');

	if (!isset ($_SESSION['idutente'])) die ("Errore, nessuna sessione attiva!");

	$idutente=$_SESSION['idutente'];

    
	$idother=$_SESSION['idother'];

	if (!isset($_POST) ) die ( "No post!");

	$pd=$_POST['eliminapd'];



	if ( $pd != ""  ) {
    
		$Mysql = "DELETE FROM pregidifetti WHERE idutente=$idother AND idpregio=$pd ";
	
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		
		$Mysql="SELECT * FROM pregidifetti_main WHERE idpregio=$pd";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		$res=mysql_fetch_array($Result);
		
		$action="MASTER - Rimosso pregio/difetto ".mysql_real_escape_string($res['nomepregio']);
		
		
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idother, 0, '$action' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		
	}
	
	session_write_close();
	header("Location: ../bg2.php", true);



?>

