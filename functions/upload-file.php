<?php

function uploadImage($image){


    $error = "";
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($_FILES[$image]["name"],PATHINFO_EXTENSION));
    $basePath = $_SERVER['DOCUMENT_ROOT'];
    $path = '/assets/images/posts/' . '/' . date('Y-m-d-H-i-s') . '.' . $imageFileType;

    $check = getimagesize($_FILES[$image]["tmp_name"]);
    if($check === false) {
        $error = "ERROR: File is not an image.";
        $uploadOk = 0;
    }

// Check if file already exists
    if (file_exists($basePath.$path)) {
        $error = "ERROR: Sorry, file already exists.";
        $uploadOk = 0;
    }

// Check file size
    if ($_FILES[$image]["size"] > 500000) {
        $error = "ERROR: Sorry, your file is too large.";
        $uploadOk = 0;
    }

// Allow certain file formats

    $allowMimes = array('jpg', 'png', 'jpeg', 'gif');
    if(!in_array($imageFileType, $allowMimes)) {
        $error = "ERROR: Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        return "Your file was not uploaded. " . $error;
// if everything is ok, try to upload file
    } else {
        if (!move_uploaded_file($_FILES[$image]["tmp_name"], $basePath . $path)) {
            return "ERROR: Sorry, there was an error uploading your file.";
        }
    }

    return $path;
}

