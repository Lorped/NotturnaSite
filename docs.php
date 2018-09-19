<? 
	include ('session_start.inc.php');
	include ('db_start.inc.php');

	if (!isset ($_SESSION['idutente'])) {
		// die ("Errore, nessuna sessione attiva!");
		session_write_close();
		header("Location: index.php", true);
	}
	$_SESSION['LastTime']=0;

  	$idutente=$_SESSION['idutente'];
		

	$MySql = "SELECT *  FROM personaggio WHERE idutente=$idutente";
	$Result = mysql_query($MySql);
	$res = mysql_fetch_array($Result);
 
	$nome=$res['nomepg'];
	$idclan=$res['idclan'];
	
	$link="#";
	
	switch ($idclan) {
       
		case 1:   //  Toreador
			$link = "https://drive.google.com/file/d/0BwbyMyT-GT-UZ2pKb0RzRlZoaVU/view";
		break;
		
		case 2:   //  Ventrue
			$link = "https://drive.google.com/file/d/0BwbyMyT-GT-UTTRodGZXdzdCVXM/view";
		break;
		
		case 3:		// Nosferatu
			$link = "https://drive.google.com/file/d/0BwbyMyT-GT-UUDNmT3llNjZ3UXM/view";
		break;
		
		case 4:		// Brujah
			$link = "https://drive.google.com/file/d/0BwbyMyT-GT-UNFZURFpYR2pfNVk/view";
		break;
		
		case 5:		// Gangrel
			$link = "https://drive.google.com/file/d/0BwbyMyT-GT-UcFRxVFRkNnRLb28/view";
		break;
		
		case 6:		// Malkavian
			$link = "https://drive.google.com/file/d/0BwbyMyT-GT-UZ2dRSW1VOGFWNDQ/view";
		break;  
		
		case 7:		// Tremere
			$link = "https://drive.google.com/file/d/0BwbyMyT-GT-US3d3OEpnbV9Ccjg/view";
		break;
		
		case 8:		// Lasombra
			$link = "#";
		break;
		
		case 9:		// Tzimisce
			$link = "#";
		break;
		
		case 10:	// Assamiti
			$link = "https://drive.google.com/file/d/0BwbyMyT-GT-ULXpGWkxLNWZhaDg/view";
		break;
		
		case 11:	// Giovanni
			$link = "https://drive.google.com/file/d/0BwbyMyT-GT-UYTVUZFlNeEo2N0k/view";
		break;
		
		case 12:	// Ravnos
			$link = "https://drive.google.com/file/d/0BwbyMyT-GT-UVTF3QWJ2TzNXZk0/view";
		break;
		
		case 13:	// Setiti
			$link = "https://drive.google.com/file/d/0BwbyMyT-GT-UOUo0dll2NjRDOHc/view";
		break;
		
		case 20:	// vili
			$link = "https://drive.google.com/file/d/0BwbyMyT-GT-UOWhsMExKd2YzTVU/view";
		break;   
		

	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Notturna - Cronaca di Roma</title>
	<link href="https://fonts.googleapis.com/css?family=Libre+Baskerville" rel="stylesheet"> 	
	<link href="w3.css" rel="stylesheet"> 	
	
	<style type="text/css">
		

		input[type=number] {
			width:  80px;
			-moz-appearance: textfield;
		} 
		body {
			font-family: arial, sans-serif; 
			font-size: 1.1em;
		}
		.alc {
			text-align: center;
		}

		.small {
			font-size: 90%;
		}
		.title2 {
			font-size: 105%;
			font-weight: bold;
			font-family: 'Libre Baskerville'
		}
		hr {
			border-top: 1px solid #000000;
			margin-top: 0.2em;
    		margin-bottom: 0.2em;
		} 
	</style>

</head>
<body>
	<div align="center">
	<table style="border:0; cellpadding:1; cellspacing:1;">
		<tr>
			<td colspan=2><img src="notturnalogo.png" height=300 width=320></td>
		</tr>
	</table>	

	<table style="border:0; cellpadding:1; cellspacing:1;" >

		<tr>
			<td colspan=2 class="alc title2" ><hr>Regolamento generale di Notturna<hr></td>
		</tr>
	<tr>
			<td>
				<a href="docs/NOTTURNA-Regole-Comportamentali.pdf" class="w3-btn w3-white w3-ripple w3-left-align" style="width:400px;" target="_blank"> Regole di Comportamento<br>&nbsp;</a>
			</td>
			<td>
				<a href="docs/Adesione Notturna.pdf" class="w3-btn w3-white w3-ripple w3-left-align" style="width:400px;" target="_blank"> ADESIONE NOTTURNA CON LIBERATORIA<br><span class="small">(da stampare e consegnare compilata AD OGNI EVENTO)</span></a>
				<!-- <a href="docs/NOTTURNA-LIBERATORIA-MINORENNI.pdf" class="w3-btn w3-white w3-ripple w3-left-align" style="width:400px;" target="_blank"> Liberatoria Minori<br><span class="small">(da stampare e consegnare compilata all'evento)</span></a> -->
			</td>
		</tr>
		<tr>
			<td colspan=2 class="alc title2" ><hr>Manuali e informazioni di gioco<hr></td>
		</tr>
		<tr>
			<td>
				<a href="https://drive.google.com/file/d/0BwbyMyT-GT-UZUZUcXhscmp3bVU/view" class="w3-btn w3-white w3-ripple w3-left-align" style="width:400px;" target="_blank"> Guida alla creazione del personaggio</a>
			</td>
			<td>
				<a href="https://drive.google.com/file/d/0BwbyMyT-GT-UaGluODVPczdhRkE/view" class="w3-btn w3-white w3-ripple w3-left-align" style="width:400px;" target="_blank"> Ambientazione Generale</a>
			</td>
		</tr>		
		<tr>
			<td>
				<a href="https://drive.google.com/file/d/0BwbyMyT-GT-UZFBwNmp4SHZ6SFk/view" class="w3-btn w3-white w3-ripple w3-left-align" style="width:400px;" target="_blank"> Regolamento</a>
			</td>
		
			<td>
				<a href="https://drive.google.com/file/d/0BwbyMyT-GT-UR2loVWQwbWh3LXM/view" class="w3-btn w3-white w3-ripple w3-left-align" style="width:400px;" target="_blank"> Usi e Costumi della Camarilla</a>
			</td>
		</tr>
		<tr>
			<td>
				<a href="https://drive.google.com/file/d/0BwbyMyT-GT-UbndjUk9aSHZ6NkE/view" class="w3-btn w3-white w3-ripple w3-left-align" style="width:400px;" target="_blank"> Lista Pregi e Difetti</a>
			</td>
			<td>
				<a href="https://drive.google.com/file/d/1j8Y2ipW1PRwSvw80one2ktcgX_lRREje/view" class="w3-btn w3-white w3-ripple w3-left-align" style="width:400px;" target="_blank"> Le Posizioni di Potere</a>
			</td>
		</tr>

		
		
		<tr>
			<td colspan=2 class="alc title2" ><hr>Materiale specifico di Clan<hr></td>
		</tr>
		<tr>		
		<? if ($idclan==7) { ?>

			<td>
				<a href="https://drive.google.com/file/d/0BwbyMyT-GT-URWlmTUtjNUhfc0E/view" class="w3-btn w3-white w3-ripple w3-left-align" style="width:400px;" target="_blank"  > Rituali Taumaturgici</a>
			</td>
		<? } else { ?>
			<td>
				<button class="w3-btn w3-white w3-ripple w3-left-align" style="width:400px;" disabled > Rituali Taumaturgici</button>
			</td>
		<? } ?>
		<? if ($idclan==11) { ?>
			<td>
				<a href="https://drive.google.com/file/d/0BwbyMyT-GT-UX3VNX1U4T21pejA/view" class="w3-btn w3-white w3-ripple w3-left-align" style="width:400px;" target="_blank"  > Rituali Negromantici</a>
			</td>
		<? } else {?>
			<td>
				<button class="w3-btn w3-white w3-ripple w3-left-align" style="width:400px;"  disabled > Rituali Negromantici</button>
			</td>
		<? } ?>
		</tr>		
		<tr>		
		<? if ($idclan==2) { ?>
			<td>
				<a href="https://drive.google.com/file/d/0BwbyMyT-GT-UNE1DVEZsT3l2S1E/view" class="w3-btn w3-white w3-ripple w3-left-align" style="width:400px;" target="_blank"  > Info Ventrue</a>
			</td>
		<? } else { ?>
			<td>
				<button class="w3-btn w3-white w3-ripple w3-left-align"  style="width:400px;"  disabled > Info Ventrue</button>
			</td>
		<? } ?>
		<td>
			<a href="<?=$link?>" class="w3-btn w3-white w3-ripple w3-left-align" style="width:400px;" target="_blank"  > Conoscenze e Obiettivi di Clan</a>
		</td>
		</tr>
		<tr>
			<td colspan=2><button class="w3-btn w3-white w3-border w3-border-blue w3-round w3-block" onclick="javascript:window.location.href='main.php'">Indietro</button></td>
		</tr>			
	</table>
	</div>
</body>
	
		
