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

	$Mysql="select count(*) as a from personaggio where idutente=$idutente";
	$Res=mysql_fetch_array(mysql_query($Mysql));

	$numscheda=$Res['a'];


	$admin=0;
	$Mysql="select admin from utente where idutente=$idutente";
	$Res=mysql_fetch_array(mysql_query($Mysql));

	if ($Res['admin']==1) {
		$_SESSION['admin']=1;
		$admin=1;
	} else {

		//come utente normale faccio check su fdv

		$Mysql="SELECT fdv,fdvmax,lastfdv FROM personaggio WHERE idutente=$idutente";
		$Result=mysql_query ($Mysql);
		$res=mysql_fetch_array($Result);

		$fdv=$res['fdv'];
		$fdvmax=$res['fdvmax'];
		$lastfdv=$res['lastfdv'];

		if ( $fdv == $fdvmax ) {  // tutto ok

			$Mysql="UPDATE personaggio SET lastfdv=NOW()  WHERE idutente=$idutente";
			$Result=mysql_query ($Mysql);
		} else {

			$base=strtotime("2017-01-01 18:00:00");
			$qlastftv=strtotime($lastfdv);
			$now=time();

			$tramonti0=floor( ($qlastftv - $base)/( 24*60*60 )) ;
			$tramonti1=floor(($now - $base) / ( 24*60*60 ) );

			$difftramonti=$tramonti1-$tramonti0;


			if ( $difftramonti > 0 ) {

				$newfdv=$fdv+$difftramonti;
				if ($newfdv > $fdvmax)  {$newfdv=$fdvmax ;}

				$newlastfdv=$base + $tramonti1*( 24*60*60 )+1;

				$newlastfdvstring=date("Y-m-d H:i:s",$newlastfdv );

				$Mysql="UPDATE personaggio SET fdv = $newfdv , lastfdv = '$newlastfdvstring' WHERE idutente=$idutente";
				$Result=mysql_query ($Mysql);

			} else {
				// echo "<br>da quando ho controlato fdv non è passato un tramonto";
			}

		}

		//fine test su fdv
		//inizio test su ps

		$Mysql="SELECT PScorrenti, sete, lastps FROM personaggio LEFT
			JOIN statuscama ON personaggio.idstatus = statuscama.idstatus
			JOIN blood ON personaggio.bloodp = blood.bloodp
			WHERE idutente=$idutente";
		$Result=mysql_query ($Mysql);
		$res=mysql_fetch_array($Result);

		$PScorrenti=$res['PScorrenti'];
		$ps=$res['sete']+$res['addsete'];
		$lastps=$res['lastps'];

		if ( $PScorrenti == $ps ) {  // tutto ok
			//
		} else {
			$now=time();
			$qlastps=strtotime($lastps);

			$diff =  ($now - $qlastps) / (24*60*60);

			if ( $diff > 1 ) {
				$newlastps=date("Y-m-d H:i:s",$now );
				$Mysql="UPDATE personaggio SET PScorrenti = $ps , lastps = '$newlastps' WHERE idutente=$idutente";
				$Result=mysql_query ($Mysql);
			}

		}

		//fine test su ps
		// legami
	  $Mysql="DELETE FROM legami WHERE target = $idutente and livello = 1 and (DATE_ADD(dataultima, INTERVAL 60 DAY) < NOW())";
    $Result = mysql_query($Mysql);
	  $Mysql="UPDATE legami SET livello=1 , dataultima=NOW() WHERE target = $idutente and livello = 2 and (DATE_ADD(dataultima, INTERVAL 150 DAY) < NOW())";
    $Result = mysql_query($Mysql);
    $Mysql="UPDATE legami SET livello=2 , dataultima=NOW() WHERE target = $idutente and livello = 3 and (DATE_ADD(dataultima, INTERVAL 300 DAY) < NOW())";
    $Result = mysql_query($Mysql);

		//fine test legami

	}

	if ($_POST['accept'] == "on" ) {

		$Mysql="UPDATE utente set accept=1 where idutente=$idutente";
		$Result=mysql_query($Mysql);



	}


	$Mysql="select accept from utente where idutente=$idutente";
	$Result=mysql_query($Mysql);
	$res=mysql_fetch_array($Result);
	$accept=$res['accept'];

	$norifugio = 0 ;
	if ($numscheda != 0 ) {
		$Mysql="select rifugio, zona from personaggio where idutente=$idutente";
		$Result=mysql_query($Mysql);
		$res=mysql_fetch_array($Result);
		if ( $res['rifugio'] == '') {
			$norifugio=1;
		}
	}



	$nonora=0;

	if ( $_POST ['scelta'] == 'KO') {
		 $nonora=1;
	} elseif ($_POST ['scelta'] == 'OK')  {
		$r=mysql_real_escape_string($_POST['rifugio']);
		$z=mysql_real_escape_string($_POST['zona']);
		$Mysql="UPDATE personaggio SET rifugio = '$r',   zona= '$z'  WHERE idutente=$idutente";
		mysql_query($Mysql);
		$norifugio = 0 ;
	}


	$Mysql="SELECT chance from chanceviolazione";
	$Result=mysql_query($Mysql);
	$res=mysql_fetch_array($Result);
	$chance=$res['chance'];


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Notturna - Cronaca di Roma</title>
	<link href="https://fonts.googleapis.com/css?family=Libre+Baskerville" rel="stylesheet">
	<link href="w3.css" rel="stylesheet">

	<style type="text/css">

	/* The Modal (background) */
	.modal {
		display: none; /* Hidden by default */
		position: fixed; /* Stay in place */
		z-index: 1; /* Sit on top */
		padding-top: 100px; /* Location of the box */
		left: 0;
		top: 0;
		width: 100%; /* Full width */
		height: 100%; /* Full height */
		overflow: auto; /* Enable scroll if needed */
		background-color: rgb(0,0,0); /* Fallback color */
		background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	}

	/* Modal Content */
	.modal-content {
		position: relative;
		background-color: #fefefe;
		margin: auto;
		padding: 0;
		border: 1px solid #888;
		width: 80%;
		box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
		-webkit-animation-name: animatetop;
		-webkit-animation-duration: 0.4s;
		animation-name: animatetop;
		animation-duration: 0.4s
	}

	/* Add Animation */
	@-webkit-keyframes animatetop {
    	from {top:-300px; opacity:0}
    	to {top:0; opacity:1}
	}

	@keyframes animatetop {
    	from {top:-300px; opacity:0}
    	to {top:0; opacity:1}
	}


	.modal-header {
    	padding: 2px 16px;
    	background-color: #0e0e0e
    	color: white;
	}

	.modal-body {padding: 2px 16px;}

	.modal-footer {
    	padding: 2px 16px;
    	background-color: #aaaaaa;
    	color: black;
	}


	body {
			font-family: arial, sans-serif;
			font-size: 1.1em;
	}


	</style>
	<script>

	var accept=<?=$accept?>;
	var idutente=<?=$idutente?>;
	var norifugio=<?=$norifugio?>;
	var nonora=<?=$nonora?>;



	function conferma() {
    	var txt;
    	var r = confirm("Sei sicuro di cancellare la scheda? L'operazione è irreversibile!\nPremi OK per confermare.");
    	if (r == true) {
			window.location.href="cancella.php";
    	}
	}

	function openmodal(){
		// Get the modal
		var modal = document.getElementById('myModal');
		// open the modal
		modal.style.display = "block";
	}

	function openmodal2(){
		// Get the modal
		var modal = document.getElementById('rifugioModal');
		// open the modal
		modal.style.display = "block";
	}
	</script>



