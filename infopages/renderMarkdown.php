<?php
include('functions.php');
$_REQUEST['file'] = 'instruments.md';
if (isset ($_REQUEST['file'])) {
  $filename = str_replace('/', '' ,$_REQUEST['file']);
  $file =  CurlGet($filename);
}

print (RenderMarkdown($file));

function PostJSON ($url, $json) {
  include ("config.php");
  if (function_exists('curl_version')) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					       'Content-Type: application/json', 
					       'Content-Length: ' . strlen($json),
					       'User-Agent: Sort-Tetris',
					       )
		); 
    $result = curl_exec($ch);
    return $result;
  } //end if curl_version exists
  else {
    return "CURL is not available in this PHP installation";
  }
} //end function PostJSON

function RenderMarkdown ($text) {
  if (function_exists('curl_version')) {
    $api="https://api.github.com/markdown";
    $array = array ( "mode" => "markdown",
		          "text" => $text
		     );
    $json = json_encode($array);
    $html = PostJSON($api, $json);
    return $html;
  }
  else { return "<pre>$text</pre>"; }
}
?>