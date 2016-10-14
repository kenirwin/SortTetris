<?php
header("Content-type: application/json");
include ("global_settings.php"); 

$request = (object) $_REQUEST;

if ($_SERVER['REMOTE_ADDR'] == $_SERVER['SERVER_ADDR']) {
  $local_request=true;
}
else {
  $local_request=false;
}

try {
  if ($request->action == "list-institutions") {
    print((ListInstitutions()));
  }

  elseif ($request->action == "list-games") {
    print(json_encode(ListPublicGames()));
  }

  elseif ($request->action == "authenticate") {
    if ($local_request) { 
      print(json_encode(Authenticate($request))); 
    }
    else { print "only local requests"; }
  }

  elseif ($request->action == "register") {
    print(json_encode(RegisterSupervisor($request, $require_supervisor_confirmation)));
  }

  elseif ($request->action == 'recoverPassword') {
    print(json_encode(RecoverPassword($request, $system_email_from)));
  }

  elseif ($request->action == "list-all-games") {
      if ($local_request) { print(json_encode(ListGames(true))); }
      else { print "only local requests"; }
  }
  
  elseif ($request->action == "admin-list-supervisors") {
    if ($local_request) { 
	print(json_encode(AdminListSupervisors())); 
    }
    else { print "local requests only"; }
  }
  elseif ($request->action == "admin-activate-supervisor") {
    //    if ($local_request) { 
      print(json_encode(AdminUpdateSupervisor($request->action, $request->inst_id))); 
      //}
  //else { print "local requests only"; }
  }
  elseif ($request->action == "admin-deactivate-supervisor") {
    //if ($local_request) { 
      print(json_encode(AdminUpdateSupervisor($request->action, $request->inst_id))); 
      //}
    //else { print(json_encode(array('success'=>false,'error'=>'local requests only'))); }
  }
  elseif ($request->action == "admin-delete-supervisor") {
    if ($local_request) { 
      print(json_encode(AdminDeleteSupervisor($request->inst_id))); 
    }
    else { print "local requests only"; }
  }


    elseif ($request->action == "submit") {
    $db = MysqlConnect();
    if (! isset($request->inst_id)) { $request->inst_id = -1; }
    $required_fields = array ('username','score','percent','level','config_file','inst_id');
    $check = CheckRequiredFields($request,$required_fields);
    if ($check === true) {
        $prepped = PrepareInsert($required_fields, $request, "leaderboard"); 
        $stmt = $db->prepare($prepped->prep);
        $stmt->execute($prepped->exec);
        if ($db->lastInsertId()) {
            $response = array("result" => "success");
            $response = json_encode((object) $response);
            print $response;
        }
    }
    else {
        throw new Exception ($check);
    }
}

elseif ($request->action == ("supervisor"||"leaderboard")) {
    $required_fields = array ('config_file');
    $check = CheckRequiredFields($request,$required_fields);
    $db = MysqlConnect();
    if ($check === true) {
      print(HighScores($request->config_file, $db, $request->inst_id, $request->action)); 
    }
    else {
        throw new Exception ($check);
    }
}

}

catch (Exception $e) {
    print $e;
}

function Authenticate($req) {
    $db = MysqlConnect();  
    $stmt = $db->prepare('SELECT institution_id,institution_name FROM institutions WHERE contact_email = ? AND password = ?');
    $stmt->execute(array($req->user,$req->pass));
    if ($stmt->rowCount() == 0) {
      return(array("error" => "Invalid username or password"));
    }
    else {
      return($stmt->fetch(PDO::FETCH_ASSOC));
    }
}


function ListPublicGames() {
    $public_games = array();
    $files = glob('settings/settings_*.php');
    ob_start(); //capture irrelevant output;
    foreach ($files as $f) {
        $public_game = false;
        include($f);
        if ($public_game) {
            if (preg_match('/settings_(.+).php/', $f, $m)) {
                array_push($public_games, 
                           array(
                               'url'=>$m[1],
                               'title'=>$game_title,
                           ));
            }
        }
    }
    ob_end_clean();
    return $public_games;
}

function ListGames($include_private=false) {
    $games = array();
    $files = glob('settings/settings_*.php');
    ob_start(); //capture irrelevant output;
    foreach ($files as $f) {
        $public_game = false;
        include($f);
        if (($public_game) || ($include_private == true)) {
            if (preg_match('/settings_(.+).php/', $f, $m)) {
                array_push($games, 
                           array(
                               'url'=>$m[1],
                               'title'=>$game_title,
                           ));
            }
        }
    }
    ob_end_clean();
    return $games;
}

