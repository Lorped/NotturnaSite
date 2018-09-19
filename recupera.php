<? 
	include ('session_start.inc.php');
	include ('db_start.inc.php');


	function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
	{	
    	$str = '';
    	$max = mb_strlen($keyspace, '8bit') - 1;
    	for ($i = 0; $i < $length; ++$i) {
        	$str .= $keyspace[rand(0, $max)];
	    }	
    	return $str;
	}	





	if ( !isset ($_POST['user']) || !isset ($_POST['email']) ) {
		   //die ("No post!");
	} else {
		$user = mysql_real_escape_string ($_POST['user']);
		$email =mysql_real_escape_string ($_POST['email']);
		//die (print_r($_POST));

		// CONTROLLO USERID-PASSWORD
		$MySql = "SELECT * FROM utente WHERE nome = '$user' and email = '$email' ";
		$Results = mysql_query($MySql);
		$res = mysql_fetch_array($Results);
		
		
		if (!$res) {
			$msg = "Dati inseriti non corretti";
		} else {
			
			$idutente=$res['idutente'];
			
			$newpass= random_str(8);		
			$MySql = "UPDATE utente SET password = '$newpass' WHERE idutente = $idutente  ";
			$Results = mysql_query($MySql);
			
			$Testo="La tua password per Notturna e'\n".$newpass."\nDopo il login puoi cambiarla nel profilo della tua scheda personaggio\n\nLo staff di Notturna";
		
//$email="lorped@gmail.com";
			
			mail( $email, "Password Notturna" , $Testo, "From: staff.notturna@notturna");
		
			$msg='Password spedita correttamente. Controllare il proprio account di posta.';
			
			//session_write_close();
			//header("Location: index.php", true);
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
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><input type=submit name="Recupera"  value="Recupera password"></td>
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
	
		