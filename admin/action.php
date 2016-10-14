<?php
$path = $_SERVER['REQUEST_SCHEME'] .'://'.$_SERVER['HTTP_HOST']. preg_replace('/\/admin\/.*/','/',$_SERVER['REQUEST_URI']);
$url = $path .'ajax.php';
$fields_string = $_SERVER['QUERY_STRING'];
$fields = split('&',$fields_string);
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

//execute post
$json = curl_exec($ch);

//close connection
curl_close($ch);
print($json);
?>