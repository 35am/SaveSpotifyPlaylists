<?php

include_once './functions.php';

if (isset($_POST[PARAM_PLAYLIST]) && strlen($_POST[PARAM_PLAYLIST]) >= 1 && is_numeric($_POST[PARAM_PLAYLIST])) {
    // Check parameters
    // Get db connection
    $bdd = getConnection();

    // Get songs
    $songsCSV = getPlaylistSongs($bdd, $_POST[PARAM_PLAYLIST]);

    // Generate CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');
    $output = fopen('php://output', 'w');
    fputcsv($output, array('Name', 'Artist', 'Album', 'Spotify_URL'));
    foreach ($songsCSV as $song) {
        fputcsv($output, $song);
    }
} else {
    // Wrong parameters
    echo "A wrong decision is better than indecision.";
}
?>
