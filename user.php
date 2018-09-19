<? 
	include ('session_start.inc.php');
	include ('db_start.inc.php');

	if (!isset ($_SESSION['idutente'])) {
		// die ("Errore, nessuna sessione attiva!");
		session_write_close();
		header("Location: index.php", true);
	}

  	$idutente=$_SESSION['idutente'];

	if (isset($_POST)) {
		if (isset($_POST['email']) ){
			$email=mysql_real_escape_string($_POST['email']);
			$Mysql="SELECT count(*) FROM utente WHERE email = '$email' AND idutente != $idutente";
			$Result=mysql_query($Mysql);
			$res=mysql_fetch_array($Result);
			
			if ( $res[0] != 0 ) {
				$msg="Nuova email già presente";	
			} else {
				$Mysql="UPDATE utente SET email= '$email' WHERE idutente=$idutente";
				$Result=mysql_query($Mysql);
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
				$msg="Email cambiata";
			}
			
		}
		if (isset($_POST['password-old']) ){
			$Mysql="SELECT * FROM utente WHERE idutente=$idutente";
			$Result=mysql_query($Mysql);
			$res=mysql_fetch_array($Result);
			$pass=$res['password'];
			$email=$res['email'];
			
			$pass_old=mysql_real_escape_string($_POST['password-old']);
			$pass_new=mysql_real_escape_string($_POST['password-new']);
			
			if ( $pass_old == $pass ) {
				$Mysql="UPDATE utente SET password= '$pass_new' WHERE idutente=$idutente";
				$Result=mysql_query($Mysql);
				if (mysql_errno()) die ( mysql_errno().": ".mysql_error()."+". $Mysql );
				$msg="Password cambiata";
			} else {
				$msg="Password vecchia non corretta";
			}

		}
	} 

	$Mysql="SELECT * FROM utente WHERE idutente=$idutente";
	$Result=mysql_query($Mysql);
	$res=mysql_fetch_array($Result);
	$pass=$res['password'];
	$email=$res['email'];
	
		
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
	<table style="border:0; cellpadding:1; cellspacing:1;">
		<tr>
			<td><img src="notturnalogo.png" height=300 width=320></td>
		</tr>
	</table>
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
			<td colspan=7 class="alc title"><hr>Gestione Utente<hr></td>
		</tr>
		<tr>
			<td colspan=7>&nbsp;</td>
		</tr>
		<tr>
			<form method=POST action="" name="CambiaE" >
			<td>Email:</td>
			<td colspan=3><input type=email name="email" required maxlength="20" size="20" placeholder="<?=$email?>"></td>
			<td colspan=2>&nbsp;</td>
			<td><button class="w3-btn w3-white w3-border w3-border-red w3-round w3-block" Name="CambiaEmail" onclick="document.CambiaE.submit();">Cambia Email</button></td>
			</form>
		</tr>
		<tr>
			<form method=POST action="" name="CambiaP" >
			<td>Vecchia password:</td>
			<td><input type=password name="password-old" required maxlength="20" size="20" ></td>
			<td>&nbsp;</td>
			<td>Nuova password:</td>
			<td><input type=password name="password-new" required maxlength="20" size="20" minlength=8 type=password pattern="[a-zA-Z0-9]+" title="Solo lettere e numeri senza spazi" ></td>
			<td>&nbsp;</td>				
			<td><button class="w3-btn w3-white w3-border w3-border-red w3-round w3-block" Name="CambiaPass" onclick="document.CambiaP.submit();">Cambia Password</button></td>
			</form>
		</tr>
		<tr>
			<td colspan=7 class="alc warn">&nbsp;<?=$msg;?>&nbsp;</td>
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
	
		