<?php
	include ('session_start.inc.php');
	include ('db_start.inc.php');

	if (!isset ($_SESSION['idutente'])) {
		//die ("Errore, nessuna sessione attiva!");
		session_write_close();
		header("Location: index.php", true);
	}

	$idutente=$_SESSION['idutente'];

//	$idutente = 1;


	$MySql = "SELECT *  FROM HUNTERpersonaggio
		LEFT JOIN HUNcospiracy ON HUNTERpersonaggio.idclan=HUNcospiracy.idcospiracy
		WHERE idutente = $idutente ";

	$Result = mysql_query($MySql);
	$res = mysql_fetch_array($Result);

	$nome=$res['nomepg'];
	$nomeplayer=$res['nomeplayer'];

	$clan=$res['nomecospiracy'];
	$idstatus=$res['idstatus'];


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
	$fdvmax=$res['fdvmax'];
	$status=$res['status'];




	$fama1=$res['fama1']; //città
	$fama2=$res['fama2']; //vamp
	$fama3=$res['fama3'];  //wod

	$xp=$res['xp'];
	$xpspesi=$res['xpspesi'];

	//
	$rifugio = $res['rifugio'];
	$zona = $res['zona'];


	if ( $idstatus == 1 ) {
		$status = $res['lvl1'];
	} elseif ($idstatus == 2) {
		$status = $res['lvl2'];
	} elseif ($idstatus == 3) {
		$status = $res['lvl3'];
	}


	// PF

	$Mysql="SELECT * from skill where idskill=28 and idutente=$idutente";
	$Result = mysql_query($Mysql);
	if ( $res=mysql_fetch_array($Result)) {
		$schivare=$res['livello'];
	}
	$pf = (3+$attutimento)*2 +  $schivare ;


	// ferita permanente -3 PF
	$Mysql="SELECT * from pregidifetti where idpregio =11 and idutente=$idutente";
	$Result=mysql_query($Mysql);
	if ( $res=mysql_fetch_array($Result)) {
		$pf=$pf-3;
	}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Notturna - Cronaca di Roma</title>
	<link href="https://fonts.googleapis.com/css?family=Libre+Baskerville" rel="stylesheet">
	<link href="w3.css" rel="stylesheet" >
	<style>
		@font-face {
			font-family:Percolator;
			src:url(fonts/Percolator.otf)
		}
		@font-face {
			font-family:Percolator expert;
			src:url(fonts/PercolatorExpert.otf)
		}
		@font-face{
			font-family:Goudy Old Style;
			src:url(fonts/GoudyOldStyle.ttf)
		}
		@font-face{
			font-family:Dots;
			src:url(fonts/Dots.otf)
		}

		body {
			font-family: arial, sans-serif;
		}
		hr {
			border-top: 1px solid #000000;
			margin-top: 0.2em;
    		margin-bottom: 0.2em;
		}
		.ald {
			text-align:right;
		}
		.alc {
			text-align:center;
		}
		.vat {
			vertical-align:top;
		}
		table {
			border-collapse: collapse;
			border-spacing: 0;
			margin: 0 auto;
		}

		/* valign */
		.val { vertical-align: top; }

		img {
			border: 0px;
			margin: 0px;
		}
		.owner {
			font-family: 'Libre Baskerville';
			font-size: 105%;
			font-weight: bold;
		}
		.title2 {
			font-size: 105%;
			font-weight: bold;
		}

	</style>
</head>
<body>
	<div align="center">
	<table>
		<tr>
			<td width="65">&nbsp;</td>
			<td width="209">&nbsp;</td>
			<td width="70">&nbsp;</td>
			<td width="180">&nbsp;</td>
			<td width="25">&nbsp;</td>
			<td width="190">&nbsp;</td>
			<td width="60">&nbsp;</td>
		</tr>
		<tr>
			<td colspan=7><hr></td>
		</tr>
		<tr>
			<td>Nome</td>
			<td class="owner"><?=$nome?></td>
			<td>Player</td>
			<td><?=$nomeplayer?></td>
			<td>&nbsp;</td>
			<td>Forza di volontà</td>
			<td class="ald"><?=$fdv?>/<?=$fdvmax?></td>
		</tr>
		<tr>
			<td>Cospiracy</td>
			<td><?=$clan?></td>
			<td>Status</td>
			<td><?=$status?> </td>
			<td>&nbsp;</td>
			<td>Res. Dominazione</td>
			<td class="ald"><?= floor(($intelligenza+$prontezza+$percezione+$carisma+$fdv)/5)?></td>
		</tr>
		<tr>
			<td>XP</td>
			<td ><?=$xp." (spesi ".$xpspesi.")"?></td>
			<td colspan=3>&nbsp; </td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>

		<tr>
			<td>SafeHouse</td>
			<td><?=$rifugio?></td>
			<td>Zona</td>
			<td><?=$zona?></td>
			<td>&nbsp;</td>
			<td>Punti Ferita</td>
			<td class="ald"><?=$pf?></td>
		</tr>
