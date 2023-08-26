<?php

 class Whois {

 var $errormsg = "";


 // ������ ������� �������������� ��������
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
 // ������ `whois' ��������
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
 // ������ ����� ����������� whois ���� ����� ����������
 var $whois_avail_strings = array(
 "info.whois-servers.net" =>"NOT FOUND",
 "biz.whois-servers.net" =>"Not found",
 "whois.internic.net" =>"No match",
 "whois.nic.uk" => "No match",
 "whois.bulkregister.com" => "Not found",
 );

 // �������� ������ �� ������������, ���������� false ���� ������ ��� true ���� ��� �����
 function check_domain($domain,$ext)
 {

 if(isset($ext)){
 if(!strlen($ext)){
 $this->errormsg = "�� ����� ����� ������� ������";
 return 0;
 }
 if(!$this->my_in_array($ext,$this->whois_exts)){
 $this->errormsg = "������ ����� ������� ������ �� �������������� ��������";
 return 0;
 }
 }
 if(isset($domain)){
 if(strlen($domain) < 2 || strlen($domain) > 57){
 $this->errormsg = "����� c������ ������� ��� ��������";
 return 0;
 }
 if(strlen($domain) == 2 && !ereg("([0-9]){2}",$domain)){
 $this->errormsg = "��� ������ ������ ��������� ������ ����� � ����� ��� ��� �����, ���� ��� ������� �� ���� ������";
 return 0;
 }
 if(ereg("^-|-$",$domain)){
 $this->errormsg = "��� ������ �� ����� ��������� ��� ������������� �� ����� � �� ����� ��������� ��� ������ ������ ������";
 return 0;
 }
 if(!ereg("([a-z]|[A-Z]|[0-9]|-){".strlen($domain)."}",$domain)){
 $this->errormsg = "��� ������ ����� �������� ������ �� ����, ���� � ������";
 return 0;
 }
 } 

 return 1;
 }
 // �������� ������� �������� � �������
 function my_in_array($val,$array_)
 {
 for($l=0; $l<sizeof($array_); $l++)
 if($array_[$l] == $val)
 return 1;

 return 0;
 }
 // �������� ����� ����� � ������� ����� �������
 // ���� ��������� -1 �� ������
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
 // ���� ����� � whois, ���������� 1 ���� ������ � 0 ���� �� ������, ���� -1 �� ������ ���������� 
 // ���� $raw = true, �� ���������� ����� whois
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
 $this->errormsg = "SOA ������� ��� ������ $domainname.$ext �� �������";
 return -1;
 }
 }
 if(!$this->check_domain($domainname,$ext)) return -1;

 $rawoutput = "";

 if($raw)
 return $this->do_raw($domainname,$ext);

 if(($ns = fsockopen($this->whois_servers[$ext],43)) == false){
 $this->errormsg = "�� ���� ���������� � <b><i>".$this->whois_servers[$ext]."</i></b>";
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
