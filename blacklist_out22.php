<!DOCTYPE HTML>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">

<title> Blacklist </title>

<table border="1" cellpadding="3">

<?php
$name_tbl='blacklist';

include ("my_functions.php");
$db=connect_db ("$hostname","$port","$username","$password");
mysql_select_db("$name_db", $db);
$sql = "SELECT * FROM $name_tbl ORDER BY data_id";
mysql_query("SET NAMES 'cp1251'");
mysql_query("SET CHARACTER SET 'cp1251'");
//print($sql);
$result=mysql_query($sql);
if(!$result):
   echo("<B>Error ". mysql_errno() . ": " . mysql_error() . "</B><BR>\n");
   print("error");
   exit;
 else:
 while ($row = mysql_fetch_array($result))
   {
 printf("<tr><td>%s</td>",$row['date_of_issue']);
 printf("<td>%s</td>",$row['events']);
 printf("<td>%s</td>",$row['comments']);
 printf("<td><a href=\"files_tbl.php?name_db=$name_db&name_tbl=$name_tbl&id=%s\">Show docs</td></tr>",$row['data_id']);

    }
  endif;

  print("<a href=\"my_mail1.php\" target=\"_blank\">Сообщить об инциденте</a><br><br>");

?>

</table>

