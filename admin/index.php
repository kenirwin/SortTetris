<h1>Sort Tetris - Site Administration</h1>
<h2>View Recent Scores for:</h2>

<?
$path = $_SERVER['REQUEST_SCHEME'] .'://'.$_SERVER['HTTP_HOST']. preg_replace('/\/admin\/.*/','/',$_SERVER['REQUEST_URI']);
$ch = curl_init($path."ajax.php?action=list-all-games");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = json_decode(curl_exec($ch));
curl_close($ch);

print '<ol id="list-games">'.PHP_EOL;
foreach($response as $game) {
      print '<li><a href="./scores.php?config='.$game->url.'">'.$game->title.'</a>'.PHP_EOL;
    }
print '</ol>';

?>
