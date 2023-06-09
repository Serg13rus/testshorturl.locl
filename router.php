<?php
spl_autoload_register(function ($class) {
    $str = $class . '.php';
    $loadPath = str_replace("\\", "/", $str);
    require_once $loadPath;
});

use Actions\ActionUrl;

$shortUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$actionUrl = new ActionUrl('', $shortUrl, 'urlrewrite.php');
$url = $actionUrl->getFullUrl();

?>
<?php if ($url): ?>
<?php
    header('Location:' . $url);
    die();
?>
<?php else: ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Редирект</title>
    </head>
    <body>

    <h1>Сокращённый URL не найден</h1>

    </body>
    </html>
<?php endif; ?>