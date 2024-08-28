<?php

global $conn;
$server_name = "localhost";
$user_name = "root";
$password = "";
$db_name = "news_blog_db";
$dns = "mysql:host=$server_name;dbname=$db_name";
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
);

try {

    $conn = new PDO($dns, $user_name, $password, $options);

    //echo "Database connected!";

    //$conn = null;
}

catch (PDOException $e){
    echo $e->getMessage();
}
