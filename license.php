<div id="footer">
<?php
if (isset($contact_email)) {
  print '<span id="contact-link"><a href="contact.php">Contact Us</a></span> |'.PHP_EOL;
}
?>
<span id="license"><a href="https://github.com/kenirwin/SortTetris">Sort Tetris</a> version <?php include ("version.php"); print($version); ?> by Ken Irwin is licensed under a <a rel="license" href="https://www.gnu.org/licenses/#AGPL">GNU Affero General Public License</a>.</span>
</div>