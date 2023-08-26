<center>
 <form method="post">
 <input type="text" name="ip" size="35">
 <input type="submit" value="Input IP address" value="<?= htmlspecialchars($_REQUEST['ip']); ?>">
 </form>
</center>
<?php
if(!empty($_POST['ip'])) echo whois("whois.arin.net",$_POST['ip']);

function whois($url,$ip)
{
  // Соединение с сокетом TCP, ожидающим на сервере "whois.arin.net" по 
  // 43 порту. В результате возвращается дескриптор соединения $sock.
  $sock = fsockopen($url, 43, $errno, $errstr);
  if (!$sock) exit("$errno($errstr)");
  else
  {
    echo $url."<br>";
    // Записываем строку из переменной $_POST["ip"] в дескриптор сокета.
    fputs ($sock, $ip."\r\n");
    // Осуществляем чтение из дескриптора сокета.
    $text = "";
    while (!feof($sock))
    {
      $text .= fgets ($sock, 128)."<br>";
    }
    // закрываем соединение
    fclose ($sock);

    // Ищем реферальный сервере
    $pattern = "|ReferralServer: whois://([^\n<:]+)|i";
    preg_match($pattern, $text, $out);
    if(!empty($out[1])) return whois($out[1], $ip);
    else return $text;
  }
}
