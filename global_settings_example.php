<?php
/* mysql connection info */
$host = "localhost";
$database = "";
$db_user = "";
$db_pass = "";
$charset = "utf8";

$audioOK = false; // set to true to allow music

$display_institution_select = false; // set to true to allow users to select their inst manually
$display_supervisor_reg_links = true; //only effective if next setting==true
$allow_supervisor_registration = false; 
$allow_admin = false; //set to true once database has been set up in this file and in supervisor/classes/Config.class.php, only if you wish to allow supervisor logins
$contact_email = ''; //email to which contact form submissions will be sent

/* Captcha API keys */
$using_captcha = false; //set to true when you add your keys (below)
$captcha_site_key = "";
$captcha_secret_key = ""; 

/* Google Analytics ID */
$google_analytics_id = ''; // usually something like UA-1234567-8
?>