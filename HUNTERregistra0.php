<?
	include ('session_start.inc.php');
	include ('db_start.inc.php');

	if (!isset ($_SESSION['idutente'])) {
		//die ("Errore, nessuna sessione attiva!");
		session_write_close();
		header("Location: index.php", true);
	}

  $idutente=$_SESSION['idutente'];

/*
	$Mysql="select count(*) as a from personaggio where idutente=$idutente";
	$Results=mysql_query($Mysql);
	$Res=mysql_fetch_array($Results);
  if ( $Res['a'] != 0 ) {
		header("Location: main.php", true);
	}
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Creazione personaggio</title>
<!-- <link rel="shortcut icon" href="favicon.ico" /> -->


<link href="https://fonts.googleapis.com/css?family=Libre+Baskerville" rel="stylesheet">
<link href="w3.css" rel="stylesheet" type="text/css" />
<style type="text/css">

	input[type=number] {
   		width:  80px;
   	-moz-appearance: textfield;
	}
	.title {
		font-family: 'Libre Baskerville', serif;
		font-size: 30px;
		}
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
	.owner {
		font-family: 'Libre Baskerville';
		font-size: 105%;
		font-weight: bold;
	}
	.title2 {
		font-size: 105%;
		font-weight: bold;
	}

</style>

<script>
function controlla() {

	var TheForm = document.Form0;

	var OK=1;

	var Nome= window.document.getElementById("nome").value.trim();






		if (TheForm.Clan.disabled==true) {
			TheForm.Clan.disabled=false;
			TheForm.Clan.value="";
		}






  if (TheForm.Clan.value == "") {
		OK=0;
		window.document.getElementById("aclan").innerHTML="Definire la Cospiracy del personaggio";
		window.document.getElementById("aclan").style.color="#F00";
	} else {
		window.document.getElementById("aclan").innerHTML="";
	}

	var NUMBACK=6;   // punti background
	var FDVBASE=2;  // FDV base



	window.document.getElementById("anumback").innerHTML=NUMBACK;


	var Contatti=parseInt(TheForm.Contatti.value);
	// var Gregge=parseInt(TheForm.Gregge.value);
	var Risorse=parseInt(TheForm.Risorse.value);
	var Seguaci=parseInt(TheForm.Seguaci.value);
	var Notorieta=parseInt(TheForm.Notorieta.value);
	var Mentore=parseInt(TheForm.Mentore.value);
	var Rifugio=parseInt(TheForm.Rifugio.value);
	// var Generazione=parseInt(TheForm.Generazione.value);


	var OKB=1;



  if ( !Contatti )  { Contatti=0 }
	if ( !Risorse ) { Risorse=0; }
	if ( !Seguaci )  { Seguaci=0; }
	if ( !Notorieta ) { Notorieta=0; }
	if ( !Mentore ) { Mentore=0;}
	if ( !Rifugio ) { Rifugio=1;}



  var TOTBACK = Contatti +  Risorse + Seguaci + Notorieta + Mentore + Rifugio  ;
	var RESBACK = NUMBACK - ( Contatti +  Risorse + Seguaci + Notorieta + Mentore + Rifugio )  ;

	window.document.getElementById("aresback").innerHTML=RESBACK;

	if ( RESBACK != 0 ) { OKB=0; }

	if ( OKB==0 ) {
		OK = 0 ;
		window.document.getElementById("aresback").style.color="#F00";
	} else {
		window.document.getElementById("aresback").style.color="";
	}




	//////////// contatti

	window.document.getElementById("tabellacontatti").style.display="none";


	if ( Contatti != "0" ) {
		window.document.getElementById("tabellacontatti").style.display="table";
	}


	if ( Contatti != "0" ) {
		var OKCC=1;

		var acontat = "";

		var DC1=TheForm.DescCont1.value.trim();
		var DC2=TheForm.DescCont2.value.trim();
		var DC3=TheForm.DescCont3.value.trim();
		var DC4=TheForm.DescCont4.value.trim();
		var DC5=TheForm.DescCont5.value.trim();
		var DC6=TheForm.DescCont6.value.trim();
		var C1=parseInt(TheForm.ValCont1.value);
		var C2=parseInt(TheForm.ValCont2.value);
		var C3=parseInt(TheForm.ValCont3.value);
		var C4=parseInt(TheForm.ValCont4.value);
		var C5=parseInt(TheForm.ValCont5.value);
		var C6=parseInt(TheForm.ValCont6.value);

    	if (!C1) { C1=0 };
   		if (!C2) { C2=0 };
		if (!C3) { C3=0 };
		if (!C4) { C4=0 };
		if (!C5) { C5=0 };
		if (!C6) { C6=0 };

		if ( DC1 == "" && C1 ) {OKCC=0; acontat="Inserire descrizione. ";}
		if ( DC2 == "" && C2 ) {OKCC=0; acontat="Inserire descrizione. ";}
		if ( DC3 == "" && C3 ) {OKCC=0; acontat="Inserire descrizione. ";}
		if ( DC4 == "" && C4 ) {OKCC=0; acontat="Inserire descrizione. ";}
		if ( DC5 == "" && C5 ) {OKCC=0; acontat="Inserire descrizione. ";}
		if ( DC6 == "" && C6 ) {OKCC=0; acontat="Inserire descrizione. ";}

		if ( C1 + C2 +C3 +C4 +C5 +C6 != Contatti) {OKCC=0; acontat+="Totale diverso dal valore \"Contatti\". ";}

		var arr = [ C1 , C2, C3 , C4 , C5 , C6];

		var tt=0; for ( i = 0 ; i < 6 ; i++) { arr[i]==5 ? tt++ :"" } if (tt >1 ) {OKCC=0; acontat+="Solo un primario. ";}
		var tt=0; for ( i = 0 ; i < 6 ; i++) { arr[i]==4 ? tt++ :"" } if (tt >3 ) {OKCC=0; acontat+="Max 3 secondiari. ";}
		var tt=0; for ( i = 0 ; i < 6 ; i++) { arr[i]==3 ? tt++ :"" } if (tt >3 ) {OKCC=0; acontat+="Max 3 terziari. ";}
		var tt=0; for ( i = 0 ; i < 6 ; i++) { arr[i]==2||arr[i]==1 ? tt++ :"" } if (tt >3 ) {OKCC=0; acontat+="Max 3 minori. ";}


		if ( OKCC==0 ) {
			OK = 0 ;
			window.document.getElementById("acontat").innerHTML=acontat;
			window.document.getElementById("acontat").style.color="#F00";
		} else {
			window.document.getElementById("acontat").innerHTML="";
		}

	}


	//////////// Fine


	var TOT1=5;
  var TOT2=4;
  var TOT3=2;
  var TOTX=11;


	var NUMATTI=4; //num attitudini
	var MAXSTAT=5; //max valore stat.



			TOT1=7;
			TOT2=5;
			TOT3=3;
			NUMATTI=5;
			MAXSTAT=7;




	/*****
	TheForm.Forza.max=MAXSTAT;
	TheForm.Destrezza.max=MAXSTAT;
	TheForm.Attutimento.max=MAXSTAT;
	TheForm.Carisma.max=MAXSTAT;
	TheForm.Persuasione.max=MAXSTAT;
	TheForm.Saggezza.max=MAXSTAT;
	TheForm.Percezione.max=MAXSTAT;
	TheForm.Intelligenza.max=MAXSTAT;
	TheForm.Prontezza.max=MAXSTAT;
	******/







	var totF=0;
	var totS=0;
	var totM=0;

	var Forza=parseInt(TheForm.Forza.value);
	var Destrezza=parseInt(TheForm.Destrezza.value);
	var Attutimento=parseInt(TheForm.Attutimento.value);
	var Carisma=parseInt(TheForm.Carisma.value);
	var Persuasione=parseInt(TheForm.Persuasione.value);
	var Saggezza=parseInt(TheForm.Saggezza.value);
	var Percezione=parseInt(TheForm.Percezione.value);
	var Intelligenza=parseInt(TheForm.Intelligenza.value);
	var Prontezza=parseInt(TheForm.Prontezza.value);



	TOTX = TOT1 + TOT2 + TOT3 ;

	window.document.getElementById("atotx").innerHTML=TOTX;
 	window.document.getElementById("atot1").innerHTML=TOT1;
	window.document.getElementById("atot2").innerHTML=TOT2;
	window.document.getElementById("atot3").innerHTML=TOT3;




	var OKC=1;

	if ( !Forza ) { Forza=0;}
	if ( !Destrezza ) { Destrezza=0; }
	if ( !Attutimento ) { Attutimento=0; }
	if ( !Carisma ) { Carisma=0; }
	if ( !Persuasione ) { Persuasione=0; }
	if ( !Saggezza ) { Saggezza=0; }
	if ( !Percezione ) { Percezione=0; }
	if ( !Intelligenza ) { Intelligenza=0; }
	if ( !Prontezza ) { Prontezza=0; }

	totF=Forza+Destrezza+Attutimento-3;
	totS=Carisma+Persuasione+Saggezza-3;
	totM=Percezione+Prontezza+Intelligenza-3;


	window.document.getElementById("totF").innerHTML=totF;
	window.document.getElementById("totS").innerHTML=totS;
	window.document.getElementById("totM").innerHTML=totM;
	window.document.getElementById("tot").innerHTML=TOTX-totF-totS-totM;

	var astat = "";
	if (TOTX-totF-totS-totM != 0 ) {
		OKC=0;
	} else {
		if ( !(totF==(TOT1) || totF==(TOT2)  || totF== (TOT3)) )  { OKC=0; astat="Distribuzione punti non corretta"; }
		if ( !(totS==(TOT1) || totS==(TOT2)  || totS== (TOT3)) )  { OKC=0; astat="Distribuzione punti non corretta";}
		if ( !(totM==(TOT1) || totM==(TOT2)  || totM== (TOT3)) )  { OKC=0; astat="Distribuzione punti non corretta";};
	}


	if ( OKC==0 ) {
		OK = 0 ;
		window.document.getElementById("tot").style.color="#F00";
		window.document.getElementById("astat").innerHTML=astat;
		window.document.getElementById("astat").style.color="#F00";
	} else {
		window.document.getElementById("tot").style.color="";
		window.document.getElementById("astat").innerHTML="";
	}



	// --------------- DISCIPLINE ------------





	var iddisc1=0;
	var iddisc2=0;
	var iddisc3=0;

	switch (TheForm.Clan.value ) {
		case "1":   //  Toreador
			window.document.getElementById("disc1").innerHTML="Ascendente";
			 iddisc1=2;
			window.document.getElementById("disc2").innerHTML="Auspex";
			 iddisc2=3;
			window.document.getElementById("disc3").innerHTML="Velocità";
				iddisc3=15;
		break;
	  case "2":   //  Ventrue
			window.document.getElementById("disc1").innerHTML="Ascendente";
			 iddisc1=2;
			window.document.getElementById("disc2").innerHTML="Dominazione";
				iddisc2=6;
			window.document.getElementById("disc3").innerHTML="Robustezza";
				iddisc3=12;
		break;
		case "3":		// Nosferatu
			window.document.getElementById("disc1").innerHTML="Animalità";
				iddisc1=1;
			window.document.getElementById("disc2").innerHTML="Oscurazione";
				iddisc2=8;
			window.document.getElementById("disc3").innerHTML="Potenza";
				iddisc3=17;
		break;

	}













	// --------------- ATTITUDINI ------------

	var MAXATTI;
	MAXATTI=Destrezza;
	if (MAXATTI>5) MAXATTI=5;
	window.document.getElementById("anumatti").innerHTML=NUMATTI;
	window.document.getElementById("amaxatti").innerHTML=MAXATTI;



	var OKAA=1;
	var msgaa="";

	var A23=parseInt(TheForm.A23.value);
	var A24=parseInt(TheForm.A24.value);
	var A25=parseInt(TheForm.A25.value);
	var A26=parseInt(TheForm.A26.value);
	var A27=parseInt(TheForm.A27.value);
	var A28=parseInt(TheForm.A28.value);

	if ( !A23) { A23=0;}
	if ( !A24) { A24=0;}
	if ( !A25) { A25=0;}
	if ( !A26) { A26=0;}
	if ( !A27) { A27=0;}
	if ( !A28) { A28=0;}


	if ( A23 > MAXATTI || A24 > MAXATTI || A25 > MAXATTI || A26 > MAXATTI || A27 > MAXATTI || A28 > MAXATTI ) { OKAA=0; msgaa="Valore attitudine troppo elevato"; }

	var totaaa = A23 + A24 + A25 + A26 + A27 + A28  ;

	if ( totaaa - NUMATTI != 0 ) { OKAA=0; }

	window.document.getElementById("totatti").innerHTML=(NUMATTI-totaaa);


	if ( OKAA==0 ) {
		OK = 0 ;
		window.document.getElementById("aatti").innerHTML=msgaa;
		window.document.getElementById("aatti").style.color="#F00";
		window.document.getElementById("totatti").style.color="#F00";
	} else {
		window.document.getElementById("aatti").innerHTML="";
		window.document.getElementById("totatti").style.color="";
	}


	// --------------- SKILL ------------

	var OKskil = 1;
	var totskill= 0;
	var NUMSKILL = 20;


	window.document.getElementById("NUMSKILL").innerHTML=NUMSKILL;

