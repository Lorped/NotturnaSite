<?
	include ('session_start.inc.php');
	include ('db_start.inc.php');

	if (!isset ($_SESSION['idutente'])) {

		// die ("Errore, nessuna sessione attiva!");
		session_write_close();
		header("Location: index.php", true);

	} else {
   		$idutente=$_SESSION['idutente'];

		$Mysql="SELECT nomepg FROM personaggio WHERE idutente=$idutente";
		if ( $res=mysql_fetch_array(mysql_query($Mysql)) ) {
		$nomepg=mysql_real_escape_string($res['nomepg']);
		} else {
			$nomepg="NARRAZIONE";
		}
	}

	$MM="DELETE FROM dadi WHERE DATE_ADD( Ora , INTERVAL 24 HOUR )<NOW()";
	mysql_query($MM);

	$_SESSION['LastTime']=0;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Notturna - Cronaca di Roma</title>
	<link href="https://fonts.googleapis.com/css?family=Libre+Baskerville" rel="stylesheet">
	<link href="w3.css" rel="stylesheet">

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
		/*input[type=submit] {
    		width: 90px;
			padding: 0;
			height: 40px;
		}*/
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
	<div align=center>
		<table>
		<tr>
			<td width="250">&nbsp;</td>
			<td width="550">&nbsp;</td>
		</tr>
		<tr>
			<td colspan=2 class="alc title"><hr>Fattore Aleatorio<hr></td>
		</tr>
		<tr>
			<td>
				<iframe src="pulsanti.php" height=400 width=250 frameborder=0></iframe>
			</td>
			<td>
				<iframe name="mappa" id="mappa" src="dadi.php" height=400 width=550 frameborder=0></iframe>
			</td>
		</tr>
		<tr>
			<td colspan=2><button class="w3-btn w3-white w3-border w3-border-blue w3-round w3-block" onclick="javascript:window.location.href='main.php'">Indietro</button></td>
		</tr>
		</table>
	</div>

</body>
