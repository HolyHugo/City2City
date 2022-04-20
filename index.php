<?php
require_once 'vendor/autoload.php';
if(file_exists('.env')){
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
}
require_once('vue.htm');
$doneLines = [];
if (!empty($_POST) && !empty($_FILES)) {
    $handle = fopen($_FILES['uploaded_file']['tmp_name'], "r");
    if ($handle) {
        while (($line = fgetcsv($handle)) !== false) {
            $result = appelCurl($line[0], $line[1]);
            $distanceKM = $result['rows'][0]['elements'][0]['distance']['text'];
            $doneLines[] = [$result['origin_addresses'][0], $result['destination_addresses'][0], $distanceKM,'',$line[0],$line[1]];
        }

        fclose($handle);
        writeResultInFile($doneLines);
    } else {
        print_r('Une erreur est survenue :/');
    }
}

function writeResultInFile($resultLines)
{
    ob_clean();
    ob_start();
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="distanceVille' . date('d-m-Y') . '.csv";');
    header('Content-Encoding: UTF-8');
    $file = fopen("php://output", "w");
    fputcsv($file, ['Ville Départ', 'Ville Arrivée', 'Distance', ' --- ','Ville départ originale','Ville arrivée']);

    foreach ($resultLines as $line) {
        fputcsv($file, $line);
    }

    fclose($file);
}

function appelCurl($villeDepart, $villeArrivee)
{

    $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $villeDepart . '&destinations=' . $villeArrivee . '&units=metric&key=' .$_ENV['API_KEY'];
    $ch = curl_init($url);
    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
    ];
    curl_setopt_array($ch, $options);

    $result = curl_exec($ch);
    return json_decode($result, true);
}
