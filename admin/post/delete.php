<?php

require_once '../../functions/helpers.php';
require_once '../../functions/connection.php';

if (isset($_GET['id']) && $_GET['id']!=''){

    global $conn;

    $query = "SELECT * FROM `news` WHERE `id` = ?";
    $statement = $conn->prepare($query);
    $statement->execute([$_GET['id']]);
    $item = $statement->fetch();
    $path = $_SERVER['DOCUMENT_ROOT'] . '/' . $item->image;
    if (file_exists($path))
        unlink($path);

    $delete_query = "DELETE FROM `news` WHERE `id` = ?";
    $delete_statement = $conn->prepare($delete_query);
    $delete_statement->execute([$_GET['id']]);
    redirect('admin/post');
}
