<?php
$apiKey = '3c25f95c-e89f-4a9c-b61f-61c8cd435bc9';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://remotehost.es/student012/shop/backend/endpoints/seller_products.php?apikey=" . $apiKey);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
$result = curl_exec($ch);
curl_close($ch);
echo $result;
?>
