<?php

	$name_db="boats3"; 
	$hostname="localhost";
	$username="root";
	$password="sam";
        $port="3306";

 function connect_db($hostname,$port,$username,$password)
 {
   if(!$db = @mysql_connect("$hostname:$port", "$username", "$password")):
    {
     print("<h2>Wrong password or username!</h2>");
     print("<BR><BR>\n");
     echo("<B>Error ". mysql_errno() . ": " . mysql_error() . "</B>");
     session_destroy();
     exit;
    }
    endif;
 return $db;
 }
 
?>

