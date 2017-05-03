<!DOCTYPE html>
<html>
<head>
  <title><?php if (isset($page_title)): ?><?php echo $page_title; ?> | <?php endif; ?>Sort Tetris Supervisor</title>
  <meta charset="utf-8" /> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.18.0/css/uikit.gradient.min.css" />
   <link rel="stylesheet" href= <?php print '"'.Config::REDIR_PATH .'/css/styles.css"'; ?> />
</head>
<body>

  <nav role="navigation" class="uk-navbar">
   <a href="../" class="uk-navbar-brand">Sort Tetris</a>

    <div class="uk-navbar-flip">
      <ul class="uk-navbar-nav">
        <?php if (Auth::getInstance()->isLoggedIn()): ?>

          <?php if (Auth::getInstance()->isAdmin()): ?>
	      <li><a href=<?php print '"' .Config::REDIR_PATH .'/users"';?>>Admin</a></li>
          <?php endif; ?>
	      <li><a href=<?php print '"' .Config::REDIR_PATH .'/index.php"'; ?>>Supervisor Panel</a></li>
	      <li><a href=<?php print '"' .Config::REDIR_PATH .'/logout.php"'; ?>>Logout</a></li>

        <?php else: ?>

		<li><a href=<?php print '"' .Config::REDIR_PATH .'/login.php"';?>>Login</a></li>
	  <li><a href="./signup.php">Register</a></li>   
        <?php endif; ?>

      </ul>
    </div>
  </nav>

  <div id="content">
