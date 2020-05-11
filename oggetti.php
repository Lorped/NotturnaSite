<?php
	include ('session_start.inc.php');
	include ('db_start.inc.php');


	if (!isset ($_SESSION['idutente'])) {
		// die ("Errore, nessuna sessione attiva!");
		session_write_close();
		header("Location: index.php", true);
	}


	$idutente=$_SESSION['idutente'];

	//die(print_r($_POST));

	if (isset($_POST['id']) && $_POST['id']=='new'){
		$nome=mysql_real_escape_string($_POST['nome']);
		$descrizione=mysql_real_escape_string($_POST['descrizione']);
		$barcode=rand(100000000000,999999999999);
		$fm=$_POST['fissomobile'];
		$Mysql="INSERT INTO oggetti ( barcode, nomeoggetto, descrizione, fissomobile ) VALUES ( $barcode, '$nome', '$descrizione' , '$fm' ) ";
		mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error() ."+".$Mysql);
	}

	if (isset($_POST['id']) && $_POST['id']!='new'){
		$idx=$_POST['id'];

		$condtypeA='addA'.$idx;
		$condtypeS='addS'.$idx;
		$condtypeD='addD'.$idx;
		$condtypeP='addP'.$idx;
		$conddomanda='addDom'.$idx;

		if ( ! isset($_POST[$conddomanda] ) ) {
			$val=$_POST['val'];

			if (isset($_POST[$condtypeA])) {
				$tipocond="A";
				$attributo=$_POST['attributo'];
			}
			if (isset($_POST[$condtypeS])) {
				$tipocond="S";
				$attributo=$_POST['Skill'];
			}
			if (isset($_POST[$condtypeD])) {
				$tipocond="D";
				$attributo=$_POST['Disciplina'];
			}
			if (isset($_POST[$condtypeP])) {
				$tipocond="P";
				$attributo=$_POST['Potere'];
				$val=1;
			}

			$descrX=mysql_real_escape_string($_POST['descrX']);

			$risp=$_POST['risp'];

			if ($risp != 'X') {
			$Mysql="INSERT INTO cond_oggetti ( idoggetto, tipocond, tabcond, valcond, descrX, risp) values($idx, '$tipocond', $attributo, $val, '$descrX' , '$risp')";
		} else {
			$Mysql="INSERT INTO cond_oggetti ( idoggetto, tipocond, tabcond, valcond, descrX ) values($idx, '$tipocond', $attributo, $val, '$descrX' )";
		}




			mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error() ."+".$Mysql);
		}

		if (isset($_POST[$conddomanda])) {
			$newdom= mysql_real_escape_string($_POST['Xdomanda']);
			$newr1= mysql_real_escape_string($_POST['Xr1']);
			$newr2= mysql_real_escape_string($_POST['Xr2']);

			$Mysql="UPDATE oggetti
				SET ifdomanda = 1 ,
					domanda ='$newdom' ,
					r1 ='$newr1' ,
					r2 = '$newr2'
					WHERE idoggetto= $idx";
			mysql_query($Mysql);
			if (mysql_errno()) die ( mysql_errno().": ".mysql_error() ."+".$Mysql);
		}
	}


	if (isset($_POST['cccxb']) ){
		$ccx=$_POST['ccx'];
		$Mysql="DELETE FROM cond_oggetti WHERE idcondizione= $ccx";
		mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error() ."+".$Mysql);
	}

	if (isset($_POST['cccxbdom']) ){
		$ccx=$_POST['cccxdom'];
		$Mysql="UPDATE oggetti
			SET ifdomanda = 0 ,
				domanda = NULL ,
				r1 = NULL ,
				r2 = NULL
				WHERE idoggetto= $ccx";

		mysql_query($Mysql);

		if (mysql_errno()) die ( mysql_errno().": ".mysql_error() ."+".$Mysql);
	}

	if (isset($_POST['cancXX']) ){
		$ccx=$_POST['ccx'];
		$Mysql="DELETE FROM cond_oggetti WHERE idoggetto= $ccx";
		mysql_query($Mysql);
		$Mysql="DELETE FROM oggetti WHERE idoggetto= $ccx";
		mysql_query($Mysql);
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
	<script>
		function show_hide(xx) {

			if ( document.getElementById(xx).style.display=="none") {
				document.getElementById(xx).style.display="table";
			} else {
				document.getElementById(xx).style.display="none";
			}
		}
	</script>
</head>
<body>

	<div align=center>
	<table>
		<tr>
			<td width="40">&nbsp;</td>
			<td width="120">&nbsp;</td>
			<td width="150">&nbsp;</td>
			<td width="370">&nbsp;</td>
			<td width="80">&nbsp;</td>
			<td width="80">&nbsp;</td>
			<td width="80">&nbsp;</td>
			<td width="80">&nbsp;</td>
		</tr>
		<tr>
			<td colspan=8 class="alc title"><hr>Oggetti<hr></td>
		</tr>
		<tr>
			<td class="title2">id</td>
			<td class="title2">Barcode</td>
			<td class="title2">Nome</td>
			<td class="title2">Descrizione</td>
			<td class="title2 alc">Tipo</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>

<?

		$Mysql="SELECT * FROM oggetti ORDER BY idoggetto";
		$Result=mysql_query($Mysql);
		while ( $res=mysql_fetch_array($Result)) {
			$idx=$res['idoggetto'];
			$ifdomanda=$res['ifdomanda'];
			$domanda=$res['domanda'];
			$r1=$res['r1'];
			$r2=$res['r2'];
?>
		<tr>

			<td><?=$res['idoggetto']?></td>
			<td><?=$res['barcode']?></td>
			<td><?=$res['nomeoggetto']?></td>
			<td><?=$res['descrizione']?></td>
			<td class="alc"><?=$res['fissomobile']?></td>
			<td><button name="change<?=$idx?>" class="w3-btn w3-white w3-border w3-border-blue w3-round " onClick="submit();" disabled>Aggiorna</button></td>
			<td><button name="cond<?=$idx?>" id="cond<?=$idx?>" class="w3-btn w3-white w3-border w3-border-blue w3-round " onClick='show_hide("tabellacond<?=$idx?>")'>Mostra/Nasc. condizioni</button></td>
			<td><form name="<?=$idx?>" method=post action=""><input type=hidden name="ccx" value="<?=$res['idoggetto']?>" ><button name="cancXX" class="w3-btn w3-white w3-border w3-border-red w3-round " onClick="submit();">Cancella</button></form></td>

		</tr>
<?
 //if ($ifdomanda == '0') {
			$Mysql2="SELECT * FROM cond_oggetti WHERE idoggetto=$idx AND risp IS NULL ORDER BY valcond ASC";
			$Result2=mysql_query($Mysql2);
			while ( $res2=mysql_fetch_array($Result2)) {
				if ($res2['tipocond'] == 'A' ){
					switch ( $res2['tabcond'] ) {
						case 1: $cc="Forza" ; break;
						case 2: $cc="Destrezza" ; break;
						case 3: $cc="Attutimento" ; break;
						case 4: $cc="Carisma" ; break;
						case 5: $cc="Persuasione" ; break;
						case 6: $cc="Saggezza" ; break;
						case 7: $cc="Percezione" ; break;
						case 8: $cc="Intelligenza" ; break;
						case 9: $cc="Prontezza" ; break;
					}
					?>
						<tr> <td>&nbsp;</td><td> <?=$cc?> </td>  <td>Min. <?=$res2['valcond'] ?> </td><td><?=$res2['descrX'] ?> </td> <td><form name="<?=$idx.$res2['idcondizione']?>" method=post action=""><input type=hidden name="ccx" value="<?=$res2['idcondizione']?>" ><button name="cccxb" class="w3-btn w3-white w3-border w3-border-red w3-round " onClick="submit();">X</button></form></td></tr>
					<?
				}
				if ($res2['tipocond'] == 'S' ){
					$ids=$res2['tabcond'];
					$Mysql4="SELECT nomeskill FROM skill_main WHERE idskill = $ids";
					$Result4=mysql_query($Mysql4);
					$res4=mysql_fetch_array($Result4);

					?>
						<tr> <td>&nbsp;</td><td> <?=$res4['nomeskill']?> </td>  <td>Min. <?=$res2['valcond'] ?> </td><td><?=$res2['descrX'] ?> </td> <td><form name="<?=$idx.$res2['idcondizione']?>"  method=post action=""><input type=hidden name="ccx" value="<?=$res2['idcondizione']?>" ><button name="cccxb" class="w3-btn w3-white w3-border w3-border-red w3-round " onClick="submit();">X</button></form></td></tr>
					<?
				}
				if ($res2['tipocond'] == 'D' ){
					$ids=$res2['tabcond'];
					$Mysql4="SELECT nomedisc FROM discipline_main WHERE iddisciplina = $ids";
					$Result4=mysql_query($Mysql4);
					$res4=mysql_fetch_array($Result4);

					?>
						<tr> <td>&nbsp;</td><td> <?=$res4['nomedisc']?> </td>  <td>Min. <?=$res2['valcond'] ?> </td><td><?=$res2['descrX'] ?> </td> <td><form name="<?=$idx.$res2['idcondizione']?>"  method=post action=""><input type=hidden name="ccx" value="<?=$res2['idcondizione']?>" ><button name="cccxb" class="w3-btn w3-white w3-border w3-border-red w3-round " onClick="submit();">X</button></form></td></tr>
					<?
				}
				if ($res2['tipocond'] == 'P' ){
					$ids=$res2['tabcond'];
					$Mysql4="SELECT nomepotere FROM poteri_main WHERE idpotere = $ids";
					$Result4=mysql_query($Mysql4);
					$res4=mysql_fetch_array($Result4);

					?>
						<tr> <td>&nbsp;</td><td> <?=$res4['nomepotere']?> </td>  <td>&nbsp;</td><td><?=$res2['descrX'] ?> </td> <td><form name="<?=$idx.$res2['idcondizione']?>"  method=post action=""><input type=hidden name="ccx" value="<?=$res2['idcondizione']?>" ><button name="cccxb" class="w3-btn w3-white w3-border w3-border-red w3-round " onClick="submit();">X</button></form></td></tr>
					<?
				}
			}
//		}
?>
<? if ($ifdomanda != '0') {
?>
	<tr>
		<td>&nbsp;</td>
		<td colspan=2> <?=$domanda?> </td>
		<td><b>Si:</b> <?=$r1 ?> <br> <b>No:</b> <?=$r2?> </td>
		<td><form name="Cancdomanda"  method=post action=""><input type=hidden name="cccxdom" value="<?=$idx?>" ><button name="cccxbdom" class="w3-btn w3-white w3-border w3-border-red w3-round " onClick="submit();">X</button></form></td></tr>
	</tr>

	<?

				$Mysql2="SELECT * FROM cond_oggetti WHERE idoggetto=$idx AND risp IS NOT NULL ORDER BY valcond ASC";
				$Result2=mysql_query($Mysql2);
				while ( $res2=mysql_fetch_array($Result2)) {
					if ($res2['tipocond'] == 'A' ){
						switch ( $res2['tabcond'] ) {
							case 1: $cc="Forza" ; break;
							case 2: $cc="Destrezza" ; break;
							case 3: $cc="Attutimento" ; break;
							case 4: $cc="Carisma" ; break;
							case 5: $cc="Persuasione" ; break;
							case 6: $cc="Saggezza" ; break;
							case 7: $cc="Percezione" ; break;
							case 8: $cc="Intelligenza" ; break;
							case 9: $cc="Prontezza" ; break;
						}
						?>
							<tr> <td><?=$res2['risp']=='S'?'SI:':'NO:'?></td><td> <?=$cc?> </td>  <td>Min. <?=$res2['valcond'] ?> </td><td><?=$res2['descrX'] ?> </td> <td><form name="<?=$idx.$res2['idcondizione']?>" method=post action=""><input type=hidden name="ccx" value="<?=$res2['idcondizione']?>" ><button name="cccxb" class="w3-btn w3-white w3-border w3-border-red w3-round " onClick="submit();">X</button></form></td></tr>
						<?
					}
					if ($res2['tipocond'] == 'S' ){
						$ids=$res2['tabcond'];
						$Mysql4="SELECT nomeskill FROM skill_main WHERE idskill = $ids";
						$Result4=mysql_query($Mysql4);
						$res4=mysql_fetch_array($Result4);

						?>
							<tr> <td><?=$res2['risp']=='S'?'SI:':'NO:'?></td><td> <?=$res4['nomeskill']?> </td>  <td>Min. <?=$res2['valcond'] ?> </td><td><?=$res2['descrX'] ?> </td> <td><form name="<?=$idx.$res2['idcondizione']?>"  method=post action=""><input type=hidden name="ccx" value="<?=$res2['idcondizione']?>" ><button name="cccxb" class="w3-btn w3-white w3-border w3-border-red w3-round " onClick="submit();">X</button></form></td></tr>
						<?
					}
					if ($res2['tipocond'] == 'D' ){
						$ids=$res2['tabcond'];
						$Mysql4="SELECT nomedisc FROM discipline_main WHERE iddisciplina = $ids";
						$Result4=mysql_query($Mysql4);
						$res4=mysql_fetch_array($Result4);

						?>
							<tr> <td><?=$res2['risp']=='S'?'SI:':'NO:'?></td><td> <?=$res4['nomedisc']?> </td>  <td>Min. <?=$res2['valcond'] ?> </td><td><?=$res2['descrX'] ?> </td> <td><form name="<?=$idx.$res2['idcondizione']?>"  method=post action=""><input type=hidden name="ccx" value="<?=$res2['idcondizione']?>" ><button name="cccxb" class="w3-btn w3-white w3-border w3-border-red w3-round " onClick="submit();">X</button></form></td></tr>
						<?
					}
					if ($res2['tipocond'] == 'P' ){
						$ids=$res2['tabcond'];
						$Mysql4="SELECT nomepotere FROM poteri_main WHERE idpotere = $ids";
						$Result4=mysql_query($Mysql4);
						$res4=mysql_fetch_array($Result4);

						?>
							<tr> <td><?=$res2['risp']=='S'?'SI:':'NO:'?></td><td> <?=$res4['nomepotere']?> </td>  <td>&nbsp;</td><td><?=$res2['descrX'] ?> </td> <td><form name="<?=$idx.$res2['idcondizione']?>"  method=post action=""><input type=hidden name="ccx" value="<?=$res2['idcondizione']?>" ><button name="cccxb" class="w3-btn w3-white w3-border w3-border-red w3-round " onClick="submit();">X</button></form></td></tr>
						<?
					}
				}
	?>



<?
}
?>

		<tr>
			<td colspan=8>
				<table id="tabellacond<?=$idx?>" width="100%" border="0" align="center" cellpadding="1" cellspacing="1" style="display: none">

				<tr><form name="newA<?=$idx?>" method=post action=""><input type=hidden name="id" value="<?=$idx?>" >
					<td>Attributo</td>
					<td colspan=2><select name="attributo">
						<option value="1">Forza</option>
						<option value="2">Destrezza</option>
						<option value="3">Attutimento</option>
						<option value="4">Carisma</option>
						<option value="5">Persuasione</option>
						<option value="6">Saggezza</option>
						<option value="7">Percezione</option>
						<option value="8">Intelligenza</option>
						<option value="9">Prontezza</option>
						</select>
					</td>
					<td><? if($res['ifdomanda']!='0'){?>Sempre<input type="radio" name="risp" value="X" checked><br> SI<input type="radio" name="risp" value="S"><br> NO<input type="radio" name="risp" value="N" > <?}?></td>
					<td>Min. <input name=val type=number min=1 max=5 size=1 value=1></td>
					<td class="alc"><textarea name="descrX" cols="40" rows="3" ></textarea></td>
					<td><button name="addA<?=$idx?>" class="w3-btn w3-white w3-border w3-border-blue w3-round " onClick="submit();">Aggiungi</button></td>
					</form>
				</tr>
				<tr><form name="newS<?=$idx?>" method=post action=""><input type=hidden name="id" value="<?=$idx?>" >
					<td>Skill</td>
					<td colspan=2><select name="Skill">
<?  					$Mysql3 ="SELECT idskill, nomeskill FROM skill_main";
						$Result3=mysql_query($Mysql3);
						while ($res3=mysql_fetch_array($Result3) ){
?>
							<option value="<?=$res3['idskill']?>" ><?=$res3['nomeskill']?></option>
<?
						}
?>
						</select>
					</td>
					<td><? if($res['ifdomanda']!='0'){?>Sempre<input type="radio" name="risp" value="X" checked><br> SI<input type="radio" name="risp" value="S"><br> NO<input type="radio" name="risp" value="N" > <?}?></td>
					<td>Min. <input name=val type=number min=1 max=5 size=1 value=1></td>
					<td class="alc"><textarea name="descrX" cols="40" rows="3" ></textarea></td>
					<td><button name="addS<?=$idx?>" class="w3-btn w3-white w3-border w3-border-blue w3-round " onClick="submit();">Aggiungi</button></td>
					</form>
				</tr>
				<tr><form name="newD<?=$idx?>" method=post action=""><input type=hidden name="id" value="<?=$idx?>" >
					<td>Disciplina</td>
					<td colspan=2><select name="Disciplina">
<?  					$Mysql3 ="SELECT iddisciplina, nomedisc FROM discipline_main";
						$Result3=mysql_query($Mysql3);
						while ($res3=mysql_fetch_array($Result3) ){
?>
							<option value="<?=$res3['iddisciplina']?>" ><?=$res3['nomedisc']?></option>
<?
						}
?>
						</select>
					</td>
					<td><? if($res['ifdomanda']!='0'){?>Sempre<input type="radio" name="risp" value="X" checked><br> SI<input type="radio" name="risp" value="S"><br> NO<input type="radio" name="risp" value="N" > <?}?></td>
					<td>Min. <input name=val type=number min=1 max=5 size=1 value=1></td>
					<td class="alc"><textarea name="descrX" cols="40" rows="3" ></textarea></td>
					<td><button name="addD<?=$idx?>" class="w3-btn w3-white w3-border w3-border-blue w3-round " onClick="submit();">Aggiungi</button></td>
					</form>
				</tr>
				<tr><form name="newP<?=$idx?>" method=post action=""><input type=hidden name="id" value="<?=$idx?>" >
					<td>Poteri</td>
					<td colspan=2><select name="Potere">
<?  					$Mysql3 ="SELECT idpotere, nomepotere, livellopot FROM poteri_main";
						$Result3=mysql_query($Mysql3);
						while ($res3=mysql_fetch_array($Result3) ){
?>
							<option value="<?=$res3['idpotere']?>" ><?=$res3['livellopot'].'.'.$res3['nomepotere']?></option>
<?
						}
?>
						</select>
					</td>
					<td><? if($res['ifdomanda']!='0'){?>Sempre<input type="radio" name="risp" value="X" checked><br> SI<input type="radio" name="risp" value="S"><br> NO<input type="radio" name="risp" value="N" > <?}?></td>
					<td>&nbsp;</td>
					<td class="alc"><textarea name="descrX" cols="40" rows="3" ></textarea></td>
					<td><button name="addP<?=$idx?>" class="w3-btn w3-white w3-border w3-border-blue w3-round " onClick="submit();">Aggiungi</button></td>
					</form>
				</tr>
				<tr><form name="newDom<?=$idx?>" method=post action=""><input type=hidden name="id" value="<?=$idx?>" >
					<td>Domanda</td>
					<td colspan=2></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td class="alc" colspan= ><textarea name="Xdomanda" cols="40" rows="3"  ><?=$domanda?></textarea></td>
					<td><button name="addDom<?=$idx?>" class="w3-btn w3-white w3-border w3-border-blue w3-round " onClick="submit();">Aggiungi</button></td>

				</tr>

				<tr>
					<td>SI:</td>
					<td colspan=3><textarea name="Xr1" cols="40" rows="3" ><?=$r1?></textarea></td>
					<td>No:</td>
					<td class="alc"><textarea name="Xr2" cols="40" rows="3" ><?=$r2?></textarea></td>
					<td>&nbsp;</td>
					</form>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan=8 ><hr></td>
		</tr>
<?
	}
?>


		<tr>
			<td colspan=8 >&nbsp;</td>
		</tr>
		<tr>
			<td colspan=8 class="alc title2">Nuovo Oggetto<hr></td>
		</tr>

		<tr>
			<form name="new" method=post action=""><input type=hidden name="id" value="new" >
			<td>Nome</td>
			<td colspan=2><input type="input" id="nome" name="nome" size=25 required></td>
			<td colspan=3 class="alc"><textarea name="descrizione" cols="50" rows="5" ></textarea></td>
			<td>Fisso<input type="radio" name="fissomobile" value="F">
				Mob.<input type="radio" name="fissomobile" value="M" checked>
				Esterno<input type="radio" name="fissomobile" value="E">
				Celato<input type="radio" name="fissomobile" value="C">
				Utente<input type="radio" name="fissomobile" value="U"> </td>
			<td><button name="change" class="w3-btn w3-white w3-border w3-border-blue w3-round onClick="submit();"" >Inserisci</button></td>
			</form>
		</tr>




<!------ ------>
		<tr>
			<td colspan=8 >&nbsp;</td>
		</tr>
		<tr>
			<td colspan=8 >&nbsp;</td>
		</tr>
		<tr>
			<td colspan=9 ><button class="w3-btn w3-white w3-border w3-border-red w3-round w3-block" onclick="javascript:window.location.href='stampaoggetti.php'">Stampa Oggetti</button></td>
		</tr>
		<tr>
			<td colspan=8 ><button class="w3-btn w3-white w3-border w3-border-blue w3-round w3-block" onclick="javascript:window.location.href='main.php'">Indietro</button></td>
		</tr>
<!---- -->
	</table>
	</div>
	<p>&nbsp;
	<p>&nbsp;
	<p>&nbsp;
</body>
