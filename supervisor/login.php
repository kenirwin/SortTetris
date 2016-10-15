<?php
session_start();
$_SESSION = array();
?>
<html>
<head>
<style>
@import url("../style.css");
</style>
</head>
<body>
<?php
if (isset($_POST['password']) && isset($_POST['email'])) {
  $id = VerifyLogin($_POST['password'], $_POST['email']);
  if ($id > 0) {
    header('Location: index.php');
  }
  else { 
    print '<div class="notice">Unable to authenticate</div>'.PHP_EOL;
  }
}
?>
<h1>Sort Tetris - Supervisor Login</h1>
<div id="description">
  When you <a href="register.php">register</a> as a supervisor, you will get access to the scores of all players who play Sort Tetris after identifying themselves as a member of your instution/office/class/etc. Be sure your students/employees are identifying themselves to get credit for their practice. 
</div>

<div id="nav"><a href="../" class="button-small">Play</a> <a href="register.php" class="button-small">Register as a Supervisor</a></div>
<form method="post">
 <label for="email">Email:</label>
 <input type="text" name="email" /><br />
   <label for="password">Password:</label>
   <input type="password" name="password" /><br />
   <input type="submit" value="Log in" />
</form>

<?php include("../license.php"); ?>
</body>
</html>
<?php
  function VerifyLogin($pass,$email) {
      if(preg_match("/(.*\/)/",$_SERVER['REQUEST_URI'],$m)) {
	$curr_dir = $m[1];
      }
      $path = $_SERVER['REQUEST_SCHEME'] .'://'.$_SERVER['HTTP_HOST']. $curr_dir;
      $ajax_url = $path.'../ajax.php?action=authenticate&user='.$email.'&pass='.$pass;
      $json = file_get_contents($ajax_url);
      $response = json_decode($json);
      if (isset($response->institution_id)) {
	$_SESSION['institution_id'] = $response->institution_id;
	$_SESSION['institution_name'] = $response->institution_name;
	return($response->institution_id);
      }
      else { return(0); }
    }
?>