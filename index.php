<?php
include_once './functions.php';

$bdd = getConnection();
$playlits = getPlaylists($bdd);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>SpotiSave</title>
    </head>
    <body>
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
            <br /><br />
            <p>
                Songs :
            </p>
            <p>
                <textarea name="<?php echo PARAM_SONGS; ?>" id="<?php echo PARAM_SONGS; ?>" style="width: 800px;" rows="10" ></textarea>
            </p>
            <p><input type="submit" value="Go !" style="width: 100px;"></p>
        </form>
    </body>
</html>
