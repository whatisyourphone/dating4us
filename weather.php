<!DOCTYPE HTML>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
//https://samples.openweathermap.org/data/2.5/weather?q=London,uk&appid=84adeff7c864cc9d4862def4c01390c6
//84adeff7c864cc9d4862def4c01390c6
$url = 'http://api.openweathermap.org/data/2.5/weather';
$options = array(
  'id' => 703448,
  'APPID' => '84adeff7c864cc9d4862def4c01390c6',
  'units' => 'metric',
  'lang' => 'en',
  );
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($ch, CURLOPT_URL, $url.'?'.http_build_query($options));

 $response = curl_exec($ch);
 $data = json_decode ($response, true);
 curl_close($ch);
 echo '<pre>';
 //print_r($data);

date_default_timezone_set('Europe/Kiev');

echo('Date:'.date("d.m.y"));
echo'<br>';
echo('город:'.$data['name']);
echo'<br>';


$data1=$data['name'];
$data1.=';';
$data1.=date("d.m.y");
$data1.=';';
$data1.=date("H.i");

 foreach ($data['main'] as $key=>$value) {
  echo "$key:" . $value . "<br>";
$data1.=';';
$data1.=$value;
//print_r($value);
};

//print($data1);

 $dirname1=dirname(__FILE__);
 $sf ="$dirname1/weather.dat";
 $fpsf=fopen($sf,"a+");
 fputs($fpsf,"$data1\n");
 fclose($fpsf);
//}


?>
