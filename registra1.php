<?
	include ('session_start.inc.php');
	include ('db_start.inc.php');

 if (!isset ($_SESSION['idutente'])) die ("Errore, nessuna sessione attiva!");

  	$idutente=$_SESSION['idutente'];

if (!isset($_POST)) die ("No post!");

  	$p = $_POST;
	$nome=mysql_real_escape_string($p['nome']);
	$nomeplayer=mysql_real_escape_string($p['nomeplayer']);
	$Clan=$p['Clan'];
	$generazione=$p['Generazione'];
	$Forza=$p['Forza'];
	$Destrezza=$p['Destrezza'];
	$Attutimento=$p['Attutimento'];
	$Carisma=$p['Carisma'];
	$Persuasione=$p['Persuasione'];
	$Saggezza=$p['Saggezza'];
	$Percezione=$p['Percezione'];
	$Prontezza=$p['Prontezza'];
	$Intelligenza=$p['Intelligenza'];
	$Status=$p['Status'];
	$fdv=$p['fdv'];
	$fdvmax=$p['fdv'];
	$Sentiero=$p['Sentiero']; if ($Sentiero=="") $Sentiero=1;
	$umanita=$p['umanita'];

	$disc1val=$p['disc1val'];
	$disc2val=$p['disc2val'];
	$disc3val=$p['disc3val'];
	$valtaum1=$p['valtaum1'];
	$valtaum2=$p['valtaum2'];
	$valtaum3=$p['valtaum3'];

	$valnecro1=$p['valnecro1'];
	$valnecro2=$p['valnecro2'];
	$valnecro3=$p['valnecro3'];

	$Taumaturgia1=$p['Taumaturgia1'];
	$Taumaturgia2=$p['Taumaturgia2'];
	$Taumaturgia3=$p['Taumaturgia3'];
	$Necromanzia1=$p['Necromanzia1'];
	$Necromanzia2=$p['Necromanzia2'];
	$Necromanzia3=$p['Necromanzia3'];

	$Gregge=$p['Gregge'];
	$Risorse=$p['Risorse'];
	$Seguaci=$p['Seguaci'];
	$Notorieta=$p['Notorieta'];
	$Mentore=$p['Mentore'];
	$Rifugio=$p['Rifugio'];
	$Contatti=$p['Contatti'];

	$dc1=mysql_real_escape_string($p['DescCont1']);
	$dc2=mysql_real_escape_string($p['DescCont2']);
	$dc3=mysql_real_escape_string($p['DescCont3']);
	$dc4=mysql_real_escape_string($p['DescCont4']);
	$dc5=mysql_real_escape_string($p['DescCont5']);
	$dc6=mysql_real_escape_string($p['DescCont6']);

	$vc1=$p['ValCont1'];
	$vc2=$p['ValCont2'];
	$vc3=$p['ValCont3'];
	$vc4=$p['ValCont4'];
	$vc5=$p['ValCont5'];
	$vc6=$p['ValCont6'];


	$vile1=$p['vile1'];
	$vile2=$p['vile2'];
	$vile3=$p['vile3'];


	$g14=$p['g14'];


$rifugio=mysql_real_escape_string($p['rifugio']);
$zona=mysql_real_escape_string($p['zona']);

if ( $g14=="on") {
	$newgen=14;
	$generazione=0;
	$Clan=20;
} else {
	$newgen=13-$generazione;
}

//die ("g14 ".$g14 ." generazioneBG ".$generazione." newgen".$newgen);


$MySql="SELECT * from generazione where generazione = $newgen";
$Result=mysql_query($MySql);
$res=mysql_fetch_array($Result);
$bp1=$res['bloodpmin'];
$MySql="SELECT * from statuscama where idstatus = $Status";
$Result=mysql_query($MySql);
$res=mysql_fetch_array($Result);
$bp2=$res['addbp'];

