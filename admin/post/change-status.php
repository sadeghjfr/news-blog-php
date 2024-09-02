<?php

require_once '../../functions/helpers.php';
require_once '../../functions/connection.php';

if (isset($_GET['id']) && $_GET['id']!=''){

    global $conn;

    $query = "SELECT * FROM `news` WHERE `id` = ?";
    $statement = $conn->prepare($query);
    $statement->execute([$_GET['id']]);
    $item = $statement->fetch();
    $new_status = $item->status==1 ? 0 : 1;

    $query2 = "UPDATE `news` SET status = ? WHERE id = ?";
    $statement2 = $conn->prepare($query2);
    $statement2->execute([$new_status , $_GET['id']]);
    redirect('admin/post');
}
