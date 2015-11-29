<?php

include_once './functions.php';

// Get connection
$bdd = getConnection();

$state = 0;
$resultStr = '';
$continue = 1;
while (1 == $continue) {
    // Get first 5 songs to update
    // FIXME : If for any reason it's imposible to update 5 songs, infinite loop of the death
    $songsToUpdate = getSongsToUpdate($bdd);

    if (!empty($songsToUpdate[0])) {
        // If we have songs to update

        try {
            // Get infos from Spotify
            $json = json_decode(file_get_contents('https://api.spotify.com/v1/tracks/?ids=' . implode(',', array_map(function ($entry) {
                                                return $entry[BDD_COL_SPOTIFY_ID];
                                            }, $songsToUpdate))), true);

            foreach ($json['tracks'] as $track) {
                // Update each song with infos
                updateSong($bdd, searchForId($songsToUpdate, $track['id']), $track['name'], implode(', ', array_map(function ($entry) {
                                            return $entry['name'];
                                        }, $track['artists'])), $track['album']['name']);
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