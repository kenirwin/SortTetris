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

if (! $_REQUEST['install']) {
  print '<h2>Preflight Checklist</h2>'.PHP_EOL;
  print '<ol>'.PHP_EOL;
  print '<li>Create a MySQL database for the game&apos;s tables</li>'.PHP_EOL;
  print '<li>Create a MySQL user that has <code>ALTER, CREATE, DELETE, INSERT, SELECT, UPDATE</code> permissions on the database</li>'.PHP_EOL;

  print '<li>in the main directory, copy <code>global_settings_example.php</code> to <code>global_settings.php</code></li>'.PHP_EOL;
  print '<li>Configure the MySQL <code>$host</code>, <code>$database</code>, <code>$user</code>, and <code>$pass</code> variables in global_settings.php to connect to the database and user you established</li>'.PHP_EOL;
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
  
  $inst_query = "CREATE TABLE IF NOT EXISTS `institutions` (
  `institution_id` int(11) NOT NULL AUTO_INCREMENT,
  `institution_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `contact_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `contact_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `activated` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`institution_id`),
  UNIQUE KEY `contact_email` (`contact_email`),
  UNIQUE KEY `institution_name` (`institution_name`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";

$leaderboard_query = "CREATE TABLE IF NOT EXISTS `leaderboard` (
  `game_id` int(11) NOT NULL AUTO_INCREMENT,
  `time_entry` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `score` int(11) NOT NULL,
  `percent` tinyint(4) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `config_file` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `inst_id` int(11) NOT NULL,
  PRIMARY KEY (`game_id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";



$failed = false; 
try {
  $stmt = $db->prepare($mode_query);
  if ($stmt->execute()) {
    print '<li>Set SQL mode</li>';
  }
  else { 
    print '<li class="warn">Unable to set SQL mode</li>';
  }
}
catch (PDOException $e) {
  print '<li class="warn">Unable to set SQL mode: '. $e->getMessage().'</li>'.PHP_EOL;
}



try {
  $stmt = $db->prepare($inst_query);
  if ($stmt->execute()) {
    print '<li>Created table `institutions`</li>';
  }
  else { 
    print '<li class="warn">Unable to create table `institutions`</li>';
    $failed = true;
  }
}

catch (PDOException $e) {
  print '<li class="warn">Unable to create table `institutions`: '. $e->getMessage().'</li>'.PHP_EOL;
  $failed = true;
}

try {
  $stmt = $db->prepare($leaderboard_query);
  if ($stmt->execute()) {
    print '<li>Created table `leaderboard`';
  }
  else { 
    print '<li><li class="warn">Unable to create table `leaderboard`</li>'.PHP_EOL;
  $failed = true;
  }
}
catch (PDOException $e) {
  print '<li><li class="warn">Unable to create table `leaderboard`: '.$e->getMessage().'</li>'.PHP_EOL;
  $failed = true;
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
    foreach (['host', 'database','charset','user','pass'] as $f) {
        if (!isset($$f)) { 
            $return = ['message','MySQL Connect Error: variable $'.$f.' not set in global_settings.php'];
            print(json_encode($return));
        }
    }
    
    try {
        $db = new PDO("mysql:host=$host;dbname=$database;charset=$charset", "$user", "$pass");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }
    catch (PDOException $e) {
      //        $return = [ 'message'=> 'MySQL error: '.$e->getMessage() ];
        print ('<li class="warn">MySQL connection not yet established</li>'.PHP_EOL);
    }
}


?>