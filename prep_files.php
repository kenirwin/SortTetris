<?php
$line = array();
$contents = array(); //new stdClass();
$maindir = 'raw-data';

if (! isset($argv[1])) {
    DisplayFiles();
}
else { 
    $realm = $argv[1];
    $input_files = GetInputs($realm);
    if ($input_files) { 
        $total_files = 0;
        foreach ($input_files as $file) {
            $total_files++;
            $input_path = $maindir.'/'.$realm.'/'.$file;
            $handle = @fopen($input_path, 'r');
            $type = str_replace('\ ',' ',$file);
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
    }

    

    if (sizeof($contents) < 1) {
        print 'No data available in '.$realm.PHP_EOL;
    }
    elseif ($total_files > 1) {
        $outfile = @fopen('data-files/'.$realm.'.json', 'w');
        if (fwrite($outfile, (json_encode($contents)))) {
            print 'JSON data written to data-files/'.$realm.'.json'.PHP_EOL;
        }
        else {
            print 'Could not write data to data-files/'.$realm.'.json'.PHP_EOL;
        }
    }
    else {
        print 'Fewer than two input files in '.$maindir.'/'.$realm.'. At least two files are needed.'.PHP_EOL;
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
            return false;
        }
}

?>