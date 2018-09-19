<?php
	include ('session_start.inc.php');
	include ('db_start.inc.php');


	if (!isset ($_SESSION['idutente'])) {
		// die ("Errore, nessuna sessione attiva!");
		session_write_close();
		header("Location: index.php", true);
	}


	$idutente=$_SESSION['idutente'];

	if ( isset ( $_POST['id'] ) ) {
		$id=$_POST['id'];
		$_SESSION['idother']=$id;
	 } else {
		$id=$_SESSION['idother'];
	}

	if (isset($_POST['InsNote']) ){
		$note=mysql_real_escape_string($_POST['notedata']);

		$note=htmlspecialchars($note);

		$Mysql="UPDATE personaggio SET notemaster= '$note' WHERE idutente=$id";
		$Result=mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

	}


	$MySql = "SELECT *  FROM personaggio
		LEFT JOIN clan ON personaggio.idclan=clan.idclan
		LEFT JOIN statuscama ON personaggio.idstatus=statuscama.idstatus
		LEFT JOIN sentieri ON personaggio.idsentiero=sentieri.idsentiero
		LEFT JOIN generazione ON personaggio.generazione=generazione.generazione
		WHERE idutente = $id ";

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
	$status=$res['status'];
	$idstatus=$res['idstatus'];

	$valsentiero=$res['valsentiero'];
	$sentiero=$res['sentiero'];
	$idsentiero=$res['idsentiero'];


	$fama1=$res['fama1']; //città
	$fama2=$res['fama2']; //vamp
	$fama3=$res['fama3'];  //wod

	$xp=$res['xp'];
	$xpspesi=$res['xpspesi'];

	$rifugio = $res['rifugio'];

	$MAXSTAT=$res['maxstat'];


	$notemaster=$res['notemaster'];




	$MySql = "SELECT  nomeback ,livello , background.idback as xid FROM background
       		LEFT JOIN background_main ON background_main.idback=background.idback
       		WHERE idutente = $id";
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
	<form id="f1_p" method="post" action="wsadmin/fama.php"><input type="hidden" name="f1" value="1"></form>
	<form id="f1_m" method="post" action="wsadmin/fama.php"><input type="hidden" name="f1" value="-1"></form>
	<form id="f2_p" method="post" action="wsadmin/fama.php"><input type="hidden" name="f2" value="1"></form>
	<form id="f2_m" method="post" action="wsadmin/fama.php"><input type="hidden" name="f2" value="-1"></form>
	<form id="f3_p" method="post" action="wsadmin/fama.php"><input type="hidden" name="f3" value="1"></form>
	<form id="f3_m" method="post" action="wsadmin/fama.php"><input type="hidden" name="f3" value="-1"></form>
	<!------ ------>
	<form id="Gregge_p" method="post" action="wsadmin/back.php"><input type="hidden" name="do" value="1"><input type="hidden" name="id" value="1"></form>
	<form id="Gregge_m" method="post" action="wsadmin/back.php"><input type="hidden" name="do" value="-1"><input type="hidden" name="id" value="1"></form>
	<form id="Risorse_p" method="post" action="wsadmin/back.php"><input type="hidden" name="do" value="1"><input type="hidden" name="id" value="2"></form>
	<form id="Risorse_m" method="post" action="wsadmin/back.php"><input type="hidden" name="do" value="-1"><input type="hidden" name="id" value="2"></form>
	<form id="Seguaci_p" method="post" action="wsadmin/back.php"><input type="hidden" name="do" value="1"><input type="hidden" name="id" value="3"></form>
	<form id="Seguaci_m" method="post" action="wsadmin/back.php"><input type="hidden" name="do" value="-1"><input type="hidden" name="id" value="3"></form>
	<form id="Notorieta_p" method="post" action="wsadmin/back.php"><input type="hidden" name="do" value="1"><input type="hidden" name="id" value="4"></form>
	<form id="Notorieta_m" method="post" action="wsadmin/back.php"><input type="hidden" name="do" value="-1"><input type="hidden" name="id" value="4"></form>
	<form id="Mentore_p" method="post" action="wsadmin/back.php"><input type="hidden" name="do" value="1"><input type="hidden" name="id" value="6"></form>
	<form id="Mentore_m" method="post" action="wsadmin/back.php"><input type="hidden" name="do" value="-1"><input type="hidden" name="id" value="6"></form>
	<form id="Rifugio_p" method="post" action="wsadmin/back.php"><input type="hidden" name="do" value="1"><input type="hidden" name="id" value="8"></form>
	<form id="Rifugio_m" method="post" action="wsadmin/back.php"><input type="hidden" name="do" value="-1"><input type="hidden" name="id" value="8"></form>
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
			<td colspan=8 class="alc title"><hr>~~<?=$nome?>~~<hr></td>
		</tr>
		<tr>
			<td colspan=8 class="alc title"><hr>Rifugio<hr></td>
		</tr>
		<tr>
			<form name="rif" method="post" action="wsadmin/newrif.php">
			<td colspan=4><input type=text name="rifugio" required maxlength="50" size="50" value="<?=$rifugio?>" pattern="[0-9\bA-Z\ba-z\b][0-9a-zA-Z\s']*"></td>
			<td colspan=3>&nbsp;</td>
			<td><button class="w3-btn w3-white w3-border w3-border-red w3-round w3-block"  onclick="document.rif.submit();">Cambia</button></td>
			</form>
		</tr>
		<tr>
			<td colspan=8 class="alc title"><hr>Note Master<hr></td>
		</tr>
		<form method=POST action="" name="note" >
			<td colspan=5><textarea name="notedata" cols="116" rows="5" ><?=$notemaster?></textarea><br>
				<td colspan=2>&nbsp;</td>
		<td><button class="w3-btn w3-white w3-border w3-border-red w3-round w3-block"  Name="InsNote" onclick="document.note.submit();">Cambia</button></td>
		</form>
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
	$MySql = "SELECT  idcontatto, nomecontatto, livello  FROM contatti WHERE idutente = $id ORDER BY livello DESC";
	$Result=mysql_query($MySql);

	while ( $res= mysql_fetch_array($Result) ) {
?>
		<tr>

			<td colspan=2><?=$res['nomecontatto']?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<form name="CambiaCd<?=$res['idcontatto']?>" method="post" action="wsadmin/cont.php"><input type="hidden" name="id" value="<?=$res['idcontatto']?>"><input type="hidden" name="do" value="-1">
			<td><button class="w3-btn w3-white w3-border w3-border-dark w3-round w3-block" name="<?=$res['idcontatto']?>" onclick="document.CambiaCd<?=$res['idcontatto']?>.submit();"><?= $res['livello']>1?'Diminuisci':'Elimina'?></button></td>
			</form>
			<td class="alc">
<?
	for ( $i = 0 ; $i < $res['livello']; $i++) echo "<img src='img/bluedot.gif' width='10' height='10' >";
	for ( $i = $res['livello']; $i < 5; $i++) echo "<img src='img/blank.gif' width='10' height='10' >";
?>
			</td>
			<form name="CambiaCa<?=$res['idcontatto']?>" method="post" action="wsadmin/cont.php"><input type="hidden" name="id" value="<?=$res['idcontatto']?>"><input type="hidden" name="do" value="1">
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
		<form name="AddC" method="post" action="wsadmin/cont.php">
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
		<form id="FormGen" name="FormGen" method=post action="wsadmin/gen.php">
		<td colspan=2>Generazione</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td class="alc"><?=$generazione?></td>
		<td><button class="w3-btn w3-white w3-border w3-border-red w3-round w3-block" <?= $generazione==8?'disabled':''?> onclick="document.FormGen.submit();">Diminuisci</button></td>
		<td>&nbsp;</td>
		</form>
	</tr>
	<tr>
		<form id="FormSentC" name="FormSentC" method=post action="wsadmin/sentiero.php">
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
		<td><form id="FormSentD" name="FormSentD" method=post action="wsadmin/sentiero.php"><input type="hidden" name="do" value="-1"><button class="w3-btn w3-white w3-border w3-border-dark w3-round w3-block"  <?= $valsentiero==0?'disabled':''?> onclick="document.FormSentD.submit();">Diminuisci</button></form></td>
		<td class="alc"><?=$valsentiero?>/10 </td>
		<td><form id="FormSentA" name="FormSentA" method=post action="wsadmin/sentiero.php"><input type="hidden" name="do" value="1"><button class="w3-btn w3-white w3-border w3-border-red w3-round w3-block"  <?= $valsentiero==10?'disabled':''?> onclick="document.FormSentA.submit();">Aumenta</button></form></td>
	</tr>
	<tr>
			<td colspan=8>&nbsp;</td>
	</tr>
	<tr>
		<td colspan=8 class="alc title"><hr>Rimuovi Pregio/Difetto<hr></td>
	</tr>
	<tr>
		<form name="rimuovid" action="wsadmin/rimuovipd.php" method=post>
		<td><button class="w3-btn w3-white w3-border w3-border-dark w3-round"  onclick="document.rimuovid.submit();">Rimuovi</button></td>
		<td colspan=2><select name="eliminapd">
<?
	$Mysql="SELECT * FROM pregidifetti LEFT JOIN pregidifetti_main ON pregidifetti.idpregio=pregidifetti_main.idpregio WHERE idutente=$id AND valore<0";
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
		<form name="rimuovip" action="wsadmin/rimuovipd.php" method=post>
		<td><button class="w3-btn w3-white w3-border w3-border-dark w3-round"  onclick="document.rimuovip.submit();">Rimuovi</button></td>
		<td colspan=2><select name="eliminapd">
<?
	$Mysql="SELECT * FROM pregidifetti LEFT JOIN pregidifetti_main ON pregidifetti.idpregio=pregidifetti_main.idpregio WHERE idutente=$id AND valore >0";
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
