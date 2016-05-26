var currentTrack;
function yeah()
{
  jukebox_display = document.getElementById('if');
  jukebox_display.contentWindow.location.reload();
  x  = jukebox_display.contentWindow.document.getElementById('t');
}

function doit()
{
  var request = new XMLHttpRequest();
  request.open('GET', 'get_current_track_info.php', true);

  request.onload = function() {
    if (request.status >= 200 && request.status < 400) {
      // Success!
      var resp = request.responseText;

      var iff = document.getElementById('if');
      resp = JSON.parse(resp);

      if(currentTrack != resp.track) {
        $('.main').addClass('changing')
      }
      setTimeout(function() {
        document.getElementById('track').innerHTML = resp.track;
        document.getElementById('artist').innerHTML = resp.artist;
        document.getElementById('album').innerHTML = resp.album;
        document.getElementById('added_by').innerHTML = "Added by " + resp.added_by;
        document.getElementById('album_art').src = resp.art;

      }, 200);

      if(currentTrack != resp.track) {
        setTimeout(function() {
          $('.main').removeClass('changing')
        }, 300);
        currentTrack = resp.track;
      }

    } else {
      // We reached our target server, but it returned an error

    }
  };

  request.onerror = function() {
    // There was a connection error of some sort
  };

  request.send();
}

window.onload = function()
{
  setInterval(doit, 1000);

}
