<?php
	include ('../session_start.inc.php');
	include ('../db_start.inc.php');

	if (!isset ($_SESSION['idutente'])) die ("Errore, nessuna sessione attiva!");

	$idutente=$_SESSION['idutente'];
    



	if (!isset($_POST) ) die ( "No post!");
//die (print_r($_POST));

	$delta=$_POST['do'];
	$idsentiero=$_POST['Sentiero'];

	if ( $delta != "" ) {
    
		$MySql = "UPDATE personaggio SET valsentiero = valsentiero + $delta WHERE idutente=$idutente ";
		$Result = mysql_query($MySql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		
		$azione="Modifica sentiero ".($delta>0?"+1":"-1");
		$MySql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, 0, '$azione' )" ;
		$Result = mysql_query($MySql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		
	}
	if ( $idsentiero != "" ) {
		$MySql = "UPDATE personaggio SET idsentiero = $idsentiero  WHERE idutente=$idutente ";
		$Result = mysql_query($MySql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		
		
		$MySql="SELECT * from sentieri WHERE idsentiero=$idsentiero";
		$Result = mysql_query($MySql);
		$res=mysql_fetch_array($Result);
		$newsent=$res['sentiero'];
		
		$azione="Cambio sentiero ".$newsent;
		$MySql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, 0, '$azione' )" ;
		$Result = mysql_query($MySql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
	}		
	
	session_write_close();
	header("Location: ../bg.php", true);



?>

