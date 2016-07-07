<?php
$item_label_cap = ucfirst($item_label);
$json_buttons = json_encode($buttons);
if (empty($game_logo_file)) {
    $game_header = '<h1>'.$game_title.'</h1>';
}
else {
    $game_header = '<img src="'.$game_logo_file.'" />';
}
?>
<script type="text/javascript">
var settings_buttons = <?php print($json_buttons); ?>;
var settings_audioOK = <?php if($audioOK) { print 'true'; } else print 'false'; ?>;
var settings_itemLabel = "<?php print($item_label_cap); ?>";
</script>
