
<?php
require_once '../../functions/helpers.php';
require_once '../../functions/connection.php';
require_once '../../functions/upload-file.php';
global $item;
global $conn;

if (!isset($_GET['id']) || $_GET['id'] == '')
    redirect('admin/post');

$query = "SELECT * FROM `news` WHERE `id` = ?";
$statement = $conn->prepare($query);
$statement->execute([$_GET['id']]);
$item = $statement->fetch();

if ($item === false)
    redirect('admin/post');

if (
        isset($_POST['title']) && $_POST['title'] != '' &&
        isset($_POST['body']) && $_POST['body'] != '' &&
        isset($_POST['category']) && $_POST['category'] != ''
)
{
    $image = "";
    //dd($_FILES['image']);
    if (!isset($_FILES['image']) || $_FILES['image']["name"] === "")
        $image = $item->image;

    else{

        $image = uploadImage('image');
        if (strpos($image, "ERROR") !== false) {
            die($image);
        }

        else{
            //$image = 'assets/images/posts/' . basename($_FILES['image']["name"]);
            $path = $_SERVER['DOCUMENT_ROOT'] . '/' . $item->image;
            if (file_exists($path))
                unlink($path);
        }
    }

    global $conn;
    $query = "UPDATE news SET title=?, description = ?, image = ?, category_id = ?, updated_at=NOW() WHERE id=?";
    $statement = $conn->prepare($query);
    $statement->execute([
        $_POST['title'], $_POST['body'],$image ,$_POST['category'], $_GET['id']
        ]);

    redirect('admin/post');
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

                <form action="<?= url('admin/post/edit.php?id=') . $_GET['id'] ?>" method="post" enctype="multipart/form-data">
                    <section class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title"  value="<?= $item->title ?>">
                    </section>
                    <section class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" id="image" ">
                    </section>
                    <section class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" name="category" id="category">
                            <?php

                            global $conn;
                            $query = "SELECT * FROM categories";
                            $statement = $conn->prepare($query);
                            $statement->execute();
                            $categories = $statement->fetchAll();

                            foreach ($categories as $category){

                                ?>

                                <option <?php if ($category->id == $item->category_id) { ?> selected <?php } ?> value="<?= $category->id ?>"><?= $category->name ?></option>

                            <?php } ?>
                        </select>
                    </section>
                    <section class="form-group">
                        <label for="body">Body</label>
                        <textarea class="form-control" name="body" id="body" rows="5" ><?= $item->description ?></textarea>
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