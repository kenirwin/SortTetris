<?php

/**
 * Sign up a new user
 */

// Initialisation
require_once('includes/init.php');

// Require the user to NOT be logged in before they can see this page.
Auth::getInstance()->requireGuest();

// Process the submitted form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $user = User::signup($_POST);

  if (empty($user->errors)) {

    // Redirect to signup success page
    print "redirecting";
    Util::redirect('/signup_success.php');
  }
}


// Set the title, show the page header, then the rest of the HTML
$page_title = 'Sign Up';
include('includes/header.php');

?>

<h1>Sign Up</h1>

<?php if (isset($user)): ?>
  <ul>
    <?php foreach ($user->errors as $error): ?>
      <li><?php echo $error; ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<form method="post" id="signupForm" class="uk-form uk-form-horizontal">
  <div class="uk-form-row">
    <label for="name" class="uk-form-label">Name</label>
    <div class="uk-form-controls">
      <input id="name" name="name" required="required" value="<?php echo isset($user) ? htmlspecialchars($user->name) : ''; ?>" autofocus="autofocus" />
    </div>
  </div>

  <div class="uk-form-row">
    <label for="email" class="uk-form-label">Email address</label>
    <div class="uk-form-controls">
      <input id="email" name="email" required="required" type="email" value="<?php echo isset($user) ? htmlspecialchars($user->email) : ''; ?>" />
    </div>
  </div>

  <div class="uk-form-row">
    <label for="password" class="uk-form-label">Password</label>
    <div class="uk-form-controls">
      <input type="password" id="password" name="password" required="required" pattern=".{5,}" title="minimum 5 characters" />
    </div>
  </div>

  <div class="uk-form-row">
    <div class="uk-form-controls">
      <button class="uk-button uk-button-primary">Sign Up</button>
    </div>
  </div>
</form>

<?php include('includes/footer.php'); ?>