<!--
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan=2 class="ald"><? /* for($i=0;$i<$ps; $i++) { echo '&EmptySmallSquare;';} */ ?></td>
		</tr>
-->
	</table>

	</div>
	<div align="center">
	<table>
		<tr>
			<td width="150">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="25">&nbsp;</td>
			<td width="150">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="25">&nbsp;</td>
			<td width="150">&nbsp;</td>
			<td width="100">&nbsp;</td>
		</tr>
		<tr>
			<td colspan=8 class="alc title2"><hr>Attributi<hr></td>
		</tr>
		<tr>
			<td colspan=2 class="alc">Fisici</td>
			<td>&nbsp;</td>
			<td colspan=2 class="alc">Sociali</td>
			<td>&nbsp;</td>
			<td colspan=2 class="alc">Mentali</td>
		</tr>
		<tr>
			<td>Forza</td>
			<td class="ald"><?
for ( $i = 0 ; $i < $forza; $i++) echo "<img src='img/dot.gif' width='10' height='10' >";
for ( $i = $forza ; $i < 5; $i++) echo "<img src='img/blank.gif' width='10' height='10' >";
?></td>
			<td>&nbsp;</td>
			<td>Carisma</td>
			<td class="ald"><?
for ( $i = 0 ; $i < $carisma; $i++) echo "<img src='img/dot.gif' width='10' height='10' >";
for ( $i = $carisma ; $i < 5; $i++) echo "<img src='img/blank.gif' width='10' height='10' >";
?></td>
			<td>&nbsp;</td>
			<td>Percezione</td>
			<td class="ald"><?
for ( $i = 0 ; $i < $percezione; $i++) echo "<img src='img/dot.gif' width='10' height='10' >";
for ( $i = $percezione ; $i < 5; $i++) echo "<img src='img/blank.gif' width='10' height='10' >";
?></td>
		</tr>
		<tr>
			<td>Destrezza</td>
			<td class="ald"><?
for ( $i = 0 ; $i < $destrezza; $i++) echo "<img src='img/dot.gif' width='10' height='10' >";
for ( $i = $destrezza ; $i < 5; $i++) echo "<img src='img/blank.gif' width='10' height='10' >";
?></td>
			<td>&nbsp;</td>
			<td>Persuasione</td>
			<td class="ald"><?
for ( $i = 0 ; $i < $persuasione; $i++) echo "<img src='img/dot.gif' width='10' height='10' >";
for ( $i = $persuasione ; $i < 5; $i++) echo "<img src='img/blank.gif' width='10' height='10' >";
?></td>
			<td>&nbsp;</td>
			<td>Intelligenza</td>
			<td class="ald"><?
for ( $i = 0 ; $i < $intelligenza; $i++) echo "<img src='img/dot.gif' width='10' height='10' >";
for ( $i = $intelligenza ; $i < 5; $i++) echo "<img src='img/blank.gif' width='10' height='10' >";
?></td>
		</tr>
		<tr>
			<td>Attutimento</td>
			<td class="ald"><?
for ( $i = 0 ; $i < $attutimento; $i++) echo "<img src='img/dot.gif' width='10' height='10' >";
for ( $i = $attutimento ; $i < 5; $i++) echo "<img src='img/blank.gif' width='10' height='10' >";
?></td>
			<td>&nbsp;</td>
			<td>Saggezza</td>
			<td class="ald"><?
