<?php

include ('../session_start.inc.php');
include ('../db_start.inc.php');

if (!isset ($_SESSION['idutente'])) die ("Errore, nessuna sessione attiva!");

$idutente=$_SESSION['idutente'];

if (!isset($_POST) ) die ( "No post!");

$MySql="SELECT * FROM personaggio WHERE idutente=$idutente";
$Result=mysql_query($MySql);
$res=mysql_fetch_array($Result);
$oldstatus=$res['idstatus'];
$oldbp=$res['bloodp'];
$gen=$res['generazione'];

$MySql="SELECT * FROM statuscama WHERE idstatus=$oldstatus";
$Result=mysql_query($MySql);
$res=mysql_fetch_array($Result);
$oldbp1=$res['addbp'];

$MySql="SELECT * FROM statuscama WHERE idstatus=$oldstatus+1";
$Result=mysql_query($MySql);
$res=mysql_fetch_array($Result);
$newbp1=$res['addbp'];

$MySql="SELECT * FROM generazione WHERE generazione=$gen";
$Result=mysql_query($MySql);
$res=mysql_fetch_array($Result);
$maxbp=$res['bloodpmax'];



$newbp=$oldbp+$newbp1-$oldbp1;

//die("oldbp ".$oldbp."newbp1 ".$newbp1."oldbp1 ".$newbp1)."maxbp ".$maxbp;

if($newbp > $maxbp) { $newbp=$maxbp ;}


$MySql="UPDATE personaggio SET idstatus = idstatus+1 , bloodp = $newbp WHERE idutente=$idutente";
mysql_query($MySql);
if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

$azione="Aumento Status";
$MySql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, 0, '$azione' )" ;
mysql_query($MySql);
if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

$newfdv=1;
if ($oldstatus==4) $newfdv=2;

$MySql="UPDATE personaggio SET fdvmax = fdvmax+$newfdv WHERE idutente=$idutente";
mysql_query($MySql);

$azione="Aumento Status -> FDVMAX +".$newfdv;
$MySql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, 0, '$azione' )" ;
mysql_query($MySql);
if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );


$MySql="SELECT skill_main.idskill , nomeskill, livello FROM skill_main LEFT JOIN skill ON skill_main.idskill = skill.idskill AND idutente = $idutente WHERE tipologia =0";
$Result=mysql_query($MySql);
	while ($res=mysql_fetch_array($Result)) {

		$skill=$res['idskill'];
		$fx='F'.$res['idskill'];
		$rx=$res['livello'] ;
		if ($rx=="" ) $rx=0;

		//echo $fx."<br>";
		//echo "post ".$_POST[$fx]. " liv ".$res['livello'];

		if ($_POST[$fx] != $rx ) {

			$newliv=$_POST[$fx];

			if ($rx == 0 ) {
				//echo $res['nomeskill']." aggiunto <br>";
				$MySql = "INSERT INTO skill ( idutente, idskill, livello) VALUES ( $idutente, $skill, $newliv )" ;
				mysql_query($MySql);
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

				$azione="Aumento Status -> aggiunto ".$res['nomeskill']." ".$newliv;
				$MySql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, 0, '$azione' )" ;
				mysql_query($MySql);
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

			} else {
				//echo $res['nomeskill']." cambiato <br>";
				$MySql = "UPDATE skill SET livello = $newliv WHERE idutente=$idutente AND idskill=$skill" ;
				mysql_query($MySql);
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

				$azione="Aumento Status -> modificato ".$res['nomeskill']." ".$newliv;
				$MySql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, 0, '$azione' )" ;
				mysql_query($MySql);
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
			}
		}


}

	if ( 0 > 0 ) {



		$MySql = "INSERT INTO logpx ( idutente, px, azione) VALUES ( $idutente, $newpx, 'ADD' )" ;
		$Result = mysql_query($MySql);


	}

	session_write_close();
	header("Location: ../bg.php", true);


?>
