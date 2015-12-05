<?php
include_once './functions.php';

$state = 0;
$resultStr = '';
$nbAdd = 0;

if (strlen($_POST[PARAM_PLAYLIST]) >= 1 && is_numeric($_POST[PARAM_PLAYLIST]) && strlen($_POST[PARAM_SONGS]) > 1) {
    // Check parameters
    // Get db connection
    $bdd = getConnection();

    $inSongs = trim($_POST[PARAM_SONGS]);
    $songs = array_filter(explode("\n", $inSongs), 'trim');

    foreach ($songs as $song) {
        // Reading songs line by line

        if (preg_match('#^https?://open.spotify.com/track/#i', $song) === 1) {
            // Check correct URL
            // Inserting song
            $idNewSong = insertSong($bdd, preg_replace('/\s+/', '', $song));
            if (-1 != $idNewSong) {
                // Linking song to playlist
                insertSongPlaylist($bdd, $idNewSong, $_POST[PARAM_PLAYLIST]);
                $nbAdd++;
            } else {
                $resultStr .= 'Error adding : ' . $song;
                $state = 1;
            }
        } else {
            $resultStr .= 'Wrong URL : ' . $song;
            $state = 1;
        }
    }
} else {
    // Wrong parameters
    $state = -1;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Result</title>
    </head>
    <body>
        <p><?php echo $nbAdd; ?> song(s) added to your playlist</p>
<?php
if (-1 == $state) {
    ?>
            <p>Check your parameters !</p>
            <?php
        } else if (1 == $state) {
            ?>
            <p>Something wrong happened :</p>
            <p>
                <textarea name="errors" id="errors" style="width: 800px;" rows="10" ><?php echo $resultStr; ?></textarea>
            </p>
    <?php
} else {
    ?>
            <p>Songs succesfully added to your playlist !</p>
        <?php } ?>
        <p>
            <a href="./index.php" alt="Back"><button>Back</button></a>
        </p>
        <p style="margin-top: 50px; text-align: center;"><a href="https://github.com/35am/SaveSpotifyPlaylists" alt="GitHub">SaveSpotifyPlaylists on GitHub</a></p>
    </body>
</html>

