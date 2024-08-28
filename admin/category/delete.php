<?php

require_once '../../functions/helpers.php';
require_once '../../functions/connection.php';

if (isset($_GET['id']) && $_GET['id']!=''){

    global $conn;
    $query = "DELETE FROM categories WHERE id=?";
    $statement = $conn->prepare($query);
    $statement->execute([$_GET['id']]);
    redirect('admin/category');
}
