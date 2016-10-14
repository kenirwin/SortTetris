<html>
<head>
<title>Register as a Supervisor</title>
<?php include("../global_settings.php"); ?>
<script src='https://www.google.com/recaptcha/api.js'></script>
<style>
@import url("../style.css");
</style>
</head>
<body>
<h2>Register as a Supervisor</h2>
<?php
   if (isset($_REQUEST['submit_button']) && (isset($_REQUEST['g-recaptcha-response']))) {
     ConfirmHuman($captcha_secret_key);
     SubmitSupervisorRequest($require_supervisor_confirmation);
   }
?>

<form method="post">
   <label for="name">Name</label><input type="text" name="name" /><br />
   <label for="email">Email</label><input type="text" name="email" /><br />
   <label for="inst_name">Institution Name</label><input type="text" name="inst_name" /><br />
   <input type="submit" name="submit_button" value="Register" />
   <div class="g-recaptcha" data-sitekey="<?php print($captcha_site_key); ?>"></div>
<?php include("../license.php"); ?>
</body>
</html>
<?php
   function ConfirmHuman($key) {
	 $url = 'https://www.google.com/recaptcha/api/siteverify';
	 $fields = array(
			 'secret' => $key,
			 'response' => $_REQUEST['g-recaptcha-response']
			 
			 );	 
	 
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
       
function SubmitSupervisorRequest($require_supervisor_confirmation, $db) {
  $path = $_SERVER['REQUEST_SCHEME'] .'://'.$_SERVER['HTTP_HOST']. preg_replace('/\/supervisor\/.*/','/',$_SERVER['REQUEST_URI']);
  $url .= $path.'ajax.php?action=register&inst_name='.urlencode($_REQUEST['inst_name']).'&email='.urlencode($_REQUEST['email']).'&contact_name='.urlencode($_REQUEST['name']);
  //  print $url;
  $response = json_decode(file_get_contents($url));
  if ($response->success == true) {
    print "Registration Successful. More info.";
  }
  else { 
    print ("Registration Failed: ");
    var_dump ($response);
  }
}
?>