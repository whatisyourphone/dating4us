<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">


<?php


session_start();

//include ("my_functions.php");
//check_valid_user();

//$norm_hour=58.2;

//print_r($_SERVER);

 $ip=getenv("REMOTE_ADDR");
 $ag=getenv("HTTP_USER_AGENT");

function to_file(){
 $dirname1=dirname(__FILE__);
 $sf ="$dirname1/stat_error.dat";
 $fpsf=fopen($sf,"a+");
 $ip=getenv("REMOTE_ADDR");
 $ag=getenv("HTTP_USER_AGENT");
 $from=getenv("HTTP_REFERER");
 $host=getenv("REQUEST_URI");
 $date = date("d.m.y");
 fputs($fpsf,"$date#$time#$ip#$ag#$from#$host\n");
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

list ($white11, $white22, $white33)=from_file($ip,$ag);
//$white11=from_file($ip,$ag);
//print($white33);
   if($white11<>100){
    to_file();
    print("$ag");
    print('<br>');
    print('error');
    exit();
}

function to_file_ok($white33){
 $dirname1=dirname(__FILE__);
 $sf ="$dirname1/stat_ok.dat";
 $fpsf=fopen($sf,"a+");
 $who=$white33;
 $ip=getenv("REMOTE_ADDR");
// $ag=getenv("HTTP_USER_AGENT");
// $from=getenv("HTTP_REFERER");
// $host=getenv("REQUEST_URI");
 $date = date("d.m.y.h.m");
// fputs($fpsf,"$date#$time#$ip#$ag#$from#$host\n");
 fputs($fpsf,"$who#$date#$ip\n");
 fclose($fpsf);
}


//if($ip<>'176.37.166.29'){    //Oleg linder
//if($ip<>'82.145.220.252'){   //Oleg Linder
////if($ip<>'94.45.88.138'){     //my_home_zhukova
////if($ip<>'94.153.226.246'){   //my_job
//if(!strpos($ag,'SM-J120H Build/LMY47V')){   //my Samsung
//if(!strpos($ag,'ozilla/5.0 (iPhone; CPU iPhone OS 11_3_1 like Mac OS X) AppleWebKit/604.1.34')){   //Lupashevskiy
////if(!strpos($ag,'HUAWEI Y541-U02 Build/HUAWEIY541-U02')){ //my Huawei
//if(!strpos($ag,'ozilla/5.0 (Linux; Android 5.1; Lenovo P1ma40 Build/LMY47D) AppleWebKit/537.36 (KHTML, like Gecko)')){ //Fedorov 
//if(!strpos($ag,'ozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170')){ //my job and my home and other! 
//if(!strpos($ag,'ozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36 OPR/54.0.2952.51')){ //my job 
//if(!strpos($ag,'Lenovo P70-A Build/KOT49H')){ //Yulia
////if(!strpos($ag,'AppleWebKit/537.36')){ //my job comp
////if(!strpos($ag,'ozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36 OPR/52.0.2871.64')){ //my_home_Zhukova
//if(!strpos($ag,'CAM-L21 Build/HUAWEICAM')){ //Ksyuha Olega
//if(!strpos($ag,'Android 6.0.1;ru_ru; C107-9 Build/ZFXCNCT5801711253S)')){ //Oleg Linder
//to_file();
//print("$ag");
//print('<br>');
//print('error');
//exit();
//}}}}}}}}}}

to_file_ok($white33);


$nds=20;
$norm_hour=$_POST["norm_hour"];
$type_of_surv=$_POST["type_of_surv"];
$lenght=$_POST["lenght"];
$kol_korp=$_POST["kol_korp"];
$power_of_engine=$_POST["power_of_engine"];
$hydro=$_POST["hydro"];
$new_ves=$_POST["new_ves"];
$renew=$_POST["renew"];
$renew2=$_POST["renew2"];
$vidr=$_POST["vidr"];
$document=$_POST["document_1"];
$document_copy=$_POST["document_copy_1"];
$type_of_ves=1;

if (!preg_match("|^[\d]*[\.]?[\d]*$|", $document)):
    print ('Некорректный ввод');
elseif (!preg_match("|^[\d]*[\.]?[\d]*$|", $document_copy)):
    print ('Некорректный ввод');
exit;  
else: 
    //$document1=round($norm_hour*$document+$norm_hou$document/100*20,2);
    if($power_of_engine<=30):
     $add_doc=$document*0.25;
     $add_doc_copy=$document_copy*0.2;
    else:
     $add_doc=$document;
     $add_doc_copy=$document_copy*0.8;
    endif;
endif;

if(isset($vidr)):
   $vidr=370;
   $vidr1=round($vidr/$norm_hour,2);
     //$vidr1=3.27;
else:
   $vidr1=0;
endif;

if ($power_of_engine==''):
 print('Не введена мощность двигателя');
//Шаблон проверки числа. В качестве разделителя - точка или запятая
 //elseif(!preg_match("|^[\d]*[\.,]?[\d]*$|", $power_of_engine)):
//Шаблон проверки числа. В качестве разделителя - точка или запятая
elseif(!preg_match("|^[\d]*[\.]?[\d]*$|", $power_of_engine)):
 print ('Некорректный ввод');
elseif(isset($renew)&&isset($renew2)):
 print('Нужно выбрать только один из "чергових"');
elseif(isset($new_ves)&&isset($renew)):
 print('Нужно выбрать только один из вариантов');
elseif(isset($new_ves)&&isset($renew2)):
 print('Нужно выбрать только один из вариантов');
elseif(($type_of_surv==3)&&isset($renew)||($type_of_surv==3)&&isset($renew2)):
 print('Это первичный');
elseif(($type_of_surv==2.25)&&isset($new_ves)):
 print('Это черговий');
elseif(($type_of_surv==2)&&isset($new_ves)||($type_of_surv==2)&&isset($renew)||($type_of_surv==2)&&isset($renew2)):
print('Это проміжний');
elseif(($type_of_surv==1)&&isset($new_ves)||($type_of_surv==1)&&isset($renew)||($type_of_surv==1)&&isset($renew2)):
 print('Это проміжний');
 exit();
else:

if (isset($new_ves)&&$type_of_surv==3):
   // if ($type_of_surv==3):
     $new_ves=3;
   // endif;
   //print ("new_ves=yes");
  else:
   $new_ves=0; 
  endif;


//$power_array=array("0","1.6","2","2.3","2.5","2.6","3.3","3.5","3.6","4","5","5.8","6","8","9.8","9.9","15","18","20","23","25","30","40","45","50","55","60","65","70","74","75","80","90","100","110","115","120","125","130","135","140","145","150","155","160","170","180","190","200","210","215","220","225","230","240","245","250","260","270","280","290","300","310","320","330","350","370","400","460","500","520","560","600","640","680","700");
//$power_array=array("60","65","70","75","80","85","90","100","110","115","125","130","135","140","150","155","175","180","185","200","210","215","225","250","255","260","300");
//for($i = 0; $i < count($power_array); $i++) 
//   { 
//$power_of_engine=$power_array[$i];


//print("type_of_surv=$type_of_surv");
//print('<br><br>');
//print("lenght=$lenght");
//print('<br><br>');
//print("kol_korp=$kol_korp");
//print('<br><br>');
//print("power_of_engine=$power_of_engine");
//print('<br><br>');
//print("norm_hour=$norm_hour");
//print('<br><br>');


if($power_of_engine==0):
  if ($type_of_surv==1||$type_of_surv==2):
   $normativ=1;$type_of_ves=0.75;$kol_dok=0.25;$tal=0.1;
  else:
    $normativ=1;$type_of_ves=0.75;$new_ves1=0.5;$kol_dok=1;$tal=0.1;
  endif;

elseif($power_of_engine>0 && $power_of_engine<=6.25):
  if ($type_of_surv==1||$type_of_surv==2):
   $normativ=1;$kol_dok=0.25;$tal=0.2;
  else:  
    $normativ=1;$new_ves1=0.5;$kol_dok=1;$tal=0.2;
  endif;

elseif($power_of_engine>6.25 && $power_of_engine<=15):
  if ($type_of_surv==1||$type_of_surv==2):
   $normativ=sqrt($power_of_engine)*0.4;$kol_dok=0.25;$tal=0.2;
  else:  
    $normativ=sqrt($power_of_engine)*0.4;$new_ves1=0.5;$kol_dok=1;$tal=0.2;
  endif;

elseif($power_of_engine>=16 && $power_of_engine<=30):
  if ($type_of_surv==1||$type_of_surv==2):
   $normativ=sqrt($power_of_engine)*0.45;$kol_dok=0.25;$tal=0.2;
  else:
    $normativ=sqrt($power_of_engine)*0.45;$new_ves1=0.5;$kol_dok=1;$tal=0.2;
  endif;

elseif($power_of_engine>=31 && $power_of_engine<=40):
  if ($type_of_surv==1||$type_of_surv==2):
   $normativ=sqrt($power_of_engine)*0.55;$kol_dok=1;$tal=0.2;
  else:
   $normativ=sqrt($power_of_engine)*0.55;$kol_dok=4;$tal=0.2;
  endif;

elseif($power_of_engine>=41 && $power_of_engine<=50):
  if ($type_of_surv==1||$type_of_surv==2):
   $normativ=sqrt($power_of_engine)*0.6;$kol_dok=1;$tal=0.2;
  else:
   $normativ=sqrt($power_of_engine)*0.6;$kol_dok=4;$tal=0.2;
  endif;

elseif($power_of_engine>=51 && $power_of_engine<=74):
  if ($type_of_surv==1||$type_of_surv==2):
   $normativ=sqrt($power_of_engine)*0.65;$kol_dok=1;$tal=0.2;
  else:
   $normativ=sqrt($power_of_engine)*0.65;$kol_dok=4;$tal=0.2;
  endif;

elseif($power_of_engine==75):
  if($type_of_surv==1||$type_of_surv==2):
   $normativ=sqrt($power_of_engine)*0.65;$kol_dok=2;$tal=0.2;
  else:
   $normativ=sqrt($power_of_engine)*0.65;$kol_dok=5;$tal=0.2;
  endif;

elseif($power_of_engine>=76 && $power_of_engine<=100):
  if ($type_of_surv==1||$type_of_surv==2):
   $normativ=sqrt($power_of_engine)*0.65;$kol_dok=2;$tal=0.2;
  else:
   $normativ=sqrt($power_of_engine)*0.65;$kol_dok=5;$tal=0.2;
  endif;

elseif($power_of_engine>=101 && $power_of_engine<=150):
  if ($type_of_surv==1||$type_of_surv==2):
   $normativ=sqrt($power_of_engine)*0.7;$kol_dok=2;$tal=0.2;
  else:
   $normativ=sqrt($power_of_engine)*0.7;$kol_dok=5;$tal=0.2;   endif;

elseif($power_of_engine>=151 && $power_of_engine<=200):
  if ($type_of_surv==1||$type_of_surv==2):
   $normativ=sqrt($power_of_engine)*0.8;$kol_dok=2;$tal=0.2;
  else:
   $normativ=sqrt($power_of_engine)*0.8;$kol_dok=5;$tal=0.2;
  endif;

elseif($power_of_engine>=201 && $power_of_engine<=300):
  if ($type_of_surv==1||$type_of_surv==2):
   $normativ=sqrt($power_of_engine)*0.9;$kol_dok=2;$tal=0.2;
  else:
   $normativ=sqrt($power_of_engine)*0.9;$kol_dok=5;$tal=0.2;
  endif;

elseif($power_of_engine>300):
  if ($type_of_surv==1||$type_of_surv==2):
   $normativ=sqrt($power_of_engine)*1;$kol_dok=2;$tal=0.2;
  else:
   $normativ=sqrt($power_of_engine)*1;$kol_dok=5;$tal=0.2;
  endif;

endif;


if ($new_ves<>0&&$power_of_engine<=30): 
       //if($power_of_engine<=30):
       $new_ves=0.5;
elseif($new_ves<>0&&$power_of_engine>30):
       $new_ves=3;   
      // endif;
endif;

if($power_of_engine<>0):
 $type_of_ves=1;
endif;

 if (isset($hydro)&&$power_of_engine>=75):
  $kol_dok=$kol_dok-1;
 endif;
 
 if (isset($renew)&&$power_of_engine<=30):
  $kol_dok=$kol_dok-0.5;
  $kol_dok=$kol_dok+0.4;
 endif;

 if (isset($renew2)&&$power_of_engine<=30):
  $kol_dok=$kol_dok-0.5;
 endif;

 if (isset($renew)&&$power_of_engine>30):
  $kol_dok=$kol_dok-2;
  $kol_dok=$kol_dok+1.6;
 endif;

if (isset($renew2)&&$power_of_engine>30):
  $kol_dok=$kol_dok-2;
 endif;

//print("normativ=$normativ");
//print('<br><br>');
$normativ1=preg_replace("/(\d+\.{0,1}(\d{0,4}))\d*/","$1",$normativ);
//print("normativ1=$normativ1");
//print('<br><br>');
//print("new_ves=$new_ves");
//print('<br><br>');

//otladka
//printf("lenght=%s<br>",$lenght);
//printf("type_of_surv=%s<br>",$type_of_surv);
//printf("kol_korp=%s<br>",$kol_korp);
//printf("normativ1=%s<br>",$normativ1);
//printf("type_of_ves=%s<br>",$type_of_ves);
//printf("new_ves=%s<br>",$new_ves);
//printf("kol_dok=%s<br>",$kol_dok);
//printf("tal=%s<br>",$tal);
$sum_norm_hour=$lenght*$type_of_surv*$kol_korp*$normativ1*$type_of_ves+$new_ves+$kol_dok+$add_doc+$add_doc_copy+$tal+$vidr1;
$sum_norm_hour1=round($sum_norm_hour,2);
$sum_norm_hour2=round($sum_norm_hour1,2);
//printf("sum_norm_hour=%s<br>",$sum_norm_hour);
//printf("sum_norm_hour1=%s<br>",$sum_norm_hour1);
//printf("sum_norm_hour2=%s<br>",$sum_norm_hour2);


//$sum_norm_hour=$lenght*$type_of_surv*$kol_korp*$normativ1*$type_of_ves+$new_ves+$kol_dok+$tal;
//$sum_norm_hour1=round($sum_norm_hour,2);
//$sum_without_nds=round($sum_norm_hour1*$norm_hour,2);
$sum_without_nds=round($sum_norm_hour2*$norm_hour,2);
$sum_with_nds=round($sum_without_nds/100*20+$sum_without_nds,2);

//print("Мощность: <b>$power_array[$i]</b> ");
print("СУММА: <b>$sum_with_nds</b>");
//print("<br>$ip<br>");
//print("$ag");

//print("<b>$sum_with_nds</b>");
print('<br>');
$power_of_engine_kW=round($power_of_engine/1.3596,2);
//print("Потужність кВт: <b>$power_of_engine_kW</b>");
print('<br>');

//}


endif;

include("./includes_stat/counter_tarif.php");

?>
</html>
