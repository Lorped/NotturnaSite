<? include ('inc/session_start.inc.php');

$_SESSION['idutente']=NULL;
unset ( $_SESSION['idutente'] );
session_write_close();

setcookie (session_id(), "", time() - 3600);
session_destroy();
session_write_close();

header("Location: index.php", true);
?>