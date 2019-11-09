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


	$disc1val=$p['disc1val'];
	$disc2val=$p['disc2val'];
	$disc3val=$p['disc3val'];
	$valtaum1=$p['valtaum1'];
	$valtaum2=$p['valtaum2'];
	$valtaum3=$p['valtaum3'];

	$valnecro1=$p['valnecro1'];
	$valnecro2=$p['valnecro2'];
	$valnecro3=$p['valnecro3'];




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





$rifugio=mysql_real_escape_string($p['rifugio']);
$zona=mysql_real_escape_string($p['zona']);




  	$Mysql = "INSERT INTO HUNTERpersonaggio
  	(
    	idutente, nomepg, idclan,
    	forza, destrezza, attutimento, carisma, persuasione, saggezza, percezione, prontezza, intelligenza,
    	fdv, fdvmax,
    	idstatus,
    	fama1, fama2, fama3, xp, xpspesi,nomeplayer,
			rifugio, zona

  	)
  	VALUES
  	(
    	$idutente, '$nome', $Clan,
      	$Forza, $Destrezza, $Attutimento, $Carisma, $Persuasione, $Saggezza, $Percezione, $Prontezza, $Intelligenza,
      	4, 4,
      	1,
      	0, 0, 0 ,0,0 , '$nomeplayer' ,
				'$rifugio' , '$zona'

  	)";

 	mysql_query($Mysql);
	if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
//  	echo $Mysql, "<br>";



	$Mysql = "SELECT * FROM HUNdiscipline_main WHERE idcospiracy = $Clan and minlvl < 3 ";

	$Result = mysql_query($Mysql);
	if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

	while ($Res=mysql_fetch_array($Result)) {
		$DXX='D'.$Clan.$Res['iddisciplina'];

		if ( $p[$DXX] != 0 ) {

			$idd=$Res['iddisciplina'];
			$lev=$p[$DXX];
			$Mysql2 ="INSERT INTo HUNdiscipline ( iddisciplina, idutente , livello) VALUES ( $idd , $idutente, $lev)";
			mysql_query($Mysql2);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql2 );

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
