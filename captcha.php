<?php
function ConfirmHuman($key) {
  $url = 'https://www.google.com/recaptcha/api/siteverify';
  $fields = array(
		  'secret' => $key,
		  'response' => $_REQUEST['g-recaptcha-response']
		  
		  );	 
  $fields_string = '';
  foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
  rtrim($fields_string, '&');
  
  //open connection
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
  $result = json_decode($json);
  if ($result->success == true) {
    return true;
  }
  else {
    print '<h3>Unable to process your request</h3>'.PHP_EOL;
    foreach ($result->{'error-codes'} as $error) {
      if ($error == 'missing-input-response') {
	print '<li class="warn">Be sure to check the "I&apos;m not a robot" box below</li>'.PHP_EOL;
      }
      else { print '<li class="warn">'.$error.'</li>'.PHP_EOL; }
    }
  }
  }

?>