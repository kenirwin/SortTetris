<?php
header("Content-type: application/json");
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
}
catch (PDOException $e) {
    $return = [ 'message'=> 'MySQL error: '.$e->getMessage() ];
    print (json_encode($return));
}

$request = (object) $_REQUEST;

try {
if ($request->action == "submit") {
    $required_fields = array ('username','score','percent','level','config_file');
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

elseif ($request->action == "leaderboard") {
    $required_fields = array ('config_file');
    $check = CheckRequiredFields($request,$required_fields);
    if ($check === true) {
        Leaderboard($request->config_file, $db); 
    }
    else {
        throw new Exception ($check);
    }
}

}

catch (Exception $e) {
    print $e;
}

function Leaderboard ($config,$db) {
    $stmt = $db->prepare("SELECT username,score FROM leaderboard WHERE config_file=? ORDER BY score DESC LIMIT 0,10");
    $stmt->execute(array($config));
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print (json_encode($results));
    
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

function CheckRequiredFields ($request, $required) {
    foreach ($required as $f) {
        if (! isset($request->$f)) {
            return ('Missing field: ' . $f);
        }
    }
    return true;
}


?>