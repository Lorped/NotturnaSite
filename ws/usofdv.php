<?
	include ('../session_start.inc.php');
	include ('../db_start.inc.php');

	if (!isset ($_SESSION['idutente'])) {

	// die ("Errore, nessuna sessione attiva!");
		session_write_close();
		header("Location: index.php", true);

	} else {
   		$idutente=$_SESSION['idutente'];

		$Mysql="SELECT nomepg, fdv  FROM personaggio WHERE idutente=$idutente";
		if ( $res=mysql_fetch_array(mysql_query($Mysql)) ) {
			$nomepg=mysql_real_escape_string($res['nomepg']);
			$fdv=$res['fdv'];
		} else {
			$nomepg="NARRAZIONE";
		}
	}



		$testo="usa Forza di Volontà";
		$Mysql="INSERT INTO dadi ( idutente, nomepg, Ora, Testo) VALUES ( $idutente, '$nomepg', NOW(), '$testo' ) ";
		mysql_query($Mysql);
		$Mysql="UPDATE personaggio SET fdv=fdv-1 WHERE idutente= $idutente ";
		mysql_query($Mysql);

		header("Location: ../pulsanti.php", true);



?>
