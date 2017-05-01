<?php
include ('../global_settings.php');
if (! $allow_admin) {
  die('Admin functions not allowed. To activate them, password-protect this directory and set <b>$allow_admin = true</b> in <b>global_settings.php</b>');
}
?>
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
tbody th.activate { 
color: green;
}
tbody th.delete {
color: red;
}
tbody th.deactivate {
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
      Bindings();


      function Bindings () {
	$('.delete').unbind();
	$('.activate').unbind();
	$('.deactivate').unbind();
      $('.delete').click(function() {
	  var curr_row = $(this).parent();
	  var thisid =$(this).parent().children('td:first-child').text();
	  $.getJSON('./action.php', 
		    { action: 'admin-delete-supervisor', inst_id: thisid},
		    function(json) { 
		      if (json.success) {
			$(curr_row).hide();
		      }
		      else { 
			alert(json.success + json.error);
			  }
		    });
	});

      $('.activate').click(function() {
	  var curr_row = $(this).parent();
	  var row= $(this).parent().clone().addClass('moved');
	  var thisid =$(this).parent().children('td:first-child').text();
	  $.getJSON('./action.php', 
		    { action: 'admin-activate-supervisor', inst_id: thisid},
		    function(json) { 
		      if (json.success) {
			$("#activated tbody").append(row);
			$('.moved .activate').text('Deactivate').addClass('deactivate').removeClass('moved').removeClass('activate');
			$('.moved').removeClass('moved');
			$(curr_row).hide();
       		      }
		      else { 
			alert(json.success + json.error);
		      }

		    });
	  Bindings();
	});

      $('.deactivate').click(function() {
	  var curr_row = $(this).parent();
	  var row= $(this).parent().clone().addClass('moved');
	  var thisid =$(this).parent().children('td:first-child').text();
	  $.getJSON('./action.php', 
		    { action: 'admin-deactivate-supervisor', inst_id: thisid},
		    function(json) { 
		      if (json.success) {
			$("#deactivated tbody").append(row);
			$('.moved .deactivate').text('Activate').addClass('activate').removeClass('deactivate');
			$('.moved').removeClass('moved');
			$(curr_row).hide();
		      }
		      else { 
			alert(json.success + json.error);
		      }
		      
		    });
	  Bindings();
	});
      } //end function Bindings
    });
</script>
</head>
<body>
<h1>Sort Tetris - Manage Supervisors</h1>
<div id="nav"><a href="../" class="button-small">Play</a> <a href="../supervisor" class="button-small">Supervisor Login</a></div>

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

<?php include("../license.php"); ?>