$bp=$bp1+$bp2;

  	$Mysql = "INSERT INTO personaggio
  	(
    	idutente, nomepg, idclan, generazione,
    	forza, destrezza, attutimento, carisma, persuasione, saggezza, percezione, prontezza, intelligenza,
    	fdv, fdvmax,
    	idstatus, idsentiero, valsentiero,
    	fama1, fama2, fama3, xp, xpspesi,nomeplayer,
			rifugio, zona,
			bloodp
  	)
  	VALUES
  	(
    	$idutente, '$nome', $Clan, $newgen,
      	$Forza, $Destrezza, $Attutimento, $Carisma, $Persuasione, $Saggezza, $Percezione, $Prontezza, $Intelligenza,
      	($Status+1+$fdv), ($Status+1+$fdv),
      	$Status, $Sentiero, ($umanita+5),
      	0, 0, 0 ,0,0 , '$nomeplayer' ,
				'$rifugio' , '$zona' ,
				$bp
  	)";

 	mysql_query($Mysql);
	if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
//  	echo $Mysql, "<br>";


  	$Mysql2 = "INSERT INTO discipline
       (iddisciplina, idutente, livello, DiClan)
       VALUES";

  	switch ( $Clan ) {

		case 1:   //  Toreador
			$xx = "( 2 , $idutente , $disc1val, 'S' )";
			$yy = "( 3 , $idutente , $disc2val, 'S' )";
			$zz = "( 15 , $idutente , $disc3val, 'S' )";

		break;
		case 2:   //  Ventrue
			$xx = "( 2 , $idutente , $disc1val, 'S' )";
			$yy = "( 6 , $idutente , $disc2val, 'S' )";
			$zz = "( 12 , $idutente , $disc3val, 'S' )";

		break;
		case 3:		// Nosferatu
			$xx = "( 1 , $idutente , $disc1val, 'S' )";
			$yy = "( 8 , $idutente , $disc2val, 'S' )";
			$zz = "( 17 , $idutente , $disc3val, 'S' )";

		break;
		case 4:		// Brujah
			$xx = "( 2 , $idutente , $disc1val, 'S' )";
			$yy = "( 17 , $idutente , $disc2val, 'S' )";
			$zz = "( 15 , $idutente , $disc3val, 'S' )";

		break;
		case 5:		// Gangrel
			$xx = "( 1 , $idutente , $disc1val, 'S' )";
			$yy = "( 10 , $idutente , $disc2val, 'S' )";
			$zz = "( 12 , $idutente , $disc3val, 'S' )";

		break;
		case 6:		// Malkavian
			$xx = "( 3 , $idutente , $disc1val, 'S' )";
			/***  $yy = "( 6 , $idutente , $disc2val, 'S' )";  **/
			$yy = "( 5 , $idutente , $disc2val, 'S' )";
			$zz = "( 8 , $idutente , $disc3val, 'S' )";

		break;
		case 8:		// Lasombra
			$xx = "( 6 , $idutente , $disc1val, 'S' )";
			$yy = "( 17 , $idutente , $disc2val, 'S' )";
			$zz = "( 9 , $idutente , $disc3val, 'S' )";

		break;
		case 9:		// Tzimisce
			$xx = "( 1 , $idutente , $disc1val, 'S' )";
			$yy = "( 3 , $idutente , $disc2val, 'S' )";
			$zz = "( 16 , $idutente , $disc3val, 'S' )";

		break;
		case 10:	// Assamiti
			$xx = "( 8 , $idutente , $disc1val, 'S' )";
			$yy = "( 11 , $idutente , $disc2val, 'S' )";
			$zz = "( 15 , $idutente , $disc3val, 'S' )";

		break;
		case 12:	// Ravnos
			$xx = "( 1 , $idutente , $disc1val, 'S' )";
			$yy = "( 4 , $idutente , $disc2val, 'S' )";
			$zz = "( 12 , $idutente , $disc3val, 'S' )";

		break;
		case 13:	// Setiti
			$xx = "( 2 , $idutente , $disc1val, 'S' )";
			$yy = "( 8 , $idutente , $disc2val, 'S' )";
			$zz = "( 13 , $idutente , $disc3val, 'S' )";
		break;
		case 20:	// vili
			$xx = "( $vile1 , $idutente , $disc1val, 'N' )";
			$yy = "( $vile2 , $idutente , $disc2val, 'N' )";
			$zz = "( $vile3 , $idutente , $disc3val, 'N' )";
		break;


	}

