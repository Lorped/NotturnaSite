<?php
	include ('../session_start.inc.php');
	include ('../db_start.inc.php');

	if (!isset ($_SESSION['idutente'])) die ("Errore, nessuna sessione attiva!");

	$idutente=$_SESSION['idutente'];

	$idother=$_SESSION['idother'];

	if (!isset($_POST) ) die ( "No post!");



//die ( print_r($_POST));


	if ( isset($_POST['id'] )) {

		$id=$_POST['id'];

		$MySql = "SELECT livello, nomecontatto FROM contatti  WHERE idcontatto=$id";
		$Result = mysql_query($MySql);
		$res=mysql_fetch_array($Result);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$liv=$res['livello'];


		$newliv=$liv+$_POST['do'];

		if ( $newliv <0 ) $newliv=0;
		if ( $newliv >5 ) $newliv=5;

		$nome=$res['nomecontatto'];

		//die ("liv ".$liv." "."newliv ".$newliv."id ".$id);

		if ( $liv>0 && $newliv==0) {
			$Mysql = "DELETE FROM contatti WHERE idcontatto=$id";
			$Result = mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

			$delta=-1;
			$Mysql = "SELECT livello FROM background WHERE idutente = $idother AND idback = 77";
			$Result = mysql_query($Mysql);
			$res=mysql_fetch_array($Result);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

			if ( $res['livello'] == 1 ) {
				$Mysql = "DELETE FROM background WHERE idutente = $idother AND idback = 77";
				$Result = mysql_query($Mysql);
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
			} else {
				$Mysql = "UPDATE background SET livello=livello + $delta WHERE idutente=$idother  AND idback = 77";
				$Result = mysql_query($Mysql);
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
			}

			$azione="MASTER Contatto ".$nome." cancellato";
			$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idother, 0, '$azione' )" ;
			$Result = mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		}

		if ( $liv!=0 && $newliv!=0) {
			$Mysql = "UPDATE contatti SET livello=$newliv WHERE idcontatto=$id";
			$Result = mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

			$delta=$newliv-$liv;
			$Mysql = "UPDATE background SET livello=livello + $delta WHERE idutente = $idother AND idback = 77 ";
			$Result = mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

			$azione="MASTER Contatto ".$nome." a ".$newliv;
			$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idother, 0, '$azione' )" ;
			$Result = mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		}
	} else {



		$nome=mysql_real_escape_string($_POST['nome']);
		$liv=$_POST['livello'];

		$Mysql = "INSERT INTO contatti ( nomecontatto, idutente, livello) VALUES ( '$nome', $idother, $liv)";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$Mysql = "SELECT count(*) as s FROM background WHERE idutente = $idother AND idback = 77";
		$Result = mysql_query($Mysql);
		$res=mysql_fetch_array($Result);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );


		if ( $res['s'] == 0 ) {
			$Mysql = "INSERT INTO background ( idback, idutente, livello) VALUES ( 77, $idother, $liv)";
			$Result = mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		} else {
			$Mysql = "UPDATE background SET livello=livello + $liv WHERE idutente = $idother AND idback = 77 ";



			$Result = mysql_query($Mysql);
			if (mysql_errno()) die ( "here ".mysql_errno().": ".mysql_error()."+". $Mysql );

		}


		$azione="MASTER Contatto ".$nome." inserito a ".$liv;
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idother, 0, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

	}



	session_write_close();
	header("Location: ../bg2.php", true);


?>
