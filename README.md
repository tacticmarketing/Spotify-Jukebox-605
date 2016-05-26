# Spotify Jukebox 605

Run an office Jukebox with Spotify.

At Tactic we have _Jukebox Fridays_ where everyone adds seven songs to a collaborative playlist and we show what's playing on a Smart TV.

![Preview Screenshot](http://i.imgur.com/wnMbu1h.png)


## Requirements

* PHP 5.5 or greater.
* PHP [cURL extension](http://php.net/manual/en/book.curl.php) (Usually included with PHP).
* A computer running Mac OS X.



## How it works

- `sync.php` pulls all the tracks from a designated collaborative Spotify playlist and dumps them into a `playlist.json` file. This requires authenticating with Spotify.
- The `Spotify Jukebox.scpt` AppleScript talks to Spotify and sends the currently playing track ID to `set_current_track.php` on the server which then writes it to `current_track_id.txt`.
- `index.html` runs a continuous ajax request to `get_current_track_info.php` which will load the current track and check it against every track in `playlist.json`. Once it finds the track it will return all that track information as a JSON object.


## Installation and Configuration


### 1. Create a Spotify Developer Account

[Create a Spotify developer account](https://developer.spotify.com). Once created, you will need to create a new application and copy/paste the Client ID and Client Secret strings into `settings.php`. You will also need to add a redirect URI to the application (for example http://yourdomain.com/jukebox/sync.php) and update the `REDIRECT_URI` constant in `settings.php`.

### 2. Create a collaborative playlist

Create a collaborative playlist in spotify and then update the `PLAYLIST_USER` and `PLAYLIST_ID` constants in `settings.php`.

### 3. Update the AppleScript file

Update the URL on line 9 in `Spotify Jukebox.scpt`. For example, http://yourdomain.com/jukebox/set_current_track.php. You also need to update the `auth` paramater to be the same as the `CLIENT_ID` provided by Spotify for your application. This will prevent anyone else from sending their song info to your server.

### 4. Display real names instead of usernames
This step is optional. You can update the switch statement in `get_current_track_info.php` to change usernames like `121245618` into real names like `Lauren`.

### 5. Upload the contents of `/dist` to your server

Set permissions on `current_track_id.txt` and `playlist.json` to 777.


## Running Jukebox
1. Add your songs to the the collaborative playlist defined in `settings.php`
2. Once all songs have been added, browse to `sync.php` on your web server. If new songs are added later you will need to re-sync the playlist.
3. Choose someone to play from their computer and have them run `Spotify Jukebox.scpt`. They will need to press the play icon on the script and leave it open until Jukebox Friday is over.
4. Browse to `index.html` on the TV and give it to anyone else who wants to see what's currently playing. It's optimized to run on a Samsung Smart TV (which is partially why some of the code looks like 💩).

Have fun!


## Special Thanks
- [jwwilson's](https://github.com/jwilsson) [Spotify API PHP Wrapper](https://github.com/jwilsson/spotify-web-api-php/)
- [Brandon Ehrlich](http://www.brandonehrlich.com/) for conceiving Jukebox Friday
- [Tactic](http://tacticmarketing.com) and [TrendyMinds](http://trendyminds.com)
