<!DOCTYPE HTML>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">

<?php 
//session_start();
include ("my_functions.php");
//check_valid_user();                   

function show_form() 
{ 
?> 

<form action="" method="post"> 
<div align="center"> 
Сообщение<br> 
<textarea rows="10" name="mess" cols="30"></textarea>


<?
if ($_SESSION['username']=='admin'):{
  print("<br><select name=\"to_email\">");
  print("<option value=andrey_svirid@yahoo.com>to_Yahoo</option>");
  print("<option value=andrey@battery.kiev.ua>to_Other</option>");
  print("</select>");}
endif;
?>

<br><input type="submit" value="Отправить" name="submit"> 
</div> 
</form> 

<? 
} 

function complete_mail() { 
                // $_POST['title'] содержит данные из поля "Тема", trim() - убираем все лишние пробелы и переносы строк, htmlspecialchars() - преобразует специальные символы в HTML сущности, будем считать для того, чтобы простейшие попытки взломать наш сайт обломались, ну и    substr($_POST['title'], 0, 1000) - урезаем текст до 1000 символов. Для переменных $_POST['mess'], $_POST['name'], $_POST['tel'], $_POST['email'] все аналогично 
                //$_POST['title'] =    substr(htmlspecialchars(trim($_POST['title'])), 0, 1000); 
//$mess1 = substr(htmlspecialchars(trim($_POST['mess'])), 0, 1000000); 
$mess1=$_POST['mess'];
$toemail = substr(htmlspecialchars(trim($_POST['to_email'])), 0, 50); 
//$toemail=$_POST['to_email'];
                //$_POST['name'] =    substr(htmlspecialchars(trim($_POST['name'])), 0, 30); 
                //$_POST['tel'] =    substr(htmlspecialchars(trim($_POST['tel'])), 0, 30); 
                //$_POST['email'] =    substr(htmlspecialchars(trim($_POST['email'])), 0, 50); 
                // если не заполнено поле "Имя" - показываем ошибку 0 
                //if (empty($_POST['name'])) 
                //         output_err(0); 
                // если неправильно заполнено поле email - показываем ошибку 1 
                //if(!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $_POST['email'])) 
                 //        output_err(1); 
                // если не заполнено поле "Сообщение" - показываем ошибку 2 
                if(empty($_POST['mess'])) 
                         output_err(2); 
                // создаем наше сообщение 
                $mess = 'Сообщение:'.$mess1;
		    $subject = 'От blacklist';
                // $to - кому отправляем           
                
 if ($_SESSION['username']=='admin'):
  $to = $toemail;
 else:
  $to = 'andrey@battery.kiev.ua';
 endif;

		    // $to = 'andrey@battery.kiev.ua';
                // $from - от кого
                $from='From:andrey@battery.kiev.ua';
                $headers = 'Content-type: text/html; charset=windows-1251 ' . "\r\n";
		    $headers.=$from;
                mail($to, $subject, $mess, $headers);

                echo 'Спасибо! Ваше сообщение принято'; 
} 

function output_err($num) 
{ 
        //$err[0] = 'ОШИБКА! Не введено имя.'; 
        //$err[1] = 'ОШИБКА! Неверно введен e-mail.'; 
        $err[2] = 'ОШИБКА! Не введено сообщение.'; 
        echo '<p>'.$err[$num].'</p>'; 
        show_form(); 
        exit(); 
} 

if (!empty($_POST['submit'])) complete_mail(); 
else show_form(); 
?> 


</html>