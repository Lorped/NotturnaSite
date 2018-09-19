<?
$par_DbHost = '62.149.150.60' ;
// $par_DbHost = 'localhost' ;
$par_DbUser = 'Sql153576';
// $par_DbUser = 'rbn2user';
$par_DbPassword = 'lQVCp2oI' ;
// $par_DbPassword = 'rbn2passwd' ;
$par_DbName = 'Sql153576_1' ;
// $par_DbName = 'rbn2' ;



$db = mysql_connect($par_DbHost,$par_DbUser,$par_DbPassword) or die("<b>ERRORE DI ACCESSO AI DATI</B><br>L'errore di solito &egrave; dovuto a problemi di sovraccarico del server, &egrave; temporaneo e sparisce dopo qualche minuto.<br><br>
IL problema di oggi ( 16 - febbraio 2012 ) &egrave; dovuto ad un malfunzionamento del provider ARUBA<br>
Confidiamo che venga risolto quanto prima.. scusate per il disagio.<br><br><a href='Javascript:location.reload()'>riprova</a>");
$dbselect=mysql_select_db($par_DbName);

mysql_set_charset('utf8',$db);

	if(!$dbselect) {
		mysql_close($db);
		die("There seems to be a problem with the MySQL database, sorry for the inconvenience.");
	}

?>