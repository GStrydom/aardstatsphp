<?php
    define("HOST", "localhost");
    define("DBNAME", "aardphp");
    define("USERNAME", "root");
    define("PASSWORD", "");

    $dsn = "mysql:host=" . HOST . ";dbname=" . DBNAME;
    $pdo = new PDO($dsn, USERNAME, PASSWORD);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);