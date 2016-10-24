<html>
<head>
<title>Recover Supervisor Password</title>
<?php include('../global_settings.php'); ?>
<?php include('../captcha.php'); ?>
<?php include('supervisor_scripts.php'); ?>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script type="text/javascript" src="../lib/jquery.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
<style>
@import url("../style.css");
</style>

<script type="text/javascript">
   $(document).ready(function() {
       $('#recover-form').validate({
	 rules: {
	   email: {
	     required: true,
		 email: true
		 }
	   }
	 });
     });
</script>

</head>
<body>
<h1>Sort Tetris - Recover Supervisor Password</h1>

<?php
if (isset($_REQUEST['submit_button'])) {
  if (! $using_captcha) {
    RecoverPassword();
  }
  else {
    if ($_REQUEST['g-recaptcha-response'] == '') {
      print '<div class="warn">Be sure to check the "I&apos;m not a robot" checkbox</div>'.PHP_EOL;
      print '<hr /><h2>Try Password Recovery Again</h2>'.PHP_EOL;
      DisplayRecoveryForm(); 
    }
    elseif (ConfirmHuman($captcha_secret_key) === true) {
      RecoverPassword();
    }
    else { 
      print '<hr /><h2>Try Password Recovery Again</h2>'.PHP_EOL;
      DisplayRecoveryForm(); 
    }
  }
}    
else { 
  DisplayRecoveryForm();
}

?>

<?php include('../license.php'); ?>
<?php
if (isset($google_analytics_id)) {
  include_once('../google_analytics.php');
}
?>
