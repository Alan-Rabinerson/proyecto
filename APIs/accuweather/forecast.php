<?php

$locationKey = '305482'; // Clave de ubicación para Mahón
$apiKey = 'zpka_463a1bcd9972461385e29c4e2090f7d4_3bd1c314';
$ch = curl_init();
$data = array( 'Authorization' => "Bearer $apiKey" );
$payload = json_encode($data);

curl_setopt($ch, CURLOPT_URL, "https://dataservice.accuweather.com/forecasts/v1/daily/5day/$locationKey/?apikey=$apiKey");
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

$result = curl_exec($ch);
curl_close($ch);
echo $result;
