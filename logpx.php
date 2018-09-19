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


	$MAXSTAT=$res['maxstat'];

	$maxdisctab  = [
		[ 2, 3, 3, 4,  4,  5,  5 ],
		[ 3, 3, 4, 4 , 5 , 5 , 5 ],
		[ 3, 4, 5, 5 , 5 , 5 , 5 ],
		[ 4, 5, 5, 5 , 5 , 5 , 5 ],
		[ 4, 5, 5, 5 , 5 , 5 , 5 ],
		[ 5, 5, 5, 5 , 5 , 5 , 5 ]
	];

	$MAXSDISC=$maxdisctab[$idstatus][14-$generazione];


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
			<td colspan=8 class="alc title"><hr>Log Spesa PX</td>
		</tr>
		<tr>
			<td colspan=8 class="alc title2">(e modifiche extra)<hr></td>
		</tr>
<?
		$Mysql="SELECT * FROM logpx WHERE idutente=$idutente ORDER BY data ASC";
		$Result=mysql_query($Mysql);
		while ($res=mysql_fetch_array($Result)) {
?>
		<tr>
			<td colspan=2><?=$res['data']?></td>
			<td colspan=5><?=$res['Azione']?></td>
			<td class="ald"><?=($res['px']!=0?$res['px']:"-")?></td>
		</tr>
<?
		}

		$Mysql="SELECT sum(px) as g FROM logpx WHERE idutente=$idutente AND px>0";
		$Result=mysql_query($Mysql);
		$res=mysql_fetch_array($Result);
		$g=$res['g'];

		$Mysql="SELECT sum(px) as s FROM logpx WHERE idutente=$idutente AND px<0";
		$Result=mysql_query($Mysql);
		$res=mysql_fetch_array($Result);
		$s=$res['s'];

?>
	<tr>
		<td colspan=8 >&nbsp;</td>
	</tr>
	<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>Guadagnati:</td>
			<td><?=$g?></td>
			<td>Spesi</td>
			<td><?=-$s?></td>
			<td>Restanti;</td>
			<td><?=$g+$s?></td>
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