/* Inserisco le discipline di clan anche se a zero */

	if ( $Clan != 7 && $Clan != 11 && $Clan != 14) {
    	$Mysql=$Mysql2.$xx ;
	  	mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

    	$Mysql=$Mysql2.$yy ;
	  	mysql_query($Mysql);

    	$Mysql=$Mysql2.$zz ;
	  	mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

	}

/* ma tolgo quelle dei vili se a zero.... */
	if ( $Clan == 20  ) {
		$Mysql="DELETE FROM discipline WHERE idutente=$idutente AND livello = 0 ";
		mysql_query($Mysql);
	}


/**************** versione con gli IF

	if ( $Clan != 7 && $Clan != 11 ) {
		if ($disc1val != 0 ) {
    	$Mysql=$Mysql2.$xx ;
	  	mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
//    	echo $Mysql , "<br>";
  	}
  	if ($disc2val != 0 ) {
    	$Mysql=$Mysql2.$yy ;
	  	mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
//    	echo $Mysql , "<br>";
  	}
  	if ($disc3val != 0 ) {
    	$Mysql=$Mysql2.$zz ;
	  	mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
//    	echo $Mysql , "<br>";
  	}
**************************************/


  if ( $Clan == 7 ) {
		$xx = "( 3 , $idutente , $disc1val, 'S' )";
		$yy = "( 6 , $idutente , $disc2val, 'S' )";

	  	if ($valtaum1==5) {
			$valtaumX = $valtaum1+$valtaum2;
		} else {
			$valtaumX = $valtaum1;
		}
		$zz = "( 98 , $idutente , $valtaumX, 'S'  )";


/******* Inserimento a zero */
		  $Mysql=$Mysql2.$xx ;
		  mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

      		$Mysql=$Mysql2.$yy ;
    		mysql_query($Mysql);
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

      		$Mysql=$Mysql2.$zz ;
    		mysql_query($Mysql);
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

/****************  VERSIONE con IF

	  if ($disc1val != 0 ) {
		  $Mysql=$Mysql2.$xx ;
		  mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
//		  echo $Mysql , "<br>";
    	}
    	if ($disc2val != 0 ) {
      		$Mysql=$Mysql2.$yy ;
    		mysql_query($Mysql);
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
//     		echo $Mysql , "<br>";
    	}
    	if ( $valtaumX != 0 ) {
      		$Mysql=$Mysql2.$zz ;
    		mysql_query($Mysql);
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
//     		echo $Mysql , "<br>";
    	}
******************/

    	if ( $valtaum1 != 0 ) {
      		$MysqlXX = "INSERT INTO taumaturgie ( idtaum, livello, idutente, principale ) VALUES ( $Taumaturgia1 , $valtaum1 , $idutente , 1 )";
    		mysql_query ( $MysqlXX );
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $MysqlXX );
//     		echo $MysqlXX;
    	}
    	if ( $valtaum2 != 0 ) {
      		$MysqlXX = "INSERT INTO taumaturgie ( idtaum, livello, idutente, principale ) VALUES ( $Taumaturgia2 , $valtaum2 , $idutente , 2 )";
    		mysql_query ( $MysqlXX );
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $MysqlXX );
//     		echo $MysqlXX;
    	}
    	if ( $valtaum3 != 0 ) {
      		$MysqlXX = "INSERT INTO taumaturgie ( idtaum, livello, idutente, principale ) VALUES ( $Taumaturgia3 , $valtaum3 , $idutente , 3 )";
    		mysql_query ( $MysqlXX );
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $MysqlXX );
//     		echo $MysqlXX;
    	}
  	}

  	if ( $Clan == 11 ) {
			$xx = "( 6 , $idutente , $disc1val, 'S'  )";

			if ( $valnecro1 == 5 ) {
				$valnecroX = $valnecro1+$valnecro2;
			} else {
				$valnecroX = $valnecro1;
			}
			$yy = "( 99 , $idutente , $valnecroX, 'S'  )";

			$zz = "( 17 , $idutente , $disc3val, 'S'  )";

/************ INSERIMENTO a Zero */

			$Mysql=$Mysql2.$xx ;
	    	mysql_query($Mysql);

      		$Mysql=$Mysql2.$yy ;
    		mysql_query($Mysql);
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

      		$Mysql=$Mysql2.$zz ;
    		mysql_query($Mysql);
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

/************** versione con IF

		if ($disc1val != 0 ) {
			$Mysql=$Mysql2.$xx ;
	    	mysql_query($Mysql);
//		  	echo $Mysql , "<br>";
    	}
    	if ($disc3val != 0 ) {
      		$Mysql=$Mysql2.$zz ;
    		mysql_query($Mysql);
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
//     		echo $Mysql , "<br>";
    	}
    	if ( $valnecroX != 0 ) {
      		$Mysql=$Mysql2.$zz ;
    		mysql_query($Mysql);
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
//     		echo $Mysql , "<br>";
    	}
********************/

    	if ( $valnecro1 != 0 ) {
      		$MysqlXX = "INSERT INTO necromanzie ( idnecro, livello, idutente, principale ) VALUES ( $Necromanzia1 , $valnecro1 , $idutente , 1 )";
    		mysql_query ( $MysqlXX );
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $MysqlXX );
//     		echo $MysqlXX;
    	}
    	if ( $valnecro2 != 0 ) {
      		$MysqlXX = "INSERT INTO necromanzie ( idnecro, livello, idutente, principale ) VALUES ( $Necromanzia2 , $valnecro2 , $idutente , 2 )";
    		mysql_query ( $MysqlXX );
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $MysqlXX );
//     		echo $MysqlXX;
    	}
    	if ( $valnecro3 != 0 ) {
      		$MysqlXX = "INSERT INTO necromanzie ( idnecro, livello, idutente, principale ) VALUES ( $Necromanzia3 , $valnecro3 , $idutente , 3 )";
    		mysql_query ( $MysqlXX );
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $MysqlXX );
//     		echo $MysqlXX;
    	}
  	}

		if ( $Clan == 14 ) {
			$xx = "( 3 , $idutente , $disc1val, 'S'  )";

			if ( $valnecro1 == 5 ) {
				$valnecroX = $valnecro1+$valnecro2;
			} else {
				$valnecroX = $valnecro1;
			}
			$yy = "( 99 , $idutente , $valnecroX, 'S'  )";

			$zz = "( 12 , $idutente , $disc3val, 'S'  )";

/************ INSERIMENTO a Zero */

			$Mysql=$Mysql2.$xx ;
	    	mysql_query($Mysql);

      		$Mysql=$Mysql2.$yy ;
    		mysql_query($Mysql);
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

      		$Mysql=$Mysql2.$zz ;
    		mysql_query($Mysql);
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

    	if ( $valnecro1 != 0 ) {
      		$MysqlXX = "INSERT INTO necromanzie ( idnecro, livello, idutente, principale ) VALUES ( $Necromanzia1 , $valnecro1 , $idutente , 1 )";
    		mysql_query ( $MysqlXX );
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $MysqlXX );
//     		echo $MysqlXX;
    	}
    	if ( $valnecro2 != 0 ) {
      		$MysqlXX = "INSERT INTO necromanzie ( idnecro, livello, idutente, principale ) VALUES ( $Necromanzia2 , $valnecro2 , $idutente , 2 )";
    		mysql_query ( $MysqlXX );
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $MysqlXX );
//     		echo $MysqlXX;
    	}
    	if ( $valnecro3 != 0 ) {
      		$MysqlXX = "INSERT INTO necromanzie ( idnecro, livello, idutente, principale ) VALUES ( $Necromanzia3 , $valnecro3 , $idutente , 3 )";
    		mysql_query ( $MysqlXX );
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $MysqlXX );
//     		echo $MysqlXX;
    	}
  	}



  	if ( $Gregge != 0 ) {
    	$Mysql = "INSERT INTO background ( idback, idutente, livello ) VALUES ( 1, $idutente, $Gregge )";
    	mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $MySql );
