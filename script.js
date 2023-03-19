/**
 * Ajax-запрос для получения сокращённого URL
 *
 * @param {string} actionUrl - URL для отправки запроса.
 * @param {string} inputId - Идентификатор поля ввода для отображения результата.
 * @param {string} url - URL для сокращения.
 * @param {string} listUrlPath - Путь к файлу для хранения URL.
 * @param {number} length - Колличество символов после домена в сокращённом URL.
 *
 * @return {string} - Сокращённый URL или строка с описанием ошибки.
 */

async function requestShortUrl(actionUrl, inputId, url, listUrlPath, length) {

    let promise = await fetch(actionUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify({
            url: url,
            listUrlPath: listUrlPath,
            length: length,
        }),
    });
    if (promise.ok) {
        let cont = await promise.json();
        let el = document.getElementById(inputId);
        console.log(cont);
        el.value = cont.shortUrl;
    }
}