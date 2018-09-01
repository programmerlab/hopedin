<?php
/*$params = array(
  'api_key'=>'944a4c9d',
  'api_secret'=>'GVW8g4dvgpqvrY0u',
  'to'=>'8615579830172',
  'from'=>'NEXMO',
  'text'=>'Hello from Nexmo'
  
);*/
$postData = http_build_query($params);
$ch = curl_init();
curl_setopt_array($ch, array(    CURLOPT_URL => 'https://rest.nexmo.com/sms/json',    CURLOPT_RETURNTRANSFER => true,    CURLOPT_POST => true,    CURLOPT_POSTFIELDS => $postData));
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$output = curl_exec($ch);
if(curl_errno($ch)){    
echo 'error:' . curl_error($ch);
}
print_r($output);
curl_close($ch);
?>
