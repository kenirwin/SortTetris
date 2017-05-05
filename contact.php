<html>
<head
><title>Sort Tetris - Contact Form</title>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script type="text/javascript" src="./lib/jquery.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
<style>
@import url("./style.css");
</style>
<script type="text/javascript">
   $(document).ready(function() {
       $('#contact-form').validate({
	 rules: {
	   from_name: {
	     required: true
		 },
	       from_email: {
	     required: true,
		 email: true
		 },
	       confirm_email: {
	     required: true,
		 email: true,
		 equalTo: '#from-email'
	     },
	       subject: {
	     required: true
	     },
	       message: {
	     required: true
	     },
	   }
	 });
     });
</script>
</head>
<body>
<h1>Sort Tetris - Contact Form</h1>
<?php
include('global_settings.php');
include('captcha.php');

if (isset($_REQUEST['submit_contact'])) {
  if ($using_captcha) {
    if (ConfirmHuman($captcha_secret_key)) {
      SendMail();
    }
    else {
      print 'Could not confirm that you&apos;re human. Try again.'.PHP_EOL;
      PrintContactForm();
    }
  }
  else {
    SendMail();
  }
}

else { 
  if (isset($contact_email)) {
    PrintContactForm();
  }
  else { 
    print '<div>No contact email set up. To activate this feature, the site administrator must define a <b>$contact_email</b> in the <b>global_settings.php</b> file.</div>';
  }
}
?>
</body>
</html>
<?php

function SendMail() {
  global $contact_email;
  $to = $contact_email;
  $subject = $_REQUEST['subject'];
  $content = $_REQUEST['message'];
  $headers = 'From: '.$REQUEST['from_name'] .'<'. $_REQUEST['from_email'].'>';
  if (mail($to,$subject,$content,$headers)) {
    print "<div>Mail sent. We will be in touch with you as soon as possible.</div>";
  }
  else { 
    print '<div class="warn">Unable to send mail.</div>'.PHP_EOL;
  }
  }
function PrintContactForm() {
  global $captcha_site_key, $using_captcha;
  print '<form id="contact-form" method="post">';
  print '<label for="from_name">Your Name</label>'.PHP_EOL;
  print '<input type="text" name="from_name" value="'.SubmittedValue('from_name').'"><br />'.PHP_EOL;  
  print '<label for="from_email">Your Email</label>'.PHP_EOL;
  print '<input type="text" name="from_email" id="from-email" value="'.SubmittedValue('from_email').'"><br />'.PHP_EOL;
  print '<label for="confirm_email">Confirm Your Email</label>'.PHP_EOL;
  print '<input type="text" name="confirm_email" value="'.SubmittedValue('confirm_email').'"><br />'.PHP_EOL;
  print '<label for="subject">Subject</label>'.PHP_EOL;
  print '<input type="text" name="subject" value="'.SubmittedValue('subject').'"><br />'.PHP_EOL;
  print '<label for="message">Message</label><br />'.PHP_EOL;
  print '<textarea name="message" cols="80" rows="10">'.SubmittedValue('message').'</textarea><br />'.PHP_EOL;
  if ($using_captcha) {
    print '<div class="g-recaptcha" data-sitekey="'.$captcha_site_key.'"></div>';
  }
  print '<input type="submit" name="submit_contact"/>'.PHP_EOL;
  print '</form>'.PHP_EOL;
}

print '<div><a href="./">Return to the game</a></div>'.PHP_EOL;
include('license.php');

function SubmittedValue($field) {
  if (isset($_REQUEST[$field]) && !empty($_REQUEST[$field])) { 
    return $_REQUEST[$field];
  }
  else {
    return "";
  }
}
?>