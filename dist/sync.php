<?php
error_reporting(-1);
ini_set('display_errors', 1);

require 'settings.php';
require 'vendor/autoload.php';

$session = new SpotifyWebAPI\Session(
    CLIENT_ID,
    CLIENT_SECRET,
    REDIRECT_URI
);
$api = new SpotifyWebAPI\SpotifyWebAPI();

if (isset($_GET['code'])) {
    $session->requestAccessToken($_GET['code']);
    $api->setAccessToken($session->getAccessToken());
    $api->setReturnAssoc(true);

    $playlist = $api->getUserPlaylistTracks('bmehrlich','7CbqAsFI7v3oH6xPfFaoBq');
    $playlist = json_encode($playlist);
    $fp = fopen('playlist.json', 'w');
    fwrite($fp, $playlist);
    fclose($fp);

    echo "<h1>The playlist is synced.</h1><p>Whoever is playing from Spotify should run the Spotify Jukebox script. <a href='/'>Use this link</a> on the TV.";
} else {
    $scopes = array(
        'scope' => array(
            'playlist-read-collaborative',
        ),
    );

    header('Location: ' . $session->getAuthorizeUrl($scopes));
}
