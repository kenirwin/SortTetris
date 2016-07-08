<?
$line = array();
$contents = array(); //new stdClass();
$input_files = array("books","book chapters","articles");
foreach ($input_files as $file) {
    $handle = @fopen($file, "r");
    $type = substr($file, 0, -1);
    if ($handle) {
        while (($buffer = fgets($handle, 4096)) !== false) {
            $buffer = ltrim(chop($buffer));
            //            print('"'.strip_tags($buffer, '<em><i>'). '","'. $type . '"'. PHP_EOL);
            $line['item']=strip_tags($buffer, '<em><i>');
            $line['type']=$type;
            array_push($contents, $line);
        }
        if (!feof($handle)) {
            echo "Error: unexpected fgets() fail\n";
        }
        fclose($handle);
    }
}
print(json_encode($contents));
//print_r($contents);
?>