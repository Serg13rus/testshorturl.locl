<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ShortURL</title>
    <script src="script.js"></script>
</head>
<body>

<fieldset>
    <legend>Получить короткий URL</legend>
    <br>
    <label for="url">Введите оригинальный URL<em>* </em> </label><br>
    <input type="text" id="url" size="100"><br><br><br>
    <label for="shortUrl">Короткий URL</label><br>
    <input type="text" id="shortUrl" size="100"><br><br>
</fieldset>

<p><input type="submit" value="Получить короткий URL"
          onclick="requestShortUrl('shorturl.php', 'shortUrl', document.getElementById('url').value, 'urlrewrite.php', 5)"></p>
</body>
</html>