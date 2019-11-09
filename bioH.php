<?
	include ('session_start.inc.php');
	include ('db_start.inc.php');

	if (!isset ($_SESSION['idutente'])) {
		// die ("Errore, nessuna sessione attiva!");
		session_write_close();
		header("Location: index.php", true);
	}

  	$idutente=$_SESSION['idutente'];

//die ( print_r ($_POST) );

	if (isset($_POST)) {
		if (isset($_POST['InsBio']) ){
			$bio=mysql_real_escape_string($_POST['biodata']);

			$bio=htmlspecialchars($bio);

			$Mysql="UPDATE HUNTERpersonaggio SET bio= '$bio' WHERE idutente=$idutente";
			$Result=mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		}

		if (isset($_POST['InsNote']) ){
			$note=mysql_real_escape_string($_POST['notedata']);

			$note=htmlspecialchars($note);

			$Mysql="UPDATE HUNTERpersonaggio SET note= '$note' WHERE idutente=$idutente";
			$Result=mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );

		}

	}

	$Mysql="SELECT * FROM HUNTERpersonaggio WHERE idutente=$idutente";
	$Result=mysql_query($Mysql);
	$res=mysql_fetch_array($Result);
	$bio=$res['bio'];
	$note=$res['note'];
	$notemaster=$res['notemaster'];


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

		.warn {
			color: #ff0000;
		}

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

	<div align="center">
	<table>
		<tr>
			<td width="150">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="50">&nbsp;</td>
			<td width="150">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="50">&nbsp;</td>
			<td width="100">&nbsp;</td>
		</tr>
		<tr>
			<td colspan=7 class="alc title"><hr>Biografia personaggio<hr></td>
		</tr>
		<tr>
			<td colspan=7>&nbsp;</td>
		</tr>
		<tr>
			<form method=POST action="" name="bio" >
				<td colspan=7><textarea name="biodata" cols="116" rows="10" ><?=$bio?></textarea><br>
			<button class="w3-btn w3-white w3-border w3-border-red w3-round w3-block" Name="InsBio" onclick="document.bio.submit();">Inserisci Bio</button></td>
			</form>
		</tr>
		<tr>
			<td colspan=7 >&nbsp;</td>
		</tr>
		<tr>
			<td colspan=7 class="alc title2">Annotazioni<hr></td>
		</tr>
		<tr>
			<form method=POST action="" name="note" >
				<td colspan=7><textarea name="notedata" cols="116" rows="5" ><?=$note?></textarea><br>
			<button class="w3-btn w3-white w3-border w3-border-red w3-round w3-block" Name="InsNote" onclick="document.note.submit();">Inserisci Note</button></td>
			</form>
		</tr>
		<tr>
			<td colspan=7 class="alc title2">Annotazioni master<hr></td>
		</tr>
		<tr>
				<td colspan=7><?=$notemaster?></td>

		</tr>
		<tr>
			<td colspan=7 >&nbsp;</td>
		</tr>
		<tr>
			<td colspan=7 >&nbsp;</td>
		</tr>
		<tr>
			<td colspan=7 ><button class="w3-btn w3-white w3-border w3-border-blue w3-round w3-block" onclick="javascript:window.location.href='main.php'">Indietro</button></td>
		</tr>
	</table >
	</div>
</body>
