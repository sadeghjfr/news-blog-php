<?php

const BASE_URL = 'http://localhost:63342/news-blog/';

function redirect($url){

    header('Location: ' . trim(BASE_URL, '/ ') . '/' . trim($url, '/ '));
    exit();
}

// css, js, images
function asset($file){

    return trim(BASE_URL, '/ ') . '/' . trim($file, '/ ');

}

// links
function url($url){

    return trim(BASE_URL, '/ ') . '/' . trim($url, '/ ');

}

// dump & die
function dd($result){

    echo "<pre>";
    var_dump($result);
    exit();
}