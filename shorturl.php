<?php
spl_autoload_register(function ($class) {
    $str = $class . '.php';
    $loadPath = str_replace("\\", "/", $str);
    require_once $loadPath;
});

use Actions\ActionUrl;

$objUrl = json_decode(file_get_contents("php://input"));
$actionUrl = new ActionUrl($objUrl->url, '', $objUrl->listUrlPath);
echo json_encode($actionUrl->findOrCreateShortUrl($objUrl->length));
die();