<?
$MySql = "SELECT * FROM skill_main WHERE tipologia = 0 ";
$Results = mysql_query($MySql);
while ( $Res = mysql_fetch_array($Results))  { ?>

	var F<?=$Res['idskill']?>=parseInt(TheForm.F<?=$Res['idskill']?>.value);
	if ( !F<?=$Res['idskill']?>) { F<?=$Res['idskill']?>=0;}
	totskill += F<?=$Res['idskill']?> ;
<?
 }
?>

	window.document.getElementById("totskill").innerHTML=NUMSKILL-totskill;

	if ( totskill != NUMSKILL  ) { OKskil=0; }

	if ( OKskil==0 ) {
		OK = 0 ;
		window.document.getElementById("totskill").style.color="#F00";
	} else {
		window.document.getElementById("totskill").style.color="";
	}


	// --------------- FDV ------------



	var fdv=2;





	// --------------- FINE ------------


	if (OK==1) {
		document.getElementById("Submit").disabled = false;
		document.getElementById("Submit").value = "OK - Prosegui";
		document.getElementById("Submit").style.color = "#0F0";

	} else {
		document.getElementById("Submit").disabled = true;
		document.getElementById("Submit").value = "KO - Prosegui";
		document.getElementById("Submit").style.color = "#F00";

	}

	var Pf = 8 ;
	Pf = ( 3 + Attutimento )*2 ;
	if (iddisc1 == 12 )  { Pf += disc1val };
	if (iddisc2 == 12 )  { Pf += disc2val };
	if (iddisc3 == 12 )  { Pf += disc3val };

	Pf += A28 ;  /* schivare */
	window.document.getElementById("apf").innerHTML=Pf;



}




