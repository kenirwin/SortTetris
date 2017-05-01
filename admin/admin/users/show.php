<?php

/**
 * User admin - show a user
 */

// Initialisation
require_once('../../includes/init.php');

// Require the user to be logged in before they can see this page.
Auth::getInstance()->requireLogin();

// Require the user to be an administrator before they can see this page.
Auth::getInstance()->requireAdmin();

// Find the user or show a 404 page.
$user = User::getByIDor404($_GET);

// Show the page header, then the rest of the HTML
include('../../includes/header.php');

?>

<h1>User</h1>

<p><a href="/admin/users">&laquo; back to list of users</a></p>

<dl class="uk-description-list-horizontal">
  <dt>Name</dt>
  <dd><?php echo htmlspecialchars($user->name); ?></dd>
  <dt>email address</dt>
  <dd><?php echo htmlspecialchars($user->email); ?></dd>
  <dt>Active</dt>
  <dd><?php echo $user->is_active ? '&#10004;' : '&#10008;'; ?></dd>
  <dt>Administrator</dt>
  <dd><?php echo $user->is_admin ? '&#10004;' : '&#10008;'; ?></dd>
</dl>

<a href="/admin/users/edit.php?id=<?php echo $user->id; ?>" class="uk-button uk-button-primary">Edit</a></li>
<?php if ($user->id == Auth::getInstance()->getCurrentUser()->id): ?>
  Delete
<?php else: ?>
  <a href="/admin/users/delete.php?id=<?php echo $user->id; ?>" class="uk-button uk-button-danger">Delete</a>
<?php endif; ?>
    
<?php include('../../includes/footer.php'); ?>
