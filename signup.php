<? 
	include ('session_start.inc.php');
	include ('db_start.inc.php');

	if ( !isset ($_POST['user']) || !isset ($_POST['password']) ) {
		   //die ("No post!");
	} else {
		$user = mysql_real_escape_string ($_POST['user']);
		$pass = mysql_real_escape_string ($_POST['password']);
		$email =mysql_real_escape_string ($_POST['email']);
		//die (print_r($_POST));

		// CONTROLLO USERID-PASSWORD
		$MySql = "SELECT * FROM utente WHERE nome = '$user' ";
		$Results = mysql_query($MySql);
		$res = mysql_fetch_array($Results);
		
		$MySql = "SELECT * FROM utente WHERE email = '$email' ";
		$Results = mysql_query($MySql);
		$res2 = mysql_fetch_array($Results);
		
		if ($res) {
			$msg = "Nome utente già presente";
		} elseif ( $res2)  {
			$msg = "Email già presente";
		} else {
			$MySql = "INSERT INTO utente ( nome , email , password ) VALUES ( '$user', '$email', '$pass' )  ";
			$Results = mysql_query($MySql);
			session_write_close();
			header("Location: index.php", true);
		}
	}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Notturna - Cronaca di Roma</title>
	<link href="https://fonts.googleapis.com/css?family=Libre+Baskerville" rel="stylesheet"> 	
	<link href="w3.css" rel="stylesheet" >
	
	<style type="text/css">

		input {
			width:  18em;
			-moz-appearance: textfield;
		} 
		input[type=submit] {
			width:  19em;
			/* -moz-appearance: textfield; */
			background-color: #B0B0B0;
			/* background: #808080; */
			color: #ff0000;
       border-radius: 30px !important;
       border: 1px solid #000000;
			height: 28px;
		}
		input[type=number] {
			width:  80px;
			-moz-appearance: textfield;
			font-size: 1em;
		}

		.xbody {
			/*  font-family: 'Libre Baskerville', serif;   */
			font-family: Arial, sans;
			font-size: 0.8em;
			color: #404040;
			border: 0px #ffffff;
		}
		.msg {
			/*  font-family: 'Libre Baskerville', serif;   */
			font-family: Arial, sans;
			font-size: 1em;
			color: #FF0000;
		}
		td {
			text-align: center;
		}
	</style>
</head>
<body>
	<form id="loginform" name="loginform" method="post" action="">
	<div align="center">
	<table style="border:0; cellpadding:1; cellspacing:1;">
		<tr>
			<td><img src="notturnalogo.png" height=300 width=320></td>
		</tr>
		<tr>
			<td><input id="user" name="user" type=text  maxlength="20" placeholder="user" pattern="[a-zA-Z0-9]+" title="Solo lettere e numeri senza spazi" required></td>
		</tr>
		<tr>
			<td><input id="email" name="email" type=email placeholder="email"  required></td>
		</tr>		
		<tr>
			<td><input id="password" name="password" maxchar=20 maxlength="20" type=password pattern="[a-zA-Z0-9]+" title="Solo lettere e numeri senza spazi" placeholder="password" required></td>
		</tr>
		<tr>
			<td><input type=submit name="Registrati"  value="Registrati"></td>
		</tr>
		<tr>
			<td><button class="xbody" onclick="javascript:window.location.href='index.php';">Indietro</button></td>
		<tr>		
		<tr>
			<td class="msg"><?=$msg?></td>
		<tr>
	</table>
	</div>
	</form>
</body>
	
		