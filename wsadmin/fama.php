<?php
	include ('../session_start.inc.php');
	include ('../db_start.inc.php');

	if (!isset ($_SESSION['idutente'])) die ("Errore, nessuna sessione attiva!");

	$idutente=$_SESSION['idutente'];

	$idother=$_SESSION['idother'];
    
	if (!isset($_POST) ) die ( "No post!");

	$MySql = "SELECT fama1, fama2, fama3 FROM personaggio  WHERE idutente=$idother ";
	$Result = mysql_query($MySql);
	$res=mysql_fetch_array($Result);

	$f1=$res['fama1'];
	$f2=$res['fama2'];
	$f3=$res['fama3'];


	if ( isset ( $_POST['f1'] )) {
		$f=$_POST['f1'] + $f1;
		
		if ( $f <0 ) $f=0;
		if ( $f >5 ) $f=5;
		
		$MySql = "UPDATE personaggio SET fama1 =  $f WHERE idutente=$idother ";
		$Result = mysql_query($MySql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		
		$azione="MASTER FamaCittà a ".$f;
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idother, 0, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		
	}

	if ( isset ( $_POST['f2'] )) {
		$f=$_POST['f2'] + $f2;
		
		if ( $f <0 ) $f=0;
		if ( $f >5 ) $f=5;
		
		$MySql = "UPDATE personaggio SET fama2 =  $f WHERE idutente=$idother ";
		$Result = mysql_query($MySql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		
		$azione="MASTER FamaVamp a ".$f;
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idother, 0, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		
	}			

	if ( isset ( $_POST['f3'] )) {
		$f=$_POST['f3'] + $f3;
		
		if ( $f <0 ) $f=0;
		if ( $f >5 ) $f=5;
		
		$MySql = "UPDATE personaggio SET fama3 =  $f WHERE idutente=$idother ";
		$Result = mysql_query($MySql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		
			
		$azione="MASTER FamaMondo a ".$f;
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idother, 0, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		
	}						

	
	session_write_close();
	header("Location: ../bg2.php", true);



?>

