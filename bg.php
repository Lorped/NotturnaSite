<?php
	include ('session_start.inc.php');
	include ('db_start.inc.php');


	if (!isset ($_SESSION['idutente'])) {
		// die ("Errore, nessuna sessione attiva!");
		session_write_close();
		header("Location: index.php", true);
	}


	$idutente=$_SESSION['idutente'];




	$MySql = "SELECT *  FROM personaggio
		LEFT JOIN clan ON personaggio.idclan=clan.idclan
		LEFT JOIN statuscama ON personaggio.idstatus=statuscama.idstatus
		LEFT JOIN sentieri ON personaggio.idsentiero=sentieri.idsentiero
		LEFT JOIN generazione ON personaggio.generazione=generazione.generazione
		WHERE idutente = $idutente ";

	$Result = mysql_query($MySql);
	$res = mysql_fetch_array($Result);

	$nome=$res['nomepg'];

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
	$idstatus=$res['idstatus'];
	$attivazione=$res['attivazione'];

	$valsentiero=$res['valsentiero'];
	$sentiero=$res['sentiero'];
	$idsentiero=$res['idsentiero'];


	$fama1=$res['fama1']; //città
	$fama2=$res['fama2']; //vamp
	$fama3=$res['fama3'];  //wod

	$xp=$res['xp'];
	$xpspesi=$res['xpspesi'];


	$MAXSTAT=$res['maxstat'];

	$maxdisctab  = [
		[ 2, 3, 3, 4,  4,  5,  5 ,6,7,8,9],
		[ 3, 3, 4, 4 , 5 , 5 , 5 ,6,7,8,9],
		[ 3, 4, 5, 5 , 5 , 5 , 5 ,6,7,8,9],
		[ 4, 5, 5, 5 , 5 , 5 , 5 ,6,7,8,9],
		[ 4, 5, 5, 5 , 5 , 5 , 5 ,6,7,8,9],
		[ 5, 5, 5, 5 , 5 , 5 , 5 ,6,7,8,9]

	];

	$MAXSDISC=$maxdisctab[$idstatus][14-$generazione];

	$maxskilltab  = [
		[ 20, 20, 17, 15,  13 , 10 ,  5 , 5, 5, 5, 5],
		[ 33, 33, 27, 25,  20 , 15 , 10 ,10,10,10,10],
		[ 35, 35, 33, 30 , 25 , 20 , 15 ,15,15,15,15],
		[ 45, 45, 43, 40 , 35 , 30 , 20 ,20,20,20,20],
		[ 55, 55, 53, 50 , 45 , 40 , 30 ,30,30,30,30],
		[ 95, 95, 93, 90 , 80 , 70 , 50 ,50,50,50,50]
	];



	$NUMSKILL=$maxskilltab[$idstatus][14-$generazione];

	$MySql = "SELECT  nomeback ,livello , background.idback as xid FROM background
       		LEFT JOIN background_main ON background_main.idback=background.idback
       		WHERE idutente = $idutente";
	$Results = mysql_query($MySql);
	if (mysql_errno())  die ( mysql_errno().": ".mysql_error() );

	$Contatti=0;
	$Gregge=0;
	$Risorse=0;
	$Seguaci=0;
	$Notorieta=0;
	$Mentore=0;
	$Generazione=0;
	$Rifugio=0;

