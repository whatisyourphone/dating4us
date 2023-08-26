<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">

<?php

session_start();

include ("functions_yalynka.php");
$ip=getenv("REMOTE_ADDR");
$ag=getenv("HTTP_USER_AGENT");
//check_valid_user();

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

//KNIGA-----------------------------------
////$norm_hour=58.2;
//$power_of_engine=$_POST["power_of_engine"];
$nds=20;
$lenght1=$_POST["lenght1"];
$action1=$_POST["action1"];
$course=$_POST["course"];
$k_or_r=$_POST["k_or_r"];


if(!isset($k_or_r)):
 print('<font color=red>Не выбрана книга или реестр</font>');
 exit();
endif;
if($course==0):
 print('<font color=red>Не введен курс</font>');
 exit();
endif;
if(!preg_match("|^[\d]*[\.]?[\d]*$|", $course)):
print('<font color=red>Нужно ввести курс через точку</font>');
 exit();
endif;
//$course=str_replace(",",".",$course);


printf("Курс НБУ: <b>%s</b><br>",$course);

if($k_or_r==k):
 if($action1==140):
  $calc2=$lenght1*$action1*$course;
  $calc2=round($calc2,2);
  //$calc3=$calc2*0.2+$calc2;
  print("СУМА СК Реєстрація: <b>$calc2</b><br>");
 elseif($action1==45):
  $calc2=$lenght1*$action1*$course;
  $calc2=round($calc2,2);
  //$calc3=$calc2*0.2+$calc2;
  print("СУМА СК Виключення: <b>$calc2</b><br>");
 elseif($action1==25):
  $calc2=$lenght1*$action1*$course;
  $calc2=round($calc2,2);
  //$calc3=$calc2*0.2+$calc2;
  print("СУМА СК Оновлення: <b>$calc2</b><br>");
 elseif($action1==141):
  $action1=$action1-1;
  $calc2=$lenght1*$action1*$course;
  //$calc3=$calc2*0.2+$calc2;
  $calc4=$calc2/100*50;
  $calc2=round($calc4,2);
  print("СУМА СК Внесення змін: <b>$calc2</b><br>");
 elseif($action1==142):
  $action1=$action1-2;
  $calc2=$lenght1*$action1*$course;
  //$calc3=$calc2*0.2+$calc2;
  $calc5=$calc2/100*35;
  $calc2=round($calc5,2);
  print("СУМА СК Перереєстрація: <b>$calc2</b><br>");
 endif;
endif;

//REESTR-----------------------------------
$nds=20;
$age=$_POST["age"];
$action2=$_POST["action2"];
$course=$_POST["course"];

if($k_or_r==r):
 if($action2==140):
  $calc7=$action2*$age*$course;
  $calc7=round($calc7,2);
  //$calc3=$calc2*0.2+$calc2;
  print("СУМА ДСРУ Реєстрація: <b>$calc7</b><br>");
 elseif($action2==70):
  $calc7=$action2*$age*$course;
  $calc7=round($calc7,2);
  //$calc3=$calc2*0.2+$calc2;
  print("СУМА ДСРУ Тимчасова реєстрація: <b>$calc7</b><br>");
 elseif($action2==45):
  $calc7=$action2*$course;
  $calc7=round($calc7,2);
  //$calc3=$calc2*0.2+$calc2;
  print("СУМА ДСРУ Виключення: <b>$calc7</b><br>");
 elseif($action2==25):
  $calc7=$action2*$age*$course;
  //$calc3=$calc2*0.2+$calc2;
  $calc7=round($calc7,2);
  print("СУМА ДСРУ Оновлення: <b>$calc7</b><br>");
 elseif($action2==141):
  $action2=$action2-1;
  $calc7=$action2*$age*$course;
  //$calc3=$calc2*0.2+$calc2;
  $calc7=$calc7/100*50;
  $calc7=round($calc7,2);
  print("СУМА ДСРУ Внесення змін: <b>$calc7</b><br>");
 elseif($action2==142):
  $action2=$action2-2;
  $calc7=$action2*$age*$course;
  //$calc3=$calc2*0.2+$calc2;
  $calc7=$calc7/100*35;
  $calc7=round($calc7,2);
  print("СУМА ДСРУ Перереєстрація: <b>$calc7</b><br>");
 endif;
endif;


to_file_umri($white33);

//$itogo_dsru=$calc7+$sum_with_nds;
//   print("<br><b>ИТОГО ДСРУ:</b> <b><font color=\"blue\">
//$itogo_dsru</font></b>");
 
//$itogo_sk=$calc2+$sum_with_nds;
//   print("<br><b>ИТОГО СК:</b> <b><font color=\"blue\">
//$itogo_sk</font></b>");



?>
</html>
