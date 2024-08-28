<?php
require_once '../../functions/helpers.php';
require_once '../../functions/connection.php';
global $category;
global $conn;

if (!isset($_GET['id']) || $_GET['id'] == '')
    redirect('admin/category');

    $query = "SELECT * FROM `categories` WHERE `id` = ?";
    $statement = $conn->prepare($query);
    $statement->execute([$_GET['id']]);
    $category = $statement->fetch();

if ($category === false)
    redirect('admin/category');

if (isset($_POST['name']) && $_POST['name'] != ''){

    global $conn;
    $query = "UPDATE categories SET name=?, updated_at=NOW() WHERE id=?";
    $statement = $conn->prepare($query);
    $statement->execute([$_POST['name'], $_GET['id']]);
    redirect('admin/category');
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP panel</title>
    <link rel="stylesheet" href="<?=asset('assets/css/bootstrap.min.css')?>" media="all" type="text/css">
    <link rel="stylesheet" href="<?=asset('assets/css/style.css')?>" media="all" type="text/css">
</head>
<body>
<section id="app">
    <?php require_once '../layouts/top-nav.php'; ?>

    <section class="container-fluid">
        <section class="row">
            <section class="col-md-2 p-0">
                <?php require_once '../layouts/side-bar.php'; ?>

            </section>
            <section class="col-md-10 pt-3">

                <form action="<?= url('admin/category/edit.php?id=') . $_GET['id'] ?>" method="post">
                    <section class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name"  value="<?= $category->name ?>">
                    </section>
                    <section class="form-group">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </section>
                </form>

            </section>
        </section>
    </section>

</section>

<script src="<?= asset('assets/js/jquery.min.js') ?>"></script>
<script src="<?= asset('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>