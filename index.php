<?php
require_once 'vendor/autoload.php';
if (file_exists('.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

if (count(glob(getcwd() . "/process/done/*")) !== 0) {
    require_once('public/vue.htm');
} else {
    require_once('public/vue.htm');
    if (!empty($_POST) && !empty($_FILES)) {

        $filename = pathinfo($_FILES['uploaded_file']['name'], PATHINFO_FILENAME);
        move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], getcwd() . "/process/inputfile.csv");
        chmod('process/inputfile.csv', 0755);
        $script = sprintf("python3 " . getcwd() . "/process/process.py %s '%s' '%s' %s > /dev/null 2>&1 &", $_ENV['API_KEY'], $_POST['separator_entry'], $_POST['separator_output'], $filename);
        passthru($script);
        header('Location: http://city2city.hugo-bocktaels.fr/index.php');
    }
}