</script>

</head>

<!-- <body bgcolor="#000000" color="#cccccc" link="#cc0000" alink="#eeeeee" vlink="#cc0000"> -->
<body>
<form id="Form0" name="Form0" method="post" action="registra1.php">

  <table width="65%" border="0" align="center" cellpadding="1" cellspacing="1">
		<tr>
			<td width="16.6%">&nbsp;</td>
			<td width="16.6%">&nbsp;</td>
			<td width="16.6%">&nbsp;</td>
			<td width="16.6%">&nbsp;</td>
			<td width="16.6%">&nbsp;</td>
			<td width="16.6%">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="6"><div align="center" ><p class="title">Creazione personaggio</p></div></td>
		</tr>
    <tr>
			<td colspan="6"><div align="center"><hr> Passo 1 - Dati del personaggio e Status iniziale <hr></div></td>
    </tr>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>

		<tr>
			<td colspan="3">Nome del Personaggio
			<input name="nome" id="nome" type="text" maxlength="25" pattern="[A-Z\ba-z\b][a-zA-Z\s']*" required onchange="controlla()"/></td>
			<td colspan="3" >Nome (reale) del Giocatore
			<input name="nomeplayer" id="nomeplayer" type="text" maxlength="25" pattern="[A-Z\ba-z\b][a-zA-Z\s']*" required onchange="controlla()"/></td>
		</tr>
    	<tr>
			<td >Cospiracy </td>
			<td colspan="2" class="alc">
        		<select name="Cospiracy" id="Clan" onchange="controlla()">
        		<option value=''></option>
