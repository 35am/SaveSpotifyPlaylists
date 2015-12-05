<?php

include_once './functions.php';

// Get connection
$bdd = getConnection();

$state = 0;
$resultStr = '';
$continue = 1;
while (1 == $continue) {
    // Get first 5 songs to update
    $songsToUpdate = getSongsToUpdate($bdd);

    if (!empty($songsToUpdate[0])) {
        // If we have songs to update

        try {
            // Get infos from Spotify
            $json = json_decode(file_get_contents('https://api.spotify.com/v1/tracks/?ids=' . implode(',', array_map(function ($entry) {
                                                return $entry[BDD_COL_SPOTIFY_ID];
                                            }, $songsToUpdate))), true);


            foreach ($json[JSON_TRACKS] as $track) {

                // Check the JSON
                if (isAValidJSONTrack($track)) {

                    // Get the correct SpotifyID
                    $spotifySongId = isset($track[JSON_LINKED_FROM]) ? $track[JSON_LINKED_FROM][JSON_LINKED_FROM_ID] : $track[JSON_TRACK_ID];

                // Update each song with infos
                    updateSong($bdd, $spotifySongId, $track[JSON_TRACK_NAME], implode(', ', array_map(function ($entry) {
                                                return $entry[JSON_TRACK_ARTIST_NAME];
                                            }, $track[JSON_TRACK_ARTISTS])), $track[JSON_TRACK_ALBUM][JSON_TRACK_ALBUM_NAME]);

                    // Set update OK
                    $songsToUpdate[getIndexOfSong($songsToUpdate, $spotifySongId)][PARAM_UPDATED] = 1;
            }
            }


            // Update the LAST_TRY column for songs that can't be updated
            foreach ($songsToUpdate as $song) {
                if (0 === $song[PARAM_UPDATED]) {
                    updateLastTry($bdd, $song[BDD_COL_SPOTIFY_ID]);
                }
            }
        } catch (Exception $e) {
            $resultStr .= 'Error updating ' . implode(',', array_map(function ($entry) {
                                        return $entry[BDD_COL_SPOTIFY_ID];
                                    }, $songsToUpdate)) . '<br />';
            $state = 1;
        }
    } else {
        // We have to stop
        $continue = -1;
    }
}

if (0 === $state) {
    echo "Update done !";
} else {
    echo "Errors : " . $resultStr;
}
?>