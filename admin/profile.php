<?php

/**
 * Profile
 */

// Initialisation
require_once('includes/init.php');

// Require the user to be logged in before they can see this page.
Auth::getInstance()->requireLogin();

// Set the title, show the page header, then the rest of the HTML
$page_title = 'Profile';
include('includes/header.php');

?>

<h1>Profile</h1>

  <?php $user = Auth::getInstance()->getCurrentUser(); ?>

  <dl class="uk-description-list-horizontal">
    <dt>Name</dt>
    <dd><?php echo htmlspecialchars($user->name); ?></dd>
    <dt>Email address</dt>
    <dd><?php echo htmlspecialchars($user->email); ?></dd>
  </dl>
    
<?php include('includes/footer.php'); ?>