while ($res=mysql_fetch_array($Results) ) {

	$$res['nomeback']=$res['livello'];
	if ($res['xid']==4) $Notorieta=$res['livello'];
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
		/*	table td {
			border: 1px solid red;
		} */
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
		input[type=number] {
   			width:  80px;
   			-moz-appearance: textfield;
		}
		input[type=submit] {
    		width: 80px;
			padding: 0;
		}
		select {
    		width: 230px;
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
	<form id="f1_p" method="post" action="ws/fama.php"><input type="hidden" name="f1" value="1"></form>
	<form id="f1_m" method="post" action="ws/fama.php"><input type="hidden" name="f1" value="-1"></form>
	<form id="f2_p" method="post" action="ws/fama.php"><input type="hidden" name="f2" value="1"></form>
	<form id="f2_m" method="post" action="ws/fama.php"><input type="hidden" name="f2" value="-1"></form>
	<form id="f3_p" method="post" action="ws/fama.php"><input type="hidden" name="f3" value="1"></form>
	<form id="f3_m" method="post" action="ws/fama.php"><input type="hidden" name="f3" value="-1"></form>
	<!------ ------>
	<form id="Gregge_p" method="post" action="ws/back.php"><input type="hidden" name="do" value="1"><input type="hidden" name="id" value="1"></form>
	<form id="Gregge_m" method="post" action="ws/back.php"><input type="hidden" name="do" value="-1"><input type="hidden" name="id" value="1"></form>
	<form id="Risorse_p" method="post" action="ws/back.php"><input type="hidden" name="do" value="1"><input type="hidden" name="id" value="2"></form>
	<form id="Risorse_m" method="post" action="ws/back.php"><input type="hidden" name="do" value="-1"><input type="hidden" name="id" value="2"></form>
	<form id="Seguaci_p" method="post" action="ws/back.php"><input type="hidden" name="do" value="1"><input type="hidden" name="id" value="3"></form>
	<form id="Seguaci_m" method="post" action="ws/back.php"><input type="hidden" name="do" value="-1"><input type="hidden" name="id" value="3"></form>
	<form id="Notorieta_p" method="post" action="ws/back.php"><input type="hidden" name="do" value="1"><input type="hidden" name="id" value="4"></form>
	<form id="Notorieta_m" method="post" action="ws/back.php"><input type="hidden" name="do" value="-1"><input type="hidden" name="id" value="4"></form>
	<form id="Mentore_p" method="post" action="ws/back.php"><input type="hidden" name="do" value="1"><input type="hidden" name="id" value="6"></form>
	<form id="Mentore_m" method="post" action="ws/back.php"><input type="hidden" name="do" value="-1"><input type="hidden" name="id" value="6"></form>
	<form id="Rifugio_p" method="post" action="ws/back.php"><input type="hidden" name="do" value="1"><input type="hidden" name="id" value="8"></form>
	<form id="Rifugio_m" method="post" action="ws/back.php"><input type="hidden" name="do" value="-1"><input type="hidden" name="id" value="8"></form>
	<!------ ------>
	<div align=center>
	<table>
		<tr>
			<td width="100">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="100">&nbsp;</td>
		</tr>
		<tr>
			<td colspan=8 class="alc title">Nota - ogni modifica su questa pagina deve essere concordata con la Narrazione</td>
		</tr>
		<tr>
			<td colspan=8 class="alc title"><hr>Fama<hr></td>
		</tr>
		<tr>
			<td colspan=2>Fama in Città</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><button class="w3-btn w3-white w3-border w3-border-dark w3-round w3-block" <?= $fama1==0?'disabled':'' ?> onclick="document.getElementById('f1_m').submit();">Diminuisci</button></td>
			<td class="alc">
<?
	for ( $i = 0 ; $i < $fama1; $i++) echo "<img src='img/bluedot.gif' width='10' height='10' >";
	for ( $i = $fama1 ; $i < 5; $i++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
			<td><button class="w3-btn w3-white w3-border w3-border-red w3-round w3-block" <?= $fama1==5?'disabled':'' ?> onclick="document.getElementById('f1_p').submit();">Aumenta</button></td>

		</tr>
		<tr>
			<td colspan=2>Fama tra i Vampiri</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><button class="w3-btn w3-white w3-border w3-border-dark w3-round w3-block" <?= $fama2==0?'disabled':'' ?> onclick="document.getElementById('f2_m').submit();">Diminuisci</button></td>
			<td class="alc">
<?
	for ( $i = 0 ; $i < $fama2; $i++) echo "<img src='img/bluedot.gif' width='10' height='10' >";
	for ( $i = $fama2 ; $i < 5; $i++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
			<td><button class="w3-btn w3-white w3-border w3-border-red w3-round w3-block" <?= $fama2==5?'disabled':'' ?> onclick="document.getElementById('f2_p').submit();">Aumenta</button></td>
		</tr>
		<tr>
			<td colspan=2>Fama nel Mondo Oscuro</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><button class="w3-btn w3-white w3-border w3-border-dark w3-round w3-block" <?= $fama3==0?'disabled':'' ?> onclick="document.getElementById('f3_m').submit();">Diminuisci</button></td>
			<td class="alc">
<?
	for ( $i = 0 ; $i < $fama3; $i++) echo "<img src='img/bluedot.gif' width='10' height='10' >";
	for ( $i = $fama3 ; $i < 5; $i++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
			<td><button class="w3-btn w3-white w3-border w3-border-red w3-round w3-block" <?= $fama3==5?'disabled':'' ?> onclick="document.getElementById('f3_p').submit();">Aumenta</button></td>
		</tr>


		<tr>
			<td colspan=8>&nbsp;</td>
		</tr>
		<tr>
			<td colspan=8 class="alc title"><hr>Background<hr></td>
		</tr>
		<tr>
			<td colspan=2>Gregge</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><button class="w3-btn w3-white w3-border w3-border-dark w3-round w3-block" <?= $Gregge==0?'disabled':'' ?> onclick="document.getElementById('Gregge_m').submit();">Diminuisci</button></td>
			<td class="alc">
<?
	for ( $i = 0 ; $i < $Gregge; $i++) echo "<img src='img/bluedot.gif' width='10' height='10' >";
	for ( $i = $Gregge ; $i < 5; $i++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
			<td><button class="w3-btn w3-white w3-border w3-border-red w3-round w3-block" <?= $Gregge==5?'disabled':'' ?> onclick="document.getElementById('Gregge_p').submit();">Aumenta</button></td>
		</tr>
		<tr>
			<td colspan=2>Risorse</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><button class="w3-btn w3-white w3-border w3-border-dark w3-round w3-block" <?= $Risorse==0?'disabled':''?> onclick="document.getElementById('Risorse_m').submit();">Diminuisci</button></td>
			<td class="alc">
<?
	for ( $i = 0 ; $i < $Risorse; $i++) echo "<img src='img/bluedot.gif' width='10' height='10' >";
	for ( $i = $Risorse ; $i < 5; $i++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
			<td><button class="w3-btn w3-white w3-border w3-border-red w3-round w3-block" <?= $Risorse==5?'disabled':''?> onclick="document.getElementById('Risorse_p').submit();">Aumenta</button></td>
		</tr>
		<tr>
			<td colspan=2>Seguaci</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><button class="w3-btn w3-white w3-border w3-border-dark w3-round w3-block" <?= $Seguaci==0?'disabled':''?> onclick="document.getElementById('Seguaci_m').submit();">Diminuisci</button></td>
			<td class="alc">
<?
	for ( $i = 0 ; $i < $Seguaci; $i++) echo "<img src='img/bluedot.gif' width='10' height='10' >";
	for ( $i = $Seguaci ; $i < 5; $i++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
			<td><button class="w3-btn w3-white w3-border w3-border-red w3-round w3-block" <?= $Seguaci==5?'disabled':''?> onclick="document.getElementById('Seguaci_p').submit();">Aumenta</button></td>
		</tr>
		<tr>
			<td colspan=2>Notorietà</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><button class="w3-btn w3-white w3-border w3-border-dark w3-round w3-block" <?= $Notorieta==0?'disabled':''?> onclick="document.getElementById('Notorieta_m').submit();">Diminuisci</button></td>
			<td class="alc">
<?
	for ( $i = 0 ; $i < $Notorieta; $i++) echo "<img src='img/bluedot.gif' width='10' height='10' >";
	for ( $i = $Notorieta; $i < 5; $i++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
			<td><button class="w3-btn w3-white w3-border w3-border-red w3-round w3-block" <?= $Notorieta==5?'disabled':''?> onclick="document.getElementById('Notorieta_p').submit();">Aumenta</button></td>
		</tr>
		<tr>
			<td colspan=2>Mentore</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><button class="w3-btn w3-white w3-border w3-border-dark w3-round w3-block"  <?= $Mentore==0?'disabled':''?> onclick="document.getElementById('Mentore_m').submit();">Diminuisci</button></td>
			<td class="alc">
<?
	for ( $i = 0 ; $i < $Mentore; $i++) echo "<img src='img/bluedot.gif' width='10' height='10' >";
	for ( $i = $Mentore; $i < 5; $i++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
			<td><button class="w3-btn w3-white w3-border w3-border-red w3-round w3-block" <?= $Mentore==5?'disabled':''?> onclick="document.getElementById('Mentore_p').submit();">Aumenta</button></td>
		</tr>
		<tr>
			<td colspan=2>Rifugio</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><button class="w3-btn w3-white w3-border w3-border-dark w3-round w3-block"  <?= $Rifugio==0?'disabled':''?> onclick="document.getElementById('Rifugio_m').submit();">Diminuisci</button></td>
			<td class="alc">
<?
	for ( $i = 0 ; $i < $Rifugio; $i++) echo "<img src='img/bluedot.gif' width='10' height='10' >";
	for ( $i = $Rifugio; $i < 5; $i++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
			<td><button class="w3-btn w3-white w3-border w3-border-red w3-round w3-block" <?= $Rifugio==5?'disabled':''?> onclick="document.getElementById('Rifugio_p').submit();">Aumenta</button></td>
		</tr>
<!------ ------>
		<tr>
			<td colspan=8 >&nbsp;</td>
		</tr>
		<tr>
			<td colspan=8 class="alc title"><hr>Contatti (<?=$Contatti?>/20)<hr></td>
		</tr>
<?
	$MySql = "SELECT  idcontatto, nomecontatto, livello  FROM contatti WHERE idutente = $idutente ORDER BY livello DESC";
	$Result=mysql_query($MySql);

	while ( $res= mysql_fetch_array($Result) ) {
?>
		<tr>

			<td colspan=2><?=$res['nomecontatto']?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<form name="CambiaCd<?=$res['idcontatto']?>" method="post" action="ws/cont.php"><input type="hidden" name="id" value="<?=$res['idcontatto']?>"><input type="hidden" name="do" value="-1">
			<td><button class="w3-btn w3-white w3-border w3-border-dark w3-round w3-block" name="<?=$res['idcontatto']?>" onclick="document.CambiaCd<?=$res['idcontatto']?>.submit();"><?= $res['livello']>1?'Diminuisci':'Elimina'?></button></td>
			</form>
			<td class="alc">
<?
	for ( $i = 0 ; $i < $res['livello']; $i++) echo "<img src='img/bluedot.gif' width='10' height='10' >";
	for ( $i = $res['livello']; $i < 5; $i++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
			<form name="CambiaCa<?=$res['idcontatto']?>" method="post" action="ws/cont.php"><input type="hidden" name="id" value="<?=$res['idcontatto']?>"><input type="hidden" name="do" value="1">
			<td><button class="w3-btn w3-white w3-border w3-border-red w3-round w3-block" name="<?=$res['idcontatto']?>" <?= $res['livello']==5?'disabled':''?> onclick="document.CambiaCa<?=$res['idcontatto']?>.submit();">Aumenta</button></td>
			</form>
		</tr>

<?
	}

?>
	<tr>
		<td colspan=8 >&nbsp;</td>
	</tr>
	<tr>
		<td colspan=8 class="alc title2">Nuovo Contatto<hr></td>
	</tr>
	<tr>
		<td colspan=6 >Descrizione</td>
		<td class="alc">Livello</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<form name="AddC" method="post" action="ws/cont.php">
		<td colspan=3><input type=text name="nome" required maxlength="25" size="25" value="" pattern="[0-9\bA-Z\ba-z\b][0-9a-zA-Z\s']*"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td class="alc"><input type=number name=livello min=0 max=5 required></td>
		<td><button class="w3-btn w3-white w3-border  w3-border-red w3-round w3-block" Name="aggiungi" onclick="document.AddC.submit();">Aggiungi</button></td>
		</form>
	</tr>

<!------ ------>
	<tr>
		<td colspan=8 >&nbsp;</td>
	</tr>
	<tr>
		<td colspan=8 class="alc title"><hr>Generazione e Sentiero<hr></td>
	</tr>
	<tr>
		<form id="FormGen" name="FormGen" method=post action="ws/gen.php">
		<td colspan=2>Generazione</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td class="alc"><?=$generazione?></td>
		<td><button class="w3-btn w3-white w3-border w3-border-red w3-round w3-block" <?= $generazione==4?'disabled':''?> onclick="document.FormGen.submit();">Diminuisci</button></td>
		<td>&nbsp;</td>
		</form>
	</tr>
	<tr>
		<form id="FormSentC" name="FormSentC" method=post action="ws/sentiero.php">
		<td>Umanità/Sentiero</td>
		<td colspan=4>
			<select name="Sentiero" id="Sentiero" >
<?
$MySql = "SELECT * FROM sentieri ";
$Results = mysql_query($MySql);
while ( $Res = mysql_fetch_array($Results))  {
	?>
			<option value='<?=$Res['idsentiero']?>' <?= ($Res['idsentiero']==$idsentiero?"selected":"") ?> > <?=$Res['sentiero']?></option>
<?
}
?>
			</select>
		<button class="w3-btn w3-white w3-border w3-border-dark w3-round"  onclick="document.FormSentC.submit();">Cambia</button></td></form>
		<td><form id="FormSentD" name="FormSentD" method=post action="ws/sentiero.php"><input type="hidden" name="do" value="-1"><button class="w3-btn w3-white w3-border w3-border-dark w3-round w3-block"  <?= $valsentiero==0?'disabled':''?> onclick="document.FormSentD.submit();">Diminuisci</button></form></td>
		<td class="alc"><?=$valsentiero?>/10 </td>
		<td><form id="FormSentA" name="FormSentA" method=post action="ws/sentiero.php"><input type="hidden" name="do" value="1"><button class="w3-btn w3-white w3-border w3-border-red w3-round w3-block"  <?= $valsentiero==10?'disabled':''?> onclick="document.FormSentA.submit();">Aumenta</button></form></td>
	</tr>
	<tr>
			<td colspan=8>&nbsp;</td>
	</tr>
	<tr>
		<td colspan=8 class="alc title"><hr>Rimuovi Pregio/Difetto<hr></td>
	</tr>
	<tr>
		<form name="rimuovid" action="ws/rimuovipd.php" method=post>
		<td><button class="w3-btn w3-white w3-border w3-border-dark w3-round"  onclick="document.rimuovid.submit();">Rimuovi</button></td>
		<td colspan=2><select name="eliminapd">
<?
	$Mysql="SELECT * FROM pregidifetti LEFT JOIN pregidifetti_main ON pregidifetti.idpregio=pregidifetti_main.idpregio WHERE idutente=$idutente AND valore<0";
	$Result=mysql_query($Mysql);
	while ( $res=mysql_fetch_array($Result) ) {
?>
			<option value="<?=$res['idpregio']?>" > <?=$res['nomepregio']?></option>
<?
	}
?>
		</select></td>
		</form>
		<td>&nbsp;</td>
		<form name="rimuovip" action="ws/rimuovipd.php" method=post>
		<td><button class="w3-btn w3-white w3-border w3-border-dark w3-round"  onclick="document.rimuovip.submit();">Rimuovi</button></td>
		<td colspan=2><select name="eliminapd">
<?
	$Mysql="SELECT * FROM pregidifetti LEFT JOIN pregidifetti_main ON pregidifetti.idpregio=pregidifetti_main.idpregio WHERE idutente=$idutente AND valore >0";
	$Result=mysql_query($Mysql);
	while ( $res=mysql_fetch_array($Result) ) {
?>
			<option value="<?=$res['idpregio']?>" > <?=$res['nomepregio']?></option>
<?
	}
?>
		</select></td>
		</form>
	</tr>
	<tr>
		<td colspan=8 >&nbsp;</td>
	</tr>

	<? if ($idstatus < 5 ) { ?>

	<tr>
		<td colspan=8 class="alc title"><hr>Progredisci di Status<hr></td>
	</tr>
<?
		$Mysql="SELECT * FROM statuscama WHERE idstatus=$idstatus+1";
		$Result=mysql_query($Mysql);
		$res=mysql_fetch_array($Result);
		$newstatus=$res['status'];
		$newattivazione=$res['attivazione'];
		$idstatus<3?$newfdv=$fdvmax+1:$newfdv=$fdvmax+2;
		switch ($idstatus+1) {
			case 1:
				$newbg=1;
				$bp=0;
				break;
			case 2:
				$newbg=2;
				$bp=1;
				break;
			case 3:
				$newbg=2;
				$bp=1;
				break;
			case 4:
				$newbg=5;
				$bp=2;
				break;
			case 5:
				$newbg=10;
				$bp=2;
				break;
		}
		$NEWNUMSKILL=$maxskilltab[$idstatus+1][14-$generazione];
		$OLDNUMSKILL=$maxskilltab[$idstatus][14-$generazione];
		$DELTASKILL=$NEWNUMSKILL-$OLDNUMSKILL;
?>
	<tr>
		<td colspan=2>Da: <?=$status?></td>
		<td colspan=2>A: <?=$newstatus?></td>
		<td colspan=4>&nbsp;</td>
	</tr>
	<tr>
		<td>Attivazione ==></td>
		<td><?=$newattivazione?> (+<?=($newattivazione-$attivazione)?>)</td>
		<td>FdV =></td>
		<td><?=$newfdv?> (+<?=($newfdv-$fdvmax)?>)</td>
		<td >BG => +<?=$newbg?></td>
		<td >BP => +<?=$bp?></td>
		<td colspan=2>Punti Competenze => +<?=$DELTASKILL?></td>
	</tr>
<script>
<?
$MySql = "SELECT sum(livello) as l FROM skill LEFT JOIN skill_main on skill_main.idskill=skill.idskill WHERE idutente = $idutente AND tipologia = 0 ";
$Result=mysql_query($MySql);
$res=mysql_fetch_array($Result);
$sumskill=$res['l'];
?>

	 var 	DELTASKILL= <?= $DELTASKILL?>;
	 var 	sumskill= <?=$sumskill?>;
	 function controlla() {
		 var totskill=0;

<?
$MySql = "SELECT * FROM skill_main WHERE tipologia = 0 ";
$Results = mysql_query($MySql);
while ( $Res = mysql_fetch_array($Results))  { ?>

	var F<?=$Res['idskill']?>=parseInt(TheForm.F<?=$Res['idskill']?>.value);
	if ( !F<?=$Res['idskill']?>) { F<?=$Res['idskill']?>=0;}
	totskill += F<?=$Res['idskill']?> ;
<?
 }
?>		document.getElementById("csgo").disabled=true;
		document.getElementById("msg").innerHTML="";
		document.getElementById("pt").innerHTML=(sumskill+DELTASKILL-totskill);
		if ( totskill == sumskill+DELTASKILL ) {
			 document.getElementById("csgo").disabled=false;
			 document.getElementById("pt").innerHTML=(sumskill+DELTASKILL-totskill);
			 document.getElementById("msg").innerHTML="<br><b>Dopo</b> aver compiuto il passaggio di Status, ricordarsi di aggiungere  <b> <?=$newbg?> </b> punti BG.";
		}
	 }
</script>

	<tr>
		<td><button id="cson" class="w3-btn w3-white w3-border w3-border-dark w3-round"  onclick='document.getElementById("tabellaskill").style.display="table";document.getElementById("cson").disabled=true;document.getElementById("csoff").disabled=false;'>Inizia Cambio Status</button></td>
		<td><button id="csoff" class="w3-btn w3-white w3-border w3-border-dark w3-round" disabled onclick='document.getElementById("tabellaskill").style.display="none";document.getElementById("cson").disabled=false;document.getElementById("csoff").disabled=true;'>Annulla Cambio Status</button></td>
		<td colspan=6>&nbsp;</td>
	</tr>
	<tr>
		<td colspan=8>
			<table id="tabellaskill" width="85%" border="0" align="center" cellpadding="1" cellspacing="1" style="display: none">
				<form name="TheForm" id=TheForm" action="ws/cambiostatus.php" method="post">
<?
$Mysql="SELECT skill_main.idskill , nomeskill, livello FROM skill_main LEFT JOIN skill ON skill_main.idskill = skill.idskill AND idutente = $idutente WHERE tipologia =0";
$Result=mysql_query($Mysql);
while ($res=mysql_fetch_array($Result)) {
	$res['livello']==""?$res['livello']=0:'';
	?>
	<tr>
		<td><?=$res['nomeskill']?></td>

		<td><input name="F<?=$res['idskill']?>" id="F<?=$res['idskill']?>" type=number min=<?=$res['livello']?> max=5 size=1 value=<?=$res['livello']?>   onchange="controlla()"></td>

		<?
		if ($res=mysql_fetch_array($Result) ) {
		$res['livello']==""?$res['livello']=0:''; ?>
			<td><?=$res['nomeskill']?></td>

		<td><input name="F<?=$res['idskill']?>" id="F<?=$res['idskill']?>" type=number min=<?=$res['livello']?> max=5 size=1 value=<?=$res['livello']?>   onchange="controlla()"></td>


		<? }
		if ($res=mysql_fetch_array($Result) ) {
		$res['livello']==""?$res['livello']=0:''; ?>
			<td><?=$res['nomeskill']?></td>

		<td><input name="F<?=$res['idskill']?>" id="F<?=$res['idskill']?>" type=number min=<?=$res['livello']?> max=5 size=1 value=<?=$res['livello']?>   onchange="controlla()"></td>

		<? } ?>
	</tr>
<?
}
?>
	<tr>
		<td><button id="csgo" disabled class="w3-btn w3-white w3-border w3-border-red w3-round"  onclick='submit()'>Esegui cambio Status</button></td>
		<td colspan=5>Punti da assegnare <span id="pt"><?=$NEWNUMSKILL-$NUMSKILL?></span>&nbsp;<span id="msg" style="color:red;"></span></td>
	</tr>
	</form>
			</table>
		</td>
	</tr>

	<? } ?>
	<tr>
		<td colspan=8 >&nbsp;</td>
	</tr>
	<tr>
		<td colspan=8 ><button class="w3-btn w3-white w3-border w3-border-blue w3-round w3-block" onclick="javascript:window.location.href='main.php'">Indietro</button></td>
	</tr>
<!---- -->
	</table>
	</div>
	<p>&nbsp;
	<p>&nbsp;
	<p>&nbsp;
</body>
