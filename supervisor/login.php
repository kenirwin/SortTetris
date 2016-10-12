<?php
session_start();
$_SESSION = array();

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

<form method="post">
 <label for="email">Email:</label>
 <input type="text" name="email" /><br />
   <label for="password">Password:</label>
   <input type="password" name="password" /><br />
   <input type="submit" value="Log in" />
</form>

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