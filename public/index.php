<?php
require_once '../app/config/config.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$validPages = ['home', 'about', 'contact', 'login', 'register'];

if (!in_array($page, $validPages)) {
    $page = 'home';
}

$pagePath = PAGE_PATH . "/{$page}.php";

if (!file_exists($pagePath)) {
    header("HTTP/1.0 404 Not Found");
    $page = '404';
    $pagePath = PAGE_PATH . "/404.php";
}

include_once LAYOUT_PATH . '/header.php';
include_once $pagePath;
include_once LAYOUT_PATH . '/footer.php';
