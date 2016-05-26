<?php
require 'settings.php';

if(!empty($_POST['trackId']) && $_POST['auth'] == CLIENT_ID) {
  $fp = fopen('current_track_id.txt', 'w');
  fwrite($fp, $_POST['trackId']);
  fclose($fp);
}
?>
