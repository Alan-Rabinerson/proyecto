<?php
$locationKey = '305482'; // Clave de ubicación para Mahón
$apiKey = 'zpka_9f0db2f848fb41b49876f21bf448b754_62f8e394';
$ch = curl_init();
$data = array( 'Authorization' => "Bearer $apiKey" );
$payload = json_encode($data);


curl_setopt($ch, CURLOPT_URL, "https://dataservice.accuweather.com/currentconditions/v1/$locationKey/?apikey=$apiKey");
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

$result = curl_exec($ch);
curl_close($ch);
echo $result;
