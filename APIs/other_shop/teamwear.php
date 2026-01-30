<?php
$apiKey = '12345alan';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://remotehost.es/student014/shop/backend/endpoints/product_seller.php?apikey=$apiKey");
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

$result = curl_exec($ch);
curl_close($ch);
echo $result;
?>
