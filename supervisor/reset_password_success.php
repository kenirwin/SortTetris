<?php

/**
 * Reset password success page
 */

// Initialisation
require_once('includes/init.php');

// Set the title, show the page header, then the rest of the HTML
$page_title = 'Reset password';
include('includes/header.php');

?>

<h1>Reset password</h1>

<p>Success! Your password has been reset. You can now <a href="login.php">log in</a>.</p>

<?php include('includes/footer.php'); ?>
