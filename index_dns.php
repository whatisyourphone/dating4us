<?php
 include_once "whois.php";
 $whois=new Whois;
 ?>
 <form action="test_whois.php" method="POST">
 <input type=text name=domain>.<select name=ext>
 <?
 foreach ($whois->whois_exts as $exts) {
 echo "<option>$exts</option>";
 }
 ?>
 </select>
  <input type=submit value=GO>
 </form>
 <?
$domain=$_POST["domain"];
$ext=$_POST["ext"];
 if(isset($domain) and isset($ext)) {
 $rc=$whois->perform_whois($domain,$ext,true);
 if ($rc==-1) {
 echo $whois->errormsg;
 } else {
 echo "<pre>$rc</pre>";
 }
 }
 ?>
