<?php


var_dump(extension_loaded('curl'));

function _is_curl_installed() {
    if  (in_array  ('curl', get_loaded_extensions())) {
        return true;
    }
    else {
        return false;
    }
}

// Ouput text to user based on test
if (_is_curl_installed()) {
  echo "cURL is <span style=\"color:blue\">installed</span> on this server";
} else {
  echo "cURL is NOT <span style=\"color:red\">installed</span> on this server";
}

ini_set('display_errors', 1);
error_reporting(E_ALL);
$url = 'https://www.google.com'; 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_TIMEOUT,10);
$output = curl_exec($ch);
print_r($output);
curl_close($ch); 

/*
$params = array(
  'api_key'=>'944a4c9d',
  'api_secret'=>'GVW8g4dvgpqvrY0u',
  'to'=>'919179817828',
  'from'=>'NEXMO',
  'text'=>'Hello from Nexmo'
  
);
echo $postData = http_build_query($params);
$ch = curl_init();
curl_setopt_array($ch, array(    CURLOPT_URL => 'https://rest.nexmo.com/sms/json',    CURLOPT_RETURNTRANSFER => true,    CURLOPT_POST => true,    CURLOPT_POSTFIELDS => $postData));
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$output = curl_exec($ch);
if(curl_errno($ch)){    
echo 'error:' . curl_error($ch);
}
print_r($output);
curl_close($ch);*/
?>