<?
$MySql = "SELECT * FROM HUNcospiracy ";
$Results = mysql_query($MySql);
while ( $Res = mysql_fetch_array($Results))  {
	?> <option value='<?=$Res['idcospiracy']?>'><?=$Res['nomecospiracy']?></option> <?
}

?>
				</select>
			</td>
			<td >Status iniziale</td>
			<td colspan="2" class="alc">
					<span id=astatus></span>- - -</td>
			</td>
			<tr>
			<td colspan="6" align="center"><span id="aclan">&nbsp;</span></td>
		</tr>
		</tr>
			<tr>
			<td >SafeHouse</td>
			<td align="center"><input name="rifugio" id="rifugio" type="text" maxlength="49" pattern="[A-Z\ba-z\b][a-zA-Z0-9\s']*" required onchange="controlla()"/></td>
			<td >Indirizzo (o zona indicativa) del GIOCATORE</td>
			<td align="center"><input name="zona" id="zona" type="text" maxlength="49" pattern="[A-Z\ba-z\b][a-zA-Z0-9\s']*" required onchange="controlla()"/></td>
			<td>Punti Ferita</td>
			<td><span id="apf">8</span></td>
		</tr>

		</tr>

	</table>
	<!-- ------------
	TABLE BACKGROUND
	------>
  <table width="65%" border="0" align="center" cellpadding="1" cellspacing="1">
		<tr>
     	<td colspan="6"><div align="center" ><hr> Passo 2 - Background <hr></div></td>
		</tr>
    	<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
		<tr>
			<td>Contatti</td>
      		<td><input name="Contatti" id="Contatti" type=number min=0 max=20 value=0 required onChange="controlla()"/> (max 20)</td>
      		<td>Notorietà</td>
      		<td><input name="Notorieta" id="Notoriet" type=number min=0 max=5 size=1 value=0 required onChange="controlla()"/></td>
      		<td>Risorse</td>
      		<td><input name="Risorse" id="Risorse" type=number min=0 max=5 size=1 value=0 required onChange="controlla()"/></td>
		</tr>
    	<tr>
			<td>Collaboratori</td>
    		<td><input name="Seguaci" id="Seguaci" type=number min=0 max=5 size=1 value=0 required onChange="controlla()"/></td>
    		<td>Mentore</td>
	    	<td><input name="Mentore" id="Mentore" type=number min=0 max=5 size=1 value=0 required onChange="controlla()"/></td>
				<td>SafeHouse (min.1)</td>
				<td><input name="Rifugio" id="Rifugio" type=number min=1 max=5 size=1 value=1 required onChange="controlla()"/></td>
		</tr>

  		<tr>
      		<td colspan="6">&nbsp;</td>
    	</tr>
		<tr>
      		<td colspan="6" align="center">Valore massimo per singolo background: 5 se non altrimenti indicato.<p> Totale punti background da distribuire: <span id="aresback">6</span>/<span id="anumback">6</span> . </td>
    	</tr>
  </table>
	<!-------------
	TABLE CONTATTI
	-------->
	<table id="tabellacontatti" width="65%" border="0" align="center" cellpadding="1" cellspacing="1" style="display: none">
		<tr>
			<td colspan="5" align="center"><hr><p>Dettaglio contatti<hr></td>
		</tr>
		<tr>
			<td><input name="DescCont1" id="DescCont1" type=text maxlength="20" size="20" value="" pattern="[0-9\bA-Z\ba-z\b][0-9a-zA-Z\s']*" onChange="controlla()"/></td>
			<td><input name="ValCont1" id="ValCont1" type=number min=0 max=5 size=1 value=0 required onChange="controlla()"/></td>
			<td>&nbsp;</td>
			<td><input name="DescCont2" id="DescCont2" type=text maxlength="20" size="20" value="" pattern="[0-9\bA-Z\ba-z\b][0-9a-zA-Z\s']*" onChange="controlla()"/></td>
			<td><input name="ValCont2" id="ValCont2" type=number min=0 max=5 size=1 value=0 required onChange="controlla()"/></td>
		</tr>
		<tr>
			<td><input name="DescCont3" id="DescCont3" type=text maxlength="20" size="20" value="" pattern="[0-9\bA-Z\ba-z\b][0-9a-zA-Z\s']*" onChange="controlla()"/></td>
			<td><input name="ValCont3" id="ValCont3" type=number min=0 max=5 size=1 value=0 required onChange="controlla()"/></td>
			<td>&nbsp;</td>
			<td><input name="DescCont4" id="DescCont4" type=text maxlength="20" size="20" value="" pattern="[0-9\bA-Z\ba-z\b][0-9a-zA-Z\s']*" onChange="controlla()"/></td>
			<td><input name="ValCont4" id="ValCont4" type=number min=0 max=5 size=1 value=0 required onChange="controlla()"/></td>
 	   </tr>
		<tr>
			<td><input name="DescCont5" id="DescCont5" type=text maxlength="20" size="20" value="" pattern="[0-9\bA-Z\ba-z\b][0-9a-zA-Z\s']*" onChange="controlla()"/></td>
			<td><input name="ValCont5" id="ValCont5" type=number min=0 max=5 size=1 value=0 required onChange="controlla()"/></td>
			<td>&nbsp;</td>
			<td><input name="DescCont6" id="DescCont6" type=text maxlength="20" size="20" value="" pattern="[0-9\bA-Z\ba-z\b][0-9a-zA-Z\s']*" onChange="controlla()"/></td>
			<td><input name="ValCont6" id="ValCont6" type=number min=0 max=5 size=1 value=0 required onChange="controlla()"/></td>
    	</tr>
		<tr>
			<td colspan="5">&nbsp;</td>
    	</tr>
		<tr>
			<td colspan="5">Inserire una descrizione succinta (p.es. "Min. Interno", "Questura di Roma", "Banca XYZ" ecc. ) dei contatti e il loro valore.</td>
		</tr>
		<tr>
			<td colspan="5" align="center"><span id="acontat">&nbsp;</span></td>
    	</tr>
	</table>
		<!-----------------
		TABLE ATTRIBUTI
		-------------->
	<table width="65%" border="0" align="center" cellpadding="1" cellspacing="1">
  		<tr>
    		<td colspan="6">&nbsp;</td>
    	</tr>
    	<tr>
      		<td colspan="6"><div align="center" ><hr> Passo 3 - Attributi <hr></div></td>
    	</tr>
    	<tr>
      		<td colspan="6">&nbsp;</td>
    	</tr>
   		<tr>
      		<td colspan="2" align="center" >Fisici</td>
      		<td colspan="2" align="center" >Sociali</td>
      		<td colspan="2" align="center" >Mentali</td>
		</tr>
    	<tr>
      		<td>Forza</td>
      		<td><input name="Forza" id="Forza" type=number min=1 max=5 size=1 value=1 required onchange="controlla()"/></td>
      		<td>Carisma</td>
      		<td><input name="Carisma" id="Carisma" type=number min=1 max=5 size=1 value=1 required onchange="controlla()"/></td>
      		<td>Percezione</td>
      		<td><input name="Percezione" id="Percezione" type=number min=1 max=5 size=1 value=1 required onchange="controlla()"/></td>
		</tr>
    	<tr>
      		<td>Destrezza</td>
      		<td><input name="Destrezza" id="Destrezza" type=number min=1 max=5 size=1 value=1 required onchange="controlla()"/></td>
      		<td>Persuasione</td>
      		<td><input name="Persuasione" id="Persuasione" type=number min=1 max=5 size=1 value=1 required onchange="controlla()"/></td>
      		<td>Intelligenza</td>
      		<td><input name="Intelligenza" id="Intelligenza" type=number min=1 max=5 size=1 value=1 required onchange="controlla()"/></td>
    	</tr>
    	<tr>
      		<td>Attutimento</td>
      		<td><input name="Attutimento" id="Attutimento" type=number min=1 max=5 size=1 value=1 required onchange="controlla()"/></td>
      		<td>Saggezza</td>
      		<td><input name="Saggezza" id="Saggezza" type=number min=1 max=5 size=1 value=1 required onchange="controlla()"/></td>
      		<td>Prontezza</td>
      		<td><input name="Prontezza" id="Prontezza" type=number min=1 max=5 size=1 value=1 required onchange="controlla()"/></td>
    	</tr>
    	<tr>
      		<td colspan="6">&nbsp;</td>
    	</tr>
    	<tr>
      		<td colspan="2" align="center" >Punti aggiunti: <span id="totF">0</span></td>
      		<td colspan="2" align="center" >Punti aggiunti: <span id="totS">0</span></td>
      		<td colspan="2" align="center" >Punti aggiunti: <span id="totM">0</span></td>
    	</tr>
    	<tr>
      		<td colspan="6">&nbsp;</td>
    	</tr>
		<tr>
      		<td colspan="6" align="center">Punti da aggiungere alle varie abilit&agrave;  : [  <span id="atot1">5</span> , <span id="atot2">4</span> , <span id="atot3">2</span> ] </td>
    	</tr>
   		<tr>
      		<td colspan="6" align="center" >Punti ancora da assegnare: <span id="tot">11</span> / <span id="atotx">11</span> </td>
    	</tr>
		<tr>
      		<td colspan="6" align="center" ><span id="astat">&nbsp;</span></td>
    	</tr>
	</table>
	<!------------
		TABLE DISCIPLINE
	--------------->
	<table width="65%" border="0" align="center" cellpadding="1" cellspacing="1">
		<tr>
      		<td colspan="6">&nbsp;</td>
		</tr>
    	<tr>
			<td colspan="6"><div align="center" ><hr> Passo 4 - Discipline <hr></div></td>
    	</tr>
    	<tr>
      		<td colspan="6">&nbsp;</td>
    	</tr>
		<tr>
			<td colspan="6">
			<table id="tabellavili" width="100%" border="0" align="center" cellpadding="1" cellspacing="1" style="display: none">
			<tr>
			<td>Disciplina1</td>
			<td><select name="vile1" id="vile1" onchange="controlla()">