</head>
<body>




<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
    </div>
    <div class="modal-body" style="height:600px; overflow-y: scroll;">

		<h2>Regole di condotta durante gli eventi denominati NOTTURNA — Cronaca di Roma</h2>
		<ol>
			<li>E' obbligatorio tenere un comportamento civile tra tutti i partecipanti dell'evento. Ovviamente bisogna considerare che, una volta in gioco, i personaggi potrebbero avere atteggiamenti diversi da quelli che la nostra società ritiene civili, vista la natura stessa dell'evento, ma non sarà tollerata nessuna violazione di questa regola al di fuori dagli accadimenti della cronaca.</li>
			<li>Ognuno è responsabile di se stesso e delle sue azioni.</li>
			<li>E' vietato arrecare danno a persone o ad oggetti. A tale scopo bisogna utilizzare l'equipaggiamento adatto per questo tipo di eventi. Lo stesso verrà sempre controllato dallo Staff organizzativo. Per qualsiasi dubbio contattateci alla mail seguente : info.epica@libero.it</li>
			<li>E' vietato il contatto fisico esagerato durante gli scontri. Per contatto fisico esagerato si intende : spinte violente, calci, pugni, schiaffi o qualsivoglia altro tipo di comportamento violento non consono allo spirito dell'evento ludico.</li>
			<li>E' vietato assolutamente affondare con le armi.</li>
			<li>E' vietato colpire alla testa e/o nelle parti intime.</li>
			<li><b>E' vietato rubare oggetti di qualsiasi natura che non siano segnalati con l'apposito cartellino oggetto. Se capitasse di trovare un oggetto non proprio, siete tenuti a consegnarlo direttamente ad un membro dello Staff organizzativo. </b></li>
		</ol>
		<p>La mancata osservanza delle regole di condotta e di qualsiasi altro comportamento non consono ad un evento ludico ed alla società civile, sarà punito a giudizio INSINDACABILE dello Staff organizzativo. Qualsivoglia rimostranza in merito alle decisioni dell'organizzazione, non sarà presa in considerazione che dal giorno seguente l'evento. Questo per permettere agli altri partecipanti di continuare a veder tutelato il loro diritto di divertirsi nel rispetto delle regole e del gioco.</p>
		<h2>Il Metaplay</h2>
		Con "Metaplay" si intendono tutte quelle azioni che portano il giocatore a infrangere le regole in game e, quindi, a barare. E' Metaplay quando:
		<ol>
			<li>Si sfruttano delle informazioni ottenute FUORI dal gioco, come se fossero state ottenute ALL'INTERNO del gioco. Questa cosa non è ammissibile, poiché le storie dei vostri personaggi si sviluppano sulla base delle caratteristiche che gli avete dato e si costruiscono proprio in base alle trame di ogni singolo player. Basta che uno solo riveli un'informazione ottenuta magari di straforo che ecco si vanno a compromettere gli equilibri in game.</li>
			<li>Si mente sulle proprie reali abilità o sui punteggi delle schede. Le schede esistono appositamente per dare a ognuno la possibilità di interagire in maniera equa con gli altri giocatori. E' un gioco e come tale, qualche volta si vince e qualche volta si perde e si deve accettare la propria "sconfitta": se pur di non ammettere di aver perso un piccolo scontro o una disputa si verte a cambiare le carte in tavola, l'ammonizione è automatica. Per tale motivo, onde evitare episodi simili, bisogna avere sempre con sé la propria scheda, cui copia è pervenuta anche ai Narratori, affinché possano controllarla.</li>
			<li>Si monopolizza il personaggio di un giocatore meno esperto per i propri scopi, convincendolo FUORI gioco ad affidarsi completamente alle cure di qualcuno che gioca da più tempo. Poiché è diritto di OGNUNO quello di poter giocare ed essere protagonista della propria storia e non una mera comparsa nella trama di qualcun altro, ricordate sempre di essere rispettosi nei confronti degli altri. Un conto è dare una mano, un conto è manipolare le azioni di un giocatore perché la cosa frutti soltanto a voi stessi. Va bene raggirare qualcuno ALL'INTERNO della trama, mai in OFF.</li>
		</ol>
			<p><b>Sanzioni</b>
			<br>Le sanzioni che lo Staff organizzativo può comminare ai partecipanti sono di quattro diverse tipologie e dipendono dalla gravità dell'infrazione commessa.
			<p><b>Allontanamento permanente dagli Eventi</b>
			<br>Questa è la sanzione più grave, in quanto prevede l'allontanamento permanente di uno o più soggetti dalla comunità di NOTTURNA, senza possibilità di ritorno. L'applicazione di questa sanzione avviene con effetto immediato ed è decisa a causa di una violazione particolarmente grave.
			<p><b>Allontanamento dalla Sessione di Gioco in corso</b>
			<br>La persona o le persone a cui viene applicata questa sanzione è invitata ad allontanarsi dall'area di gioco per un determinato tempo, che può estendersi a tutta la durata dell'evento in corso. Se il comportamento negativo venisse reiterato nel tempo, la sanzione può convertirsi in permanente.
			<p><b>Perdita parziale/totale dei punti esperienza (PX) per l'Evento in corso</b>
			<br>La persona o le persone a cui viene applicata questa sanzione perde parzialmente/ totalmente i PX che avrebbero ricevuto per l'evento in corso. Se il comportamento negativo venisse reiterato nel tempo, la sanzione può convertirsi in un allontanamento dalla sessione di gioco.
			<p><b>Richiamo</b>
			<br>La sanzione più leggera e frequente nel gioco è il richiamo, che non comporta nessun tipo di provvedimento per la persona, ma se nell'arco dello stesso evento si ricevessero 2 richiami, la sanzione si convertirebbe nella perdita parziale o totale dei punti esperienza relativi alla sessione in corso.
	</div>
    <div class="modal-footer alc">
		<form method="post" action="#" name="FormAccept"><b>Ho letto e accetto il regolamento</b><input type="checkbox" name="accept" id="accept"></form>
    </div>
  </div>

