<?php

require_once '../../functions/helpers.php';
require_once '../../functions/connection.php';
require_once '../../functions/upload-file.php';

if (
        isset($_POST['title']) && $_POST['title'] != '' &&
        isset($_POST['body']) && $_POST['body'] != '' &&
        isset($_POST['category']) && $_POST['category'] != '' &&
        isset($_FILES['image']) && $_FILES['image']['name'] != ''
) {

    $image = uploadImage('image');
    if (strpos($image, "ERROR") !== false) {
        die($image);
    }

    global $conn;
    $query = "INSERT INTO news SET title=?, description = ?, image = ?, category_id = ?, created_at=NOW();";
    $statement = $conn->prepare($query);
    $statement->execute([
            $_POST['title'], $_POST['body'],$image ,$_POST['category']
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

                <form action="<?= url('admin/post/create.php') ?>" method="post" enctype="multipart/form-data">
                    <section class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="title ...">
                    </section>
                    <section class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" id="image">
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

                            <option value="<?= $category->id ?>"><?= $category->name ?></option>

                            <?php } ?>
                        </select>
                    </section>
                    <section class="form-group">
                        <label for="body">Body</label>
                        <textarea class="form-control" name="body" id="body" rows="5" placeholder="body ..."></textarea>
                    </section>
                    <section class="form-group">
                        <button type="submit" class="btn btn-primary">Create</button>
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