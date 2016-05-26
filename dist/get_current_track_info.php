<?php
header('Content-Type: application/json');

// Get playlist
$filename = 'playlist.json';
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);

$playlist = json_decode($contents);

// Get currently playing track
$filename = "current_track_id.txt";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);

$current_track = $contents;
$playlist = $playlist->{'items'};

// Get current track info from playlist
foreach($playlist as $player)
{
  $added_by = str_replace('"','\"',$player->{'added_by'}->{'id'});

  if(stripos($current_track, $player->{'track'}->{'id'}))
  {
    $track = str_replace('"','\"',$player->{'track'}->{'name'});
    $artist =  str_replace('"','\"',$player->{'track'}->{'artists'}[0]->{'name'});
    $album = str_replace('"','\"',$player->{'track'}->{'album'}->{'name'});
    $art =  str_replace('"','\"',$player->{'track'}->{'album'}->{'images'}[0]->{'url'});
    break;
  }
}

// If the track couldn't be found, send this default data
if(!isset($track))
{
  ?>
  {
    "track": "???",
    "artist": "",
    "album": "",
    "added_by": "no one",
    "art": ""
  }
  <?
  die();
}

// Switch out usernames with real names if desired
switch(strtolower($added_by))
{
  case '121245618':
    $added_by = 'Lauren';
  break;
}


// Display JSON
?>
{
  "track": "<?php echo $track; ?>",
  "artist": "<?php echo $artist; ?>",
  "album": "<?php echo $album; ?>",
  "added_by": "<?php echo $added_by; ?>",
  "art": "<?php echo $art; ?>"
}