<?
			$mysql="SELECT * FROM discipline_main WHERE vili=1";
			$result=mysql_query($mysql);
			while ($res=mysql_fetch_array($result) ) {
?>
			<option value="<?=$res['iddisciplina']?>" label="<?=$res['nomedisc']?>" ><?=$res['nomedisc']?></option>
<?
			}
?>
				</select></td>
			<td>Disciplina2</td>
			<td><select name="vile2" id="vile2" onchange="controlla()">
<?
			$mysql="SELECT * FROM discipline_main WHERE vili=1";
			$result=mysql_query($mysql);
			while ($res=mysql_fetch_array($result) ) {
?>
			<option value="<?=$res['iddisciplina']?>" label="<?=$res['nomedisc']?>"><?=$res['nomedisc']?></option>
<?
			}
?>

				</select></td>
			<td>Disciplina3</td>
			<td><select name="vile3" id="vile3" onchange="controlla()">
<?
			$mysql="SELECT * FROM discipline_main WHERE vili=1";
			$result=mysql_query($mysql);
			while ($res=mysql_fetch_array($result) ) {
?>
			<option value="<?=$res['iddisciplina']?>" label="<?=$res['nomedisc']?>"><?=$res['nomedisc']?></option>
<?
			}
?>
				</select></td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td><span id="disc1">Disc #1</span></td>
			<td><input name="disc1val"  id="disc1val" type=number min=0 max=5 size=1 value=0 required onchange="controlla()"/></td>
			<td><span id="disc2">Disc #2</span></td>
			<td><input name="disc2val"  id="disc2val" type=number min=0 max=5 size=1 value=0 required onchange="controlla()"/></td>
			<td><span id="disc3">Disc #3</span></td>
			<td><input name="disc3val"  id="disc3val" type=number min=0 max=5 size=1 value=0 required onchange="controlla()"/></td>
		</tr>
		<tr>
      		<td colspan="6">&nbsp;</td>
    	</tr>
		<tr>
      		<td colspan="6" align="center">Punti da distribuire: <span id="totdisc">5</span> / <span id="anumdisc">5</span> . Il valore massimo della singola disciplina &egrave; <span id="amaxsdisc">3</span></td>
    	</tr>
    	<tr>
      		<td colspan="6" align="center"><span id="adisc">&nbsp;</span></td>
    	</tr>
	</table>
		<!---------
			TREMERE
			--------->
	<table width="65%" border="0" align="center" cellpadding="1" cellspacing="1" id="tabellatremere" style="display: none;">
  		<tr>
      		<td colspan="6">&nbsp;</td>
		</tr>
    	<tr>
			<td colspan="6"><div align="center" ><hr> Dettagli taumaturgie<hr></div></td>
    	</tr>
    	<tr>
      		<td colspan="6">&nbsp;</td>
    	</tr>
		<tr>
			<td>Via primaria</td>
			<td>
				<select name="Taumaturgia1" id="Taumaturgia1" onchange="controlla()">
        		<option value=''></option>
