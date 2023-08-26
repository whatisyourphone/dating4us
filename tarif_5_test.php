<!DOCTYPE HTML>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">


<?php


session_start();

include ("functions_yalynka.php");



 $ip=getenv("REMOTE_ADDR");
 $ag=getenv("HTTP_USER_AGENT");


list ($white11, $white22, $white33)=from_file($ip,$ag);
//$white11=from_file($ip,$ag);
//print($white33);


from_file_counter($white33);
//$white11=from_file($ip,$ag);

exit;



?>
</html>
