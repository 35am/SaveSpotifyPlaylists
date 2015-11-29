# SaveSpotifyPlaylists
Backup Spotify Playlists to your database and export to CSV


# Install
1. Update the files to your webserver
2. Make sure OpenSSL is activated on your PHP conf (php.ini). It's the **extension=php_openssl** row.
3. Play ***install.sql*** on your database


# Create a new playlist
```INSERT INTO playlist (name) VALUE ('YourPlaylistName');```
