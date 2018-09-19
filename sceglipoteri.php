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


	$MySql = "SELECT *  FROM personaggio
		LEFT JOIN clan ON personaggio.idclan=clan.idclan
		LEFT JOIN statuscama ON personaggio.idstatus=statuscama.idstatus
		LEFT JOIN sentieri ON personaggio.idsentiero=sentieri.idsentiero
		LEFT JOIN generazione ON personaggio.generazione=generazione.generazione
		WHERE idutente = $idutente ";

	$Result = mysql_query($MySql);
	$res = mysql_fetch_array($Result);

	$nome=$res['nomepg'];
	$nomeplayer=$res['nomeplayer'];

	$clan=$res['nomeclan'];
	$generazione=$res['generazione'];

	$ps=$res['ps'];
	$psturno=$res['psturno'];

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
	$attivstatus=$res['attivazione'];

	$valsentiero=$res['valsentiero'];
	$sentiero=$res['sentiero'];


	$fama1=$res['fama1']; //città
	$fama2=$res['fama2']; //vamp
	$fama3=$res['fama3'];  //wod

	$xp=$res['xp'];
	$xpspesi=$res['xpspesi'];

	//
	$rifugio = $res['rifugio'];
	$zona = $res['zona'];
	// PF


	if ( $_POST['AddPotere']) {
		//echo "ADDpotere ".$_POST['AddPotere'] ;
		$idp=$_POST['AddPotere'];

		$Mysqlx="INSERT INTO poteri (idpotere, idutente) values ($idp, $idutente)";
		mysql_query($Mysqlx);
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
		.title {
			font-family: 'Libre Baskerville';
			font-size: 110%;
			font-weight: bold;
		}
		.title2 {
			font-size: 105%;
			font-weight: bold;
		}

	</style>
</head>
<body>

	<div align=center>
	<table>
		<tr>
			<td width="250">&nbsp;</td>
			<td width="70">&nbsp;</td>
			<td width="250">&nbsp;</td>
			<td width="70">&nbsp;</td>
			<td width="70">&nbsp;</td>
			<td width="160">&nbsp;</td>
		</tr>
		<tr>
			<td colspan=7 class="alc title"><hr>Scelta Poteri<hr></td>
		</tr>

<?
	$MySql = "SELECT *  FROM discipline
	LEFT JOIN discipline_main ON discipline.iddisciplina = discipline_main.iddisciplina
	WHERE idutente = $idutente AND livello > 0
	AND discipline.iddisciplina != 98 and discipline.iddisciplina != 99 ";

	$Result = mysql_query($MySql);

	while ( $res = mysql_fetch_array($Result)) {

		$numpallini = $res['livello'];
		$disc = $res['iddisciplina'];
		$nomedisc = $res['nomedisc'];

?>
<tr>
	<td colspan=8 class="alc title2"><?= $nomedisc ?> (Liv. <?= $numpallini ?> )</td>
</tr>


<?
		$numpot=0;
		$Mysql2 = "SELECT *  from poteri
			LEFT JOIN poteri_main ON poteri.idpotere=poteri_main.idpotere
			WHERE poteri_main.iddisciplina = $disc AND poteri.idutente=$idutente
			ORDER BY livellopot ASC";

		$Result2 = mysql_query($Mysql2);
		while ( $res2=mysql_fetch_array($Result2) ) {
			$numpot++;

			?>
			<tr>
				<td width="250"><?= $res2['nomepotere'] ?></td>
				<td width="70">- <?= $res2['livellopot'] ?> -</td>
				<td width="250">&nbsp;</td>
				<td width="70">&nbsp;</td>
				<td width="70">&nbsp;</td>
				<td width="160">&nbsp;</td>
			</tr>
			<?

		}

		if ( $numpot <  $numpallini ) {
			$newpot=$numpot+1;
			?>
			<tr>
				<td colspan=7 class="alc">Devi ancora scegliere un potere di livello minore o uguale a - <?= $newpot ?> -</td>


			</tr>

			<form method="post" action="" name="poteri<?=$disc?>">
				<tr>
						<td colspan=1>	<input type=submit value="Scegli"> </td>
						<td colspan=3> <select name="AddPotere" >

			<?

			$Mysql3 = "SELECT *  from poteri_main
				WHERE iddisciplina = $disc
				AND idpotere NOT IN ( SELECT idpotere from poteri where idutente=$idutente)
				AND livellopot <= $newpot
				ORDER BY livellopot DESC";
			$Result3 = mysql_query ($Mysql3);
			while ($res3=mysql_fetch_array($Result3)) {
				$disabled=0;
				if ($res3['discprereq']!="") {
					 $dp= $res3['discprereq'];
					 $ldp= $res3['livdiscprereq'];
					 $Mysql4="SELECT count(*) as c from discipline WHERE iddisciplina=$dp AND idutente=$idutente and livello>=$ldp ";
					 $Result4=mysql_query($Mysql4);
					 $res4=mysql_fetch_array($Result4);
					 if ($res4['c']==0) { $disabled=1;}
				}
				if ($res3['skillprereq']!="") {
					 $dp= $res3['skillprereq'];
					 $ldp= $res3['livskillprereq'];
					 $Mysql4="SELECT count(*) as c from skill WHERE idskill=$dp AND idutente=$idutente and livello>=$ldp ";
					 $Result4=mysql_query($Mysql4);
					 $res4=mysql_fetch_array($Result4);
					 if ($res4['c']==0) { $disabled=1;}
				}
				if ($res3['attrprereq']!="") {
					 $dp= $res3['attrprereq'];
					 $ldp= $res3['livattrprereq'];
					 if ( $$dp< $ldp) { $disabled=1;}
				}

				if ($res3['potereprereq']!="") {
					 $dp= $res3['potereprereq'];
					 $Mysql4="SELECT count(*) as c from poteri WHERE idpotere=$dp AND idutente=$idutente  ";
					 $Result4=mysql_query($Mysql4);
					 $res4=mysql_fetch_array($Result4);
					 if ($res4['c']==0) { $disabled=1;}
				}

				?>
					<option value="<?=$res3['idpotere']?>" <?=$disabled==1?"disabled":""?> > <?="(".$res3['livellopot'].") ".$res3['nomepotere']?></option>


				<?
				//echo "(".$res3['livellopot'].") ".$res3['nomepotere']."- ".$res3['idpotere']."disabled=".$disabled."<br>";
			}

			?>
				</select>
			</td>
			<td colspan=3>&nbsp;</td>
		</tr>
			</form>
			<?
		}

		?>
		<tr>
			<td colspan=7 class="alc title"><hr></td>
		</tr>
		<?


	}
?>

<tr>
	<td colspan=8 >&nbsp;</td>
</tr>
<tr>
	<td colspan=8 >&nbsp;</td>
</tr>
<tr>
	<td colspan=8 ><button class="w3-btn w3-white w3-border w3-border-blue w3-round w3-block" onclick="javascript:window.location.href='main.php'">Indietro</button></td>
</tr>
</table>
</div>
<p>&nbsp;
<p>&nbsp;
<p>&nbsp;
</body>
