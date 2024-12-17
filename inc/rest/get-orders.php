<?php

include '../inc.php';

if( isset($_POST) && isset( $_POST['user_id'] ) && isset($_POST['_nonce']) ) {
    $data = [];
    $user = new User( $_POST['user_id'] );
    $orders = $user->getOrders();

    $data['user'] = $user->getPost();
    $data['orders'] = $orders;

    header('Content-Type: application/json');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
}


