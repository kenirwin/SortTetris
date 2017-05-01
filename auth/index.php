<?php

/**
 * Homepage
 */

// Initialisation
require_once('includes/init.php');

// Show the page header, then the rest of the HTML
include('includes/header.php');

?>

<h1>Home</h1>

<?php if (Auth::getInstance()->isLoggedIn()): ?>

  <p>Hello <?php echo htmlspecialchars(Auth::getInstance()->getCurrentUser()->name); ?>.

<?php else: ?>

  <p><a href="signup.php">Sign up</a> or <a href="login.php">Log in</a></p>

<?php endif; ?>

<?php include('includes/footer.php'); ?>
