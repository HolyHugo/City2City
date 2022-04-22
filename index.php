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
    $filename = pathinfo($_FILES['uploaded_file']['name'], PATHINFO_FILENAME);
    move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], "process/inputfile.csv");
    $script = sprintf("python3 process/process.py %s '%s' '%s' %s > /dev/null 2>&1 &",$_ENV['API_KEY'],$_POST['separator_entry'],$_POST['separator_output'],$filename);
    system($script);
    }
