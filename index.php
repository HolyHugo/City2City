<?php
require_once 'vendor/autoload.php';
require_once('public/vue.htm');
if(file_exists('.env')){
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
}

$doneLines = [];

if (!empty($_POST) && !empty($_FILES)) {
    
    $filename = pathinfo($_FILES['uploaded_file']['name'], PATHINFO_FILENAME);
    move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], getcwd()."/process/inputfile.csv");
    chmod('process/inputfile.csv',0755);
    $script = sprintf("python3 ".getcwd()."/process/process.py %s '%s' '%s' %s > /dev/null &",$_ENV['API_KEY'],$_POST['separator_entry'],$_POST['separator_output'],$filename);
    passthru($script);
    }
