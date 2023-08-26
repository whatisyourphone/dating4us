<?php

 class Whois {

 var $errormsg = "";


 // список доменов поддерживаемых системой
 var $whois_exts = array(
 "ua",
 "kiev.ua",
 "pp.ua",
 "ru",
 "com.ru",
 "org.ru",
 "net.ru",
 "msk.ru",
 "spb.ru",
 "com",
 "net",
 "org",
 "info",
 "biz",
 "co.uk"
 );
 // массив `whois' серверов
 var $whois_servers = array(
 "ua" => "whois.net.ua",
 "kiev.ua" => "whois.net.ua",
 "pp.ua" => "whois.net.ua",
 "com" => "whois.internic.net",
 "net" => "whois.verisign-grs.com",
 "org" => "whois.internic.net",
 "info" => "info.whois-servers.net",
 "biz" => "biz.whois-servers.net"
 );
 var $whois_info_servers = array(
 "ua" => "whois.ua",
 "com" => "whois.networksolutions.com",
 "net" => "whois.networksolutions.com",
 "org" => "whois.networksolutions.com",
 "edu" => "whois.networksolutions.com",
 "mil" => "whois.networksolutions.com",
 "info" => "info.whois-servers.net",
 "biz" => "biz.whois-servers.net"
 );
 var $whois_info_servers_backup = array(
 "com" => "whois.internic.net",
 "net" => "whois.internic.net",
 "org" => "whois.internic.net",
 "edu" => "whois.internic.net",
 "mil" => "whois.internic.net",
 "info" => "info.whois-servers.net",
 "biz" => "biz.whois-servers.net"
 );
 // массив строк возващаемых whois если домен недоступен
 var $whois_avail_strings = array(
 "info.whois-servers.net" =>"NOT FOUND",
 "biz.whois-servers.net" =>"Not found",
 "whois.internic.net" =>"No match",
 "whois.nic.uk" => "No match",
 "whois.bulkregister.com" => "Not found",
 );

 // проверка домена на корректность, возвращает false если ошибка или true если все верно
 function check_domain($domain,$ext)
 {

 if(isset($ext)){
 if(!strlen($ext)){
 $this->errormsg = "Не задан домен первого уровня";
 return 0;
 }
 if(!$this->my_in_array($ext,$this->whois_exts)){
 $this->errormsg = "Данный домен первого уровня не поддерживается системой";
 return 0;
 }
 }
 if(isset($domain)){
 if(strlen($domain) < 2 || strlen($domain) > 57){
 $this->errormsg = "Домен cлишком длинный или короткий";
 return 0;
 }
 if(strlen($domain) == 2 && !ereg("([0-9]){2}",$domain)){
 $this->errormsg = "Имя домена должно содержать только букву и цифру или две буквы, если оно состоит из двух знаков";
 return 0;
 }
 if(ereg("^-|-$",$domain)){
 $this->errormsg = "Имя домена не может начинатся или заканчиваться на дефис и не может содержать два дефиса идущий подряд";
 return 0;
 }
 if(!ereg("([a-z]|[A-Z]|[0-9]|-){".strlen($domain)."}",$domain)){
 $this->errormsg = "Имя домена может состоять только из букв, цифр и дефиса";
 return 0;
 }
 } 

 return 1;
 }
 // проверка наличия значения в массиве
 function my_in_array($val,$array_)
 {
 for($l=0; $l<sizeof($array_); $l++)
 if($array_[$l] == $val)
 return 1;

 return 0;
 }
 // пытаемся найти домен и вернуть ответ сервера
 // если вернулось -1 то ошибка
 function do_raw($domainname, $ext)
 {
 static $rawoutput,$ns;


 if(!$this->check_domain($domainname,$ext)) return -1;

 if(($ns = fsockopen($this->whois_info_servers[$ext],43)) == false){
 if(($ns = fsockopen($this->whois_info_servers_backup[$ext],43)) == false)
 return -1;
 else
 $server = $this->whois_info_servers_backup[$ext];
 }
 else
 $server = $this->whois_info_servers[$ext];

 fputs($ns,"$domainname.$ext\n");
 while(!feof($ns))
 $rawoutput = $rawoutput.fgets($ns,128);

 fclose($ns);

 $pos = @strpos($rawoutput,$this->whois_avail_strings[$server]);
 if(is_string($pos) && !$pos) {} else {
 if(!is_string($pos) || $pos){
 if(($ns = fsockopen($this->whois_info_servers_backup[$ext],43)) == false)
 return -1;
 else {
 $rawoutput = "";
 fputs($ns,"$domainname.$ext\n");
 while(!feof($ns))
 $rawoutput = $rawoutput.fgets($ns,128);
 $pos = @strpos($rawoutput,$this->whois_avail_strings[$this->whois_info_servers_backup[$ext]]);
 if(!is_string($pos) || $pos){}
 else
 return -1;
 }
 }
 }
 return $rawoutput;
 }
 // ищем домен в whois, возвращаем 1 если найден и 0 если не найден, если -1 то ошибка соединения 
 // если $raw = true, то возварщаем ответ whois
 function perform_whois($domainname,$ext,$raw = false)
 {
 static $rawoutput,$ns,$mystr,$str;
 if(preg_match("/msk.ru$/",$ext) or preg_match("/spb.ru$/",$ext) ) {
 if(checkdnsrr("$domainname.$ext",SOA)) {
 if($raw) {
 exec("/usr/bin/dig @ns.mtu.ru $domainname.$ext soa",$str);
 foreach($str as $value) {
 $mystr.="$value\n";
 // echo $value;
 }
 // $str=preg_replace("/\n/","<br>",$str);
 return $mystr; 
 } else {
 return 1;
 }
 } else {
 $this->errormsg = "SOA записей для домена $domainname.$ext не найдена";
 return -1;
 }
 }
 if(!$this->check_domain($domainname,$ext)) return -1;

 $rawoutput = "";

 if($raw)
 return $this->do_raw($domainname,$ext);

 if(($ns = fsockopen($this->whois_servers[$ext],43)) == false){
 $this->errormsg = "Не могу соеденится с <b><i>".$this->whois_servers[$ext]."</i></b>";
 return -1;
 }
 fputs($ns,"$domainname.$ext\n");
 while(!feof($ns))
 $rawoutput .= fgets($ns,128);

 fclose($ns);

 if(ereg($this->whois_avail_strings[$this->whois_servers[$ext]], $rawoutput) == false)
 return 1;

 return 0;
 }
 }
 ?>
