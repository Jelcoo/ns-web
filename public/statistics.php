<?php
    chdir(__DIR__."/..");

    require_once "./functions/env.php";

    if (getenv("DEBUG") == "true") {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }

    require_once "./functions/database.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <title>NS Trains - Statistics</title>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <link rel="stylesheet" href="assets/css/style.css" />

        <script src="assets/js/utils.js"></script>
    </head>
    <body>
        <?php require './components/navbar.php'; ?>
        <main>
            
        </main>
    </body>
</html>
