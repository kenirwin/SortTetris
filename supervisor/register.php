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
<h1>Register as a Supervisor</h1>
<?php
   if (isset($_REQUEST['submit_button']) && (isset($_REQUEST['g-recaptcha-response']))) {
     ConfirmHuman($captcha_secret_key);
     SubmitSupervisorRequest($require_supervisor_confirmation);
     
     print '<hr />'.PHP_EOL;
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
