<?php

setlocale(LC_ALL, 'ru_RU');

session_start();
//error_reporting(0);

define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('HOME', $_SERVER['REQUEST_URI']);

require_once ROOT . '/inc/db/index.php';
include_once ROOT . '/inc/classes/index.php';