<?php
/* mysql connection info */
$host = "localhost";
$database = "";
$user = "";
$pass = "";
$charset = "utf8";

$audioOK = false; // set to true to allow music

$display_institution_select = false; // set to true to allow users to select their inst manually
$display_supervisor_reg_links = true; //only effective if next setting==true
$allow_supervisor_registration = false; 
$require_supervisor_confirmation = true; // false allows supervisors to register on the site without needing a sort-tetris administrator activate the user manually
$system_email_from = ''; //this email address will be used to send recovered passwords


/* Captcha API keys */
$using_captcha = false; //set to true when you add your keys (below)
$captcha_site_key = "";
$captcha_secret_key = ""; 

/* Google Analytics ID */
$google_analytics_id = ''; // usually something like UA-1234567-8
?>