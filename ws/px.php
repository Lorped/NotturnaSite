<?php
	include ('../session_start.inc.php');
	include ('../db_start.inc.php');

	if (!isset ($_SESSION['idutente'])) die ("Errore, nessuna sessione attiva!");

	$idutente=$_SESSION['idutente'];


	$Mysql = "SELECT *  FROM personaggio
		LEFT JOIN generazione ON personaggio.generazione=generazione.generazione
		WHERE idutente = $idutente ";

	$Result = mysql_query($Mysql);
	$res = mysql_fetch_array($Result);


	$forza=$res['forza'];
	$destrezza=$res['destrezza'];
	$attutimento=$res['attutimento'];
	$carisma=$res['carisma'];
	$persuasione=$res['persuasione'];
	$saggezza=$res['saggezza'];
	$percezione=$res['percezione'];
	$intelligenza=$res['intelligenza'];
	$prontezza=$res['prontezza'];

	$fdv=$res['fdv'];

	$xp=$res['xp'];
	$xpspesi=$res['xpspesi'];

	$clan=$res['idclan'];

	$bloodp=$res['bloodp'];


	if (!isset($_POST) ) die ( "No post!");


	if ( isset($_POST['Disciplina']) ) {     //aumentare disciplina

		$iddisc=$_POST['iddisc'];

		$Mysql = "SELECT * FROM discipline LEFT JOIN discipline_main ON discipline.iddisciplina = discipline_main.iddisciplina
					WHERE discipline_main.iddisciplina = $iddisc  AND idutente = $idutente";
		$Result = mysql_query($Mysql);
		$res = mysql_fetch_array($Result);
		$diclan=$res['DiClan'];
		$livello=$res['livello'];
		$disc=$res['nomedisc'];

		if ( $diclan == 'S' ) {
			$pxspesi = ($livello +1 )*2;
		} else {
			$pxspesi = ($livello +1 )*3;
		}

		$Mysql = "UPDATE discipline SET livello = livello+1 WHERE iddisciplina = $iddisc  AND idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$Mysql = "UPDATE personaggio SET xpspesi = xpspesi+$pxspesi WHERE idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$azione=$disc." a ".($livello+1);
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, -$pxspesi, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

	}

	if ( isset ($_POST ['IncrSkill'] )  || isset ($_POST ['IncrSkillX'] )   ) { //aumentare skill / attitudini

		$idskill=$_POST['IDSkill'];
		if  ( isset ($_POST ['IncrSkill'] ) ) $mult=2;
		if  ( isset ($_POST ['IncrSkillX'] ) ) $mult=3;

		$Mysql = "SELECT * FROM skill LEFT JOIN skill_main ON skill.idskill = skill_main.idskill
					WHERE skill_main.idskill = $idskill  AND idutente = $idutente";
		$Result = mysql_query($Mysql);
		if ($res = mysql_fetch_array($Result) ) {
			$livello=$res['livello'];
			$skill=$res['nomeskill'];
			$pxspesi = ($livello +1 )*$mult;

			$Mysql = "UPDATE skill SET livello = livello+1 WHERE idskill = $idskill  AND idutente = $idutente";
			$Result = mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );


		} else {
			$livello=0;
			$pxspesi = $mult;

			$Mysql = "SELECT * FROM skill_main WHERE idskill = $idskill";
			$Result = mysql_query($Mysql);
			$res = mysql_fetch_array($Result);
			$skill=$res['nomeskill'];

			$Mysql = "INSERT INTO skill (idskill, idutente, livello ) VALUES ( $idskill , $idutente , 1 ) ";
			$Result = mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		}

		$Mysql = "UPDATE personaggio SET xpspesi = xpspesi+$pxspesi WHERE idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$azione=$skill." a ".($livello+1);
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, -$pxspesi, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

	}

	if ( isset ($_POST ['Forza'] )) { //aumenta Forza

		$pxspesi=($forza+1)*2;

		$Mysql = "UPDATE personaggio SET xpspesi = xpspesi+$pxspesi , forza = forza +1 WHERE idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$azione="Forza a ".($forza+1);
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, -$pxspesi, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );


	}

	if ( isset ($_POST ['Destrezza'] )) { //aumenta Destrezza

		$pxspesi=($destrezza+1)*2;

		$Mysql = "UPDATE personaggio SET xpspesi = xpspesi+$pxspesi , destrezza = destrezza +1 WHERE idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$azione="Destrezza a ".($destrezza+1);
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, -$pxspesi, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );


	}

	if ( isset ($_POST ['Attutimento'] )) { //aumenta Attutimento

		$pxspesi=($attutimento+1)*2;

		$Mysql = "UPDATE personaggio SET xpspesi = xpspesi+$pxspesi , attutimento = attutimento +1 WHERE idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$azione="Attutimento a ".($attutimento+1);
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, -$pxspesi, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );


	}

	if ( isset ($_POST ['Carisma'] )) { //aumenta Carisma

		$pxspesi=($carisma+1)*2;

		$Mysql = "UPDATE personaggio SET xpspesi = xpspesi+$pxspesi , carisma = carisma +1 WHERE idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$azione="Carisma a ".($carisma+1);
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, -$pxspesi, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );



	}

	if ( isset ($_POST ['Persuasione'] )) { //aumenta Persuasione

		$pxspesi=($persuasione+1)*2;

		$Mysql = "UPDATE personaggio SET xpspesi = xpspesi+$pxspesi , persuasione = persuasione +1 WHERE idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$azione="Persuasione a ".($persuasione+1);
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, -$pxspesi, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

	}

	if ( isset ($_POST ['Saggezza'] )) { //aumenta Saggezza

		$pxspesi=($saggezza+1)*2;

		$Mysql = "UPDATE personaggio SET xpspesi = xpspesi+$pxspesi , saggezza = saggezza +1 WHERE idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$azione="Saggezza a ".($saggezza+1);
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, -$pxspesi, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );


	}

	if ( isset ($_POST ['Percezione'] )) { //aumenta Percezione

		$pxspesi=($percezione+1)*2;

		$Mysql = "UPDATE personaggio SET xpspesi = xpspesi+$pxspesi , percezione = percezione +1 WHERE idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$azione="Percezione a ".($percezione+1);
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, -$pxspesi, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );



	}

	if ( isset ($_POST ['Intelligenza'] )) { //aumenta Intelligenza

		$pxspesi=($intelligenza+1)*2;

		$Mysql = "UPDATE personaggio SET xpspesi = xpspesi+$pxspesi , intelligenza = intelligenza +1 WHERE idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$azione="Intelligenza a ".($intelligenza+1);
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, -$pxspesi, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );


	}

	if ( isset ($_POST ['Prontezza'] )) { //aumenta Prontezza

		$pxspesi=($prontezza+1)*2;

		$Mysql = "UPDATE personaggio SET xpspesi = xpspesi+$pxspesi , prontezza = prontezza +1 WHERE idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$azione="Prontezza a ".($prontezza+1);
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, -$pxspesi, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );



	}

	if ( isset ($_POST ['ImparaDisc'] )) { //impara disciplina non di clan

		$pxspesi=5;
		$disc=$_POST ['iddisciplina'];

		$Mysql = "SELECT nomedisc FROM discipline_main WHERE iddisciplina=$disc";
		$Result = mysql_query($Mysql);
		$res=mysql_fetch_array($Result);
		$nomedisc=$res['nomedisc'];

		$Mysql = "INSERT INTO discipline (iddisciplina, idutente, livello, DiClan ) VALUES ( $disc , $idutente , 1 ,'N' ) ";
		$Result = mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$Mysql = "UPDATE personaggio SET xpspesi = xpspesi+$pxspesi  WHERE idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$azione="Acquisita ".$nomedisc;
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, -$pxspesi, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );



	}

	if ( isset ($_POST ['Taumaturgia'] )) { //aumenta taumaturgia

		$idtaum=$_POST['idtaum'];

		$Mysql = "SELECT * FROM taumaturgie LEFT JOIN taumaturgie_main ON taumaturgie.idtaum = taumaturgie_main.idtaum
					WHERE taumaturgie_main.idtaum = $idtaum  AND idutente = $idutente";
		$Result = mysql_query($Mysql);
		$res = mysql_fetch_array($Result);
		$livello=$res['livello'];
		$disc=$res['nometaum'];
		if ( $clan == 7 ) {
			$pxspesi = ($livello +1 )*2;
		} else {
			$pxspesi = ($livello +1 )*3;
		}

		$Mysql = "UPDATE taumaturgie SET livello = livello+1 WHERE idtaum = $idtaum  AND idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );


		$Mysql = "SELECT livello FROM taumaturgie  WHERE principale = 1  AND idutente = $idutente";
		$Result = mysql_query($Mysql);
		$Res=mysql_fetch_array($Result);
		$x1=$Res['livello'];

		if ( $x1 < 5 ) {
			$newtaum = $x1;
		}else{
			$Mysql = "SELECT livello FROM taumaturgie  WHERE principale = 2  AND idutente = $idutente";
			$Result = mysql_query($Mysql);
			$Res=mysql_fetch_array($Result);
			$x2=$Res['livello'];
			if ($x2 == '') { $x2=0; }
			$newtaum = $x1+$x2;
		}

		$Mysql = "UPDATE discipline SET livello = $newtaum WHERE iddisciplina = 98  AND idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$Mysql = "UPDATE personaggio SET xpspesi = xpspesi+$pxspesi WHERE idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$azione=$disc." a ".($livello+1);
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, -$pxspesi, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
	}


	if ( isset ($_POST ['ImparaTaum'] )) { //impara taumaturgia
		$idtaum=$_POST['idtaum'];
		if ( $clan == 7 ) {
			$pxspesi = 2;
		} else {
			$pxspesi = 5;
		}
		$Mysql = "SELECT * FROM taumaturgie_main
					WHERE idtaum = $idtaum ";
		$Result = mysql_query($Mysql);
		$res = mysql_fetch_array($Result);
		$disc=$res['nometaum'];

		$Mysql="SELECT MAX(principale) as m FROM taumaturgie WHERE idutente=$idutente";
		$Result=mysql_query($Mysql);
		$res=mysql_fetch_array($Result);
		if ($res['m']=='' ) {$newprimary=1;} else { $newprimary = $res['m']+1 ; }


		$Mysql = "INSERT INTO taumaturgie ( idtaum, idutente, livello, principale ) VALUES (  $idtaum, $idutente, 1, $newprimary)";
		$Result=mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		if ($newprimary == 1 ) {
			$Mysql = "INSERT INTO discipline ( iddisciplina, idutente, livello, DiClan ) VALUES (  98, $idutente, 1, 'N') ";
			$Result=mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		}else {

			$Mysql = "SELECT livello FROM taumaturgie  WHERE principale = 1  AND idutente = $idutente";
			$Result = mysql_query($Mysql);
			$Res=mysql_fetch_array($Result);
			$x1=$Res['livello'];

			if ( $x1 < 5 ) {
				$newtaum = $x1;
			}else{
				$Mysql = "SELECT livello FROM taumaturgie  WHERE principale = 2  AND idutente = $idutente";
				$Result = mysql_query($Mysql);
				$Res=mysql_fetch_array($Result);
				$x2=$Res['livello'];
				if ($x2 == '') { $x2=0; }
				$newtaum = $x1+$x2;
			}

			$Mysql = "UPDATE discipline SET livello = $newtaum WHERE iddisciplina = 98  AND idutente = $idutente";
			$Result = mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		}
		$Mysql = "UPDATE personaggio SET xpspesi = xpspesi+$pxspesi WHERE idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$azione="Acquisita ".$disc;
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, -$pxspesi, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
	}

	if ( isset ($_POST ['Necromanzia'] )) { //aumenta necromanzia

		$idnecro=$_POST['idnecro'];

		$Mysql = "SELECT * FROM necromanzie LEFT JOIN necromanzie_main ON necromanzie.idnecro = necromanzie_main.idnecro
					WHERE necromanzie_main.idnecro = $idnecro  AND idutente = $idutente";
		$Result = mysql_query($Mysql);
		$res = mysql_fetch_array($Result);
		$livello=$res['livello'];
		$disc=$res['nomenecro'];
		if ( $clan == 11 ) {
			$pxspesi = ($livello +1 )*2;
		} else {
			$pxspesi = ($livello +1 )*3;
		}

		$Mysql = "UPDATE necromanzie SET livello = livello+1 WHERE idnecro = $idnecro  AND idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );


		$Mysql = "SELECT livello FROM necromanzie  WHERE principale = 1  AND idutente = $idutente";
		$Result = mysql_query($Mysql);
		$Res=mysql_fetch_array($Result);
		$x1=$Res['livello'];

		if ( $x1 < 5 ) {
			$newtaum = $x1;
		}else{
			$Mysql = "SELECT livello FROM necromanzie  WHERE principale = 2  AND idutente = $idutente";
			$Result = mysql_query($Mysql);
			$Res=mysql_fetch_array($Result);
			$x2=$Res['livello'];
			if ($x2 == '') { $x2=0; }
			$newtaum = $x1+$x2;
		}

		$Mysql = "UPDATE discipline SET livello = $newtaum WHERE iddisciplina = 99  AND idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$Mysql = "UPDATE personaggio SET xpspesi = xpspesi+$pxspesi WHERE idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$azione=$disc." a ".($livello+1);
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, -$pxspesi, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
	}


	if ( isset ($_POST ['ImparaNecro'] )) { //impara necromanzia
		$idnecro=$_POST['idnecro'];
		if ( $clan == 11 ) {
			$pxspesi = 2;
		} else {
			$pxspesi = 5;
		}
		$Mysql = "SELECT * FROM necromanzie_main
					WHERE idnecro = $idnecro ";
		$Result = mysql_query($Mysql);
		$res = mysql_fetch_array($Result);
		$disc=$res['nomenecro'];

		$Mysql="SELECT MAX(principale) as m FROM necromanzie WHERE idutente=$idutente";
		$Result=mysql_query($Mysql);
		$res=mysql_fetch_array($Result);
		if ($res['m']=='' ) {$newprimary=1;} else { $newprimary = $res['m']+1 ; }


		$Mysql = "INSERT INTO necromanzie ( idnecro, idutente, livello, principale ) VALUES (  $idnecro, $idutente, 1, $newprimary)";
		$Result=mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );


		if ($newprimary == 1 ) {
			$Mysql = "INSERT INTO discipline ( iddisciplina, idutente, livello, DiClan ) VALUES (  99, $idutente, 1, 'N') ";
			$Result=mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		}else {

			$Mysql = "SELECT livello FROM necromanzie  WHERE principale = 1  AND idutente = $idutente";
			$Result = mysql_query($Mysql);
			$Res=mysql_fetch_array($Result);
			$x1=$Res['livello'];

			if ( $x1 < 5 ) {
				$newtaum = $x1;
			}else{
				$Mysql = "SELECT livello FROM necromanzie  WHERE principale = 2  AND idutente = $idutente";
				$Result = mysql_query($Mysql);
				$Res=mysql_fetch_array($Result);
				$x2=$Res['livello'];
				if ($x2 == '') { $x2=0; }
				$newtaum = $x1+$x2;
			}

			$Mysql = "UPDATE discipline SET livello = $newtaum WHERE iddisciplina = 99  AND idutente = $idutente";
			$Result = mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
		}
		$Mysql = "UPDATE personaggio SET xpspesi = xpspesi+$pxspesi WHERE idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$azione="Acquisita ".$disc;
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, -$pxspesi, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
	}

	if ( isset ($_POST ['FDV'] )) { //aumenta FDV

		$pxspesi=($fdv+1)*4;

		$Mysql = "UPDATE personaggio SET xpspesi = xpspesi+$pxspesi , fdv = fdv +1 WHERE idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$azione="Forza di Volontà a ".($fdv+1);
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, -$pxspesi, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );


	}

	if ( isset ($_POST ['ImparaRituale'] )) { //prendi rituale

		$pxspesi=$_POST ['costo'];
		$idrituale=$_POST ['idrituale'];

		$Mysql = "INSERT INTO rituali_t (idrituale, idutente) VALUES ($idrituale, $idutente)";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$Mysql = "UPDATE personaggio SET xpspesi = xpspesi+$pxspesi  WHERE idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$azione="Acquisito  rituale ".$idrituale;
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, -$pxspesi, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );


	}

	if ( isset ($_POST ['ImparaRitualeN'] )) { //prendi rituale

		$pxspesi=$_POST ['costo'];
		$idrituale=$_POST ['idrituale'];

		$Mysql = "INSERT INTO rituali_n (idrituale, idutente) VALUES ($idrituale, $idutente)";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$Mysql = "UPDATE personaggio SET xpspesi = xpspesi+$pxspesi  WHERE idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$azione="Acquisito  rituale ".$idrituale;
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, -$pxspesi, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );


	}

	if ( isset ($_POST ['BP'] )) { //aumenta FDV

		$pxspesi=($bloodp+1)*4;

		$Mysql = "UPDATE personaggio SET xpspesi = xpspesi+$pxspesi , bloodp = bloodp +1 WHERE idutente = $idutente";
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		$azione="Blood Potency a ".($bloodp+1);
		$Mysql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, -$pxspesi, '$azione' )" ;
		$Result = mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );


	}

	session_write_close();
	header("Location: ../spendipx.php", true);











?>
