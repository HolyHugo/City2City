<?php
require_once 'vendor/autoload.php';
require_once('public/vue.htm');
require_once('Utils.php');
if(file_exists('.env')){
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
}

$doneLines = [];

if (!empty($_POST) && !empty($_FILES)) {
    $handle = fopen($_FILES['uploaded_file']['tmp_name'], "r");
    if ($handle) {
        while (($line = fgetcsv($handle,0,$_POST['separator_entry'])) !== false) {
            $result = Utils::appelCurl(Utils::noWhitespace($line[0]), Utils::noWhitespace($line[1]));

            $distanceKM = $result['rows'][0]['elements'][0]['distance']['text'] ?? '/';
            $doneLines[] = [$result['origin_addresses'][0], $result['destination_addresses'][0], $distanceKM,'',$line[0],$line[1]];
        }

        fclose($handle);
        Utils::writeResultInFile($doneLines,$_POST['separator_output']);
    } else {
        print_r('Une erreur est survenue :/');
    }
}
