<html>

<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">


<?php
foreach (scandir ("./") as $filename){
  if($filename != "." && $filename != ".." && $filename != "index.php"){
$ext_of_file=substr( strstr(basename($filename), '.'), 1 );  
if($ext_of_file!="pdf" && $ext_of_file!="jpg")
  {
//print(filetype($filename));

print("<video width=\"200\" height=\"320\" controls=\"controls\" muted=\"muted\" autoplay>");
//print("<video width=\"200\" height=\"320\" controls=\"controls\" autoplay>");
//print("<video width=\"400\" height=\"320\" controls=\"controls\">");
print("<source src=\"./$filename\" type=video/mp4; codecs=\"avc1.42E01E, mp4a.40.2\"> </video>");

print('<br>');

//"<a href=\"./$filename\">$filename");print('<br>');
//print("<a href=\"./$filename\">$filename");
//print('<br>');

}
        }}
?>


</html>
