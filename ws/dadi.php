<?
	header('Content-type: text/xml; charset="utf-8"');
	include ('../session_start.inc.php');
	include ('../db_start.inc.php');



	$last=$_SESSION['LastTime'];
	
	if ($last=="") $last=0;

// inizio output XML
	

	
	
	$MySql = "SELECT count(*) FROM dadi  ";
	$Result = mysql_query($MySql);
	$rs=mysql_fetch_row($Result);

	echo '<?xml version="1.0" encoding="utf-8" ?>';
	echo '<chat>';


	if ( $rs['0'] == 0 ) { 
		$_SESSION['LastTime']=0;

		echo '<status>0</status>';	 // vuota o svuotata
		
		
	} else {

		if ($last == 0 ) {

			echo '<status>-1</status>';	//gestione reverse
			
			$MySql = "SELECT * FROM dadi  ";
			$MySql .= " ORDER BY ID DESC LIMIT 0, 20 ";
			$Result = mysql_query($MySql);
			
		} else {
	
			echo '<status>1</status>';	//gestione normale

			$MySql = "SELECT * FROM dadi WHERE ID > '$last' ORDER BY ID ASC";
			$Result = mysql_query($MySql);
			
		}

		while ($rs=mysql_fetch_array($Result) ) {
			if ($rs['ID'] > $last) {	
				$last = $rs['ID'];
			}
			echo '<post>';
			echo '<idpg>'.$rs['idutente'].'</idpg>';
			echo '<pg>'.$rs['nomepg'].'</pg>';

//			echo '<testo>'.htmlentities($rs['Testo'],ENT_QUOTES).'</testo>';
//			echo '<testo>'.htmlspecialchars($rs['Testo'],ENT_NOQUOTES).'</testo>';
			echo '<testo>'.htmlspecialchars($rs['Testo'],ENT_QUOTES).'</testo>';
//			echo '<testo>'.$rs['Testo'].'</testo>';			

			echo '<ora>'.strftime("%H:%M", strtotime($rs['Ora'])).'</ora>';
			echo '<data>'.strftime("%d/%m/%Y", strtotime($rs['Ora'])).'</data>';
			echo '</post>';
		}
		echo '<row>'.$last.'</row>';
		$_SESSION['LastTime']=$last;
	}
	echo '</chat>';


?>
