<?php
	include ('session_start.inc.php');
	include ('db_start.inc.php');

	if (!isset ($_SESSION['idutente'])) {
		// die ("Errore, nessuna sessione attiva!");
		session_write_close();
		header("Location: index.php", true);
	}

	$idutente=$_SESSION['idutente'];

//	$idutente = 1;


	$MySql = "SELECT *  FROM personaggio
		LEFT JOIN clan ON personaggio.idclan=clan.idclan
		LEFT JOIN statuscama ON personaggio.idstatus=statuscama.idstatus
		LEFT JOIN sentieri ON personaggio.idsentiero=sentieri.idsentiero
		LEFT JOIN generazione ON personaggio.generazione=generazione.generazione
		WHERE idutente = $idutente ";

	$Result = mysql_query($MySql);
	$res = mysql_fetch_array($Result);

	$nome=$res['nomepg'];

	$clan=$res['idclan'];
	$generazione=$res['generazione'];

	$ps=$res['ps'];
	$psturno=$res['psturno'];

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
	$status=$res['status'];
	$idstatus=$res['idstatus'];

	$valsentiero=$res['valsentiero'];
	$sentiero=$res['sentiero'];


	$fama1=$res['fama1']; //città
	$fama2=$res['fama2']; //vamp
	$fama3=$res['fama3'];  //wod

	$xp=$res['xp'];
	$xpspesi=$res['xpspesi'];


	$MAXSTAT=$res['maxstat'];

	$maxdisctab  = [
		[ 2, 3, 3, 4,  4,  5,  5 ,6,7,8,9 ],
		[ 3, 3, 4, 4 , 5 , 5 , 5 ,6,7,8,9 ],
		[ 3, 4, 5, 5 , 5 , 5 , 5 ,6,7,8,9 ],
		[ 4, 5, 5, 5 , 5 , 5 , 5 ,6,7,8,9 ],
		[ 4, 5, 5, 5 , 5 , 5 , 5 ,6,7,8,9 ],
		[ 5, 5, 5, 5 , 5 , 5 , 5 ,6,7,8,9 ]
	];

	$MAXSDISC=$maxdisctab[$idstatus][14-$generazione];


