<?php

include_once './functions.php';

$bdd = getConnection();
try {
    $requete = "SELECT * FROM " . BDD_TABLE_SONG . " WHERE " . BDD_COL_NAME . " IS NOT NULL;";
    $result = $bdd->query($requete);
    while ($data = $result->fetch()) {
        echo $data[BDD_COL_NAME] . ' -- ' . $data[BDD_COL_SINGER] . ' -- ' . $data[BDD_COL_ALBUM] . '<br />';
    }
    $result->closeCursor();
} catch (Exception $e) {
    // Treat exception
}
?>
