<?php
	include ('session_start.inc.php');
	include ('db_start.inc.php');



	if (!isset ($_SESSION['idutente'])) {
		//die ("Errore, nessuna sessione attiva!");
		session_write_close();
		header("Location: index.php", true);
	}

	$idutente=$_SESSION['idutente'];

//	$idutente = 1;

	$MySql = "SELECT *  FROM HUNTERpersonaggio
		LEFT JOIN HUNconspiracy ON HUNTERpersonaggio.idclan=HUNconspiracy.idconspiracy
		WHERE idutente = $idutente ";

	$Result = mysql_query($MySql);
	$res = mysql_fetch_array($Result);

	$nome=$res['nomepg'];

	$clan=$res['nomeconspiracy'];
	$idclan=$res['idclan'];
	$idstatus=$res['idstatus'];


	$forza=$res['forza'];
	$destrezza=$res['destrezza'];
	$attutimento=$res['attutimento'];
	$carisma=$res['carisma'];
	$persuasione=$res['persuasione'];
	$saggezza=$res['saggezza'];
	$percezione=$res['percezione'];
	$intelligenza=$res['intelligenza'];
	$prontezza=$res['prontezza'];

	$fdv=$res['fdv'];
	$fdvmax=$res['fdvmax'];
	$status=$res['status'];





	$fama1=$res['fama1']; //città
	$fama2=$res['fama2']; //vamp
	$fama3=$res['fama3'];  //wod

	$xp=$res['xp'];
	$xpspesi=$res['xpspesi'];

	$rifugio=$res['rifugio'];
	$zona = $res['zona'];

	if ( $idstatus == 1 ) {
		$status = $res['lvl1'];
	} elseif ($idstatus == 2) {
		$status = $res['lvl2'];
	} elseif ($idstatus == 3) {
		$status = $res['lvl3'];
	}

	if ( $idclan == 1 ) {
		$textdisc = "Equip. Potenziato";
	} elseif ($idclan == 3) {
		$textdisc = "Elisir";
	} elseif ($idclan == 2) {
		$textdisc = "Reliquie";
	}



	//


	// PF

	$Mysql="SELECT * from skill where idskill=28 and idutente=$idutente";
	$Result=mysql_query($Mysql);
	if ( $res=mysql_fetch_array($Result)) {
		$schivare=$res['livello'];
	}
	$pf = (3+$attutimento)*2 +  $schivare ;

	// ferita permanente -3 PF
	$Mysql="SELECT * from pregidifetti where idpregio =11 and idutente=$idutente";
	$Result=mysql_query($Mysql);
	if ( $res=mysql_fetch_array($Result)) {
		$pf=$pf-3;
	}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Notturna - Cronaca di Roma</title>

	<link href="https://fonts.googleapis.com/css?family=Libre+Baskerville" rel="stylesheet">
	<link href="w3.css" rel="stylesheet" >
	<style>


		@font-face {
			font-family:Percolator;
			src:url(fonts/Percolator.otf)
		}
		@font-face {
			font-family:Percolator expert;
			src:url(fonts/PercolatorExpert.otf)
		}
		@font-face{
			font-family:Goudy Old Style;
			src:url(fonts/GoudyOldStyle.ttf)
		}
		@font-face{
			font-family:Dots;
			src:url(fonts/Dots.otf)
		}

		body {
    		margin: 0;
		}

		.list-align {
			text-align: center;
			width: 100%;
			display: none;
			position: relative;
			margin: 0;
		}
		.list {
    		width: 750px;
    		height: 1061px;
    		display: inline-block;
    		line-height: 1;
    		position: relative;
		}
		.bg-image {
    		width: 100%;
    		height: 100%;
		}
		.list-inner {
			padding-left: 80px; /*for background */
			padding-right: 60px; /*for background */
			padding-top: 65px; /*for background */
			padding-bottom: 65px; /*for background */
			font-size: 0; /* to avoid margins for inline divs*/
			position: absolute;
			top: 0;
			width: 100%;
		}
		.main-header {
			font-family: Percolator;
			text-align: center;
			font-size: 40px;
			color: #000;
			height: 35px;
		}

		*,:after,:before {
			-moz-box-sizing:border-box;
			box-sizing:border-box
		}

		body {
 			font-family:Helvetica Neue,Helvetica,Arial,sans-serif;
			font-size:14px;
			line-height:1.42857143;
			color:#333;
			background-color:#fff
		}

		.rubrica1 {
 			font-family:'Libre Baskerville';
 			text-align:left;
 			font-size:12px;
			display:inline-block;
 			line-height:22px;
			width:35%;
		}
		.rubrica2  {
 			font-family:'Dots';
			font-size:13px;
			font-style:normal;
 			text-align:center;
			display:inline-block;
 			line-height:22px;
			width:10%;
		}
		.rubrica_header {
			font-family:'Percolator expert';
			font-size:18px;
		}

		.prop {
 			font-family:'Percolator expert';
 			text-align:left;
 			font-size:17px;
		}
		.prop,.prop_value {
 			display:inline-block;
 			line-height:22px;
		}
		.prop_value {
 			font-family:'Libre Baskerville';
 			font-size:14px;
 			font-style:italic;
 			text-align:center;
 			vertical-align:top
		}
		.tabellaarmi {
			width:100%;
		}
		.propx , .propx3 {
			font-family:'Percolator expert';
 			font-size:16px;
			vertical-align:top;
			display:inline-block;
 			line-height:24px;
			text-align:center;
			width:20%;
		}
		.propx3 {
			width:25%;
		}
		.prop2, .prop3 {
			font-family:'Libre Baskerville';
 			font-size:12px;
			vertical-align:top;
			display:inline-block;
 			line-height:21px;
			text-align:center;
			width:20%;
		}
		.prop3 {

			width:25%;
		}

		.header-sub {
 			font-family:'Percolator expert';
 			text-align:center;
 			font-size:28px;
 			top:0
		}
		.header-sub,.header-sub-img {
 			position:absolute;
 			width:100%
		}
		.header-sub-img {
 			top:10px;
 			left:0
		}
		.header-sub-placeholder {
 			display:inline-block;
 			position:relative;
 			width:100%;
 			height:30px
		}
		.header-sub-bg {
 			position:absolute;
 			width:100%
		}
		.header-sub-bg img {
 			height:20px
		}

		.dots {
			font-family:'Dots';
 			font-size:13px;
			font-style:normal;
		}

		.red {
			color:#e71010;
			font-style:bold;
		}



		.prop-header {
 			position:absolute;
 			top:0;
 			width:100%
		}
		.prop-header,.prop-header-nobg, .prop-header-nobg2 {
 			font-family:'Percolator expert';
 			text-align:center;
 			font-size:22px
		}
		.prop-header-nobg {
 			width:33.3%;
 			display:inline-block
		}
		.prop-header-nobg2 {
 			width:50%;
 			display:inline-block
		}
		.prop-header-img {
 			width:100%;
 			position:absolute;
 			top:10px;
 			left:0
		}
		.prop-header-placeholder {
 			display:inline-block;
 			position:relative;
 			width:100%;
 			height:25px
		}
		.prop-header-bg {
 			position:absolute;
 			width:100%
		}
		.prop-header-bg img {
 			height:20px
		}

		.attr {
			font-family: 'Libre Baskerville';
 			text-align:left;
 			font-size:12px;
			width:21.3%;
		}
		.attr,.attr_value {
 			display:inline-block;
 			line-height:20px;
 			vertical-align:top;
		}
		.attr_value {
			font-family: 'Dots';
 			font-size:13px;
			font-style:normal;
			width:12%;
		}

		.abilities,.advantages,.attributes {
			width:100%;
 			text-align:center;
 			line-height:12px
		}
		.background_container,.umanita_container,.rituali_container {
			width:33.3%;
 			text-align:center;
			display: inline-block;
			vertical-align: top;
		}

		.discipline,.vie  {
 			width:50%;
 			display:inline-block;
 			vertical-align:top
		}

		.disc_name {
			font-family: 'Libre Baskerville';
 			text-align:left;
 			font-size:12px;
		}
		.disc_name,.disc_value {
 			line-height:20px;
 			display:inline-block;
 			width:50%
		}
		.disc_value {
			font-family: 'Dots';
 			font-size:13px;
			font-style:normal;
 			vertical-align:top;
		}

		.background, .fama, .rituali {
 			line-height:1.4;
		}

		.umanita {
			height: 12px;
			white-space: nowrap;
			font-family: 'Dots';
			vertical-align: top;
			display: inline-block;
			font-size:13px;
		}

		.rituali_name {
			font-family: 'Libre Baskerville';
			text-align:left;
			font-size:10px;
			width:100%;
			line-height:20px;
			display:inline-block;
		}
		.rituali_name_empty {
			font-family: 'Libre Baskerville';
			text-align:left;
			font-size:10px;
			width:95%;
			line-height:15px;
			display:inline-block;
		}


		.bg_name {
			font-family: 'Libre Baskerville';
			text-align:left;
			font-size:12px;
			width:60%
		}
		.bg_name,.bg_value {
			line-height:20px;
			display:inline-block;

		}
		.bg_value {
			font-family: 'Dots';
			font-size:13px;
			font-style:normal;
			vertical-align:top;
			width:40%
		}

		.fama_name {
			font-family: 'Libre Baskerville';
			text-align:left;
			font-size:11px;
			width:75%;
		}
		.fama_name,.fama_value {
			line-height:20px;
			display:inline-block;

		}
		.fama_value {
			font-family: 'Dots';
			font-size:13px;
			font-style:normal;
			vertical-align:top;
			width:25%;
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


		img {
			border: 0px;
			margin: 0px;
		}
		.owner {
			font-family: 'Libre Baskerville';
			font-size: 105%;
			font-weight: bold;
		}


		/* valign */
		.vab { vertical-align: bottom; }
		.vam { vertical-align: middle; }


	</style>



</head>
<body>
	<div class="list-align" style="display: block;" >
    	<div class="list"><img src="img/index.png" class="bg-image" id="pg1">
			<div class="list-inner">
				<div class="main-header">HUNTER</div>
				<div class="props">
        	<div class="prop" style="width:8%">Nome:</div>
          <div class="prop_value" style="width:32%"><?=$nome?></div>
					<div class="prop" style="width:10%">Conspiracy:</div>
					<div class="prop_value" style="width:35%"><?=$clan?></div>
					<div class="prop" style="width:3%">&nbsp;</div>
					<div class="prop_value" style="width:12%">&nbsp;</div>
					<div class="prop" style="width:8%">Status:</div>
					<div class="prop_value" style="width:32%"><?=$status?> </div>
					<div class="prop" style="width:8%">PF</div>
					<div class="prop_value" style="width:20%"><?= $pf ?></div>
					<div class="prop" style="width:10%">XP:</div>
					<div class="prop_value" style="width:22%"><?=$xp." (spesi ".$xpspesi.")"?></div>
					<div class="prop" style="width:8%">SafeHouse:</div>
					<div class="prop_value" style="width:32%"><?=$rifugio?></div>
					<div class="prop" style="width:19%">&nbsp;</div>
					<div class="prop_value" style="width:9%">&nbsp;</div>
					<div class="prop" style="width:23%">Res. Dominazione</div>
					<div class="prop_value" style="width:9%"><?=floor(($intelligenza+$prontezza+$percezione+$carisma+$fdv)/5)?></div>

				</div>    <!-- end props -->

				<div class="header-sub-placeholder"><img src="img/bar.png" class="header-sub-img">
	      			<div class="header-sub-bg"><img src="img/pixel.gif" width="150px"></div>
        			<div class="header-sub"><span>Attributi</span></div>
     			</div>
      			<div class="prop-header-nobg"><span>Fisici</span></div>
      			<div class="prop-header-nobg"><span>Sociali</span></div>
      			<div class="prop-header-nobg"><span>Mentali</span></div>

      			<div class="attributes">

					<div class="attr">Forza</div>
					<div class="attr_value">
<?
for ( $i = 0 ; $i < $forza; $i++) echo "B";
for ( $i = $forza ; $i < 5; $i++) echo "A";
?>
					</div>
					<div class="attr">Carisma</div>
					<div class="attr_value">
<?
for ( $i = 0 ; $i < $carisma; $i++) echo "B";
for ( $i = $carisma ; $i < 5; $i++) echo "A";
?>
					</div>
					<div class="attr">Percezione</div>
					<div class="attr_value">
<?
for ( $i = 0 ; $i < $percezione; $i++) echo "B";
for ( $i = $percezione ; $i < 5; $i++) echo "A";
?>
					</div>
					<div class="attr">Destrezza</div>
					<div class="attr_value">
<?
for ( $i = 0 ; $i < $destrezza; $i++) echo "B";
for ( $i = $destrezza ; $i < 5; $i++) echo "A";
?>
					</div>
					<div class="attr">Persuasione</div>
					<div class="attr_value">
<?
for ( $i = 0 ; $i < $persuasione; $i++) echo "B";
for ( $i = $persuasione ; $i < 5; $i++) echo "A";
?>
					</div>
					<div class="attr">Intelligenza</div>
					<div class="attr_value">
<?
for ( $i = 0 ; $i < $intelligenza; $i++) echo "B";
for ( $i = $intelligenza ; $i < 5; $i++) echo "A";
?>
					</div>
					<div class="attr">Attutimento</div>
					<div class="attr_value">
<?
for ( $i = 0 ; $i < $attutimento; $i++) echo "B";
for ( $i = $attutimento ; $i < 5; $i++) echo "A";
?>
					</div>
					<div class="attr">Saggezza</div>
					<div class="attr_value">
<?
for ( $i = 0 ; $i < $saggezza; $i++) echo "B";
for ( $i = $saggezza ; $i < 5; $i++) echo "A";
?>
					</div>
					<div class="attr">Prontezza</div>
					<div class="attr_value ">
<?
for ( $i = 0 ; $i < $prontezza; $i++) echo "B";
for ( $i = $prontezza ; $i < 5; $i++) echo "A";
?>
					</div>
				</div>
				<!-- Fine attributi -->
				<!-- conoscenze header -->
				<div class="header-sub-placeholder"><img src="img/bar.png" class="header-sub-img">
					<div class="header-sub-bg"><img src="img/pixel.gif" width="150px"></div>
					<div class="header-sub"><span>Conoscenze</span></div>
				</div>
				<div class="abilities">
<?
	$Mysql = "SELECT COUNT(*) FROM skill_main WHERE tipologia = 0";
	$res = mysql_fetch_array ( mysql_query($Mysql) ) ;
	$num_rows= $res[0];

	$Mysql="SELECT * FROM skill_main LEFT JOIN skill ON skill_main.idskill = skill.idskill AND skill.idutente = $idutente WHERE tipologia = 0 ORDER BY nomeskill";
	$Result=mysql_query($Mysql);
	while ($res=mysql_fetch_array($Result) ) {
		$liv = $res['livello'];
		if ($liv=='') $liv=0;
?>
					<div class="attr" ><?=$res['nomeskill']?></div>
					<div class="attr_value">
<?
			for ( $i = 0 ; $i < $liv; $i++) echo "B";
			for ( $i = $liv ; $i < 5; $i++) echo "A";
?>
					</div>
<?
		}
		for ( $i = 0 ; $i < $num_rows-floor($num_rows/3)*3+1 ; $i++ ) {
?>
					<div class="attr vab"  ><hr></div>
					<div class="attr_value">AAAAA</div>
<?
		}
?>
				</div>
				<!-- Fine abilità -->
				<!-- attitudini header -->
				<div class="header-sub-placeholder"><img src="img/bar.png" class="header-sub-img">
					<div class="header-sub-bg"><img src="img/pixel.gif" width="150px"></div>
					<div class="header-sub"><span>Attitudini</span></div>
				</div>
				<div class="abilities">
<?
	$Mysql="SELECT * FROM skill_main LEFT JOIN skill ON skill_main.idskill = skill.idskill AND skill.idutente = $idutente WHERE tipologia = 1 ORDER BY nomeskill";
	$Result=mysql_query($Mysql);
	while ($res=mysql_fetch_array($Result) ) {
		$liv = $res['livello'];
		if ($liv=='') $liv=0;
?>
					<div class="attr" ><?=$res['nomeskill']?></div>
					<div class="attr_value">
<?
		for ( $i = 0 ; $i < $liv; $i++) echo "B";
		for ( $i = $liv ; $i < 5; $i++) echo "A";
?>
					</div>
<?
	}
?>
				</div>  	<!-- Fine attitudini -->
				<!-- discipline header -->
				<div class="header-sub-placeholder"><img src="img/bar.png" class="header-sub-img">
					<div class="header-sub-bg"><img src="img/pixel.gif" width="<?=$idclan!=1?'150px':'250px'?>"></div>
					<div class="header-sub"><span><?=$textdisc?></span></div>
				</div>

				<div class="advantages">
					<div class="discipline">
<?
	$MySql = "SELECT  nomedisc ,livello, HUNdiscipline.iddisciplina, maxlvl  FROM HUNdiscipline
					LEFT JOIN HUNdiscipline_main ON HUNdiscipline_main.iddisciplina=HUNdiscipline.iddisciplina
					WHERE idutente = $idutente
					ORDER BY maxlvl ASC";
	$Results = mysql_query($MySql);
	while ( $res=mysql_fetch_array($Results)) {
		$liv=$res['livello'];
?>
						<div class="disc_name" ><?=$res['nomedisc']?></div>
						<div class="disc_value">
<?
		for ( $i = 0 ; $i < $liv; $i++) echo "B";
		for ( $i = $liv ; $i < $res['maxlvl']; $i++) echo "A";
?>
						</div>
<?
	}
	for (  $i=mysql_num_rows($Results) ; $i< 5 ; $i++ ) {
?>
						<div class="disc_name vab" ><hr></div>
						<div class="disc_value">AAAAA</div>
<?
	}
?>
					</div>
					<div class="vie">
<?


	for (  $i=0 ; $i< 5 ; $i++ ) {
?>
						<div class="disc_name vab" ><hr></div>
						<div class="disc_value">AAAAA</div>
<?
	}
?>
					</div>
				</div>	<!-- fine macrodiscipline -->


				<div class="background_container">
					<div class="prop-header-placeholder"><img src="img/bar2.png" class="prop-header-img">
            		<div class="prop-header-bg"><img src="img/pixel.gif" width="130px"></div>
						<div class="prop-header"><span>Background</span></div>
					</div>
					<div class="background">
<?
	$MySql = "SELECT * FROM background_main
		LEFT JOIN background ON background.idback=background_main.idback and idutente=$idutente
		WHERE background_main.idback NOT IN (1,5)";
	$Result=mysql_query($MySql);
	while ($res=mysql_fetch_array($Result)) {
		$liv=$res['livello'];
		if ($liv =="" ) $liv=0;
		if ($res['nomeback']=="Rifugio") $res['nomeback']="SafeHouse";
		if ($res['nomeback']=="Seguaci") $res['nomeback']="Collaboratori";
?>
						<div class="bg_name" ><?=$res['nomeback']?></div>
						<div class="bg_value">
<?
		for ( $i = 0 ; $i < $liv; $i++) echo "B";
		for ( $i = $liv ; $i < 5; $i++) echo "A";
?>
						</div>
<?
	}
	for (  $i=0 ; $i< 2 ; $i++ ) {
	?>
		<div class="bg_name vab" style="width=60%;" ><hr></div>
		<div class="bg_value">AAAAA</div>
	<?
	}
?>
					</div>


				</div>



				<div class="umanita_container">
				<!-- sentiero header-->

					<!-- sentiero -->

					<!-- FDV header-->
					<div class="prop-header-placeholder" ><img src="img/bar2.png" class="prop-header-img">
						<div class="prop-header-bg"><img src="img/pixel.gif" width="130px"></div>
						<div class="prop-header"><span>Volontà</span></div>
					</div>
					<!-- FDV -->
					<div style="margin-top:10px;" >
						<div class="umanita" style="width:100%;">
<?
	for ( $i = 0 ; $i < $fdvmax; $i++) echo "B";
	for ( $i = $fdvmax ; $i < 10; $i++) echo "A";
?>
						</div>
						<div class="umanita" style="width:100%;">
<?
	for ( $i = 0 ; $i < ($fdvmax-$fdv); $i++) echo "D";
	for ( $i = ($fdvmax-$fdv) ; $i < $fdvmax; $i++) echo "C";
?>
						</div>

					</div>
					<!-- PS header-->
					<div class="prop-header-placeholder" style="margin-top: 20px;"><img src="img/bar2.png" class="prop-header-img" >
						<div class="prop-header-bg"><img src="img/pixel.gif" width="130px"></div>
						<div class="prop-header"><span>Pregi/Difetti</span></div>
					</div>
					<div class="rituali" >
<?
	$MySql = "SELECT  * FROM pregidifetti
    	LEFT JOIN pregidifetti_main ON pregidifetti_main.idpregio=pregidifetti.idpregio
        WHERE idutente = '$idutente' ORDER BY valore ASC";
	$Results = mysql_query($MySql);
	while ($res=mysql_fetch_array($Results)) {
		$liv=$res['livello'];
?>
						<div class="rituali_name">&nbsp;<?=$res['nomepregio']?></div>
<?
	}
	for (  $i=mysql_num_rows($Results) ; $i< 4 ; $i++ ) {
?>
						<div class="rituali_name_empty">&nbsp;<hr></div>
<?
	}

?>
					</div>
					<!-- fama header-->

					<!-- fama -->

				</div>


				<!-- qui altro... -->
				<div class="rituali_container">
<!-- -->
					<div class="prop-header-placeholder"><img src="img/bar2.png" class="prop-header-img">
						<div class="prop-header-bg"><img src="img/pixel.gif" width="130px"></div>
						<div class="prop-header"><span>Contatti</span></div>
					</div>
					<div class="background">
					<?
					$MySql = "SELECT * FROM contatti WHERE idutente=$idutente ORDER BY livello DESC";
					$Result=mysql_query($MySql);
					while ($res=mysql_fetch_array($Result)) {
					$liv=$res['livello'];
					?>
						<div class="bg_name" ><?=$res['nomecontatto']?></div>
						<div class="bg_value">
					<?
					for ( $i = 0 ; $i < $liv; $i++) echo "B";
					for ( $i = $liv ; $i < 5; $i++) echo "A";
					?>
						</div>
					<?
					}
					for (  $i=mysql_num_rows($Result) ; $i< 8 ; $i++ ) {
					?>
						<div class="bg_name vab" style="width=60%;" ><hr></div>
						<div class="bg_value">AAAAA</div>
					<?
					}
					?>
					</div>



<!-- -->



				</div>
			</div> <!-- Fine LIST INNER -->
		</div>			<!-- Fine LIST  -->
	</div>			<!-- Fine LIST ALIGN -->


	<?
	$Mysql="SELECT livello FROM skill WHERE idskill=23 AND idutente=$idutente";
	$rissa=mysql_fetch_array ( mysql_query($Mysql) )['livello'];

	if ($rissa == "" ) $rissa=0;
	//$rissa=$rissa -2;
	if ($rissa <0 ) $rissa=0;

	$Mysql="SELECT livello FROM skill WHERE idskill=24 AND idutente=$idutente";
	$mischia=mysql_fetch_array ( mysql_query($Mysql) )['livello'];

	if ($mischia == "" ) $mischia=0;

	$Mysql="SELECT livello FROM skill WHERE idskill=25 AND idutente=$idutente";
	$fuoco=mysql_fetch_array ( mysql_query($Mysql) )['livello'];

	if ($fuoco == "" ) $fuoco=0;
	$Bfuoco=$fuoco -2;
	if ($Bfuoco <0 ) $Bfuoco=0;

	$Mysql="SELECT livello FROM skill WHERE idskill=26 AND idutente=$idutente";
	$tiro=mysql_fetch_array ( mysql_query($Mysql) )['livello'];

	if ($tiro == "" ) $tiro=0;
	$tiro=$tiro -2;
	if ($tiro <0 ) $tiro=0;

	$Mysql="SELECT livello FROM skill WHERE idskill=26 AND idutente=$idutente";
	$lancio=mysql_fetch_array ( mysql_query($Mysql) )['livello'];

	if ($lancio == "" ) $lancio=0;
	$lancio=$lancio -2;
	if ($lancio <0 ) $lancio=0;


	?>


	<div class="list-align" style="display: block;" >
    	<div class="list"><img src="img/index.png" class="bg-image">
			<div class="list-inner">



				<div class="header-sub-placeholder"><img src="img/bar.png" class="header-sub-img"></div>

				<div class="main-header">Rubrica</div>
				<div class="tabellaarmix">
					<div class="rubrica1 rubrica_header">Contatto</div>
					<div class="rubrica1 rubrica_header">Annotazioni</div>
					<div class="rubrica2 rubrica_header">Cell.</div>
					<div class="rubrica2 rubrica_header">Email</div>
					<div class="rubrica2 rubrica_header">Rifug.</div>
<?
					$Mysql="SELECT * from rubrica where owner=$idutente";
					$Result=mysql_query($Mysql);
					while ( $res=mysql_fetch_array($Result)) {
?>
					<div class="rubrica1"><?=$res['contatto']?></div>
					<div class="rubrica1"><?=$res['note']?></div>
					<div class="rubrica2"><?=($res['cell']==1?"D":"C")?></div>
					<div class="rubrica2"><?=($res['email']==1?"D":"C")?></div>
					<div class="rubrica2"><?=($res['home']==1?"D":"C")?></div>
<?
					}
?>
					<div class="rubrica1 vab" style="width:30%"><hr></div>
					<div class="rubrica2" style="width:5%">&nbsp;</div>
					<div class="rubrica1 vab" style="width:30%"><hr></div>
					<div class="rubrica2" style="width:5%">&nbsp;</div>
					<div class="rubrica2">C</div>
					<div class="rubrica2">C</div>
					<div class="rubrica2">C</div>
					<!--
					<div class="rubrica1 vab" style="width:30%"><hr></div>
					<div class="rubrica2" style="width:5%">&nbsp;</div>
					<div class="rubrica1 vab" style="width:30%"><hr></div>
					<div class="rubrica2" style="width:5%">&nbsp;</div>
					<div class="rubrica2">C</div>
					<div class="rubrica2">C</div>
					<div class="rubrica2">C</div>
				-->
				</div>

				<div class="header-sub-placeholder"><img src="img/bar.png" class="header-sub-img">
<!--					<div class="header-sub-bg"><img src="img/pixel.gif" width="180px"></div>
						<div class="header-sub"><span>Armi da Fuoco</span></div> -->
				</div>


				<div class="main-header">Tabella Danni</div>
				<div class="tabellaarmix">

					<div class="tabellaarmi">
						<div class="propx3" style="text-align:left;">Descrizione</div>
						<div class="propx3">Danno Base</div>
						<div class="propx3">Attitudine</div>
						<div class="propx3">DANNI</div>
					</div>
					<div class="tabellaarmi">
						<div class="prop3" style="text-align:left;">Pugno/Calcio</div>
						<div class="prop3">(Fo+ATT)/2</div>
						<div class="prop3">Rissa</div>
						<div class="prop3" style="font-style:bold"><?=ceil(($forza+$rissa)/2)?></div>
					</div>



					<div class="tabellaarmi">
						<div class="prop3" style="text-align:left;">Pugnale/Paletto </div>
						<div class="prop3">(Fo+ATT)/2+1</div>
						<div class="prop3">Mischia</div>
						<div class="prop3" style="font-style:bold"><?=ceil(($forza+$mischia)/2)+1?></div>
					</div>
					<div class="tabellaarmi">
						<div class="prop3" style="text-align:left;">Spada corta/Mazza</div>
						<div class="prop3">(Fo+ATT)/2+2</div>
						<div class="prop3">Mischia</div>
						<div class="prop3" style="font-style:bold"><?=ceil(($forza+$mischia)/2)+2?></div>
					</div>
					<div class="tabellaarmi">
						<div class="prop3" style="text-align:left;">Spada lunga</div>
						<div class="prop3">(Fo+ATT)/2+3</div>
						<div class="prop3">Mischia</div>
						<div class="prop3" style="font-style:bold"><?=ceil(($forza+$mischia)/2)+3?></div>
					</div>
					<div class="tabellaarmi">
						<div class="prop3" style="text-align:left;">Pugnale da lancio</div>
						<div class="prop3">(Fo+ATT)/2+1</div>
						<div class="prop3">Armi da lancio</div>
						<div class="prop3" style="font-style:bold"><?=ceil(($forza+$lancio)/2)+1?></div>
					</div>
					<div class="tabellaarmi">
						<div class="prop3" style="text-align:left;">Balestra</div>
						<div class="prop3">(3+ATT)/2+1</div>
						<div class="prop3">Armi da tiro</div>
						<div class="prop3" style="font-style:bold"><?=ceil((3+$tiro)/2)+1?></div>
					</div>

					<div class="header-sub-placeholder"><img src="img/bar.png" class="header-sub-img">
						<div class="header-sub-bg"><img src="img/pixel.gif" width="180px"></div>
						<div class="header-sub"><span>Armi da Fuoco</span></div>
					</div>

					<div class="tabellaarmi">
						<div class="propx3" style="text-align:left;">Descrizione</div>
						<div class="propx3">Min. Attitud.</div>
						<div class="propx3">Danno Base</div>
						<div class="propx3">Danni</div>
					</div>
					<div class="tabellaarmi">
						<div class="prop3" style="text-align:left;">Revolver/Pistola leggera</div>
						<div class="prop3">1</div>
						<div class="prop3">(3+Fuoco)/2</div>
						<div class="prop3"><?=($fuoco>=1?ceil((3+$fuoco)/2):"-")?></div>
					</div>
					<div class="tabellaarmi">
						<div class="prop3" style="text-align:left;">Revolver/Pistola pesante</div>
						<div class="prop3">1</div>
						<div class="prop3">(3+Fuoco)/2+1</div>
						<div class="prop3"><?=($fuoco>=1?ceil((3+$fuoco)/2)+1:"-")?></div>
					</div>
					<div class="tabellaarmi">
						<div class="prop3" style="text-align:left;">Mitra leggero</div>
						<div class="prop3">2</div>
						<div class="prop3">(3+Fuoco)/2+2</div>
						<div class="prop3"><?=($fuoco>=2?ceil((3+$fuoco)/2)+2:"-")?></div>
					</div>
					<div class="tabellaarmi">
						<div class="prop3" style="text-align:left;">Mitra pesante/d'assalto</div>
						<div class="prop3">3</div>
						<div class="prop3">(3+Fuoco)/2+3</div>
						<div class="prop3"><?=($fuoco>=3?ceil((3+$fuoco)/2)+3:"-")?></div>
					</div>

				</div>
			</div>
		</div>
	</div>
	<p>
	<p>
	<p>
	<p>
	<table>
		<tr>
			<td colspan=9 >&nbsp;</td>
		</tr>
		<tr>
			<td colspan=9 >&nbsp;</td>
		</tr>
		<tr>
			<td colspan=9 >&nbsp;</td>
		</tr>
		<tr>
			<td colspan=9 ><button class="w3-btn w3-white w3-border w3-border-red w3-round w3-block" onclick="javascript:window.print();">Stampa</button></td>
		</tr>
		<tr>
			<td colspan=9 ><button class="w3-btn w3-white w3-border w3-border-blue w3-round w3-block" onclick="javascript:window.location.href='schedaH.php'">Indietro</button></td>
		</tr>
	</table>



</body>
