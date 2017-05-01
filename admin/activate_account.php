<?php

/**
 * Activate new account
 */

// Initialisation
require_once('includes/init.php');


// Activate the account for the user with the token
if (isset($_GET['token'])) {
  User::activateAccount($_GET['token']);
}


// Set the title, show the page header, then the rest of the HTML
$page_title = 'Activate account';
include('includes/header.php');

?>

<h1>Account activated</h1>

<p>Thank you for activating your account! You can now <a href="login.php">login</a>.</p>

<?php include('includes/footer.php'); ?>
