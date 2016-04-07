<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

<head>
<script type="text/javascript" src="jquery.js"></script>
<script>
     $(document).ready(function() {
         var myjson;
         var path = "./more-pairs.json";
         $.getJSON(path, function(data) {
             for (var i in data) {
                 //        alert(data[i].citation);
             }
             gamedata = data;
         });
         alert(gamedata.length);
             
         var citeIndex = Math.floor(Math.random()*game.data.length);
     });
</script>
</head>

<body>
<div id="output"></div>
</body>