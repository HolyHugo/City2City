<?php
if ($handle = opendir('process/available/')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
            $thelist .= '<li><a href="process/available/' . $file . '">' . $file . '</a></li>';
        }
    }
    closedir($handle);
}
?>

<head>
    <title>Fichiers traités</title>
    <link rel="stylesheet" href="public/vue.css">
</head>

<body>
    <div class="container">
        <div class="formbox">
            <h3>Listes des fichiers</h3>
            <ul class="no-bullets"><?php echo $thelist; ?></ul>
            <hr>
            <a href="index.php">Vers l'accueil</a>
        </div>
    </div>
</body>
