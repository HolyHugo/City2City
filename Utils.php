<?php
class Utils
{

    static function writeResultInFile($resultLines, $separatorOutput)
    {
        ob_clean();
        ob_start();
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="distanceVille' . date('d-m-Y') . '.csv";');
        header('Content-Encoding: UTF-8');
        $file = fopen("php://output", "w");
        fputcsv($file, ['Ville Départ', 'Ville Arrivée', 'Distance', ' --- ', 'Ville départ originale', 'Ville arrivée'], $separatorOutput);

        foreach ($resultLines as $line) {
            fputcsv($file, $line, $separatorOutput);
        }

        fclose($file);
    }

    static function appelCurl($villeDepart, $villeArrivee)
    {

        $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $villeDepart . '&destinations=' . $villeArrivee . '&units=metric&key=' . $_ENV['API_KEY'];
        $ch = curl_init($url);
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
        ];
        curl_setopt_array($ch, $options);

        $result = curl_exec($ch);
        return json_decode($result, true);
    }
    static function noWhitespace($string)
    {
        return preg_replace('/\s+/', '', $string);
    }
}
