<?php 

/**
 * Validate that the email is available when signing up
 */

// Initialisation
require_once('includes/init.php');

$is_available = false;

// Make sure it's an Ajax request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

  $user = User::findByEmail($_POST['email']);

  $is_available = true;

  if ($user !== NULL) {
    if (isset($_POST['user_id'])) {  // user ID to ignore when editing an existing user
      if ($user->id != $_POST['user_id']) {
        $is_available = false;
      }
    }
    else {
      $is_available = false;  // no user ID sent to ignore (signup)
    }
  }
}

// Return the result, formatted as JSON
echo json_encode($is_available);

?>
