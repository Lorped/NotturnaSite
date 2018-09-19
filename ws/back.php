<?php
	include ('../session_start.inc.php');
	include ('../db_start.inc.php');

	if (!isset ($_SESSION['idutente'])) die ("Errore, nessuna sessione attiva!");

	$idutente=$_SESSION['idutente'];
    
	if (!isset($_POST) ) die ( "No post!");

//die (print_r($_POST));

	$id=$_POST['id'];

	$MySql = "SELECT livello FROM background  WHERE idutente=$idutente AND idback=$id";
	$Result = mysql_query($MySql);
	$res=mysql_fetch_array($Result);

	$liv=$res['livello'];
			   
	if ($liv=="") $liv=0;
	
	$newliv=$liv+$_POST['do'];
	
	if ( $newliv <0 ) $newliv=0;
	if ( $newliv >5 ) $newliv=5;

	$MySql = "SELECT nomeback FROM background_main  WHERE idback=$id";
	$Result = mysql_query($MySql);
	$res=mysql_fetch_array($Result);
	$nome=$res['nomeback'];


		
	if ( $liv==0 && $newliv==1) {
		$Mysql = "INSERT INTO background ( idback, idutente, livello) VALUES ( $id, $idutente, 1)";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		
		$azione=$nome." 1";
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, 0, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		
	}
	if ( $liv>0 && $newliv==0) {		
		$Mysql = "DELETE FROM background WHERE idback=$id AND  idutente=$idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		
		$azione=$nome." cancellato";
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, 0, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
	}
	if ( $liv!=0 && $newliv!=0) {		
		$Mysql = "UPDATE background SET livello=$newliv WHERE idback=$id AND  idutente=$idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		
		$azione=$nome." a ".$newliv;
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, 0, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
	}			   
			   

	
	session_write_close();
	header("Location: ../bg.php", true);



?>

