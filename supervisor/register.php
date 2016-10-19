<html>
<head>
<title>Register as a Supervisor</title>
<?php include('../global_settings.php'); ?>
<?php include('supervisor_scripts.php'); ?>
<script src='https://www.google.com/recaptcha/api.js'></script>
<style>
@import url("../style.css");
</style>
</head>
<body>
<h1>Sort Tetris - Register as a Supervisor</h1>

<?php
   if (isset($_REQUEST['submit_button']) && (isset($_REQUEST['g-recaptcha-response']))) {
     ConfirmHuman($captcha_secret_key);
     SubmitSupervisorRequest($require_supervisor_confirmation);
     
     print '<hr />'.PHP_EOL;
     PrintRegForm();
   }
?>
<?
if ($allow_supervisor_registration) {
  PrintRegForm();
}
else { 
  print 'Registration is not enabled for this site. The administrator will need to set <b>$allow_supervisor_registration = true</b> in <b>global_settings.php</b> to allow this function.';
}
?>
<?

?>
<?php include("../license.php"); ?>
</body>
</html>
