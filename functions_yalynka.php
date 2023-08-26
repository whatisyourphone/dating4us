<?php


function to_file(){
 $dirname1=dirname(__FILE__);
 $sf ="$dirname1/stat_error.dat";
 $fpsf=fopen($sf,"a+");
 $ip=getenv("REMOTE_ADDR");
 $ag=getenv("HTTP_USER_AGENT");
 $from=getenv("HTTP_REFERER");
 $host=getenv("REQUEST_URI");
 $date = date("d.m.y");
 $time1 = date("H.i"); 
 fputs($fpsf,"$date#$time1#$ip#$ag#$from#$host\n");
 fclose($fpsf);
}


function from_file($ip,$ag){
$white1=0;
if (($handle = fopen("./whitelist.txt", "r")) !== FALSE)
{
    while (($data = fgetcsv($handle, 1000, "    ")) !== FALSE) {
        $whitelist[]=$data[0];
        }
    fclose($handle);
}

   for($j = 0; $j < count($whitelist); $j++)
   {
     if($ip==$whitelist[$j]||strpos($ag,$whitelist[$j])){
             $white1=100;
             $white2=$whitelist[$j];
             $white3=$whitelist[$j-1];
      }
   }
return array ($white1,$white2,$white3);
}

function from_file_counter($user_in_system){
$date_m=date(m);
$file_handle=fopen("./stat_ok.dat","r");
while(!feof($file_handle)){
$line=fgets($file_handle);
//echo($line);
//foreach($lines as $line){
$string2= explode('#',$line);
$username=$string2[0];
$data=$string2[1];
$string3=explode('.',$string2[1]);
$month=$string3[1];
//print($username.$month);
//print('<br>');
if ($username==$user_in_system)
if ($month==$date_m)
 { $arr[]=$username.$month;
//   print ($username.$month);
//   print('<br>'); 
//   print_r($arr);  
 }
}
$col_vo=count($arr);
printf("You are used system %s times in %s months",$col_vo,$date_m);
}



function to_file_umri($white33){
 $dirname1=dirname(__FILE__);
 $sf ="$dirname1/stat_umri.dat";
 $fpsf=fopen($sf,"a+");
 $who=$white33;
 $ip=getenv("REMOTE_ADDR");
// $ag=getenv("HTTP_USER_AGENT");
// $from=getenv("HTTP_REFERER");
// $host=getenv("REQUEST_URI");
 $date = date("d.m.y");
 $time1 = date("H.i"); 
// fputs($fpsf,"$date#$time#$ip#$ag#$from#$host\n");
 fputs($fpsf,"$who#$date#$time1#$ip\n");
 fclose($fpsf);
}


function to_file_ok($white33){
 $dirname1=dirname(__FILE__);
 $sf ="$dirname1/stat_ok.dat";
 $fpsf=fopen($sf,"a+");
 $who=$white33;
 $ip=getenv("REMOTE_ADDR");
 $ag=getenv("HTTP_USER_AGENT");
// $from=getenv("HTTP_REFERER");
// $host=getenv("REQUEST_URI");
 $date = date("d.m.y");
 $time1 = date("H.i"); 
// fputs($fpsf,"$date#$time1#$ip#$ag#$from#$host\n");
 fputs($fpsf,"$who#$date#$time1#$ip\n");
 fclose($fpsf);
}

?>
