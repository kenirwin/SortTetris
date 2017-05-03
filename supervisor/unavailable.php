<head>
<title>Admin functions unavailable</title>
<link rel="stylesheet" type="text/css" href="../style.css"/>
</head>

<h1>Admin functions unavailable</h1>
<?php
   if (isset($_REQUEST['reason'])) {
       if ($_REQUEST['reason'] == 'no-config-class') {
	 $message = "Basic database configuration settings must be established before using admin functions.";
       }
       elseif ($_REQUEST['reason'] == 'no-global-settings') {
	 $message = "The global settings must be established before using admin functions.";
       }
       elseif ($_REQUEST['reason'] == 'disallowed') {
	 $message = "Admin functions have been disallowed by the adminstrator.";
       }
       elseif ($_REQUEST['reason'] == 'registration-disallowed') {
	 $message = "Online registration has been disallowed by the adminstrator.";
       }
     }
     if (isset($message)) { print "<p>$message</p>"; }
?>
<p>The game, however, is still playable from the <a href="../">main menu</a>.

<?php include('../license.php'); ?>