</div>


<div id="rifugioModal" class="modal">
	<form method="post" action="#" name="FormRifugio">
		<div class="modal-content">
			<div class="modal-header">
    	</div>
			<div class="modal-body" style="height:400px; overflow-y: scroll;">
				<h2>Inserimento Rifugio PG e Zona del Giocatore </h2>
				<p>Nella scheda non è definito il Rifugio del Personaggio né la Zona abitativa del Giocatore.</p>
				<p></p>
				<table>
					<tr>
						<td>Rifugio</td><td><input type="text" size=40 name="rifugio"></input></td>
					</tr>
					<tr>
						<td>Zona</td><td><input type="text" size=40 name="zona"></input></td>
					</tr>
				</table>
			</div>
			<div class="modal-footer alc">

				<button name="scelta" value="OK"  onclick="document.FormRifugio.submit();" class="w3-button w3-white w3-ripple w3-left-align">OK</button>
				<button name="scelta" value="KO"  onclick="document.FormRifugio.submit();" class="w3-button w3-red w3-ripple w3-left-align">Non Ora</button>

	    </div>
		</div>
	</form>
</div>


	<script>

	if ( accept == "0"  ) {

		openmodal();


		// Get the <span> element that closes the modal

		var box = document.getElementById("accept");

		// When the user clicks on <span> (x), close the modal

		box.onclick = function() {
			var modal = document.getElementById('myModal');
    		modal.style.display = "none";
			FormAccept.submit();
		}

	}

	if ( norifugio!=0 && nonora != 1) {
		openmodal2();
	}


	</script>


	<div align="center">
	<table style="border:0; cellpadding:1; cellspacing:1;">
		<tr>
			<td colspan=2><img src="notturnalogo.png" height=300 width=320></td>
		</tr>
	</table>

	<table style="border:0; cellpadding:1; cellspacing:1;" >

