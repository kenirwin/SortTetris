<?
$line = array();
$contents = array(); //new stdClass();
$maindir = 'raw-data';

if (! isset($argv[1])) {
    DisplayFiles();
}
else { 
    $realm = $argv[1];
    $input_files = GetInputs($realm);
    $outfile = @fopen('data-files/'.$realm.'.json', 'w');
    foreach ($input_files as $file) {
        $handle = @fopen($maindir.'/'.$realm.'/'.$file, 'r');
        $type = substr($file, 0, -1);
        if ($handle) {
            while (($buffer = fgets($handle, 4096)) !== false) {
                $buffer = ltrim(chop($buffer));
                $line['item']=strip_tags($buffer, '<em><i><img>');
                $line['item']=preg_replace('/&nbsp;/',' ',$line['item']);
                $line['type']=$type;
                if (preg_match("/[a-zA-Z0-9]/",$line['item'])) { // if string has content
                    array_push($contents, $line);
                }
            }
            if (!feof($handle)) {
                echo 'Error: unexpected fgets() fail'.PHP_EOL;
            }
            fclose($handle);
        }
    }
    if (sizeof($contents) < 1) {
        print 'No data available in '.$realm.PHP_EOL;
    }
    elseif (fwrite($outfile, (json_encode($contents)))) {
        print 'JSON data written to data-files/'.$realm.'.json'.PHP_EOL;
    }
    else {
        print 'Could not write data to data-files/'.$realm.'.json'.PHP_EOL;
    }
} //end else 

function DisplayFiles() {
    global $maindir;
    $files = scandir($maindir);
    print PHP_EOL.'Usage: php prep_files.php [realm]'.PHP_EOL.PHP_EOL;
    print 'Available realms: '.PHP_EOL;
    foreach ($files as $f) { 
        if (is_dir($maindir.'/'.$f) &! (preg_match("/^\./", $f))) { //exclude .dirs
            print '  '.$f.' ('.GetInputs($f,true).')'.PHP_EOL;
                }
    }
}

function GetInputs ($realm, $human_readable=false) {
    global $maindir;
    $output = array();
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
}

?>