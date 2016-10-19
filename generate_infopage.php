<?php
$line = array();
$contents = array(); //new stdClass();
$maindir = 'raw-data';

if (! isset($argv[1])) {
    DisplayFiles();
}
else { 
  if ($argv[1] == '--sort') {
    $realm = $argv[2];
    $sort = true;
  }
  else { 
    $realm = $argv[1];
    $sort = false;
  }
    $input_files = GetInputs($realm);
    if ($input_files) { 
      $data='<h1>'.ucfirst($realm).'</h1>'.PHP_EOL;
      $total_files = 0;
      foreach ($input_files as $file) {
	$data.='<h2>'.$file.'</h2>'.PHP_EOL;
	$data.=CreateInfo($file, $sort);
      }
}
    if (isset($data)) {
      print $data;
    }
}

function DisplayFiles() {
    global $maindir;
    $files = scandir($maindir);
    print PHP_EOL.'Usage: php [--sort] generate_infopage.php [realm]'.PHP_EOL.PHP_EOL;
    print 'Available realms: '.PHP_EOL;
    foreach ($files as $f) { 
        if (is_dir($maindir.'/'.$f) &! (preg_match("/^\./", $f))) { //exclude .dirs
            print '  '.$f.' ('.GetInputs($f,true).')'.PHP_EOL;
                }
    }
}

function CreateInfo($file, $sort=false) {
  global $maindir;
  global $realm;
  $output = '';
  $input_path = $maindir.'/'.$realm.'/'.$file;
  $handle = @fopen($input_path, 'r');
  $lines = array();
  if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
      $term = ltrim(chop($buffer));
      array_push($lines, $term);
    }
    if ($sort === true) {
      sort($lines);
    }
    foreach($lines as $term) {
      $output.='<li><a href="https://en.wikipedia.org/wiki/'.$term.'">'.$term.'</a></li>'.PHP_EOL;
    }
  }
  return $output;
}

function GetInputs ($realm, $human_readable=false) {
    global $maindir;
    $output = array();
    if (is_dir($maindir.'/'.$realm)) {
            $files = scandir($maindir.'/'.$realm);
            foreach ($files as $f) {
                if (! (preg_match('/^\./', $f))) {
                    array_push($output, $f);
                }
            }
            $human_array = join (', ', $output);
            if ($human_readable) { 
                return $human_array;
            }
            else { return $output; } 
        } //end if is_dir
        else {
            print 'Not a directory: '.$maindir.'/'.$realm.PHP_EOL;
	    print PHP_EOL.'Usage: php [--sort] generate_infopage.php [realm]'.PHP_EOL.PHP_EOL;

            return false;
        }
}

?>