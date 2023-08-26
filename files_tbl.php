<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1251">
<title> Файлы </title>
<script language="JavaScript" type="text/javascript" src="jquery/jquery-1.11.1.min.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery/jquery.simpletip-kvartorg-1.3.1.min.js"></script>
<link rel="stylesheet" href="css/style_2.css">
</head>
<body bgcolor="#EEEFFF">
<br>

<table>


<?php
//session_start();
//include("my_functions.php");
//check_valid_user();
$hostname1='boat.pp.ua';
// $name_db=$_GET["name_db"];
 $name_tbl=$_GET["name_tbl"];
 $id=$_GET["id"];
// $image=$_GET["image"];

//$i=0;
//$id0=explode("'",$id);
//$id1=$id0[1];
$directory="/home/lodka/htdocs/blanks/$name_tbl/$id";
//$directory="/blanks/$name_tbl/$id";
$directory1="/blanks/$name_tbl/$id";
//echo($directory);

if (!is_dir($directory))
if(!mkdir($directory)) { echo "Ошибка создания каталога $directory...<br />\n"; } 



//foreach (scandir ("./blanks") as $filename){
//print($directory);
//print('Для печати картинки нажмите на ней');
//}

//print('<br><br>');
$dl=opendir($directory);
 while ($filename=readdir($dl)):
 
   if($filename != "." && $filename != ".."){  
   if(!is_dir($directory . "/" . $filename))
//if ($filename == '.' || $filename == '..' || !is_dir($directory . "/" . $filename))
    {
    //$filename1=substr($filename,0,7).$filename_new;
 
print("<tr>");
if (ereg("jpg",$filename)||ereg("jpeg",$filename)||ereg("JPG",$filename)):
 $filename1=$filename;
// echo($filename1);
 $size=getimagesize("http://$hostname1/$directory1/$filename1");
 $width1=$size[0]/10;
 $height1=$size[1]/10;
 $width2=$size[0]/2;
 $height2=$size[1]/2;
 print("<td><img src=\"http://$hostname1/$directory1/$filename1\" width=$width1 height=$height1 alt=\"img\" title=\"$filename1\"></td>");
 print("<td><a href=\"http://$hostname1/$directory1/$filename1\" width=$width1 height=$height1 alt=\"img\" title=\"$filename1\">$filename1</td>");
// print("<td><img src=\"http://$hostname1/$directory1/$filename1\"></td>");
// print("<td><a href=\"image_print.php?filename1=$filename1&directory=$directory&width=$width2&height=$height2\" target=\"_blank\">Открыть и напечатать картинку</a></td><td> </td>");
endif;
print("</tr>");
}
   }
$i=$i+1;
endwhile;
closedir($dl);
 //print('<br>');



?>

</table><br><br>




<?php
//printf("<a href=http://$hostname1/boats_inf_tbl.php?name_db=$name_db&name_tbl=$name_tbl&what=content&any_query=&x=0&y=30>к списку</a><br>");
?>

</body>
</html>
