<?php
$servername = "127.0.0.1:3306";
$username = "root";
$password = "01275770953Andrew";
$dbname = "super_market";



// Create connection
$connect = new mysqli($servername, $username, $password, $dbname);

// check connection

if (!$connect) {
    console_log("Error");
    echo "Connection error: ";
}

console_log("Connected DataBase");
