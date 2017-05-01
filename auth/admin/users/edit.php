<?php

/**
 * User admin - edit a user
 */

// Initialisation
require_once('../../includes/init.php');

// Require the user to be logged in before they can see this page.
Auth::getInstance()->requireLogin();

// Require the user to be an administrator before they can see this page.
Auth::getInstance()->requireAdmin();

// Find the user or show a 404 page.
$user = User::getByIDor404($_GET);


// Process the submitted form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if ($user->save($_POST)) {

    // Redirect to show page
    Util::redirect('/admin/users/show.php?id=' . $user->id);
  }
}


// Show the page header, then the rest of the HTML
include('../../includes/header.php');

?>

<h1>Edit User</h1>

<?php include('form.php'); ?>
    
<?php include('../../includes/footer.php'); ?>
