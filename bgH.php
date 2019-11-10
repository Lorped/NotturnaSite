<?php
	include ('session_start.inc.php');
	include ('db_start.inc.php');


	if (!isset ($_SESSION['idutente'])) {
		// die ("Errore, nessuna sessione attiva!");
		session_write_close();
		header("Location: index.php", true);
	}


	$idutente=$_SESSION['idutente'];






	$MySql = "SELECT  nomeback ,livello , background.idback as xid FROM background
       		LEFT JOIN background_main ON background_main.idback=background.idback
       		WHERE idutente = $idutente";
	$Results = mysql_query($MySql);
	if (mysql_errno())  die ( mysql_errno().": ".mysql_error() );

	$Contatti=0;
	$Risorse=0;
	$Seguaci=0;
	$Notorieta=0;
	$Mentore=0;
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

	<!------ ------>

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
			<td colspan=8>&nbsp;</td>
		</tr>
		<tr>
			<td colspan=8 class="alc title"><hr>Background<hr></td>
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
			<td colspan=2>Collaboratori</td>
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
			<td colspan=2>SafeHouse</td>
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

<!---------
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
----->
	<tr>
		<td colspan=8 >&nbsp;</td>
	</tr>


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
