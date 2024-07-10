<!-- api_integration.php -->
<?php
$api_url = "http://api.weatherstack.com/current?access_key=21905c30f7909d26e1c5f9d535320b6c&query=Pondicherry";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

echo "Current temperature in Puducherry: " . $data['current']['temperature'] . "°C";
?>
