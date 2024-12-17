<?php

include '../inc.php';

if( isset($_POST) && isset($_POST['_nonce'])) {
    header('Content-Type: application/json');
    $products = (new Products([], ['title' => 'ASC', 'price' => 'DESC']))->getPosts();
    $products_array = [];
    foreach ($products as $product) {
        $products_array[] = $product->getPost();
    }
    echo json_encode($products_array, JSON_UNESCAPED_UNICODE);
}