//die ( "status = ".$idstatus." gen = ".$generazione." maxsdisc = ".$MAXSDISC);

	$exp=$xp-$xpspesi;

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

		img {
			border: 0px;
			margin: 0px;
		}
		input[type=number] {
   			width:  80px;
   			-moz-appearance: textfield;
		}
		input[type=submit] {
    		width: 200px;
		}
		select {
    		width: 200px;
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
			<td width="150">&nbsp;</td>
			<td width="50">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="100">&nbsp;</td>
		</tr>
		<tr>
			<td colspan=8 class="alc title"><hr>Punti Esperienza<hr></td>
		</tr>
		<tr>
			<td>Punti Totali</td>
			<td><?=$xp?></td>
			<td>&nbsp;</td>
			<td colspan=4>Aumentare PX (ereditati o guadagnati nelle sessioni di gioco)</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Punti Disponibili</td>
			<td><?=$xp-$xpspesi?></td>
			<td>&nbsp;</td>
			<form method="post" action="ws/addpx.php">
				<td colspan=2>PX da aggiungere</td>
				<td><input name="px" type=number min=0 max=99 value=0 required></td>
				<td colspan=2><input type=submit value="Aggiungi" class="btn"></td>
			</form>
		</tr>
	</table>
	</div>

	<div align=center>
	<table>
		<tr>
			<td width="200">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="100">&nbsp;</td>
		</tr>
		<tr>
			<td colspan=8 class="alc title"><hr>Spendere PX<hr></td>
		</tr>
		<tr>
			<td colspan=8>&nbsp;</td>
		</tr>
		<tr>
			<td colspan=8 class="alc title2">Attributi</td>
		</tr>
		<tr>
			<td colspan=8 class="alc"><hr></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>Costo</td>
			<td>&nbsp;</td>
		</tr>
<?	if ( $forza<$MAXSTAT ) {
?>
		<tr>
<?		if ( $exp < ($forza+1)*2 ) {
?>
			<td class="alc">- Aumenta Forza -</td>
<?		} else {
?>
			<td><form method="post" action="ws/px.php"><input type=submit name="Forza" value="Aumenta Forza" ></form></td>
<?		}
?>
			<td>&nbsp;</td>
			<td>Valore attuale</td>
			<td><?=$forza?></td>
			<td>&nbsp;</td>
			<td>px: <?= ($forza+1)*2 ?></td>
			<td>&nbsp;</td>
		</tr>
<?	}
?>
<?	if ( $destrezza<$MAXSTAT ) {
?>
		<tr>
<?		if ( $exp < ($destrezza+1)*2 ) {
?>
			<td class="alc">- Aumenta Destrezza -</td>
<?		} else {
?>
			<td><form method="post" action="ws/px.php"><input type=submit name="Destrezza" value="Aumenta Destrezza" ></form></td>
<?		}
?>
			<td>&nbsp;</td>
			<td>Valore attuale</td>
			<td><?=$destrezza?></td>
			<td>&nbsp;</td>
			<td>px: <?= ($destrezza+1)*2 ?></td>
			<td>&nbsp;</td>
		</tr>
<?	}
?>
<?	if ( $attutimento<$MAXSTAT ) {
?>
		<tr>
<?		if ( $exp < ($attutimento+1)*2 ) {
?>
			<td class="alc">- Aumenta Attutimento -</td>
<?		} else {
?>
			<td><form method="post" action="ws/px.php"><input type=submit name="Attutimento" value="Aumenta Attutimento" ></form></td>
<?		}
?>
			<td>&nbsp;</td>
			<td>Valore attuale</td>
			<td><?=$attutimento?></td>
			<td>&nbsp;</td>
			<td>px: <?= ($attutimento+1)*2 ?></td>
			<td>&nbsp;</td>
		</tr>
<?	}
?>
<?	if ( $carisma<$MAXSTAT ) {
?>
		<tr>
<?		if ( $exp < ($carisma+1)*2 ) {
?>
			<td class="alc">- Aumenta Carisma -</td>
<?		} else {
?>
			<td><form method="post" action="ws/px.php"><input type=submit name="Carisma" value="Aumenta Carisma" ></form></td>
<?		}
?>
			<td>&nbsp;</td>
			<td>Valore attuale</td>
			<td><?=$carisma?></td>
			<td>&nbsp;</td>
			<td>px: <?= ($carisma+1)*2 ?></td>
			<td>&nbsp;</td>
		</tr>
<?	}
?>
<?	if ( $persuasione<$MAXSTAT ) {
?>
		<tr>
<?		if ( $exp < ($persuasione+1)*2 ) {
?>
			<td class="alc">- Aumenta Persuasione -</td>
<?		} else {
?>
			<td><form method="post" action="ws/px.php"><input type=submit name="Persuasione" value="Aumenta Persuasione" ></form></td>
<?		}
?>
			<td>&nbsp;</td>
			<td>Valore attuale</td>
			<td><?=$persuasione?></td>
			<td>&nbsp;</td>
			<td>px: <?= ($persuasione+1)*2 ?></td>
			<td>&nbsp;</td>
		</tr>
<?	}
?>
<?	if ( $saggezza<$MAXSTAT ) {
?>
		<tr>
<?		if ( $exp < ($saggezza+1)*2 ) {
?>
			<td class="alc">- Aumenta Saggezza -</td>
<?		} else {
?>
			<td><form method="post" action="ws/px.php"><input type=submit name="Saggezza" value="Aumenta Saggezza" ></form></td>
<?		}
?>
			<td>&nbsp;</td>
			<td>Valore attuale</td>
			<td><?=$saggezza?></td>
			<td>&nbsp;</td>
			<td>px: <?= ($saggezza+1)*2 ?></td>
			<td>&nbsp;</td>
		</tr>
<?	}
?>
<?	if ( $percezione<$MAXSTAT ) {
?>
		<tr>
<?		if ( $exp < ($percezione+1)*2 ) {
?>
			<td class="alc">- Aumenta Percezione -</td>
<?		} else {
?>
			<td><form method="post" action="ws/px.php"><input type=submit name="Percezione" value="Aumenta Percezione" ></form></td>
<?		}
?>
			<td>&nbsp;</td>
			<td>Valore attuale</td>
			<td><?=$percezione?></td>
			<td>&nbsp;</td>
			<td>px: <?= ($percezione+1)*2 ?></td>
			<td>&nbsp;</td>
		</tr>
<?	}
?>
<?	if ( $intelligenza<$MAXSTAT ) {
?>
		<tr>
<?		if ( $exp < ($intelligenza+1)*2 ) {
?>
			<td class="alc">- Aumenta Intelligenza -</td>
<?		} else {
?>
			<td><form method="post" action="ws/px.php"><input type=submit name="Intelligenza" value="Aumenta Intelligenza" ></form></td>
<?		}
?>
			<td>&nbsp;</td>
			<td>Valore attuale</td>
			<td><?=$intelligenza?></td>
			<td>&nbsp;</td>
			<td>px: <?= ($intelligenza+1)*2 ?></td>
			<td>&nbsp;</td>
		</tr>
<?	}
?>
<?	if ( $prontezza<$MAXSTAT ) {
?>
		<tr>
<?		if ( $exp < ($prontezza+1)*2 ) {
?>
			<td class="alc">- Aumenta Prontezza -</td>
<?		} else {
?>
			<td><form method="post" action="ws/px.php"><input type=submit name="Prontezza" value="Aumenta Prontezza" ></form></td>
<?		}
?>
			<td>&nbsp;</td>
			<td>Valore attuale</td>
			<td><?=$prontezza?></td>
			<td>&nbsp;</td>
			<td>px: <?= ($prontezza+1)*2 ?></td>
			<td>&nbsp;</td>
		</tr>
<?	}
?>
		<!----------- SKILL ------------->
		<tr>
			<td colspan=8 class="alc title2">Conoscenze</td>
		</tr>
		<tr>
			<td colspan=8 class="alc"><hr></td>
		</tr>

<?	$Mysql="SELECT skill_main.idskill, nomeskill FROM skill_main
		LEFT JOIN skill ON skill_main.idskill=skill.idskill and idutente=$idutente
		WHERE tipologia=0 and livello IS NULL ORDER BY nomeskill";
	$Result=mysql_query($Mysql);
	if ( mysql_num_rows($Result)) {
?>
		<tr>
			<form method="post" action="ws/px.php">
<?		if ( $exp < 2 ) {
?>
			<td class="alc">- Acquisisci -</td>
<?		} else {
?>
			<td><input type=submit name="IncrSkill" value="Acquisisci"></td>
<?		}
?>
			<td>&nbsp;</td>
			<td colspan=2><select name="IDSkill">
<?			while ($res=mysql_fetch_array($Result)) {
?>
				<option value="<?=$res['idskill']?>" ><?=$res['nomeskill']?></option>
<?			}
?>
				</select></td>

			<td>&nbsp;</td>
			<td>px: 2</td>
			<td>&nbsp;</td>
			</form>
		</tr>
<?	}
?>
<?	$Mysql="SELECT * FROM skill_main
		LEFT JOIN skill ON skill_main.idskill=skill.idskill and idutente=$idutente
		WHERE tipologia=0 and livello= 1 ORDER BY nomeskill";
	$Result=mysql_query($Mysql);
	if ( mysql_num_rows($Result)) {
?>
		<tr>
			<form method="post" action="ws/px.php">
<?		if ( $exp < 4 ) {
?>
			<td class="alc">- Incrementa a 2 -</td>
<?		} else {
?>
			<td><input type=submit name="IncrSkill" value="Incrementa a 2"></td>
<?		}
?>
			<td>&nbsp;</td>
			<td colspan=2><select name="IDSkill">
<?			while ($res=mysql_fetch_array($Result)) {
?>
				<option value="<?=$res['idskill']?>" ><?=$res['nomeskill']?></option>
<?			}
?>
				</select></td>

			<td>&nbsp;</td>
			<td>px: 4</td>
			<td>&nbsp;</td>
			</form>
		</tr>
<?	}
?>
<?	$Mysql="SELECT * FROM skill_main
		LEFT JOIN skill ON skill_main.idskill=skill.idskill and idutente=$idutente
		WHERE tipologia=0 and livello=2 ORDER BY nomeskill";
	$Result=mysql_query($Mysql);
	if ( mysql_num_rows($Result)) {
?>
		<tr>
			<form method="post" action="ws/px.php">
<?		if ( $exp < 6 ) {
?>
			<td class="alc">- Incrementa a 3 -</td>
<?		} else {
?>
			<td><input type=submit name="IncrSkill" value="Incrementa a 3"></td>
<?		}
?>
			<td>&nbsp;</td>
			<td colspan=2><select name="IDSkill">
<?			while ($res=mysql_fetch_array($Result)) {
?>
				<option value="<?=$res['idskill']?>" ><?=$res['nomeskill']?></option>
<?			}
?>
				</select></td>

			<td>&nbsp;</td>
			<td>px: 6</td>
			<td>&nbsp;</td>
			</form>
		</tr>
<?	}
?>
<?	$Mysql="SELECT * FROM skill_main
		LEFT JOIN skill ON skill_main.idskill=skill.idskill and idutente=$idutente
		WHERE tipologia=0 and livello=3 ORDER BY nomeskill";
	$Result=mysql_query($Mysql);
	if ( mysql_num_rows($Result)) {
?>
		<tr>
			<form method="post" action="ws/px.php">
<?		if ( $exp < 8 ) {
?>
			<td class="alc">- Incrementa a 4 -</td>
<?		} else {
?>
			<td><input type=submit name="IncrSkill" value="Incrementa a 4"></td>
<?		}
?>
			<td>&nbsp;</td>
			<td colspan=2><select name="IDSkill">
<?			while ($res=mysql_fetch_array($Result)) {
?>
				<option value="<?=$res['idskill']?>" ><?=$res['nomeskill']?></option>
<?			}
?>
				</select></td>

			<td>&nbsp;</td>
			<td>px: 8</td>
			<td>&nbsp;</td>
			</form>
		</tr>
<?	}
?>
<?	$Mysql="SELECT * FROM skill_main
		LEFT JOIN skill ON skill_main.idskill=skill.idskill and idutente=$idutente
		WHERE tipologia=0 and livello=4 ORDER BY nomeskill";
	$Result=mysql_query($Mysql);
	if ( mysql_num_rows($Result)) {
?>
		<tr>
			<form method="post" action="ws/px.php">
<?		if ( $exp < 10 ) {
?>
			<td class="alc">- Incrementa a 5 -</td>
<?		} else {
?>
			<td><input type=submit name="IncrSkill" value="Incrementa a 5"></td>
<?		}
?>
			<td>&nbsp;</td>
			<td colspan=2><select name="IDSkill">
<?			while ($res=mysql_fetch_array($Result)) {
?>
				<option value="<?=$res['idskill']?>" ><?=$res['nomeskill']?></option>
<?			}
?>
				</select></td>

			<td>&nbsp;</td>
			<td>px: 10</td>
			<td>&nbsp;</td>
			</form>
		</tr>
<?	}
?>
		<!----------- ATTITUDINI ------------->
		<tr>
			<td colspan=8 class="alc title2">Attitudini</td>
		</tr>
		<tr>
			<td colspan=8 class="alc"><hr></td>
		</tr>

<?	$Mysql="SELECT skill_main.idskill , nomeskill  FROM skill_main
		LEFT JOIN skill ON skill_main.idskill=skill.idskill and idutente=$idutente
		WHERE tipologia=1 and livello IS NULL ORDER BY nomeskill";
	$Result=mysql_query($Mysql);
	if ( mysql_num_rows($Result)) {
?>
		<tr>
			<form method="post" action="ws/px.php">
<?		if ( $exp < 3 ) {
?>
			<td class="alc">- Acquisisci -</td>
<?		} else {
?>
			<td><input type=submit name="IncrSkillX" value="Acquisisci"></td>
<?		}
?>
			<td>&nbsp;</td>
			<td colspan=2><select name="IDSkill">
<?			while ($res=mysql_fetch_array($Result)) {
?>
				<option value="<?=$res['idskill']?>" ><?=$res['nomeskill']?></option>
<?			}
?>
				</select></td>

			<td>&nbsp;</td>
			<td>px: 3</td>
			<td>&nbsp;</td>
			</form>
		</tr>
<?	}
?>
<?	$Mysql="SELECT * FROM skill_main
		LEFT JOIN skill ON skill_main.idskill=skill.idskill and idutente=$idutente
		WHERE tipologia=1 and livello= 1 ORDER BY nomeskill";
	$Result=mysql_query($Mysql);
	if ( mysql_num_rows($Result) && $destrezza > 1 ) {
?>
		<tr>
			<form method="post" action="ws/px.php">
<?		if ( $exp < 6 ) {
?>
			<td class="alc">- Incrementa a 2 -</td>
<?		} else {
?>
			<td><input type=submit name="IncrSkillX" value="Incrementa a 2"></td>
<?		}
?>
			<td>&nbsp;</td>
			<td colspan=2><select name="IDSkill">
<?			while ($res=mysql_fetch_array($Result)) {
?>
				<option value="<?=$res['idskill']?>" ><?=$res['nomeskill']?></option>
<?			}
?>
				</select></td>

			<td>&nbsp;</td>
			<td>px: 6</td>
			<td>&nbsp;</td>
			</form>
		</tr>
<?	}
?>
<?	$Mysql="SELECT * FROM skill_main
		LEFT JOIN skill ON skill_main.idskill=skill.idskill and idutente=$idutente
		WHERE tipologia=1 and livello=2 ORDER BY nomeskill";
	$Result=mysql_query($Mysql);
	if ( mysql_num_rows($Result) && $destrezza > 2 )  {
?>
		<tr>
			<form method="post" action="ws/px.php">
<?		if ( $exp < 9 ) {
?>
			<td class="alc">- Incrementa a 3 -</td>
<?		} else {
?>
			<td><input type=submit name="IncrSkillX" value="Incrementa a 3"></td>
<?		}
?>
			<td>&nbsp;</td>
			<td colspan=2><select name="IDSkill">
<?			while ($res=mysql_fetch_array($Result)) {
?>
				<option value="<?=$res['idskill']?>" ><?=$res['nomeskill']?></option>
<?			}
?>
				</select></td>

			<td>&nbsp;</td>
			<td>px: 9</td>
			<td>&nbsp;</td>
			</form>
		</tr>
<?	}
?>
<?	$Mysql="SELECT * FROM skill_main
		LEFT JOIN skill ON skill_main.idskill=skill.idskill and idutente=$idutente
		WHERE tipologia=1 and livello=3 ORDER BY nomeskill";
	$Result=mysql_query($Mysql);
	if ( mysql_num_rows($Result) && $destrezza > 3) {
?>
		<tr>
			<form method="post" action="ws/px.php">
<?		if ( $exp < 12 ) {
?>
			<td class="alc">- Incrementa a 4 -</td>
<?		} else {
?>
			<td><input type=submit name="IncrSkillX" value="Incrementa a 4"></td>
<?		}
?>
			<td>&nbsp;</td>
			<td colspan=2><select name="IDSkill">
<?			while ($res=mysql_fetch_array($Result)) {
?>
				<option value="<?=$res['idskill']?>" ><?=$res['nomeskill']?></option>
<?			}
?>
				</select></td>

			<td>&nbsp;</td>
			<td>px: 12</td>
			<td>&nbsp;</td>
			</form>
		</tr>
<?	}
?>
<?	$Mysql="SELECT * FROM skill_main
		LEFT JOIN skill ON skill_main.idskill=skill.idskill and idutente=$idutente
		WHERE tipologia=1 and livello=4 ORDER BY nomeskill";
	$Result=mysql_query($Mysql);
	if ( mysql_num_rows($Result) && $destrezza > 4) {
?>
		<tr>
			<form method="post" action="ws/px.php">
<?		if ( $exp < 15 ) {
?>
			<td class="alc">- Incrementa a 5 -</td>
<?		} else {
?>
			<td><input type=submit name="IncrSkillX" value="Incrementa a 5"></td>
<?		}
?>
			<td>&nbsp;</td>
			<td colspan=2><select name="IDSkill">
<?			while ($res=mysql_fetch_array($Result)) {
?>
				<option value="<?=$res['idskill']?>" ><?=$res['nomeskill']?></option>
<?			}
?>
				</select></td>

			<td>&nbsp;</td>
			<td>px: 15</td>
			<td>&nbsp;</td>
			</form>
		</tr>
<?	}
?>

		<!----------- Discipline ------------->
		<tr>
			<td colspan=8 class="alc title2">Discipline</td>
		</tr>
		<tr>
			<td colspan=8 class="alc"><hr></td>
		</tr>
<!--<tr><td>maxdisc=<$MAXSDISC?></td></tr> -->
<?		$Mysql="SELECT * FROM discipline LEFT JOIN discipline_main ON discipline.iddisciplina = discipline_main.iddisciplina
				WHERE idutente = $idutente AND DiClan = 'S' AND discipline_main.iddisciplina!=98 AND discipline_main.iddisciplina!=99  ";
		$Result=mysql_query($Mysql);
		while ( $res=mysql_fetch_array ($Result)) {

			if ( $res['livello']<$MAXSDISC  && $res['iddisciplina']!=98 && $res['iddisciplina']!=99  ) {       // taumaturgia e necromanzia aumentano con le vie
?>
		<tr>
<?				if ( $exp < ($res['livello']+1)*2 ) {
?>
			<td class="alc">- Aumenta <?=$res['nomedisc']?> -</td>
<?				} else {
?>
			<td><form method="post" action="ws/px.php"><input type=submit name="Disciplina" value="Aumenta <?=$res['nomedisc']?>" ><input type=hidden name="iddisc" value="<?=$res['iddisciplina']?>"></form></td>
<?				}
?>
				<td>&nbsp;</td>
				<td>Valore attuale</td>
				<td><?=$res['livello']?></td>
				<td>&nbsp;</td>
				<td>px: <?= ($res['livello']+1)*2 ?></td>
				<td>&nbsp;</td>
			</tr>
<?			}
		}
?>
<?		$Mysql="SELECT * FROM discipline LEFT JOIN discipline_main ON discipline.iddisciplina = discipline_main.iddisciplina
				WHERE idutente = $idutente AND DiClan = 'N' AND discipline_main.iddisciplina!=98 AND discipline_main.iddisciplina!=99 ";
		$Result=mysql_query($Mysql);
		while ( $res=mysql_fetch_array ($Result)) {
			if ( $res['livello']<$MAXSDISC  && $res['iddisciplina']!=98 && $res['iddisciplina']!=99  ) {       // taumaturgia e necromanzia aumentano con le vie
?>
		<tr>
<?				if ( $exp < ($res['livello']+1)*3 ) {
?>
			<td class="alc">- Aumenta <?=$res['nomedisc']?> -</td>
<?				} else {
?>
			<td><form method="post" action="ws/px.php"><input type=submit name="Disciplina" value="Aumenta <?=$res['nomedisc']?>" ><input type=hidden name="iddisc" value="<?=$res['iddisciplina']?>"></form></td>
<?				}
?>
				<td>&nbsp;</td>
				<td>Valore attuale</td>
				<td><?=$res['livello']?></td>
				<td>&nbsp;</td>
				<td>px: <?= ($res['livello']+1)*3 ?></td>
				<td>&nbsp;</td>
			</tr>
<?			}
		}
?>
	<!-- Acquisizione nuove discipline -->
<?
		$Mysql="SELECT discipline_main.iddisciplina,discipline_main.nomedisc  FROM discipline_main
				LEFT JOIN discipline ON discipline.iddisciplina = discipline_main.iddisciplina AND idutente = $idutente
				WHERE  discipline_main.iddisciplina!=98 AND discipline_main.iddisciplina!=99 AND discipline.livello IS NULL";
		$Result=mysql_query($Mysql);
		if ( mysql_num_rows($Result)) {
?>
			<tr>
			<form method="post" action="ws/px.php">
<?			if ( $exp < 5 ) {
?>
				<td class="alc">- Acquisisci -</td>
<?			} else {
?>
				<td><input type=submit name="ImparaDisc" value="Acquisisci"></td>
<?			}
?>
			<td>&nbsp;</td>
			<td colspan=2><select name="iddisciplina">
<?			while ($res=mysql_fetch_array($Result)) {
?>
				<option value="<?=$res['iddisciplina']?>" ><?=$res['nomedisc']?></option>
<?			}
?>
				</select></td>

			<td>&nbsp;</td>
			<td>px: 5</td>
			<td>&nbsp;</td>
			</form>
		</tr>
<?	}
?>
			<!---- vie taumaturgiche------>
		<tr>
			<td colspan=8 class="alc title2">Vie Taumaturgiche</td>
		</tr>
		<tr>
			<td colspan=8 class="alc"><hr></td>
		</tr>
<?		$precedente=5;
		if ($clan==7) {$mult=2;} else {$mult=3;}
		$MySql="SELECT * FROM taumaturgie LEFT JOIN taumaturgie_main ON taumaturgie.idtaum = taumaturgie_main.idtaum
		WHERE idutente=$idutente ORDER BY principale";
		$Result=mysql_query($MySql);
		while( $res=mysql_fetch_array($Result)){
			if ( $res['livello']< 5 ) {
?>
		<tr>
<?				if ($exp< ($res['livello']+1)*$mult || ($res['livello']+1==$prec && $prec !=5)) {
?>
			<td class="alc">- Aumenta <?=$res['nometaum']?> -</td>
<?				} else {
?>
			<td><form method="post" action="ws/px.php"><input type=submit name="Taumaturgia" value="Aumenta <?=$res['nometaum']?>" ><input type=hidden name="idtaum" value="<?=$res['idtaum']?>"></form></td>
<?				}
?>
			<td>&nbsp;</td>
			<td>Valore attuale</td>
			<td><?=$res['livello']?></td>
			<td>&nbsp;</td>
			<td>px: <?= ($res['livello']+1)*$mult ?></td>
			<td>&nbsp;</td>
		</tr>
<?
				$prec=$res['livello'];
			}
			$prec=$res['livello'];
		}
?>
		<tr>
	<!-- Acquisizione nuove taumaturgie -->
<?
		if ($clan==7) {$mult=2;} else {$mult=5;}
		$ok_new_t=0;
		$Mysql="SELECT MIN(livello) as m FROM taumaturgie WHERE idutente=$idutente";
		$Result=mysql_query($Mysql);
		$res=mysql_fetch_array($Result);
			if ($res['m']=='' || $res['m'] >1 ) $ok_new_t=1;


		$Mysql="SELECT taumaturgie_main.idtaum,taumaturgie_main.nometaum  FROM taumaturgie_main
				LEFT JOIN taumaturgie ON taumaturgie.idtaum = taumaturgie_main.idtaum AND idutente = $idutente
				WHERE  taumaturgie.livello IS NULL";
		$Result=mysql_query($Mysql);
		if ( mysql_num_rows($Result) && $ok_new_t ) {
?>
		<tr>
			<form method="post" action="ws/px.php">
<?			if ( $exp < $mult ) {
?>
				<td class="alc">- Acquisisci -</td>
<?			} else {
?>
				<td><input type=submit name="ImparaTaum" value="Acquisisci"></td>
<?			}
?>
			<td>&nbsp;</td>
			<td colspan=2><select name="idtaum">
<?			while ($res=mysql_fetch_array($Result)) {
?>
				<option value="<?=$res['idtaum']?>" ><?=$res['nometaum']?></option>
<?			}
?>
				</select></td>
			<td>&nbsp;</td>
			<td>px: <?=$mult?></td>
			<td>&nbsp;</td>
			</form>
		</tr>
<?		}
?>
		<!--- fine taumaturgia --->
			<!---- vie necromatiche------>
		<tr>
			<td colspan=8 class="alc title2">Vie Necromantiche</td>
		</tr>
		<tr>
			<td colspan=8 class="alc"><hr></td>
		</tr>
<?		$precedente=5;
		if ($clan==7) {$mult=2;} else {$mult=3;}
		$MySql="SELECT * FROM necromanzie LEFT JOIN necromanzie_main ON necromanzie.idnecro = necromanzie_main.idnecro
		WHERE idutente=$idutente ORDER BY principale";
		$Result=mysql_query($MySql);
		while( $res=mysql_fetch_array($Result)){
			if ( $res['livello']< 5 ) {
?>
		<tr>
<?				if ($exp< ($res['livello']+1)*$mult || ($res['livello']+1==$prec && $prec !=5)) {
?>
			<td class="alc">- Aumenta <?=$res['nomenecro']?> -</td>
<?				} else {
?>
			<td><form method="post" action="ws/px.php"><input type=submit name="Necromanzia" value="Aumenta <?=$res['nomenecro']?>" ><input type=hidden name="idnecro" value="<?=$res['idnecro']?>"></form></td>
<?				}
?>
			<td>&nbsp;</td>
			<td>Valore attuale</td>
			<td><?=$res['livello']?></td>
			<td>&nbsp;</td>
			<td>px: <?= ($res['livello']+1)*$mult ?></td>
			<td>&nbsp;</td>
		</tr>
<?
				$prec=$res['livello'];
			}
		}
?>
		<tr>
	<!-- Acquisizione nuove necromanzie -->
<?
		if ($clan==11) {$mult=2;} else {$mult=5;}
		$ok_new_t=0;
		$Mysql="SELECT MIN(livello) as m FROM necromanzie WHERE idutente=$idutente";
		$Result=mysql_query($Mysql);
		$res=mysql_fetch_array($Result);
			if ($res['m']=='' || $res['m'] >1 ) $ok_new_t=1;


		$Mysql="SELECT necromanzie_main.idnecro,necromanzie_main.nomenecro  FROM necromanzie_main
				LEFT JOIN necromanzie ON necromanzie.idnecro = necromanzie_main.idnecro AND idutente = $idutente
				WHERE  necromanzie.livello IS NULL";
		$Result=mysql_query($Mysql);
		if ( mysql_num_rows($Result) && $ok_new_t ) {
?>
		<tr>
			<form method="post" action="ws/px.php">
<?			if ( $exp < $mult ) {
?>
				<td class="alc">- Acquisisci -</td>
<?			} else {
?>
				<td><input type=submit name="ImparaNecro" value="Acquisisci"></td>
<?			}
?>
			<td>&nbsp;</td>
			<td colspan=2><select name="idnecro">
<?			while ($res=mysql_fetch_array($Result)) {
?>
				<option value="<?=$res['idnecro']?>" ><?=$res['nomenecro']?></option>
<?			}
?>
				</select></td>
			<td>&nbsp;</td>
			<td>px: <?=$mult?></td>
			<td>&nbsp;</td>
			</form>
		</tr>
<?		}
?>
		<!--- fine necromanzia --->
		<!--- rituali --->

<?	$Mysql="SELECT livello, DiClan FROM discipline where iddisciplina=98 and idutente=$idutente";
		$Result=mysql_query($Mysql);
		if ($res=mysql_fetch_array($Result) ) {
			$taumaturgia=$res['livello'];
			$diclan=$res['DiClan'];
			if ($diclan=='S') {	$mult=2; } else { $mult=3;}

?>
		<tr>
			<td colspan=8 class="alc title2">Rituali</td>
		</tr>
		<tr>
			<td colspan=8 class="alc"><hr></td>
		</tr>
<?

			$Mysql="SELECT max(livello) as m FROM rituali_t
				LEFT JOIN rituali_t_main ON rituali_t.idrituale = rituali_t_main.idrituale
				WHERE idutente =$idutente ";
			$Result=mysql_query($Mysql);
			$res=mysql_fetch_array($Result);
			$livellocur=$res['m'];
			if ( $livellocur=="") { $livellocur=0; }

			for ( $i=1; ($i<= $taumaturgia && $i<7 && $i<=($livellocur+1) ); $i++ ) {


				$Mysql="SELECT rituali_t_main.idrituale,rituali_t_main.nomerituale  FROM rituali_t_main
				LEFT JOIN rituali_t ON rituali_t.idrituale = rituali_t_main.idrituale AND idutente = $idutente
				WHERE  idutente IS NULL AND livello = $i";
				$Result=mysql_query($Mysql);
?>
		<tr>
			<form method="post" action="ws/px.php">
<?			if ( $exp < $mult*$i ) {
?>
				<td class="alc">- Acquisisci -</td>
<?			} else {
?>
				<td><input type=submit name="ImparaRituale" value="Acquisisci"><input type="hidden" value="<?=$mult*$i?>" name="costo" /></td>
<?			}
?>
			<td>&nbsp;</td>
			<td colspan=2><select name="idrituale">
<?			while ($res=mysql_fetch_array($Result)) {
?>
				<option value="<?=$res['idrituale']?>" ><?=$res['nomerituale']?></option>
<?			}
?>
				</select></td>
			<td>&nbsp;</td>
			<td>px: <?=$mult*$i?></td>
			<td>&nbsp;</td>
			</form>
		</tr>
<?
			}
		}
?>
		<!--- fine rituali --->
		<!--- rituali2 --->

<?	$Mysql="SELECT livello, DiClan FROM discipline where iddisciplina=99 and idutente=$idutente";
		$Result=mysql_query($Mysql);
		if ($res=mysql_fetch_array($Result) ) {
			$necromanzia=$res['livello'];
			$diclan=$res['DiClan'];
			if ($diclan=='S') {	$mult=2; } else { $mult=3;}

?>
		<tr>
			<td colspan=8 class="alc title2">Rituali</td>
		</tr>
		<tr>
			<td colspan=8 class="alc"><hr></td>
		</tr>
<?

			$Mysql="SELECT max(livello) as m FROM rituali_n
				LEFT JOIN rituali_n_main ON rituali_n.idrituale = rituali_n_main.idrituale
				WHERE idutente =$idutente ";
			$Result=mysql_query($Mysql);
			$res=mysql_fetch_array($Result);
			$livellocur=$res['m'];
			if ( $livellocur=="") { $livellocur=0; }

			for ( $i=1; ($i<= $necromanzia && $i<7 && $i<=($livellocur+1) ); $i++ ) {


				$Mysql="SELECT rituali_n_main.idrituale,rituali_n_main.nomerituale  FROM rituali_n_main
				LEFT JOIN rituali_n ON rituali_n.idrituale = rituali_n_main.idrituale AND idutente = $idutente
				WHERE  idutente IS NULL AND livello = $i";
				$Result=mysql_query($Mysql);
?>
		<tr>
			<form method="post" action="ws/px.php">
<?			if ( $exp < (($livellocur==0 && $diclan=='S')?0:$mult*$i) ) {
?>
				<td class="alc">- Acquisisci -</td>
<?			} else {
?>
				<td><input type=submit name="ImparaRitualeN" value="Acquisisci"><input type="hidden" value="<?=($livellocur==0 && $diclan=='S')?0:$mult*$i?>" name="costo" /></td>
<?			}
?>
			<td>&nbsp;</td>
			<td colspan=2><select name="idrituale">
<?			while ($res=mysql_fetch_array($Result)) {
?>
				<option value="<?=$res['idrituale']?>" ><?=$res['nomerituale']?></option>
<?			}
?>
				</select></td>
			<td>&nbsp;</td>
			<td>px: <?=($livellocur==0 && $diclan=='S')?0:$mult*$i?></td>
			<td>&nbsp;</td>
			</form>
		</tr>
<?
			}
		}
?>
		<!--- fine rituali 2--->
		<tr>
			<td colspan=8 class="alc title2">Forza di Volontà</td>
		</tr>
		<tr>
			<td colspan=8 class="alc"><hr></td>
		</tr>
<?	if ( $fdv<10 ) {
?>
		<tr>
<?		if ( $exp < ($fdv+1)*4 ) {
?>
			<td class="alc">- Aumenta Forza di Volontà -</td>
<?		} else {
?>
			<td><form method="post" action="ws/px.php"><input type=submit name="FDV" value="Aumenta Forza di Volontà" ></form></td>
<?		}
?>
			<td>&nbsp;</td>
			<td>Valore attuale</td>
			<td><?=$fdv?></td>
			<td>&nbsp;</td>
			<td>px: <?= ($fdv+1)*4 ?></td>
			<td>&nbsp;</td>
		</tr>
<?	}
?>
		<tr>
			<td colspan=8 >&nbsp;</td>
		</tr>
		<tr>
			<td colspan=8 >&nbsp;</td>
		</tr>
		<tr>
			<td colspan=8 ><button class="w3-btn w3-white w3-border w3-border-blue w3-round w3-block" onclick="javascript:window.location.href='main.php'">Indietro</button></td>
		</tr>
	</table>
	</div>
	<p>&nbsp;
	<p>&nbsp;
	<p>&nbsp;
</body>
