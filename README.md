# SaveSpotifyPlaylists
Backup Spotify Playlists to your database and export to CSV

### Install
1. Update the files to your webserver
2. Make sure OpenSSL is activated on your PHP setup (php.ini > *extension=php_openssl*).
3. Play **install.sql** on your database

### Create a new playlist
```sql
INSERT INTO playlist (name) VALUE ('YourPlaylistName');
```