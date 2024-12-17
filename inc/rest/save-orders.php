<?php

include '../inc.php';
header('Content-Type: application/json');

if( isset($_POST) && isset($_POST['_nonce']) && isset($_POST['user_id']) && isset($_POST['product_ids']) ) {
    header('Content-Type: application/json');
    $product_ids = explode(',',$_POST['product_ids']);
    foreach ($product_ids as $product_id ) {
        $data = [];
        $data['files'] = [];
        $data['post'] = [
            'user_id' => (int)$_POST['user_id'],
            'product_id' => (int)$product_id
        ];
        $order = new Order($data);
    }

    echo json_encode($_POST['user_id'], JSON_UNESCAPED_UNICODE);

} else {
    echo json_encode(false, JSON_UNESCAPED_UNICODE);
}



