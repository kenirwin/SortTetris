<?php

/**
 * Forgotten password form
 */

// Initialisation
require_once('includes/init.php');

// Require the user to NOT be logged in before they can see this page.
Auth::getInstance()->requireGuest();

// Process the submitted form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  ob_start(); //added to handly mysterious output of SMTP code to the screen
  Auth::getInstance()->sendPasswordReset($_POST['email']);
  ob_end_clean(); //clean the buffer
  $message_sent = true;
}


// Set the title, show the page header, then the rest of the HTML
$page_title = 'Forgotten password';
include('includes/header.php');

?>

<h1>Forgotten password</h1>

<?php if (isset($message_sent)): ?>
  <p>If we found an account with that email address, we have sent password reset instructions to it. Please check your email.</p>

<?php else: ?>

  <form method="post" class="uk-form uk-form-horizontal">
    <div class="uk-form-row">
      <label for="email" class="uk-form-label">Email address</label>
      <div class="uk-form-controls">
        <input id="email" name="email" type="email" required="required" autofocus="autofocus" />
      </div>
    </div>

    <div class="uk-form-row">
      <div class="uk-form-controls">
        <button class="uk-button uk-button-primary">Send password reset instructions</button>
      </div>
    </div>
  </form>
  
<?php endif; ?>

<?php include('includes/footer.php'); ?>
