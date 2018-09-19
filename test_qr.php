<?php
// Including all required classes
include('phpqrcode/qrlib.php'); 




// Don't forget to sanitize user inputs
$text = isset($_GET['text']) ? $_GET['text'] : 'HELLO';


 QRcode::png($text);
 
 $tempDir =  "/web/htdocs/www.roma-by-night.it/home/notturna/tmp/";
 $filename=$tempDir."QR".$text.".png";

QRcode::png($text, $filename, QR_ECLEVEL_Q); 
echo '<img src="'.$filename.'" />'; 

?>
