<?php
	include ('../session_start.inc.php');
	include ('../db_start.inc.php');

	if (!isset ($_SESSION['idutente'])) die ("Errore, nessuna sessione attiva!");

	$idutente=$_SESSION['idutente'];




	if (!isset($_POST) ) die ( "No post!");



	foreach($_POST as $key => $value)
	{
   		$newpregio=$value;
	}





	if ( $newpregio > 0 ) {


		$MySql = "SELECT  sum(valore) as s FROM pregidifetti
			LEFT JOIN pregidifetti_main ON pregidifetti_main.idpregio=pregidifetti.idpregio
        	WHERE idutente = $idutente ";
		$Results = mysql_query($MySql);
		$res=mysql_fetch_array($Results);
		$pregitot=$res['s'];
		if ($pregitot=="") $pregitot=0;

		$MySql = "SELECT  sum(pxspesi) as s FROM pregidifetti
         		WHERE idutente = $idutente ";
		$Results = mysql_query($MySql);
		$res=mysql_fetch_array($Results);
		$pxspesi=$res['s'];
		if ($pxspesi=="") $pxspesi=0;

		$pregitot=$pregitot - ($pxspesi/2) ;


		$MySql = "SELECT valore, nomepregio, classe  FROM pregidifetti_main WHERE idpregio = $newpregio";
		$Results = mysql_query($MySql);
		$res=mysql_fetch_array($Results);

		$richiesto=$res['valore'];
		$nomepregio=$res['nomepregio'];
		$classe=$res['classe'];

		$mysql2="SELECT count(*) as c FROM pregidifetti LEFT JOIN pregidifetti_main ON pregidifetti_main.idpregio=pregidifetti.idpregio WHERE idutente=$idutente AND classe='$classe' AND  valore <0 ";
		$results2=mysql_query($mysql2);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		$res2=mysql_fetch_array($results2);
		$Ndife=$res2['c'];

		//die( $Ndife);


		if ( 1==0 ) {  // è un pregio, ma nessun difetto di quel tipo
		/* if ( $Ndife==0 &&  $richiesto > 0 ) {  */

			$pxrichiesti= 2*$richiesto ;

			$MySql = "INSERT INTO pregidifetti ( idpregio, idutente, pxspesi) VALUES ( $newpregio , $idutente, $pxrichiesti ) ";
			$Result = mysql_query($MySql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

			$MySql = "UPDATE personaggio SET xpspesi = xpspesi + $pxrichiesti WHERE idutente=$idutente ";
			$Result = mysql_query($MySql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

			$azione="Acquisto pregio/difetto ".mysql_real_escape_string($nomepregio);
			$MySql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, -$pxrichiesti, '$azione' )" ;
			$Result = mysql_query($MySql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		} else {

			if ( $richiesto <= -$pregitot ) {

				// Ok vado in semplice compensazione

				$MySql = "INSERT INTO pregidifetti ( idpregio, idutente) VALUES ( $newpregio , $idutente ) ";
				$Result = mysql_query($MySql);
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

				$azione="Acquisto pregio/difetto ".mysql_real_escape_string($nomepregio);
				$MySql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, 0, '$azione' )" ;
				$Result = mysql_query($MySql);
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );


			} else {

				$diff = $richiesto + $pregitot ;

				$pxrichiesti= 2*$diff ;

				//die ( "valore richiesto ".$richiesto." credito ".(-$pregitot)." spesa px: ".$pxrichiesti ) ;

				$MySql = "INSERT INTO pregidifetti ( idpregio, idutente, pxspesi) VALUES ( $newpregio , $idutente, $pxrichiesti ) ";
				$Result = mysql_query($MySql);
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

				$MySql = "UPDATE personaggio SET xpspesi = xpspesi + $pxrichiesti WHERE idutente=$idutente ";
				$Result = mysql_query($MySql);
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

				$azione="Acquisto pregio/difetto ".mysql_real_escape_string($nomepregio);
				$MySql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, -$pxrichiesti, '$azione' )" ;
				$Result = mysql_query($MySql);
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

			}
		}
	}



	session_write_close();
	header("Location: ../other.php", true);



?>
