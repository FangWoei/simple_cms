<?php

    function connectToDB() {
    $host = 'devkinsta_db';
    $dbname = 'Simple_CMS';
    $dbuser = 'root';
    $dbpassword = 'WaoDc0cvoNR1eUiM';
    $database = new PDO (
        "mysql:host=$host;dbname=$dbname",
        $dbuser,
        $dbpassword
    );
    return $database;
}