<?
$MySql = "SELECT * FROM taumaturgie_main ";
$Results = mysql_query($MySql);
while ( $Res = mysql_fetch_array($Results))  {
	?> <option value='<?=$Res['idtaum']?>'><?=$Res['nometaum']?></option>   <?
}

?>
				</select>
			</td>
			<td><input name="valtaum1" id="valtaum1" type=number min=0 max=5 size=1 value=0 required onchange="controlla()"> </td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Secondaria</td>
			<td>
				<select name="Taumaturgia2" id="Taumaturgia2" onchange="controlla()">
        		<option value=''></option>
<?
$MySql = "SELECT * FROM taumaturgie_main ";
$Results = mysql_query($MySql);
while ( $Res = mysql_fetch_array($Results))  {
	?> <option value='<?=$Res['idtaum']?>' ><?=$Res['nometaum']?></option>   <?
}

?>
				</select>
			</td>
			<td><input  name="valtaum2" id="valtaum2" type=number min=0 max=5 size=1 value=0 required onchange="controlla()"> </td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Terziaria</td>
			<td>
				<select name="Taumaturgia3" id="Taumaturgia3" onchange="controlla()">
        		<option value=''></option>
<?
$MySql = "SELECT * FROM taumaturgie_main ";
$Results = mysql_query($MySql);
while ( $Res = mysql_fetch_array($Results))  {
	?> <option value='<?=$Res['idtaum']?>'><?=$Res['nometaum']?></option>   <?
}