//    	echo $Mysql , "<br>";
  	}
  	if ( $Risorse != 0 ) {
    	$Mysql = "INSERT INTO background ( idback, idutente, livello ) VALUES ( 2, $idutente, $Risorse )";
    	mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $MySql );
//    	echo $Mysql , "<br>";
  	}
  	if ( $Seguaci != 0 ) {
    	$Mysql = "INSERT INTO background ( idback, idutente, livello ) VALUES ( 3, $idutente, $Seguaci )";
    	mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $MySql );
//    	echo $Mysql , "<br>";
  	}
  	if ( $Notorieta != 0 ) {
    	$Mysql = "INSERT INTO background ( idback, idutente, livello ) VALUES ( 4, $idutente, $Notorieta )";
    	mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
//    	echo $Mysql , "<br>";
  	}
  	if ( $generazione != 0 ) {
    	$Mysql = "INSERT INTO background ( idback, idutente, livello ) VALUES ( 5, $idutente, $generazione )";
    	mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
//    	echo $Mysql , "<br>";
  	}
  	if ( $Mentore != 0 ) {
    	$Mysql = "INSERT INTO background ( idback, idutente, livello ) VALUES ( 6, $idutente, $Mentore )";
    	mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
//    	echo $Mysql , "<br>";
  	}
		if ( $Rifugio != 0 ) {
    	$Mysql = "INSERT INTO background ( idback, idutente, livello ) VALUES ( 8, $idutente, $Rifugio )";
    	mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
//    	echo $Mysql , "<br>";
  	}
  	if ( $Contatti != 0 ) {
    	$Mysql = "INSERT INTO background ( idback, idutente, livello ) VALUES ( 77, $idutente, $Contatti )";
    	mysql_query($Mysql);
//    	echo $Mysql , "<br>";
  	}

	for ( $i=1; $i<23 ; $i++ ) {
		$skilla="F".$i;
		$skillb=$p[$skilla];
		if ( $skillb) {
			$Mysql="INSERT INTO skill (idskill, livello, idutente ) VALUES ( $i, $skillb, $idutente )";
			mysql_query($Mysql);
//			echo $Mysql , "<br>";
		}
	}
	for ( $i=23; $i<29 ; $i++ ) {
		$skilla="A".$i;
		$skillb=$p[$skilla];
		if ( $skillb) {
			$Mysql="INSERT INTO skill (idskill, livello, idutente ) VALUES ( $i, $skillb, $idutente )";
			mysql_query($Mysql);
//			echo $Mysql , "<br>";
		}
	}

	for ( $i=1; $i<7 ; $i++ ) {
		$skilla="dc".$i;
		$skillax=$$skilla;
		$skillb="vc".$i;
		$skillbx=$$skillb;
		if ( $skillbx) {
			$Mysql="INSERT INTO contatti (idutente, livello, nomecontatto, tipologia) VALUES ( $idutente, $skillbx, '$skillax', 7 )";
			mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
//			echo $Mysql , "<br>";
		}
	}

  session_write_close();
	header("Location: main.php", true);

?>
