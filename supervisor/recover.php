<html>
<head>
<title>Recover Supervisor Password</title>
<?php include('../global_settings.php'); ?>
<?php include('supervisor_scripts.php'); ?>
<script src='https://www.google.com/recaptcha/api.js'></script>
<style>
@import url("../style.css");
</style>
</head>
<body>
<h1>Sort Tetris - Recover Supervisor Password</h1>

<?php
   if (isset($_REQUEST['submit_button']) && (isset($_REQUEST['g-recaptcha-response']))) {
     if (ConfirmHuman($captcha_secret_key)) {
       RecoverPassword();
     }
     else { DisplayRecoveryForm(); }
   }
   else { 
     DisplayRecoveryForm();
   }

?>

<?php include("../license.php"); ?>