?>
				</select>
			</td>
			<td><input  name="valtaum3" id="valtaum3" type=number min=0 max=5 size=1 value=0 required onchange="controlla()"> </td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
      <td colspan="6" align="center"><span id="adisc2">&nbsp;</span></td>
    </tr>
	</table>
		<!---------
			Giovanni
		-------->
	<table width="65%" border="0" align="center" cellpadding="1" cellspacing="1" id="tabellagiovanni" style="display: none;">
		<tr>
      		<td colspan="6">&nbsp;</td>
		</tr>
    	<tr>
			<td colspan="6"><div align="center" ><hr> Dettagli negromanzie<hr></div></td>
    	</tr>
    	<tr>
      		<td colspan="6">&nbsp;</td>
    	</tr>
		<tr>
			<td>Via primaria</td>
			<td>
				<select name="Necromanzia1" id="Necromanzia1" onchange="controlla()">
        		<option value=''></option>
<?
$MySql = "SELECT * FROM necromanzie_main ";
$Results = mysql_query($MySql);
while ( $Res = mysql_fetch_array($Results))  {
	?> <option value='<?=$Res['idnecro']?>'><?=$Res['nomenecro']?></option>   <?
}

?>
				</select>
			</td>
			<td><input name="valnecro1" id="valnecro1" type=number min=0 max=5 size=1 value=0 required onchange="controlla()"> </td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Secondaria</td>
			<td>
				<select name="Necromanzia2" id="Necromanzia2" onchange="controlla()">
        		<option value=''></option>
<?
$MySql = "SELECT * FROM necromanzie_main ";
$Results = mysql_query($MySql);
while ( $Res = mysql_fetch_array($Results))  {
	?> <option value='<?=$Res['idnecro']?>'><?=$Res['nomenecro']?></option>   <?
}

?>
				</select>
			</td>
			<td><input name="valnecro2" id="valnecro2" type=number min=0 max=5 size=1 value=0 required onchange="controlla()"> </td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Terziaria</td>
			<td>
				<select name="Necromanzia3" id="Necromanzia3" onchange="controlla()">
        		<option value=''></option>
