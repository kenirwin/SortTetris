<html>
<head>
<title>Sort Tetris - Manage Supervisors</title>
<style>
@import url("../style.css");
table {
width: 75%;
  border-collapse: collapse;
}
td,th {
border: 1px solid #999;
}
th.activate { 
color: green;
}
th.delete {
color: red;
}
th.deactivate {
color: #666;
}
thead th { 
color: #000 !important; 
}
</style>

<script type="text/javascript" src="../lib/jquery.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
      $('#deactivated tr').each(function(){ 
	  $(this).append('<th class="activate">Activate</th><th class="delete">Delete</th>');
	});
      $('#activated tr').each(function(){ 
	  $(this).append('<th class="deactivate">Deactivate</th><th class="delete">Delete</th>');
	});
      $('.activate').click(function() {
	  var row= $(this).parent().clone().addClass('moved');
	  $("#activated tbody").append(row);
	   $('.moved .eactivate').text('Deactivate').addClass('deactivate').removeClass('moved').removeClass('activate');
	  $(this).parent().hide();
	});
      $('.deactivate').click(function() {
	  var row= $(this).parent().clone().addClass('moved');
	   $("#deactivated tbody").append(row);
	   $('.moved .deactivate').text('Activate').addClass('activate').removeClass('moved').removeClass('deactivate');
	  $(this).parent().hide();
	});
    });
</script>
</head>
<body>
<title>Sort Tetris - Manage Supervisors</title>

<?php
if(preg_match("/(.*\/)/",$_SERVER['REQUEST_URI'],$m)) {
  $curr_dir = $m[1];
}
$path = $_SERVER['REQUEST_SCHEME'] .'://'.$_SERVER['HTTP_HOST']. $curr_dir;
$ajax_url = $path.'../ajax.php?action=admin-list-supervisors';
$json = file_get_contents($ajax_url);
$response = json_decode($json);
if ($response->success) { 
  $actives = '';
  $inactives = '';
  foreach($response->results as $rec) {
    //    print $rec->institution_id.PHP_EOL;
    $row = '<tr><td>'.$rec->institution_id.'</td><td>'.$rec->institution_name.'</td><td>'.$rec->contact_email.'</td><td>'.$rec->contact_name.'</td></tr>'.PHP_EOL;
    if ($rec->activated == 'Y') {
      $actives .= $row;
    }
    else {
      $inactives .= $row;
    }
  }
  
  $thead = '<thead><tr><th>ID</th><th>Institution</th><th>Email</th><th>Name</th></tr></thead>';
  
  print '<h2>Non-Activated Supervisors</h2>';
  print '<table id="deactivated">'.$thead.'<tbody>'.$inactives.'</tbody></table>'.PHP_EOL;
  
  print '<h2>Activated Supervisors</h2>';
  print '<table id="activated">'.$thead.'<tbody>'.$actives.'</tbody></table>'.PHP_EOL;
}

?>