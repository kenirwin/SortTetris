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
  include('../global_settings.php');
  $proceed = true;
  if ($using_captcha) {
    include('../captcha.php');
    if (! ConfirmHuman($captcha_secret_key)) {
      $proceed = false;
      $message_sent = false;
    }
  }
  if ($proceed === true) {
    ob_start(); //added to handly mysterious output of SMTP code to the screen
    Auth::getInstance()->sendPasswordReset($_POST['email']);
    ob_end_clean(); //clean the buffer
    $message_sent = true;
  }
}


// Set the title, show the page header, then the rest of the HTML
$page_title = 'Forgotten password';
include('includes/header.php');
include('../global_settings.php');
?>

<h1>Forgotten password</h1>

<?php if (isset($message_sent)): ?>
  <p>If we found an account with that email address, we have sent password reset instructions to it. Please check your email.</p>

<?php else: ?>
     <?php if (isset($proceed) && $proceed === false): ?>
	 <p class="warn">We could not verify your humanity. No email was sent.</p>
     <?php endif ?>

  <form method="post" class="uk-form uk-form-horizontal">
    <div class="uk-form-row">
      <label for="email" class="uk-form-label">Email address</label>
      <div class="uk-form-controls">
        <input id="email" name="email" type="email" required="required" autofocus="autofocus" />
      </div>
    </div>

  <?php
  if ($using_captcha) {
    print '<div class="g-recaptcha" data-sitekey="'.$captcha_site_key.'"></div>';
  }
?>



    <div class="uk-form-row">
      <div class="uk-form-controls">
        <button class="uk-button uk-button-primary">Send password reset instructions</button>
      </div>
    </div>
  </form>
  
<?php endif; ?>

<?php include('includes/footer.php'); ?>