<?
$MySql = "SELECT * FROM necromanzie_main ";
$Results = mysql_query($MySql);
while ( $Res = mysql_fetch_array($Results))  {
	?> <option value='<?=$Res['idnecro']?>'><?=$Res['nomenecro']?></option>   <?
}

?>
				</select>
			</td>
			<td><input name="valnecro3" id="valnecro3" type=number min=0 max=5 size=1 value=0 required onchange="controlla()"> </td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
      		<td colspan="6" align="center"><span id="adisc3">&nbsp;</span></td>
    	</tr>
	</table>
		<!---------
			TABLE ATTITUDINI
		---------->
	<table width="65%" border="0" align="center" cellpadding="1" cellspacing="1" >
    	<tr>
      		<td colspan="4">&nbsp;</td>
    	</tr>
    	<tr>
      		<td colspan="4"><div align="center" ><hr> Passo 5 - Attitudini <hr></div></td>
    	</tr>
    	<tr>
      		<td colspan="4">&nbsp;</td>
    	</tr>

<?
$MySql = "SELECT * FROM skill_main WHERE tipologia = 1 ";
$Results = mysql_query($MySql);
while ( $Res = mysql_fetch_array($Results))  {
	?>

		<tr>
			<td><?=$Res['nomeskill']?></td>
			<td><input name="A<?=$Res['idskill']?>" id="A<?=$Res['idskill']?>" type=number min=0 max=5 size=1 value=0 required  onchange="controlla()"></td>
<? $Res = mysql_fetch_array($Results);
			if ($Res) {?>
 			<td><?=$Res['nomeskill']?></td>
			<td><input  name="A<?=$Res['idskill']?>" id="A<?=$Res['idskill']?>" type=number min=0 max=5 size=1 value=0 required  onchange="controlla()"></td>
<? } else { ?>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
<? } ?>

		</tr>
<?}?>
		<tr>
      		<td colspan="4">&nbsp;</td>
    	</tr>
		<tr>
      		<td colspan="4" align="center">Punti da distribuire tra le varie attitudini:  <span id="totatti">4</span> / <span id="anumatti">4</span> . Il valore massimo della singola attitudine &egrave; <span id="amaxatti">1</span> </td>
    	</tr>
		<tr>
      		<td colspan="4" align="center"><span id="aatti">&nbsp;</span></td>
    	</tr>
	</table>
		<!----------
			TABLE SKILL
		-------->
	<table width="65%" border="0" align="center" cellpadding="1" cellspacing="1" >
    	<tr>
      		<td colspan="4">&nbsp;</td>
    	</tr>
    	<tr>
      		<td colspan="4"><div align="center" ><hr> Passo 6 - Conoscenze <hr></div></td>
    	</tr>
    	<tr>
      		<td colspan="4">&nbsp;</td>
    	</tr>

<?
$MySql = "SELECT * FROM skill_main WHERE tipologia = 0 ";
$Results = mysql_query($MySql);
while ( $Res = mysql_fetch_array($Results))  {
	?>

		<tr>
			<td><?=$Res['nomeskill']?></td>
			<td><input name="F<?=$Res['idskill']?>" id="F<?=$Res['idskill']?>" type=number min=0 max=5 size=1 value=0 required  onchange="controlla()"></td>
<? $Res = mysql_fetch_array($Results);
			if ($Res) {?>
 			<td><?=$Res['nomeskill']?></td>
			<td><input  name="F<?=$Res['idskill']?>" id="F<?=$Res['idskill']?>" type=number min=0 max=5 size=1 value=0 required  onchange="controlla()"></td>
<? } else { ?>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
<? } ?>
		</tr>
<?}?>
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
		<tr>
      <td colspan="4" align="center">Punti da distribuire tra le varie Conoscenze:  <span id="totskill">25</span> / <span id="NUMSKILL">25</span> . </td>
		</tr>
		<tr>
      <td colspan="4">&nbsp;</td>
    </tr>
  </table>
	<!----------
			TABLE SKILL
		-------->
		<
	<!------  FINALE ------->

	<table width="65%" border="0" align="center" cellpadding="1" cellspacing="1" >
		<tr>
    	<td><div align="center" ><hr><hr></div></td>
    </tr>
		<tr>
			<td align="center"><input type="submit" id="Submit" name="Submit" value="KO - Registra" class="w3-btn w3-white w3-border w3-border-red w3-round w3-block " disabled></td>
    </tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><button class="w3-btn w3-white w3-border w3-border-blue w3-round w3-block" onclick="javascript:window.location.href='main.php'">Indietro</button></td>
	</tr>
	</table>

</form>
 	<p>&nbsp;
	<p>&nbsp;
	<p>&nbsp;

</body>
</html>
