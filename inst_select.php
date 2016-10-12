<?php
session_start();
$_SESSION['inst_id'] = $_REQUEST['inst_id'];
$_SESSION['inst_name'] = $_REQUEST['inst_name'];
return(print_r($_SESSION,false));
?>