<?php
$audioOK = false; // set to true to allow music
$buttons = array ('book','book chapter','article');
$data_file = 'bibliography.js';

/* Do NOT edit below this line */

$json_buttons = json_encode($buttons);
?>
<script type="javascript">
var settings_buttons = <?php print($json_buttons); ?>;
var settings_audioOK = <?php if($audioOK) { print 'true'; } else print 'false'; ?>;
</script>

