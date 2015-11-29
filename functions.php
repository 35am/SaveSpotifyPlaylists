<?php

include_once 'constants.php';

/**
 * Return a MySQL connection
 */
function getConnection() {
    try {
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $bdd = new PDO('mysql:host=' . BDD_HOSTNAME . ';dbname=' . BDD_NAME, BDD_LOGIN, Z_BDD_MDP, $pdo_options);
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    return $bdd;
}

/**
 * Get content of playlist table
 */
function getPlaylists($bdd) {
    $retour = array(array());
    $nb_pl = 0;
    try {
        $requete = "SELECT " . BDD_COL_ID . ", " . BDD_COL_NAME . " FROM " . BDD_TABLE_PLAYLIST . ";";
        $result = $bdd->query($requete);
        while ($data = $result->fetch()) {
            $retour[$nb_pl][BDD_COL_ID] = $data[BDD_COL_ID];
            $retour[$nb_pl][BDD_COL_NAME] = $data[BDD_COL_NAME];
            $nb_pl++;
        }
        $result->closeCursor();
    } catch (Exception $e) {
        // Treat exception
    }
    return $retour;
}

/**
 * Insert (if necessary) the $songUrl in the song table. Return song id if ok, -1 if error.
 */
function insertSong($bdd, $songUrl) {
    $retour = -1;
    try {
        $retour = getSongByURL($bdd, $songUrl);
        if (-1 == $retour) {
            $requete = "INSERT INTO " . BDD_TABLE_SONG . " (" . BDD_COL_SPOTIFY_URL . ", " . BDD_COL_SPOTIFY_ID . ") VALUES ('" . $songUrl . "', '" . preg_replace('#^https?://open.spotify.com/track/#i', '', $songUrl) . "');";
            $bdd->exec($requete);
            $retour = $bdd->lastInsertId();
        }
    } catch (Exception $e) {
        $retour = -1;
    }
    return $retour;
}

/**
 * Return the song row matching the $songUrl
 */
function getSongByURL($bdd, $songUrl) {
    $retour = -1;
    try {
        $requete = "SELECT " . BDD_COL_ID . " FROM " . BDD_TABLE_SONG . " WHERE " . BDD_COL_SPOTIFY_URL . "='" . $songUrl . "';";
        $result = $bdd->query($requete);
        if ($res = $result->fetch()) {
            $retour = $res[BDD_COL_ID];
        }
        $result->closeCursor();
    } catch (Exception $e) {
        // Treat exception
    }
    return $retour;
}

/**
 * Add the record $songId/$playListId in the paylist_song table
 */
function insertSongPlaylist($bdd, $songId, $playListId) {
    try {
        $requete = "INSERT INTO " . BDD_TABLE_PLAYLIST_SONG . " (" . BDD_COL_ID_SONG . "," . BDD_COL_ID_PLAYLIST . ") VALUES ('" . $songId . "', '" . $playListId . "');";
        $bdd->exec($requete);
    } catch (Exception $e) {
        // Treat exception
    }
}

/**
 * 
 */
function getSongsToUpdate($bdd) {
    $retour = array(array());
    $nb_song = 0;
    try {
        $requete = "SELECT " . BDD_COL_ID . ", " . BDD_COL_SPOTIFY_ID . " FROM " . BDD_TABLE_SONG . " WHERE " . BDD_COL_NAME . " IS NULL LIMIT 5;";
        $result = $bdd->query($requete);
        while ($data = $result->fetch()) {
            $retour[$nb_song][BDD_COL_ID] = $data[BDD_COL_ID];
            $retour[$nb_song][BDD_COL_SPOTIFY_ID] = $data[BDD_COL_SPOTIFY_ID];
            $nb_song++;
        }
        $result->closeCursor();
    } catch (Exception $e) {
        // Treat exception
    }
    return $retour;
}

function updateSong($bdd, $songId, $name, $singer, $album) {
    try {
        $requete = "UPDATE " . BDD_TABLE_SONG . " SET " . BDD_COL_NAME . "='" . secur_mysql($name) . "', " . BDD_COL_SINGER . "='" . secur_mysql($singer) . "', " . BDD_COL_ALBUM . "='" . secur_mysql($album) . "' WHERE " . BDD_COL_ID . "='" . $songId . "';";
        $bdd->exec($requete);
    } catch (Exception $e) {
        // Treat exception
    }
}

function searchForId($songs, $spotifyId) {
    foreach ($songs as $song) {
        if ($spotifyId === $song[BDD_COL_SPOTIFY_ID]) {
            return $song[BDD_COL_ID];
        }
    }
    return null;
}

function secur_mysql($value) {
    $search = array("\x00", "\n", "\r", "\\", "'", "\"", "\x1a");
    $replace = array("\\x00", "\\n", "\\r", "\\\\", "\'", "\\\"", "\\\x1a");

    return str_replace($search, $replace, $value);
}

?>
