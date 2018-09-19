<?php
	include ('session_start.inc.php');
	include ('db_start.inc.php');


	if (!isset ($_SESSION['idutente'])) {
		// die ("Errore, nessuna sessione attiva!");
		session_write_close();
		header("Location: index.php", true);
	}


	$idutente=$_SESSION['idutente'];
    


    if ( isset($_POST['id']) && $_POST['id']=="new" ){
		
		$contatto=mysql_real_escape_string($_POST['contatto']);
		$note=mysql_real_escape_string($_POST['note']);
		$cell=$_POST['check_cell'];  if ($cell=="on") {$cell=1 ;} else {$cell=0;}
		$email=$_POST['check_email'];  if ($email=="on") {$email=1 ;} else {$email=0;}
		$home=$_POST['check_home'];  if ($home=="on") {$home=1 ;} else {$home=0;}
		
		$Mysql= "INSERT INTO rubrica (  owner , contatto , cell, email, home, note) VALUES (  $idutente , '$contatto', $cell, $email , $home, '$note') ";
		mysql_query ($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error() ."+".$Mysql);
		
	} elseif ( isset($_POST['canc']) ){ 
		
		$id=$_POST['id'];
	
		$Mysql="DELETE FROM rubrica WHERE idrubrica=$id";
				mysql_query ($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error() ."+".$Mysql);
	} elseif ( isset($_POST['id']) ) {
		
		$id=$_POST['id'];
		
		$note=mysql_real_escape_string($_POST['note']);
		$cell=$_POST['check_cell'];  if ($cell=="on") {$cell=1 ;} else {$cell=0;}
		$email=$_POST['check_email'];  if ($email=="on") {$email=1 ;} else {$email=0;}
		$home=$_POST['check_home'];  if ($home=="on") {$home=1 ;} else {$home=0;}
		
		$Mysql= "UPDATE rubrica SET  cell = $cell, email=$email, home=$home, note = '$note'  WHERE idrubrica = $id ";
		mysql_query ($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error() ."+".$Mysql);
		
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
		.valm { vertical-align: middle; }


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
			line-height: 39px;
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

	<div align=center>
	<table>
		<tr>
			<td width="250">&nbsp;</td>
			<td width="70">&nbsp;</td>
			<td width="70">&nbsp;</td>
			<td width="70">&nbsp;</td>
			<td width="250">&nbsp;</td>
			<td width="80">&nbsp;</td>
			<td width="80">&nbsp;</td>
		</tr>
		<tr>
			<td colspan=7 class="alc title"><hr>Rubrica<hr></td>
		</tr>
		<tr>
			<td class="title2">Nome</td>
			<td class="alc title2">Tel</td>
			<td class="alc title2">Email</td>
			<td class="alc title2">Home</td>
			<td class="title2">Note</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		
<?
		$cont=0;
		$Mysql="SELECT * FROM rubrica WHERE owner = $idutente";
		$Result=mysql_query($Mysql);
		while ( $res=mysql_fetch_array($Result)) {
			$cont++;
?>
		<tr>
			<form name="F<?=$cont?>" method=post action=""><input type=hidden name="id" value="<?=$res['idrubrica']?>" >
			<td><?=$res['contatto']?></td>
			<td class="alc valm"><input type="checkbox" id="check_cell" name="check_cell" <?=($res['cell']==1?"checked":"")?> onchange="document.F<?=$cont?>.change<?=$cont?>.disabled=false" > </td>
			<td class="alc valm"><input type="checkbox" id="check_email" name="check_email" <?=($res['email']==1?"checked":"")?> onchange="document.F<?=$cont?>.change<?=$cont?>.disabled=false"></td>
			<td class="alc valm"><input type="checkbox" id="check_home" name="check_home" <?=($res['home']==1?"checked":"")?> onchange="document.F<?=$cont?>.change<?=$cont?>.disabled=false"></td>
			<td><input type="input" id="note" name="note" size=30 value="<?= $res['note']?>" onchange="document.F<?=$cont?>.change<?=$cont?>.disabled=false"></td>		
			<!-- <td><input type="submit" class="w3-btn w3-white w3-border w3-border-blue w3-round " value="Aggiorna"></td> -->
			<td><button name="change<?=$cont?>" class="w3-btn w3-white w3-border w3-border-blue w3-round " onClick="submit();" disabled>Aggiorna</button></td>
			<td><button name="canc" class="w3-btn w3-white w3-border w3-border-red w3-round " onClick="submit();">Cancella</button></td>
			</form>
		</tr>
<? 
		}
		for ($i=$cont; $i<10; $i++){
?>
		<tr>
			
			<td>_______________________________</td>
			<td class="alc valm"><input type="checkbox" id="check_cell" name="check_cell"  > </td>
			<td class="alc valm"><input type="checkbox" id="check_email" name="check_email" ></td>
			<td class="alc valm"><input type="checkbox" id="check_home" name="check_home" ></td>
			<td>_______________________________</td>	
<?			if ($i==$cont) {
?>			
			<td><button name="change" class="w3-btn w3-white w3-border w3-border-blue w3-round " disabled>Aggiorna</button></td>
			<td><button name="canc" class="w3-btn w3-white w3-border w3-border-red w3-round " disabled>Cancella</button></td>
<?			} else {
?>			
			<td>&nbsp;</td>
			<td>&nbsp;</td>

		</tr>
<?
			}	
		}
?>
		
		
	<tr>
		<td colspan=7 >&nbsp;</td>
	</tr>
	<tr>
		<td colspan=7 class="alc title2">Nuovo Contatto<hr></td>
	</tr>
		
	<tr>
		<form name="new" method=post action=""><input type=hidden name="id" value="new" >
		<td><input type="input" id="contatto" name="contatto" size=25 required></td>	
		<td class="alc valm"><input type="checkbox" id="check_cell" name="check_cell"  > </td>
		<td class="alc valm"><input type="checkbox" id="check_email" name="check_email" ></td>
		<td class="alc valm"><input type="checkbox" id="check_home" name="check_home" ></td>
		<td><input type="input" id="note" name="note" size=30 ></td>	
		<td>&nbsp;</td>
		<td><button name="change" class="w3-btn w3-white w3-border w3-border-blue w3-round onClick="submit();"" >Inserisci</button></td>
		<!--<td><input type="submit" class="w3-btn w3-white w3-border w3-border-blue w3-round " value="Inserisci"</td> -->
		</form>
	</tr>	
		
<!------ ------>
	<tr>
		<td colspan=7 >&nbsp;</td>
	</tr>
	<tr>
		<td colspan=7 >&nbsp;</td>
	</tr>		
	<tr>
		<td colspan=7 ><button class="w3-btn w3-white w3-border w3-border-blue w3-round w3-block" onclick="javascript:window.location.href='main.php'">Indietro</button></td>
	</tr>		
<!---- -->		
	</table>
	</div>	
	<p>&nbsp;
	<p>&nbsp;
	<p>&nbsp;
</body>		
