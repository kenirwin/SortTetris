<html>
<head>
<title>Sort Tetris Installation</title>
<style>
@import url("../style.css");
</style>
</head>


<body>
<h1>Sort Tetris - Installation</h1>

<?
$db = MysqlConnect();

if (!isset($_REQUEST['install']) || ! $_REQUEST['install']) {
  print '<h2>Preflight Checklist</h2>'.PHP_EOL;
  print '<ol>'.PHP_EOL;
  print '<li>Create a MySQL database for the game&apos;s tables</li>'.PHP_EOL;
  print '<li>Create a MySQL user that has <code>ALTER, CREATE, DELETE, INSERT, SELECT, UPDATE</code> permissions on the database</li>'.PHP_EOL;

  print '<li>In the main directory, copy <code>global_settings_example.php</code> to <code>global_settings.php</code></li>'.PHP_EOL;
  print '<li>Configure the MySQL <code>$host</code>, <code>$database</code>, <code>$db_user</code>, and <code>$db_pass</code> variables in global_settings.php to connect to the database and user you established</li>'.PHP_EOL;
  print '<li>In the supervisor/classes/ directory, copy Config_Sample.class.php to Config.class.php</li></li>'.PHP_EOL;
  print '<li>Configure the MySQL & SMTP variables in supervisor/classes/Config.class.php</li>'.PHP_EOL;
  print '</ol>'.PHP_EOL;
  print '<b>Once you have set up the database and global_settings.php file, click the "Install" button to set up the database tables.</b>'.PHP_EOL;

  if ($db) {
    print '<div><form method="post"><input type="submit" class="button" value="Install" name="install"></div>';
  }
  else {
    print '<div><input type="button" class="button inactive" value="Reload page once database connection is set up in global_settings.php" /></div>';
  }
}

else {
  
  $mode_query = 'SET SESSION sql_mode = "NO_AUTO_VALUE_ON_ZERO"';
  
$leaderboard_create = "CREATE TABLE `leaderboard` (
  `game_id` int(11) NOT NULL,
  `time_entry` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `score` int(11) NOT NULL,
  `percent` tinyint(4) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `config_file` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `inst_id` int(11) NOT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

$remember_create = "CREATE TABLE `remembered_logins` (
  `token` varchar(40) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expires_at` datetime NOT NULL
) DEFAULT CHARSET=utf8;";

$users_create = "CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `institution_name` varchar(50) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(60) NOT NULL,
  `password_reset_token` varchar(40) DEFAULT NULL,
  `password_reset_expires_at` datetime DEFAULT NULL,
  `activation_token` varchar(40) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0'
) DEFAULT CHARSET=utf8;";

$leaderboard_keys = "ALTER TABLE `leaderboard`
  ADD PRIMARY KEY (`game_id`);";

$remember_keys = "ALTER TABLE `remembered_logins`
  ADD PRIMARY KEY (`token`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `expires_at` (`expires_at`);";

$user_keys = "ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `institution_name` (`institution_name`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`),
  ADD UNIQUE KEY `activation_token` (`activation_token`),
  ADD KEY `name` (`name`);";

$leaderboard_alter = "ALTER TABLE `leaderboard`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT;";

$users_alter = "ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";

$remember_constraint = "ALTER TABLE `remembered_logins`
  ADD CONSTRAINT `remembered_logins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;";

$failed = false; 

$queries = array ('mode_query' => 'Set SQL Mode',
		  'leaderboard_create' => 'Create the Leaderboard Table',
		  'remember_create' => 'Create Remembered Logins Table',
		  'users_create' => 'Create Users Table',
		  'leaderboard_keys' => 'Establish Leaderboard Keys',
		  'remember_keys' => 'Establish Rememebered Logins Table Keys',
		  'user_keys' => 'Establish User Table Keys',
		  'leaderboard_alter' => 'Alter Leaderboard',
		  'users_alter' => 'Alter Users Table',
		  'remember_constraint' => 'Constrain Remembered Logins Table'
		  );

foreach ($queries as $query => $desc) {
  try {
    $stmt = $db->prepare($$query);
    if ($stmt->execute()) {
      print '<li>'.$desc.'</li>';
    }
    else {
      print '<li class="warn">Unable to '.$desc.'</li>';
    }
  }
  catch (PDOException $e) {
    print '<li class="warn">Unable to '.$desc.': '. $e->getMessage().'</li>'.PHP_EOL;
    $failed = true;
  }
}

if ($failed === true) {
  print 'Some aspects of the installation process failed. You may need to create the SQL tables manually using the `tables.sql` file in the main directory.';
}

else {
  print '<h2>Installation successful!</h2> <a href="../">Play the game</a>'.PHP_EOL;
}
}
  


function MysqlConnect() { 
    include ("../global_settings.php"); 
    foreach (['host', 'database','charset','db_user','db_pass'] as $f) {
        if (!isset($$f)) { 
            $return = ['message','MySQL Connect Error: variable $'.$f.' not set in global_settings.php'];
            print(json_encode($return));
        }
    }
    
    try {
        $db = new PDO("mysql:host=$host;dbname=$database;charset=$charset", "$db_user", "$db_pass");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }
    catch (PDOException $e) {
      //        $return = [ 'message'=> 'MySQL error: '.$e->getMessage() ];
        print ('<li class="warn">MySQL connection not yet established</li>'.PHP_EOL);
    }
}


?>