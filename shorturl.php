<?php
spl_autoload_register(function ($class) {
    include $class . '.php';
});

use Actions\ActionUrl;

$objUrl = json_decode(file_get_contents("php://input"));
$actionUrl = new ActionUrl($objUrl->url, '', $objUrl->listUrlPath);
echo json_encode($actionUrl->findOrCreateShortUrl($objUrl->length));
die();