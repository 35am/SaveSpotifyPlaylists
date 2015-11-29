<?php
include_once './functions.php';

$bdd = getConnection();
$playlits = getPlaylists($bdd);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>SaveSpotifyPlaylists</title>
    </head>
    <body>
        <h2>Add songs to a DB</h2>
        <form method="post" action="./submit.php">
            <p>
                Choose a playlist : 
                <select type="select" name="playlist" id="playlist">

                    <?php
                    foreach ($playlits as $playlist) {
                        print '<option value="' . $playlist[BDD_COL_ID] . '">' . $playlist[BDD_COL_NAME] . '</option>';
                    }
                    ?>
                </select>
            </p>
            <p>
                Songs :
            </p>
            <p>
                <textarea name="<?php echo PARAM_SONGS; ?>" id="<?php echo PARAM_SONGS; ?>" style="width: 800px;" rows="10" ></textarea>
            </p>
            <p><input type="submit" value="Go !" style="width: 100px;"></p>
        </form>
        ------------------------------------------------------------
        <h2>Export to CSV</h2>
        <form method="post" action="./export.php">
            <p>
                Choose a playlist : 
                <select type="select" name="playlist" id="playlist">

                    <?php
                    foreach ($playlits as $playlist) {
                        print '<option value="' . $playlist[BDD_COL_ID] . '">' . $playlist[BDD_COL_NAME] . '</option>';
                    }
                    ?>
                </select>
            </p>
            <p><input type="submit" value="Get content" style="width: 100px;"></p>
        </form>
        ------------------------------------------------------------
        <h2>Update DB</h2>
        <p><a href="./updateDb.php" alt="Update"><button>Update !</button></p>
        <p style="margin-top: 50px; text-align: center;"><a href="https://github.com/35am/SaveSpotifyPlaylists" alt="GitHub">SaveSpotifyPlaylists on GitHub</a></p>
    </body>
</html>
