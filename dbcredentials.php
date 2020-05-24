<?php

function connectDB(){

    $dbhost = 'localhost';
    $dbname = 'csusb';
    $dbuser = 'miguel';
    $dbpass = 'GhanaKid';

    // Connects with database
    try {
        $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbh;
    } catch (PDOException $e) {
        exit($e->getMessage());
    }

}

?>