<?	if ( $admin == 1 ) {
?>
			<tr>
			<td class="tdc">
				<a href="tavoladadi.php" class="w3-btn w3-white w3-ripple w3-left-align" style="width:350px;"><img src="img/dice.png" height="50" width="50" style="vertical-align:middle"> Fattore Aleatorio</a>
			</td>
			<td class="tdc">
				<a href="oggetti.php" class="w3-btn w3-white w3-ripple w3-left-align" style="width:350px;"><img src="img/oggetti.png" height="50" width="50" style="vertical-align:middle"> Creazione/gestione Oggetti</a>
			</td>
			<td class="tdc"><form method=post action="scheda2.php" name="osserva">
				<div class="w3-btn w3-white w3-ripple w3-left-align" ><img src="img/observe.png" height="50" width="50" style="vertical-align:middle" onclick="document.osserva.submit()"><select name="id">
<?  			$Mysql ="SELECT nomepg, idutente FROM personaggio ORDER BY nomepg";
				$Result=mysql_query($Mysql);
				while ($res=mysql_fetch_array($Result) ){
?>
				<option value="<?=$res['idutente']?>" ><?=$res['nomepg']?></option>
<?
				}
?>
				</select></div></form>
			</td>
				</tr>

					<tr>
						<td><form action="wsadmin/newchance.php" method="post">Chance Violazione Masq. <input name="chance"  type=number min=1 max=99 style="width: 40px" value=<?=$chance?> required /> <button class="w3-button w3-small w3-round w3-gray w3-hover-red">Cambia</button></post></td>
						<td>&nbsp;</td>
			<td class="tdc"><form method=post action="bg2.php" name="cambia">
				<div class="w3-btn w3-white w3-ripple w3-left-align" ><img src="img/master.png" height="50" width="50" style="vertical-align:middle" onclick="document.cambia.submit()"> <select name="id">
<?  			$Mysql ="SELECT nomepg, idutente FROM personaggio ORDER BY nomepg";
				$Result=mysql_query($Mysql);
				while ($res=mysql_fetch_array($Result) ){
?>
				<option value="<?=$res['idutente']?>" ><?=$res['nomepg']?></option>
<?
				}
?>
				</select></div></form>
		</tr>
<?
} else {
		if ( $numscheda == 0   ) { ?>
		<tr>
			<td class="tdc">
				<!-- <a href="registra0.php"><div class="w3-btn w3-white w3-ripple w3-left-align" style="width:300px;"><img src="http://via.placeholder.com/50x50" style="vertical-align:middle"> Crea la scheda</div></a> -->
				<a href="registra0.php" class="w3-btn w3-white w3-ripple w3-left-align" style="width:350px;"><img src="img/edit.png" height="50" width="50" style="vertical-align:middle"> Crea la scheda</a>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
<? }  else { ?>
		<tr>
			<td class="tdc">
				<a href="scheda.php" class="w3-btn w3-white w3-ripple w3-left-align" style="width:350px;"><img src="img/observe.png" height="50" width="50" style="vertical-align:middle"> Visualizza la scheda</a>
			</td>
			<td class="tdc">
				<a href="other.php" class="w3-btn w3-white w3-ripple w3-left-align" style="width:350px;"><img src="img/edit2.png" height="50" width="50" style="vertical-align:middle"> Aggiungi Pregi e Difetti</a>
			</td>
			<td class="tdc">
				<a href="bio.php" class="w3-btn w3-white w3-ripple w3-left-align" style="width:350px;"><img src="img/user2.png" height="50" width="50" style="vertical-align:middle"> Inserisci Biografia e Annotazioni</a>
			</td>

		</tr>
		<tr>
			<td class="tdc">
				<a href="spendipx.php" class="w3-btn w3-white w3-ripple w3-left-align" style="width:350px;"><img src="img/add.png" height="50" width="50" style="vertical-align:middle"> Aggiungi/Spendi PX</a>
			</td>
			<td class="tdc">
				<a href="rubrica.php" class="w3-btn w3-white w3-ripple w3-left-align" style="width:350px;"><img src="img/contacts.png" height="50" width="50" style="vertical-align:middle"> Visualizza/gestisci Rubrica</a>
			</td>
			<td class="tdc">
				<a href="bg.php" class="w3-btn w3-white w3-ripple w3-left-align" style="width:350px;"><img src="img/master.png" height="50" width="50" style="vertical-align:middle"> Modifica Fama , Background ecc..</a>
			</td>
		</tr>
		<tr>
			<td class="tdc">
				<a href="sceglipoteri.php" class="w3-btn w3-white w3-ripple w3-left-align" style="width:350px;"><img src="img/ankh.png" height="50" width="50" style="vertical-align:middle"> Scegli Poteri</a>
			</td>
			<td class="tdc">
				<a href="logpx.php" class="w3-btn w3-white w3-ripple w3-left-align" style="width:350px;"><img src="img/logs.png" height="50" width="50" style="vertical-align:middle"> Visualizza Log PX</a>
			</td>
			<td class="tdc">
				<a href="tavoladadi.php" class="w3-btn w3-white w3-ripple w3-left-align" style="width:350px;"><img src="img/dice.png" height="50" width="50" style="vertical-align:middle"> Fattore Aleatorio</a>
			</td>
		</tr>
<? }
}?>
		<tr>
			<td class="tdc">
				<a href="user.php" class="w3-btn w3-white w3-ripple w3-left-align" style="width:350px;"><img src="img/user.png" height="50" width="50" style="vertical-align:middle"> Modifica email/password</a>
			</td>
			<td class="tdc">
				<a href="docs.php" class="w3-btn w3-white w3-ripple w3-left-align" style="width:350px;"><img src="img/books.png" height="50" width="50" style="vertical-align:middle"> Regolamento e doc vari</a>
			</td>



			<td class="tdc">
<? if ($admin != 1) {		?>
				<a href="javascript:conferma()"class="w3-btn w3-white w3-ripple w3-left-align" style="width:350px;"><img src="img/delete.png" height="50" width="50" style="vertical-align:middle"> Cancella la scheda</a>
<? } else { ?>
		&nbsp;
<? } ?>
			</td>
		</tr>

		<tr>
			<td class="tdc">
				&nbsp;
			</td>
			<td class="tdc">
				&nbsp;
			</td>
			<td class="tdc">
				<a href="index.php" class="w3-btn w3-white w3-ripple w3-left-align" style="width:350px;"><img src="img/logout.png" height="50" width="50" style="vertical-align:middle"> Logout</a>
			</td>
		</tr>
	</table>
	</div>
</body>
