<?php

/* * *****************
 * PARAMETERS 
 * ******************
 */

// Your database NAME
define("BDD_NAME", "TO_CHANGE");
// Password to connect to database
define("Z_BDD_MDP", "TO_CHANGE");
// Login to connect to database
define("BDD_LOGIN", "TO_CHANGE");
// Database hostname ("localhost" most of the times)
define("BDD_HOSTNAME", "TO_CHANGE");

// Value set in CSV Export for empty fields
define("CSV_EMPTY_VAL", "_EMPTY_");





/* * *****************
 * CHANGE NOTHING AFTER
 * ******************
 */
define("PARAM_SONGS", "songs");
define("PARAM_PLAYLIST", "playlist");

define("BDD_TABLE_PLAYLIST", "playlist");
define("BDD_TABLE_PLAYLIST_SONG", "playlist_song");
define("BDD_TABLE_SONG", "song");
define("BDD_COL_ID", "id");
define("BDD_COL_ID_SONG", "id_song");
define("BDD_COL_ID_PLAYLIST", "id_playlist");
define("BDD_COL_NAME", "name");
define("BDD_COL_SINGER", "singer");
define("BDD_COL_ALBUM", "album");
define("BDD_COL_SPOTIFY_URL", "spotify_url");
define("BDD_COL_SPOTIFY_ID", "spotify_id");
define("BDD_COL_LAST_TRY", "last_try");


define("JSON_TRACKS", "tracks");
define("JSON_TRACK_ID", "id");
define("JSON_LINKED_FROM", "linked_from");
define("JSON_LINKED_FROM_ID", "id");
define("JSON_TRACK_NAME", "name");
define("JSON_TRACK_ARTISTS", "artists");
define("JSON_TRACK_ARTIST_NAME", "name");
define("JSON_TRACK_ALBUM", "album");
define("JSON_TRACK_ALBUM_NAME", "name");

define("PARAM_UPDATED", "updated");
?>