function ListInstitutions() {
  $db = MysqlConnect();
  $query = 'SELECT `institution_id`, `institution_name` FROM institutions WHERE activated="Y"';
  $stmt = $db->query($query);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return (json_encode($results));
}

function HighScores ($config,$db,$inst_id=0,$format='leaderboard') {
  if (is_object($db)) {
    if ($format=='leaderboard') {
      $query = 'SELECT username,score FROM leaderboard WHERE config_file=? AND inst_id=? ORDER BY score DESC LIMIT 0,10';
    }
    elseif ($format=='supervisor') {
      $query = 'SELECT * FROM leaderboard WHERE config_file=? AND inst_id=? ORDER BY time_entry DESC LIMIT 0,1000';
    }
    $stmt = $db->prepare($query);
    $stmt->execute(array($config,$inst_id));
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return (json_encode($results));
  }

}


function PrepareInsert ($fields, $data, $table) {
    $prep = 'INSERT INTO '.$table.'(';
    $prep .= join(',',$fields).') VALUES (:'. join(',:',$fields).')';
    $exec = array();
    foreach ($fields as $f) { 
        $key = ':'.$f;
        $exec[$key] = $data->$f;
    }
    $return = new stdClass();
    $return->prep = $prep;
    $return->exec = $exec;
    return($return);
}

function RecoverPassword ($request, $system_email_from) {
  try { 
    $db = MysqlConnect();
    $stmt = $db->prepare('SELECT `password` FROM `institutions` WHERE `contact_email` = ? LIMIT 0,1');
    $stmt->execute(array($request->email));
    if ($stmt->rowCount() == 1) { 
      $row=$stmt->fetch(PDO::FETCH_ASSOC);
      if (mail($request->email,'Sort Tetris Password Recovery','Here it is:'.$row['password'],'From: '.$system_email_from)) 
	return (array('success'=>true));
    }
    elseif ($stmt->rowCount() == 0) {
      return (array('success'=>false,'error'=>'No supervisor account found for that email address'));
    }
  }
  catch (PDOException $e) {
    return array('success'=>false,'error'=>$e->getMessage()); 
  }
  //send email
  //return status
}

function RegisterSupervisor($request, $require_supervisor_confirmation) {
  if ($require_supervisor_confirmation) {
    $activated = 'N';
  }
  else { $activated = 'Y'; }
  $db = MysqlConnect();
  $password = file_get_contents('http://www.dinopass.com/password/simple');
  try {
  $stmt = $db->prepare('INSERT INTO institutions(institution_id,institution_name,contact_email,contact_name,password,activated) VALUES (?,?,?,?,?,?)');
  $stmt->execute(array(NULL,$request->inst_name,$request->email,$request->contact_name,$password,$activated));
  if ($stmt->rowCount() == 1) { return(array('success'=>true)); }
  }
  catch (PDOException $e) { 
    return array('success'=>false,'error'=>$e->getMessage()); 
  }
}


      
function AdminListSupervisors() {
  try {
    $db=MysqlConnect(); 
    $stmt=$db->prepare('SELECT institution_id,institution_name,contact_email,contact_name,activated FROM institutions');
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $return = array('success'=>true,'results'=>$results);
    return ($return);
  }
  catch (PDOException $e) {
    return array('success'=>false,'error'=>$e->getMessage()); 
  }
}

function AdminUpdateSupervisor($update,$id) {
  try {
    $db=MysqlConnect();
    $stmt=$db->prepare('UPDATE institutions SET activated = ? WHERE institution_id = ?');
    if ($update == 'admin-activate-supervisor') {
      $values = array('Y',$id);
    }
    elseif ($update == 'admin-deactivate-supervisor') {
      $values = array('N',$id);
    }
    $response=$stmt->execute($values);
    if ($stmt->rowCount() == 1) {
      return (array('success'=>true));
    }
    else {
      return array('success'=>false,'error'=>'unknown error'); 
    }
 }
  catch (PDOException $e) {
    return array('success'=>false,'error'=>$e->getMessage()); 
  }
}

function AdminDeleteSupervisor($id) {
  try {
    $db=MysqlConnect();
  }
  catch (PDOException $e) {
    return array('success'=>false,'error'=>$e->getMessage()); 
  }
} 

function CheckRequiredFields ($request, $required) {
    foreach ($required as $f) {
        if (! isset($request->$f)) {
            return ('Missing field: ' . $f);
        }
    }
    return true;
}

function MysqlConnect() { 
    include ("global_settings.php"); 
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
        $return = [ 'message'=> 'MySQL error: '.$e->getMessage() ];
        print (json_encode($return));
    }
}


?>