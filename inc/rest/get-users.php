<?php

include '../inc.php';

if( isset($_POST) && isset($_POST['_nonce'])) {
    header('Content-Type: application/json');
    $users = (new Users())->getPosts();
    $users_array = [];
    foreach ($users as $user) {
        $users_array[] = $user->getPost();
    }
    echo json_encode($users_array, JSON_UNESCAPED_UNICODE);
}



