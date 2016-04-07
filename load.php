<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

<head>
<script type="text/javascript" src="jquery.js"></script>
<script>
     $(document).ready(function() {
         var path = "./sample.json";
         $.getJSON(path, function(data) {
                 $.each(data, function(key, val) 
                 {
                     alert (key + ":" + val.type);
                 });
             }); 
     });
</script>
</head>

<body>
<div id="output"></div>
</body>