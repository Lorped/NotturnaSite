<?php
	include ('../session_start.inc.php');
	include ('../db_start.inc.php');

	if (!isset ($_SESSION['idutente'])) die ("Errore, nessuna sessione attiva!");

	$idutente=$_SESSION['idutente'];
    



	if (!isset($_POST) ) die ( "No post!");

	$newpx=$_POST['px'];

	if ( $newpx > 0 ) {
    
		$MySql = "UPDATE personaggio SET xp = xp + $newpx WHERE idutente=$idutente ";
		$Result = mysql_query($MySql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		
		$MySql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, $newpx, 'ADD' )" ;
		$Result = mysql_query($MySql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		
	}
	
	session_write_close();
	header("Location: ../spendipx.php", true);



?>

