<?
	include ('session_start.inc.php');
	include ('db_start.inc.php');

	if (!isset ($_SESSION['idutente'])) {
		//die ("Errore, nessuna sessione attiva!");
		session_write_close();
		header("Location: index.php", true);
	}

  $idutente=$_SESSION['idutente'];

	$Mysql="select count(*) as a from personaggio where idutente=$idutente";
	$Results=mysql_query($Mysql);
	$Res=mysql_fetch_array($Results);
  if ( $Res['a'] != 0 ) {
		header("Location: main.php", true);
	}
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


	var g14 = window.document.getElementById("g14").checked;


	if ( g14 == true ) {
		TheForm.Clan.value=20; //vili
		TheForm.Generazione.value=-1;
		TheForm.Generazione.disabled=true;
		TheForm.Clan.disabled=true;
		ag14=1;

		//enable Alchimia
		// Get all options within <select id='vile1'>...</select>
		var op = document.getElementById("vile1").getElementsByTagName("option");
		for (var i = 0; i < op.length; i++) {
		  if (op[i].value == 18) {  op[i].disabled = false; }
		}
		var op = document.getElementById("vile2").getElementsByTagName("option");
		for (var i = 0; i < op.length; i++) {
		  if (op[i].value == 18) {  op[i].disabled = false; }
		}
		var op = document.getElementById("vile3").getElementsByTagName("option");
		for (var i = 0; i < op.length; i++) {
		  if (op[i].value == 18) {  op[i].disabled = false; }
		}




	} else {
		if (TheForm.Clan.disabled==true) {
			TheForm.Clan.disabled=false;
			TheForm.Clan.value="";
			TheForm.Generazione.disabled=false;
			TheForm.Generazione.value=0;
		}

		ag14=0;
		//disaable Alchimia
		// Get all options within <select id='vile1'>...</select>
		var op = document.getElementById("vile1").getElementsByTagName("option");
		for (var i = 0; i < op.length; i++) {
		  if (op[i].value == 18) {  op[i].disabled = true ;}
		}
		// Get all options within <select id='vile1'>...</select>
		op = document.getElementById("vile2").getElementsByTagName("option");
		for (var i = 0; i < op.length; i++) {
			if (op[i].value == 18) {  op[i].disabled = true ;}
		}
		// Get all options within <select id='vile1'>...</select>
		op = document.getElementById("vile3").getElementsByTagName("option");
		for (var i = 0; i < op.length; i++) {
			if (op[i].value == 18) {  op[i].disabled = true ;}
		}
	}


  if (TheForm.Clan.value == "") {
		OK=0;
		window.document.getElementById("aclan").innerHTML="Definire il Clan del personaggio";
		window.document.getElementById("aclan").style.color="#F00";
	} else {
		window.document.getElementById("aclan").innerHTML="";
	}

	var NUMBACK=6;   // punti background
	var FDVBASE=2;  // FDV base
	var NUMDISC=5; // punti disciplina

	var Status= parseInt(window.document.getElementById("Status").value );



	switch (Status) {
		case 0:
			NUMBACK=5;
			FDVBASE=1;
			NUMDISC=4;
		break;
		case 1:
			NUMBACK=6;
			FDVBASE=2;
			NUMDISC=5;
    	break;
    	case 2:
			NUMBACK=8;
			FDVBASE=3;
			NUMDISC=6;
    	break;
		case 3:
			NUMBACK=10;
			FDVBASE=4;
			NUMDISC=7;
    	break;
    	case 4:
			NUMBACK=15;
			FDVBASE=5;
			NUMDISC=10;
    	break;
  		case 5:
			NUMBACK=25;
			FDVBASE=7;
			NUMDISC=15;
    	break;
  }

	window.document.getElementById("anumback").innerHTML=NUMBACK;


	var Contatti=parseInt(TheForm.Contatti.value);
	var Gregge=parseInt(TheForm.Gregge.value);
	var Risorse=parseInt(TheForm.Risorse.value);
	var Seguaci=parseInt(TheForm.Seguaci.value);
	var Notorieta=parseInt(TheForm.Notorieta.value);
	var Mentore=parseInt(TheForm.Mentore.value);
	var Rifugio=parseInt(TheForm.Rifugio.value);
	var Generazione=parseInt(TheForm.Generazione.value);


	var OKB=1;



  	if ( !Contatti )  { Contatti=0 }
	if ( !Gregge  )  { Gregge=0; }
	if ( !Risorse ) { Risorse=0; }
	if ( !Seguaci )  { Seguaci=0; }
	if ( !Notorieta ) { Notorieta=0; }
	if ( !Mentore ) { Mentore=0;}
	if ( !Rifugio ) { Rifugio=1;}
	if ( !Generazione ) { Generazione=0;}


  	var TOTBACK = Contatti + Gregge + Risorse + Seguaci + Notorieta + Mentore + Rifugio +  Generazione -1 + ag14 ;
	var RESBACK = NUMBACK - ( Contatti + Gregge + Risorse + Seguaci + Notorieta + Mentore + Rifugio +  Generazione -1 + ag14)  ;

	window.document.getElementById("aresback").innerHTML=RESBACK;

	if ( RESBACK != 0 ) { OKB=0; }

	if ( OKB==0 ) {
		OK = 0 ;
		window.document.getElementById("aresback").style.color="#F00";
	} else {
		window.document.getElementById("aresback").style.color="";
	}

	var Gen=13-Generazione;
	window.document.getElementById("agen").innerHTML=Gen;


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

	var MAXSDISC=3; // max valore disciplina
	var NUMATTI=4; //num attitudini
	var MAXSTAT=5; //max valore stat.


	switch (Gen) {
		case 14:
			TOT1=4;
			TOT2=3;
			TOT3=2;
			NUMATTI=4;
			MAXSTAT=5;
		break;
		case 13:
			TOT1=5;
			TOT2=4;
			TOT3=2;
			NUMATTI=4;
			MAXSTAT=5;
		break;
		case 12:
			TOT1=6;
			TOT2=4;
			TOT3=2;
			NUMATTI=4;
			MAXSTAT=5;
		break;
		case 11:
			TOT1=6;
			TOT2=5;
			TOT3=2;
			NUMATTI=4;
			MAXSTAT=5;
		break;
		case 10:
			TOT1=7;
			TOT2=5;
			TOT3=3;
			NUMATTI=5;
			MAXSTAT=7;
		break;
		case 9:
			TOT1=7;
			TOT2=6;
			TOT3=4;
			NUMATTI=7;
			MAXSTAT=8;
		break;
		case 8:
			TOT1=8;
			TOT2=6;
			TOT3=4;
			NUMATTI=8;
			MAXSTAT=9;
		break;
	}

	var maxdisctab  = [
		[ 2, 3, 3, 3,  3,  3,  4 ],
		[ 3, 3, 3, 3 , 3 , 4 , 5 ],
		[ 3, 4, 4, 4 , 4 , 5 , 5 ],
		[ 4, 5, 5, 5 , 5 , 5 , 5 ],
		[ 4, 5, 5, 5 , 5 , 5 , 5 ],
		[ 5, 5, 5, 5 , 5 , 5 , 5 ]
	];

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





	MAXSDISC=maxdisctab[Status][Generazione+g14];

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

	window.document.getElementById("anumdisc").innerHTML=NUMDISC;
	window.document.getElementById("amaxsdisc").innerHTML=MAXSDISC;


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
		case "4":		// Brujah
			window.document.getElementById("disc1").innerHTML="Ascendente";
			 iddisc1=2;
			window.document.getElementById("disc2").innerHTML="Potenza";
				iddisc2=17;
			window.document.getElementById("disc3").innerHTML="Velocità";
				iddisc3=15;
		break;
		case "5":		// Gangrel
			window.document.getElementById("disc1").innerHTML="Animalità";
				iddisc1=1;
			window.document.getElementById("disc2").innerHTML="Proteide";
				iddisc2=10;
			window.document.getElementById("disc3").innerHTML="Robustezza";
				iddisc3=12;
		break;
		case "6":		// Malkavian
			window.document.getElementById("disc1").innerHTML="Auspex";
				iddisc1=3;
			window.document.getElementById("disc2").innerHTML="Dominazione";
				iddisc2=6;
			window.document.getElementById("disc3").innerHTML="Oscurazione";
				iddisc3=8;
		break;
		case "7":		// Tremere
			window.document.getElementById("disc1").innerHTML="Auspex";
				iddisc1=3;
			window.document.getElementById("disc2").innerHTML="Dominazione";
				iddisc2=6;
			window.document.getElementById("disc3").innerHTML="Taumaturgia";
				iddisc3=98;
		break;
		case "8":		// Lasombra
			window.document.getElementById("disc1").innerHTML="Dominazione";
				iddisc1=6;
			window.document.getElementById("disc2").innerHTML="Potenza";
				iddisc2=17;
			window.document.getElementById("disc3").innerHTML="Ottenebramento";
				iddisc3=9;
		break;
		case "9":		// Tzimisce
			window.document.getElementById("disc1").innerHTML="Animalità";
				iddisc1=1;
			window.document.getElementById("disc2").innerHTML="Auspex";
				iddisc2=3;
			window.document.getElementById("disc3").innerHTML="Vicissitudine";
				iddisc3=16;
		break;
		case "10":	// Assamiti
			window.document.getElementById("disc1").innerHTML="Oscurazione";
				iddisc1=8;
			window.document.getElementById("disc2").innerHTML="Quietus";
				iddisc2=11;
			window.document.getElementById("disc3").innerHTML="Velocità";
				iddisc3=15;
		break;
		case "11":	// Giovanni
			window.document.getElementById("disc1").innerHTML="Dominazione";
				iddisc1=6;
			window.document.getElementById("disc2").innerHTML="Negromanzia";
				iddisc2=99;
			window.document.getElementById("disc3").innerHTML="Potenza";
				iddisc3=17;
		break;
		case "12":	// Ravnos
			window.document.getElementById("disc1").innerHTML="Animalità";
				iddisc1=1;
			window.document.getElementById("disc2").innerHTML="Chimerismo";
			 iddisc2=4;
			window.document.getElementById("disc3").innerHTML="Robustezza";
				iddisc3=12;
		break;
		case "13":	// Setiti
			window.document.getElementById("disc1").innerHTML="Ascendente";
			 iddisc1=2;
			window.document.getElementById("disc2").innerHTML="Oscurazione";
				iddisc2=8;
			window.document.getElementById("disc3").innerHTML="Serpentis";
				iddisc3=13;
		break;
	}

	if (TheForm.Clan.value==20) {
		window.document.getElementById("tabellavili").style.display="table";

		el=document.getElementById('vile1');
		window.document.getElementById("disc1").innerHTML=el.options[el.selectedIndex].innerHTML
		iddisc1=TheForm.vile1.value;

		el=document.getElementById('vile2');
		window.document.getElementById("disc2").innerHTML=el.options[el.selectedIndex].innerHTML
		iddisc2=TheForm.vile2.value;

		el=document.getElementById('vile3');
		window.document.getElementById("disc3").innerHTML=el.options[el.selectedIndex].innerHTML
		iddisc3=TheForm.vile3.value;


	} else {
		window.document.getElementById("tabellavili").style.display="none";
	}


	window.document.getElementById("tabellatremere").style.display="none";
	window.document.getElementById("tabellagiovanni").style.display="none";

	if ( TheForm.Clan.value == "7" ) {
		window.document.getElementById("tabellatremere").style.display="table";
	}
	if ( TheForm.Clan.value == "11" ) {
		window.document.getElementById("tabellagiovanni").style.display="table";
	}


	if ( TheForm.Clan.value != "7" && TheForm.Clan.value != "11" ) { // non giovanni, non tremere





		var disc1val=parseInt(TheForm.disc1val.value);
		var disc2val=parseInt(TheForm.disc2val.value);
		var disc3val=parseInt(TheForm.disc3val.value);

		var OKD=1;
		var msgdisc ="";

		if ( (iddisc1 == iddisc2) || ( iddisc1 == iddisc3 ) || ( iddisc2 == iddisc3 ) ) {  //controllo per vili
			OKD=0; msgdisc="Duplicazione ";
		}


		if ( !disc1val ) { disc1val=0; }
		if ( !disc2val ) { disc2val=0; }
		if ( !disc3val ) { disc3val=0; }
  	if ( ( disc1val > MAXSDISC ) || ( disc2val > MAXSDISC ) ||  ( disc3val > MAXSDISC ) )  { OKD=0; msgdisc+="Valore disciplina troppo elevato"; }

		var totdisc = disc1val + disc2val + disc3val ;

		if ( disc1val + disc2val + disc3val - NUMDISC != 0 ) { OKD=0; }

		window.document.getElementById("totdisc").innerHTML=(NUMDISC-totdisc);

		if ( OKD==0 ) {
			OK = 0 ;
			window.document.getElementById("adisc").innerHTML=msgdisc;
			window.document.getElementById("adisc").style.color="#F00";
			window.document.getElementById("totdisc").style.color="#F00";
		} else {
			window.document.getElementById("adisc").innerHTML="";
			window.document.getElementById("totdisc").style.color="";
		}

	} // fine clan normali


	// -----  Paranoia Jonathan....

	var op = document.getElementById("Taumaturgia1").getElementsByTagName("option");
	for (var i = 0; i < op.length; i++) {
  	if (op[i].value == "6" || op[i].value == "7" ) op[i].disabled = false;
	}
	var op = document.getElementById("Taumaturgia2").getElementsByTagName("option");
	for (var i = 0; i < op.length; i++) {
  	if (op[i].value == "6" || op[i].value == "7" ) op[i].disabled = false;
	}
	var op = document.getElementById("Taumaturgia3").getElementsByTagName("option");
	for (var i = 0; i < op.length; i++) {
  	if (op[i].value == "6" || op[i].value == "7" ) op[i].disabled = false;
	}

	var op = document.getElementById("Necromanzia1").getElementsByTagName("option");
	for (var i = 0; i < op.length; i++) {
  	if (op[i].value == "4" ) op[i].disabled = false;
	}
	var op = document.getElementById("Necromanzia2").getElementsByTagName("option");
	for (var i = 0; i < op.length; i++) {
  	if (op[i].value == "4"  ) op[i].disabled = false;
	}
	var op = document.getElementById("Necromanzia3").getElementsByTagName("option");
	for (var i = 0; i < op.length; i++) {
  	if (op[i].value == "4"  ) op[i].disabled = false;
	}

	if ( Status == 1 ) {
		if (TheForm.Taumaturgia1.value=="6" || TheForm.Taumaturgia1.value=="7") window.document.getElementById("Taumaturgia1").value="1" ;
		if (TheForm.Taumaturgia2.value=="6" || TheForm.Taumaturgia2.value=="7") window.document.getElementById("Taumaturgia2").value="1" ;
		if (TheForm.Taumaturgia3.value=="6" || TheForm.Taumaturgia3.value=="7") window.document.getElementById("Taumaturgia3").value="1" ;
		if (TheForm.Necromanzia1.value=="4") window.document.getElementById("Necromanzia1").value="1" ;
		if (TheForm.Necromanzia2.value=="4") window.document.getElementById("Necromanzia2").value="1" ;
		if (TheForm.Necromanzia3.value=="4") window.document.getElementById("Necromanzia3").value="1" ;

		var op = document.getElementById("Taumaturgia1").getElementsByTagName("option");
		for (var i = 0; i < op.length; i++) {
  		if (op[i].value == "6" || op[i].value == "7" ) op[i].disabled = true;
		}

		var op = document.getElementById("Taumaturgia2").getElementsByTagName("option");
		for (var i = 0; i < op.length; i++) {
  		if (op[i].value == "6" || op[i].value == "7" ) op[i].disabled = true;
		}

		var op = document.getElementById("Taumaturgia3").getElementsByTagName("option");
		for (var i = 0; i < op.length; i++) {
  		if (op[i].value == "6" || op[i].value == "7" ) op[i].disabled = true;
		}

		var op = document.getElementById("Necromanzia1").getElementsByTagName("option");
		for (var i = 0; i < op.length; i++) {
  		if (op[i].value == "4" ) op[i].disabled = true;
		}

		var op = document.getElementById("Necromanzia2").getElementsByTagName("option");
		for (var i = 0; i < op.length; i++) {
  		if (op[i].value == "4"  ) op[i].disabled = true;
		}

		var op = document.getElementById("Necromanzia3").getElementsByTagName("option");
		for (var i = 0; i < op.length; i++) {
  		if (op[i].value == "4"  ) op[i].disabled = true;
		}


	}

		// -----  FINE Paranoia Jonathan....


	window.document.getElementById("disc3val").disabled=false;
	window.document.getElementById("disc2val").disabled=false;

	if ( TheForm.Clan.value == "7" ) {   // tremere


		var msgdisc ="";
		var OKD2=1;

		window.document.getElementById("disc3val").disabled=true;

		var disc1val=parseInt(TheForm.disc1val.value);
		var disc2val=parseInt(TheForm.disc2val.value);
		// var disc3val=parseInt(TheForm.disc3val.value);    // questa è taumaturgia

		if ( !disc1val ) { disc1val=0; }
		if ( !disc2val ) { disc2val=0; }


		var valtaum1=parseInt(TheForm.valtaum1.value);
		var valtaum2=parseInt(TheForm.valtaum2.value);
		var valtaum3=parseInt(TheForm.valtaum3.value);

		if ( !valtaum1 ) { valtaum1=0; }
		if ( !valtaum2 ) { valtaum2=0; }
		if ( !valtaum3 ) { valtaum3=0; }

		if ( ( disc1val > MAXSDISC ) || ( disc2val > MAXSDISC ) ||  ( valtaum1 > MAXSDISC ) ||  ( valtaum2 > MAXSDISC )  ||  ( valtaum3 > MAXSDISC )  )  { OKD2=0; msgdisc="Valore disciplina/taumaturgia troppo elevato"; }

		var totdisc = disc1val + disc2val + valtaum1 + valtaum2 + valtaum3 ;

		if ( totdisc != NUMDISC ) { OKD2=0; }

		window.document.getElementById("totdisc").innerHTML=(NUMDISC-totdisc);

		if (valtaum1 == 5 ) {
			window.document.getElementById("disc3val").value=(valtaum1 + valtaum2 + valtaum3); // il valore dipende dalle vie taumaturgiche
		} else {
			window.document.getElementById("disc3val").value=valtaum1 ;
		}


		var adisc2 = "";


		if (valtaum1 <= valtaum2  && valtaum2 !=0 && valtaum1 !=5 ) { OKD2=0; adisc2+="Secondaria >= Primaria."; }
		if (valtaum2 <= valtaum3  && valtaum3 !=0 && valtaum2 !=5 ) { OKD2=0; adisc2+="Terziaria >= Secondaria."; }

		if ( window.document.getElementById("Taumaturgia1").value  ==  "" && valtaum1 != 0  ) { OKD2=0; adisc2+="Definire la via primaria.";}
		if ( ( window.document.getElementById("Taumaturgia2").value  ==  "" && valtaum2 != 0 )  ||
		     ( window.document.getElementById("Taumaturgia3").value  ==  "" && valtaum3 != 0 ) ) { OKD2=0; adisc2+="Definire le vie secondarie." }

		if ( ( window.document.getElementById("Taumaturgia1").value  == window.document.getElementById("Taumaturgia2").value && window.document.getElementById("Taumaturgia2").value != "" ) ||
		     ( window.document.getElementById("Taumaturgia2").value  == window.document.getElementById("Taumaturgia3").value && window.document.getElementById("Taumaturgia2").value != "" ) ||
		     ( window.document.getElementById("Taumaturgia3").value  == window.document.getElementById("Taumaturgia1").value && window.document.getElementById("Taumaturgia3").value != "" )  ) { OKD2=0; adisc2+="Duplicazione ."}

		if ( OKD2==0 ) {
			OK = 0 ;
			window.document.getElementById("adisc").innerHTML=msgdisc;
			window.document.getElementById("adisc").style.color="#F00";
			window.document.getElementById("totdisc").style.color="#F00";
			window.document.getElementById("adisc2").innerHTML=adisc2;
			window.document.getElementById("adisc2").style.color="#F00";
		} else {
			window.document.getElementById("adisc2").innerHTML="";
			window.document.getElementById("adisc2").innerHTML="";
			window.document.getElementById("totdisc").style.color="";
		}

	}

	if ( TheForm.Clan.value == "11" ) {   //giovanni

		var msgdisc ="";
		var OKD2=1;

		window.document.getElementById("disc2val").disabled=true;  // necromanzia

		var disc1val=parseInt(TheForm.disc1val.value);
		// var disc2val=parseInt(TheForm.disc2val.value);  // questa è necromanzia
		var disc3val=parseInt(TheForm.disc3val.value);

		if ( !disc1val ) { disc1val=0; }
		if ( !disc3val ) { disc3val=0; }

		var valnecro1=parseInt(TheForm.valnecro1.value);
		var valnecro2=parseInt(TheForm.valnecro2.value);
		var valnecro3=parseInt(TheForm.valnecro3.value);

		if ( !valnecro1 ) { valnecro1=0; }
		if ( !valnecro2 ) { valnecro2=0; }
		if ( !valnecro3 ) { valnecro3=0; }

		if ( ( disc1val > MAXSDISC ) || ( disc3val > MAXSDISC ) ||  ( valnecro1 > MAXSDISC ) ||  ( valnecro2 > MAXSDISC )  ||  ( valnecro3 > MAXSDISC )  )  { OKD2=0; msgdisc="Valore disciplina/necromanzia troppo elevato"; }

		var totdisc = disc1val + disc3val + valnecro1 + valnecro2 + valnecro3 ;

		if ( totdisc != NUMDISC ) { OKD2=0; }

		window.document.getElementById("totdisc").innerHTML=(NUMDISC-totdisc);

		if ( valnecro1 == 5 ) {
			window.document.getElementById("disc2val").value=valnecro1 + valnecro2 ; // il valore dipende dalle vie necromantiche
		} else {
			window.document.getElementById("disc2val").value=valnecro1  ; // il valore dipende dalle vie necromantiche
		}

		var adisc3 = "";

		if (valnecro1 <= valnecro2  && valnecro2 !=0 && valnecro1 !=5 ) { OKD2=0; adisc3+="Secondaria >= Primaria."; }
		if (valnecro2 <= valnecro3  && valnecro3 !=0 && valnecro2 !=5 ) { OKD2=0; adisc3+="Terziaria >= Secondaria."; }


		if ( window.document.getElementById("Necromanzia1").value  ==  "" && valnecro1 != 0 ) { OKD2=0; adisc3+="Definire la via primaria."; }
		if ( ( window.document.getElementById("Necromanzia2").value  ==  "" && valnecro2 != 0 ) ||
		     ( window.document.getElementById("Necromanzia3").value  ==  "" && valnecro3 != 0 ) ) { OKD2=0; adisc3+="Definire le vie secondarie." }

		if ( ( window.document.getElementById("Necromanzia1").value  == window.document.getElementById("Necromanzia2").value && window.document.getElementById("Necromanzia1").value != "" )  ||
		     ( window.document.getElementById("Necromanzia2").value  == window.document.getElementById("Necromanzia3").value && window.document.getElementById("Necromanzia2").value != "" )  ||
		     ( window.document.getElementById("Necromanzia3").value  == window.document.getElementById("Necromanzia1").value && window.document.getElementById("Necromanzia1").value != "" )  ) { OKD2=0; adisc3+="Duplicazione ." }

		if ( OKD2==0 ) {
			OK = 0 ;
			window.document.getElementById("adisc").innerHTML=msgdisc;
			window.document.getElementById("adisc").style.color="#F00";
			window.document.getElementById("totdisc").style.color="#F00";
			window.document.getElementById("adisc3").innerHTML=adisc3;
			window.document.getElementById("adisc3").style.color="#F00";
		} else {
			window.document.getElementById("adisc3").innerHTML="";
			window.document.getElementById("adisc3").innerHTML="";
			window.document.getElementById("totdisc").style.color="";
		}

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
	var NUMSKILL=25;

	var maxskilltab  = [
		[ 20, 20, 17, 15,  13 , 10 ,  5 ],
		[ 33, 33, 27, 25,  20 , 15 , 10 ],
		[ 35, 35, 33, 30 , 25 , 20 , 15 ],
		[ 45, 45, 43, 40 , 35 , 30 , 20 ],
		[ 55, 55, 53, 50 , 45 , 40 , 30 ],
		[ 95, 95, 93, 90 , 80 , 70 , 50 ]
	];


	NUMSKILL=maxskilltab[Status][Generazione+g14];
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

	var OKfdv=1;
	window.document.getElementById("fdvbase").innerHTML=FDVBASE;
	var fdv=parseInt(TheForm.fdv.value);
	var umanita=parseInt(TheForm.umanita.value);

	if (!fdv) { fdv=0;}
	if (!umanita) { umanita=0;}

	var fdvsent= 2- fdv - umanita;
	window.document.getElementById("fdvsent").innerHTML=fdvsent;

	if ( fdv + umanita != 2) {  OKfdv=0; }


	if ( FDVBASE + fdv >= 4 ) {
		window.document.getElementById("Sentiero").disabled=false;
	} else {
		window.document.getElementById("Sentiero").value="1";
		window.document.getElementById("Sentiero").disabled=true;
	}


	if ( OKfdv==0 ) {
		OK = 0 ;
		window.document.getElementById("fdvsent").style.color="#F00";
	} else {
		window.document.getElementById("fdvsent").style.color="";
	}


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
			<td colspan="6"><div align="center" ><p class="title">Creazione personaggio</p></div></td>
		</tr>
    	<tr>
			<td colspan="6"><div align="center"><hr> Passo 1 - Dati del personaggio e Status iniziale <hr></div></td>
    	</tr>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
		<!-- <tr>
			<td colspan="3" >Nome (reale) del Giocatore <input name="nomeplayer" id="nomeplayer" type="text" maxlength="29" pattern="[A-Z\ba-z\b][a-zA-Z\s']*" required onchange="controlla()"/></td>
		</tr> -->
		<tr>
			<td colspan="3">Nome del Personaggio &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="nome" id="nome" type="text" maxlength="25" pattern="[A-Z\ba-z\b][a-zA-Z\s']*" required onchange="controlla()"/></td>
			<td colspan="3" class="ald" >Nome (reale) del Giocatore <input name="nomeplayer" id="nomeplayer" type="text" maxlength="29" pattern="[A-Z\ba-z\b][a-zA-Z\s']*" required onchange="controlla()"/></td>
		</tr>
    	<tr>
			<td>Clan</td>
			<td>
        		<select name="Clan" id="Clan" onchange="controlla()">
        		<option value=''></option>
<?
$MySql = "SELECT * FROM clan ";
$Results = mysql_query($MySql);
while ( $Res = mysql_fetch_array($Results))  {
	?> <option value='<?=$Res['idclan']?>'><?=$Res['nomeclan']?></option> <?
}

?>
				</select>
			</td>
			<td>Status iniziale</td>
      		<td>
					<select name="Status" id="Status" onchange="controlla()">
          			<option value=0>Infante</option>
					<option value=1 selected>Neonato</option>
          			<option value=2>Ancilla</option>
          			<option value=3>Ancilla Anziana</option>
          			<option value=4>Anziano</option>
					<option value=5>Matusalemme</option>
					</select>
			</td>
      		<td>Generazione</td>
			<td><span id="agen">13</span></td>
		</tr>
			<tr>
			<td align="center">Rifugio</td>
			<td align="center"><input name="rifugio" id="rifugio" type="text" maxlength="49" pattern="[A-Z\ba-z\b][a-zA-Z0-9\s']*" required onchange="controlla()"/></td>
			<td align="center">Indirizzo (o zona indicativa) del GIOCATORE</td>
			<td align="center"><input name="zona" id="zona" type="text" maxlength="49" pattern="[A-Z\ba-z\b][a-zA-Z0-9\s']*" required onchange="controlla()"/></td>
			<td>Punti Ferita</td>
			<td><span id="apf">8</span></td>
		</tr>
		<tr>
			<td colspan=2 align="left">14a Gen. <input type="checkbox" name="g14" id="g14" onchange="controlla()"></td>
			<td colspan=4>&nbsp;</td>
		</tr>
		</tr>
    	<tr>
			<td colspan="6" align="center"><span id="aclan">&nbsp;</span></td>
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
      		<td>Gregge</td>
      		<td><input name="Gregge" id="Gregge" type=number min=0 max=5 style="width: 80px" value=0 required onChange="controlla()"/></td>
      		<td>Risorse</td>
      		<td><input name="Risorse" id="Risorse" type=number min=0 max=5 size=1 value=0 required onChange="controlla()"/></td>
		</tr>
    	<tr>
			<td>Seguaci</td>
    		<td><input name="Seguaci" id="Seguaci" type=number min=0 max=5 size=1 value=0 required onChange="controlla()"/></td>
    		<td>Notorietà</td>
    		<td><input name="Notorieta" id="Notoriet" type=number min=0 max=5 size=1 value=0 required onChange="controlla()"/></td>
    		<td>Mentore</td>
	    	<td><input name="Mentore" id="Mentore" type=number min=0 max=5 size=1 value=0 required onChange="controlla()"/></td>
		</tr>
    	<tr>
	    	<td>Generazione </td>
    	 	<td><input name="Generazione" id="Generazione" type=number min=0 max=5 size=1 value=0 required onChange="controlla()"/> </td>

				<td>Rifugio (min.1)</td>
				<td><input name="Rifugio" id="Rifugio" type=number min=1 max=5 size=1 value=1 required onChange="controlla()"/></td>

     		<td colspan=2>&nbsp;</td>
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
		<table width="65%" border="0" align="center" cellpadding="1" cellspacing="1" >
    	<tr>
      		<td colspan="7">&nbsp;</td>
    	</tr>
    	<tr>
      		<td colspan="7"><div align="center" ><hr> Passo 7 - Forza di Volontà e Sentieri <hr></div></td>
    	</tr>
    	<tr>
      		<td colspan="7">&nbsp;</td>
    	</tr>
			<tr>
				<td>Forza di Volontà</td>
				<td><span id="fdvbase">2</span></td>
				<td><input name="fdv" id="fdv" type=number min=0 max=2 size=1 value=0 required onchange="controlla()"></td>
				<td>Umanità/Sentiero</td>
				<td><span id="umanitabase">5</span></td>
				<td><input name="umanita" id="umanita" type=number min=0 max=2 size=1 value=0 required onchange="controlla()"></td>
				<td>
				<select name="Sentiero" id="Sentiero" onchange="controlla()" disabled>
<?
$MySql = "SELECT * FROM sentieri ";
$Results = mysql_query($MySql);
while ( $Res = mysql_fetch_array($Results))  {
	?> <option value='<?=$Res['idsentiero']?>'><?=$Res['sentiero']?></option>   <?
}

?>
				</select>
			</td>
			</tr>
			<tr>
      		<td colspan="7">&nbsp;</td>
    	</tr>
			<tr>
      		<td colspan="7" align="center">Punti da distribuire:  <span id="fdvsent">2</span> / 2</td>
    	</tr>

	</table>
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
