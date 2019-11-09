<?
	include ('session_start.inc.php');
	include ('db_start.inc.php');

 	if (!isset ($_SESSION['idutente'])) die ("Errore, nessuna sessione attiva!");

  $idutente=$_SESSION['idutente'];

	$Mysql="select count(*) as a from personaggio where idutente=$idutente";
	$Res=mysql_fetch_array(mysql_query($Mysql));

	$numscheda=$Res['a'];

	$Mysql="select count(*) as a from HUNTERpersonaggio where idutente=$idutente";
	$Res=mysql_fetch_array(mysql_query($Mysql));

	$numschedaH=$Res['a'];

	if ( $numscheda != 0 )  {   // VAMPIRO !!

  $Mysql = "DELETE FROM personaggio WHERE idutente = $idutente";
 	mysql_query($Mysql);
	if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );

	$Mysql = "DELETE FROM background WHERE idutente = $idutente";
 	mysql_query($Mysql);
	if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );

	$Mysql = "DELETE FROM discipline WHERE idutente = $idutente";
 	mysql_query($Mysql);
	if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );

	$Mysql = "DELETE FROM taumaturgie WHERE idutente = $idutente";
 	mysql_query($Mysql);
	if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );

	$Mysql = "DELETE FROM necromanzie WHERE idutente = $idutente";
 	mysql_query($Mysql);
	if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );

	$Mysql = "DELETE FROM background WHERE idutente = $idutente";
 	mysql_query($Mysql);
	if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );

	$Mysql = "DELETE FROM skill WHERE idutente = $idutente";
 	mysql_query($Mysql);
	if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );

	$Mysql = "DELETE FROM contatti WHERE idutente = $idutente";
 	mysql_query($Mysql);
	if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );

	$Mysql = "DELETE FROM logpx WHERE idutente = $idutente";
 	mysql_query($Mysql);
	if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );

	$Mysql = "DELETE FROM pregidifetti WHERE idutente = $idutente";
 	mysql_query($Mysql);
	if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );

	$Mysql = "DELETE FROM rituali_t WHERE idutente = $idutente";
 	mysql_query($Mysql);
	if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );

	$Mysql = "DELETE FROM rituali_n WHERE idutente = $idutente";
 	mysql_query($Mysql);
	if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );

	$Mysql = "DELETE FROM rubrica WHERE owner = $idutente";
 	mysql_query($Mysql);
	if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );

	$Mysql = "DELETE FROM legami WHERE target = $idutente";
 	mysql_query($Mysql);
	if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );

	$Mysql = "DELETE FROM legami WHERE domitor = $idutente";
 	mysql_query($Mysql);
	if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );

	$Mysql = "DELETE FROM poteri WHERE idutente = $idutente";
	mysql_query($Mysql);
	if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );

	$Mysql = "DELETE FROM logpx  WHERE idutente = $idutente";
	mysql_query($Mysql);
	if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );

	}
	if ( $numschedaH != 0 )  {   // CACCIATORE !!
		$Mysql = "DELETE FROM HUNTERpersonaggio WHERE idutente = $idutente";
	 	mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );

		$Mysql = "DELETE FROM HUNdiscipline WHERE idutente = $idutente";
	 	mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );

		$Mysql = "DELETE FROM background WHERE idutente = $idutente";
	 	mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );

		$Mysql = "DELETE FROM skill WHERE idutente = $idutente";
	 	mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );

		$Mysql = "DELETE FROM logpx  WHERE idutente = $idutente";
		mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );

		$Mysql = "DELETE FROM contatti WHERE idutente = $idutente";
	 	mysql_query($Mysql);
		if (mysql_errno()) die ( mysql_errno().": ".mysql_error() );
	}

  session_write_close();
	header("Location: main.php", true);

?>