for ( $i = 0 ; $i < $saggezza; $i++) echo "<img src='img/dot.gif' width='10' height='10' >";
for ( $i = $saggezza ; $i < 5; $i++) echo "<img src='img/blank.gif' width='10' height='10' >";
?></td>
			<td>&nbsp;</td>
			<td>Prontezza</td>
			<td class="ald"><?
for ( $i = 0 ; $i < $prontezza; $i++) echo "<img src='img/dot.gif' width='10' height='10' >";
for ( $i = $prontezza ; $i < 5; $i++) echo "<img src='img/blank.gif' width='10' height='10' >";
?></td>
		</tr>
	</table>
	</div>


	<div align="center">
	<table>
		<tr>
			<td width="190">&nbsp;</td>
			<td width="60">&nbsp;</td>
			<td width="25">&nbsp;</td>
			<td width="190">&nbsp;</td>
			<td width="60">&nbsp;</td>
			<td width="25">&nbsp;</td>
			<td width="190">&nbsp;</td>
			<td width="60">&nbsp;</td>
		</tr>
		<tr>
			<td colspan=8 class="alc title2"><hr>Equipaggiamento potenziato, Elisir, Reliquie<hr></td>
		</tr>


		<? ///DISCIPLINE

			$MySql = "SELECT  nomedisc ,livello, HUNdiscipline.iddisciplina, maxlvl  FROM HUNdiscipline
          		LEFT JOIN HUNdiscipline_main ON HUNdiscipline_main.iddisciplina=HUNdiscipline.iddisciplina
          		WHERE idutente = $idutente
          		ORDER BY HUNdiscipline.iddisciplina";
			$Results = mysql_query($MySql);
			if (mysql_errno())  die ( mysql_errno().": ".mysql_error() );
			$num_rows = mysql_num_rows($Results);

			for ( $i=0; $i < floor($num_rows/3) ; $i++) {
				$res = mysql_fetch_array($Results);
?>
		<tr>
			<td class="vat"><?=$res['nomedisc']?>

			</td>
			<td class="ald vat" >
<?
				for ( $j = 0 ; $j < $res['livello']; $j++) echo "<img src='img/dot.gif' width='10' height='10' >";
				for ( $j = $res['livello'] ; $j < $res['maxlvl']; $j++) echo "<img src='img/blank.gif' width='10' height='10' >";

?>
			</td>
			<td>&nbsp;</td>
<?
				$res = mysql_fetch_array($Results);
?>
			<td class="vat"><?=$res['nomedisc']?>

			</td>
			<td class="ald vat" >
<?
			for ( $j = 0 ; $j < $res['livello']; $j++) echo "<img src='img/dot.gif' width='10' height='10' >";
			for ( $j = $res['livello'] ; $j < $res['maxlvl']; $j++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
			<td>&nbsp;</td>
<?
				$res = mysql_fetch_array($Results);
?>
			<td class="vat"><?=$res['nomedisc']?>

			</td>
			<td class="ald vat" >
<?
				for ( $j = 0 ; $j < $res['livello']; $j++) echo "<img src='img/dot.gif' width='10' height='10' >";
				for ( $j = $res['livello'] ; $j <  $res['maxlvl']; $j++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
		</tr>
<?
			}
?>
		<tr>
<?
			$r=0;
			for ( $k=0; $k < $num_rows-$i*3 ; $k++) {
				$res = mysql_fetch_array($Results);
?>
			<td class="vat"><?=$res['nomedisc']?>

			</td>
			<td class="ald vat">
<?
				for ( $j = 0 ; $j < $res['livello']; $j++) echo "<img src='img/dot.gif' width='10' height='10' >";
				for ( $j = $res['livello'] ; $j <  $res['maxlvl']; $j++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
			<td>&nbsp;</td>
<?
				$r=$r+3;
			}
			for ( ; $r < 9 ; $r++) {
?>
			<td>&nbsp;</td>
<?
			}
?>
		</tr>


		</table>
	</div>



	<!--- COMPETENZE -->
	<div align="center">
	<table>
		<tr>
			<td width="150">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="25">&nbsp;</td>
			<td width="150">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="25">&nbsp;</td>
			<td width="150">&nbsp;</td>
			<td width="100">&nbsp;</td>
		</tr>
		<tr>
			<td colspan=8 class="alc title2"><hr>Competenze<hr></td>
		</tr>
<?
		$Mysql = "SELECT COUNT(*) FROM skill_main WHERE tipologia = 0";
		$res = mysql_fetch_array ( mysql_query($Mysql) ) ;
		$num_rows= $res[0];

		$Mysql="SELECT * FROM skill_main LEFT JOIN skill ON skill_main.idskill = skill.idskill AND skill.idutente = $idutente WHERE tipologia = 0 ORDER BY nomeskill";
		$Result=mysql_query($Mysql);
		for ( $i=0; $i < floor($num_rows/3)+1 ;$i++)  {
			$res=mysql_fetch_array($Result);
			$liv = $res['livello'];
			if ($liv=='') $liv=0;
?>
		<tr>
			<td><?=$res['nomeskill']?></td>
			<td class="ald"><?
				for ( $j = 0 ; $j < $liv; $j++) echo "<img src='img/dot.gif' width='10' height='10' >";
				for ( $j = $liv ; $j < 5; $j++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
			<td>&nbsp;</td>
<?
			$res=mysql_fetch_array($Result);
			$liv = $res['livello'];
			if ($liv=='') $liv=0;
?>
			<td><?=($res['nomeskill']!=''?$res['nomeskill']:"___________") ?></td>
			<td class="ald"><?
				for ( $j = 0 ; $j < $liv; $j++) echo "<img src='img/dot.gif' width='10' height='10' >";
				for ( $j = $liv ; $j < 5; $j++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
			<td>&nbsp;</td>
<?
			$res=mysql_fetch_array($Result);
			$liv = $res['livello'];
			if ($liv=='') $liv=0;
?>
			<td><?=($res['nomeskill']!=''?$res['nomeskill']:"___________") ?></td>
			<td class="ald"><?
				for ( $j = 0 ; $j < $liv; $j++) echo "<img src='img/dot.gif' width='10' height='10' >";
				for ( $j = $liv ; $j < 5; $j++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
		</tr>
<?		}	?>

	</table>
	</div>
		<!--- Attitudini -->
	<div align="center">
	<table>
		<tr>
			<td width="150">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="25">&nbsp;</td>
			<td width="150">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="25">&nbsp;</td>
			<td width="150">&nbsp;</td>
			<td width="100">&nbsp;</td>
		</tr>
		<tr>
			<td colspan=8 class="alc title2"><hr>Attitudini<hr></td>
		</tr>
<?
		$Mysql = "SELECT COUNT(*) FROM skill_main WHERE tipologia = 1";
		$res = mysql_fetch_array ( mysql_query($Mysql) ) ;
		$num_rows= $res[0];

		$Mysql="SELECT * FROM skill_main LEFT JOIN skill ON skill_main.idskill = skill.idskill AND skill.idutente = $idutente WHERE tipologia = 1 ORDER BY nomeskill";
		$Result=mysql_query($Mysql);
		for ( $i=0; $i < floor($num_rows/3) ;$i++)  {
			$res=mysql_fetch_array($Result);
			$liv = $res['livello'];
			if ($liv=='') $liv=0;
?>
		<tr>
			<td><?=$res['nomeskill']?></td>
			<td class="ald"><?
				for ( $j = 0 ; $j < $liv; $j++) echo "<img src='img/dot.gif' width='10' height='10' >";
				for ( $j = $liv ; $j < 5; $j++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
			<td>&nbsp;</td>
<?
			$res=mysql_fetch_array($Result);
			$liv = $res['livello'];
			if ($liv=='') $liv=0;
?>
			<td><?=$res['nomeskill']?></td>
			<td class="ald"><?
				for ( $j = 0 ; $j < $liv; $j++) echo "<img src='img/dot.gif' width='10' height='10' >";
				for ( $j = $liv ; $j < 5; $j++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
			<td>&nbsp;</td>
<?
			$res=mysql_fetch_array($Result);
			$liv = $res['livello'];
			if ($liv=='') $liv=0;
?>
			<td><?=$res['nomeskill']?></td>
			<td class="ald"><?
				for ( $j = 0 ; $j < $liv; $j++) echo "<img src='img/dot.gif' width='10' height='10' >";
				for ( $j = $liv ; $j < 5; $j++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
		</tr>
<?		}	?>

	</table>
	</div>
		<!--- background -->
	<div align="center">
	<table>
		<tr>
			<td width="145">&nbsp;</td>
			<td width="105">&nbsp;</td>
			<td width="25">&nbsp;</td>
			<td width="145">&nbsp;</td>
			<td width="105">&nbsp;</td>
			<td width="25">&nbsp;</td>
			<td width="145">&nbsp;</td>
			<td width="105">&nbsp;</td>
		</tr>
		<tr>
			<td colspan=8 class="alc title2"><hr>Background<hr></td>
		</tr>
<? ///background

			$MySql = "SELECT  nomeback ,livello  FROM background
          		LEFT JOIN background_main ON background_main.idback=background.idback
          		WHERE idutente = $idutente";
			$Results = mysql_query($MySql);
			if (mysql_errno())  die ( mysql_errno().": ".mysql_error() );
			$num_rows = mysql_num_rows($Results);

			for ( $i=0; $i < floor($num_rows/3) ; $i++) {
				$res = mysql_fetch_array($Results);
?>
		<tr>
			<td><?=$res['nomeback']?></td>
			<td class="ald" >
<?
				for ( $j = 0 ; $j < $res['livello']; $j++) echo "<img src='img/dot.gif' width='10' height='10' >";
				for ( $j = $res['livello'] ; $j < 5; $j++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
			<td>&nbsp;</td>
<?
				$res = mysql_fetch_array($Results);
?>
			<td><?=$res['nomeback']?></td>
			<td class="ald" >
<?
			for ( $j = 0 ; $j < $res['livello']; $j++) echo "<img src='img/dot.gif' width='10' height='10' >";
			for ( $j = $res['livello'] ; $j < 5; $j++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
			<td>&nbsp;</td>
<?
				$res = mysql_fetch_array($Results);
?>
			<td><?=$res['nomeback']?></td>
			<td class="ald" >
<?
				for ( $j = 0 ; $j < $res['livello']; $j++) echo "<img src='img/dot.gif' width='10' height='10' >";
				for ( $j = $res['livello'] ; $j < 5; $j++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
		</tr>
<?
			}
			if (floor($num_rows/3)*3 !=$num_rows ) {
?>
		<tr>
<?
				$r=0;
				for ( $k=0; $k < $num_rows-$i*3 ; $k++) {
					$res = mysql_fetch_array($Results);
?>
			<td><?=$res['nomeback']?></td>
			<td class="ald">
<?
					for ( $j = 0 ; $j < $res['livello']; $j++) echo "<img src='img/dot.gif' width='10' height='10' >";
					for ( $j = $res['livello'] ; $j < 5; $j++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
			<td>&nbsp;</td>
<?
					$r=$r+3;
				}
				for ( ; $r < 9 ; $r++) {
?>
			<td>&nbsp;</td>
<?
				}
?>
		</tr>
<?
			}
	 //FINE background

  //contatti
	   		$MySql = "SELECT  nomecontatto, livello  FROM contatti WHERE idutente = $idutente ";

			$Results = mysql_query($MySql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );

			$num_rows = mysql_num_rows($Results);

			if ( $num_rows > 0 ) {
?>
		<tr>
			<td colspan=8>&nbsp;</td>
		</tr>
		<tr>
			<td colspan=8 class="alc title2">Contatti<hr></td>
		</tr>
<?
			for ( $i=0; $i < floor($num_rows/3) ; $i++) {
				$res = mysql_fetch_array($Results);
?>
		<tr>
			<td><?=$res['nomecontatto']?></td>
			<td class="ald" >
<?
				for ( $j = 0 ; $j < $res['livello']; $j++) echo "<img src='img/dot.gif' width='10' height='10' >";
				for ( $j = $res['livello'] ; $j < 5; $j++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
			<td>&nbsp;</td>
<?
				$res = mysql_fetch_array($Results);
?>
			<td ><?=$res['nomecontatto']?></td>
			<td class="ald" >
<?
				for ( $j = 0 ; $j < $res['livello']; $j++) echo "<img src='img/dot.gif' width='10' height='10' >";
				for ( $j = $res['livello'] ; $j < 5; $j++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
			<td>&nbsp;</td>
<?
				$res = mysql_fetch_array($Results);
?>
			<td><?=$res['nomecontatto']?></td>
			<td class="ald" >
<?
				for ( $j = 0 ; $j < $res['livello']; $j++) echo "<img src='img/dot.gif' width='10' height='10' >";
				for ( $j = $res['livello'] ; $j < 5; $j++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
		</tr>
<?
			}
			if (floor($num_rows/3)*3 != $num_rows ) {
?>
		<tr>
<?
				$r=0;
				for ( $k=floor($num_rows/3)*3; $k < $num_rows ; $k++) {
					$res = mysql_fetch_array($Results);
?>
			<td><?=$res['nomecontatto']?></td>
			<td class="ald">
<?
					for ( $j = 0 ; $j < $res['livello']; $j++) echo "<img src='img/dot.gif' width='10' height='10' >";
					for ( $j = $res['livello'] ; $j < 5; $j++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
			<td>&nbsp;</td>
<?
					$r=$r+3;
				}
				for ( ; $r < 9 ; $r++) {
?>
			<td>&nbsp;</td>
<?
				}
?>
		</tr>
<?
			}
	}
?>
		</table>
	</div>
<!--- pregi e difetti -->


	<div align="center">
	<table>
		<tr>
			<td width="185">&nbsp;</td>
			<td width="25">&nbsp;</td>
			<td width="65">&nbsp;</td>
			<td width="185">&nbsp;</td>
			<td width="25">&nbsp;</td>
			<td width="65">&nbsp;</td>
			<td width="185">&nbsp;</td>
			<td width="25">&nbsp;</td>
			<td width="40">&nbsp;</td>
		</tr>
		<tr>
			<td colspan=9 class="alc title2"><hr>Pregi e Difetti<hr></td>
		</tr>
<?

			$MySql = "SELECT  nomepregio ,valore FROM pregidifetti
      			LEFT JOIN pregidifetti_main ON pregidifetti_main.idpregio=pregidifetti.idpregio
          		WHERE idutente = '$idutente' ORDER BY valore DESC";
			$Results = mysql_query($MySql);
			if (mysql_errno())  die ( mysql_errno().": ".mysql_error() );
			$num_rows = mysql_num_rows($Results);

			for ( $i=0; $i < floor($num_rows/3) ; $i++) {
				$res = mysql_fetch_array($Results);
?>
		<tr>
			<td><?=$res['nomepregio']?></td>
			<td class="ald"><?=$res['valore']?></td>
			<td>&nbsp;</td>
<?
				$res = mysql_fetch_array($Results);
?>
			<td><?=$res['nomepregio']?></td>
			<td class="ald"><?=$res['valore']?></td>
			<td>&nbsp;</td>
<?
				$res = mysql_fetch_array($Results);
?>
			<td><?=$res['nomepregio']?></td>
			<td class="ald"><?=$res['valore']?></td>
			<td>&nbsp;</td>
		</tr>
<?
			}
			if (floor($num_rows/3)*3 !=$num_rows ) {
?>
		<tr>
<?
				$r=0;
				for ( $k=0; $k < $num_rows-$i*3 ; $k++) {
					$res = mysql_fetch_array($Results);
?>
			<td><?=$res['nomepregio']?></td>
			<td class="ald"><?=$res['valore']?></td>
			<td>&nbsp;</td>
<?
					$r=$r+3;
				}
				for ( ; $r < 9 ; $r++) {
?>
			<td>&nbsp;</td>
<?
				}
?>
		</tr>
<?
			}
?>
		<tr>
			<td colspan=9 >&nbsp;</td>
		</tr>
		<tr>
			<td colspan=9 >&nbsp;</td>
		</tr>
		<tr>
			<td colspan=9 ><button class="w3-btn w3-white w3-border w3-border-red w3-round w3-block" onclick="javascript:window.location.href='scheda3H.php'">Versione per Stampa</button></td>
		</tr>
		<tr>
			<td colspan=9 ><button class="w3-btn w3-white w3-border w3-border-blue w3-round w3-block" onclick="javascript:window.location.href='main.php'">Indietro</button></td>
		</tr>
	</table>
	</div>
	<p>&nbsp;
	<p>&nbsp;
	<p>&nbsp;
</body>
