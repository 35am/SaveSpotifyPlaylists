<?php

include_once './functions.php';

$bdd = getConnection();

$continue = 1;

while (1 == $continue) {
    $songsToUpdate = getSongsToUpdate($bdd);


    if (!empty($songsToUpdate[0])) {


        echo "URL : " . "https://api.spotify.com/v1/tracks/?ids=" . implode(',', array_map(function ($entry) {
                            return $entry[BDD_COL_SPOTIFY_ID];
                        }, $songsToUpdate)) . "<br />";

        $json = json_decode(file_get_contents('https://api.spotify.com/v1/tracks/?ids=' . implode(',', array_map(function ($entry) {
                                            return $entry[BDD_COL_SPOTIFY_ID];
                                        }, $songsToUpdate))), true);

        foreach ($json['tracks'] as $track) {
            echo $track['name'] . ' - ' . implode(', ', array_map(function ($entry) {
                                return $entry['name'];
                            }, $track['artists'])) . ' - ' . $track['album']['name'] . '<br />';


            updateSong($bdd, searchForId($songsToUpdate, $track['id']), $track['name'], implode(', ', array_map(function ($entry) {
                                        return $entry['name'];
                                    }, $track['artists'])), $track['album']['name']);
        }
    } else {
        $continue = -1;
    }
}
?>
