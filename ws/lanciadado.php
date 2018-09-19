<?
	include ('../session_start.inc.php');
	include ('../db_start.inc.php');

	if (!isset ($_SESSION['idutente'])) {

	// die ("Errore, nessuna sessione attiva!");
		session_write_close();
		header("Location: index.php", true);

	} else {
   		$idutente=$_SESSION['idutente'];

		$Mysql="SELECT nomepg FROM personaggio WHERE idutente=$idutente";
		if ( $res=mysql_fetch_array(mysql_query($Mysql)) ) {
		$nomepg=mysql_real_escape_string($res['nomepg']);
		} else {
			$nomepg="NARRAZIONE";
		}
	}


		$tiro=rand(1,5);
		$testo="tira ".$tiro;
		$Mysql="INSERT INTO dadi ( idutente, nomepg, Ora, Testo) VALUES ( $idutente, '$nomepg', NOW(), '$testo' ) ";
		mysql_query($Mysql);

		header("Location: ../pulsanti.php", true);



?>
