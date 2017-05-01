<?php

/**
 * User admin index - list all users
 */

// Initialisation
require_once('../../includes/init.php');


// Require the user to be logged in before they can see this page.
Auth::getInstance()->requireLogin();

// Require the user to be an administrator before they can see this page.
Auth::getInstance()->requireAdmin();


// Get the paginated data
$data = User::paginate(isset($_GET['page']) ? $_GET['page'] : 1);


// Show the page header, then the rest of the HTML
include('../../includes/header.php');

?>

<h1>Users</h1>

<p><a href="/admin/users/new.php" class="uk-button uk-button-primary">Add a new user</a></p>

<table class="uk-table uk-table-hover uk-table-striped">
  <thead>
    <tr>
      <th>Name</th>
      <th>email</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($data['users'] as $user): ?>
      <tr>
        <td><a href="/admin/users/show.php?id=<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['name']); ?></a></td>
        <td><?php echo htmlspecialchars($user['email']); ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>


<ul class="uk-pagination">
  <li class="uk-pagination-previous">
    <?php if ($data['previous'] === null): ?>
      Previous
    <?php else: ?>
      <a href="/admin/users/?page=<?php echo $data['previous']; ?>">Previous</a>
    <?php endif; ?>
  </li>
  <li class="uk-pagination-next">
    <?php if ($data['next'] === null): ?>
      Next
    <?php else: ?>
      <a href="/admin/users/?page=<?php echo $data['next']; ?>">Next</a>
    <?php endif; ?>
  </li>
</ul>

    
<?php include('../../includes/footer.php'); ?>
