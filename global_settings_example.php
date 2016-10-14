<?php
/* mysql connection info */
$host = "localhost";
$database = "";
$user = "";
$pass = "";
$charset = "utf8";

$audioOK = false; // set to true to allow music

$require_supervisor_confirmation = true; // false allows supervisors to register on the site without needing a sort-tetris administrator activate the user manually
$system_email_from = ''; //this email address will be used to send recovered passwords


/* Captcha API keys */
$using_captcha = false; //set to true when you add your keys (below)
$captcha_site_key = "";
$captcha_secret_key = ""; 

/* Google Analytics ID */
$google_analytics_id = ''; // usually something like UA-1234567-8
?>