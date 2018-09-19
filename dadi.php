<?
	include ('session_start.inc.php');
	include ('db_start.inc.php');

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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Notturna - Cronaca di Roma</title>
	<link href="https://fonts.googleapis.com/css?family=Libre+Baskerville" rel="stylesheet">
	<link href="w3.css" rel="stylesheet">

	<style type="text/css">

		input[type=number] {
			width:  80px;
			-moz-appearance: textfield;
		}
		body {
			font-family: arial, sans-serif;
			font-size: 1.1em;
		}
		.tdc {
			text-align: left;
		}
	</style>
	<script src="include2.js"></script>
	<script>

      loadXMLDoc('ws/dadi.php');
       window.setInterval("loadXMLDoc('ws/dadi.php')", 20000);
	</script>
</head>
<body>


<div id="x" ></div>

</body>
