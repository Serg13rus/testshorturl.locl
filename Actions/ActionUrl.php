<?php

namespace Actions;

class ActionUrl
{
    /**
     * URL без сокращения
     */
    private string $url = '';

    /**
     * Сокращённый URL
     */
    private string $shortUrl = '';

    /**
     * Путь к файлу для хранения URL
     */
    private string $listUrlPath = '';

    /**
     * ActionUrl constructor.
     *
     * @param string $url - URL без сокращения.
     * @param string $shortUrl - Сокращённый URL.
     * @param string $listUrlPath - Путь к файлу для хранения URL.
     *
     * @since 2023-03-19
     */
    function __construct(string $url, string $shortUrl, string $listUrlPath)
    {
        $this->url = $url;
        $this->shortUrl = $shortUrl;
        $this->listUrlPath = $listUrlPath;
    }

    /**
     * Закрытый метод для проверки валидности URL без сокращения.
     *
     * @return bool
     */
    private function _checkUrl()
    {
        if (filter_var($this->url, FILTER_VALIDATE_URL)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Закрытый метод для проверки сокращённого URL.
     *
     * @param string $shortUrl - сокращённый URL.
     *
     * @return bool
     */
    private function _checkShortUrl($shortUrl)
    {
        $data = file_get_contents($this->listUrlPath);
        if ($data) {
            $objUrl = json_decode($data, true);
            foreach ($objUrl as $val) {
                if ($val == $shortUrl) {
                    return false;
                }
            }
        } else {
            return true;
        }
        return true;
    }

    /**
     * Закрытый метод для генерации сокращённого URL.
     *
     * Устанавливает значение закрытому свойству класса "shortUrl"
     */
    private function _generateUrl($length)
    {
        $out = "";
        $chars = array_merge(range("a", "z"), range("A", "Z"));
        while (strlen($out) < $length) {
            $rand = rand(0, count($chars) - 1);
            $out .= $chars[$rand];
            unset($chars[$rand]);
        }
        $this->shortUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/' . $out;
    }

    /**
     * Общедоступный метод для поиска или создания сокращённого URL.
     *
     * @param int $length - Колличество символов после домена в сокращённом URL
     *
     * @return array - Ассоциативный массив с единственным элементом ['shortUrl' => 'сокращённая ссылка']
     */
    public function findOrCreateShortUrl($length)
    {
        if (!$this->_checkUrl()) {
            $this->url = '';
            return [
                'shortUrl' => 'Введён не корректный URL',
            ];
        }

        $data = file_get_contents($this->listUrlPath);
        if ($data) {
            $objUrl = json_decode($data, true);
        } else {
            $objUrl = [];
        }

        if ($objUrl[$this->url]) {
            $this->shortUrl = $objUrl[$this->url];
        } else {
            $this->_generateUrl($length);
            if (!$this->_checkShortUrl($this->shortUrl)) {
                $this->_generateUrl($length);
            }
            $objUrl[$this->url] = $this->shortUrl;
        }

        $data = json_encode($objUrl);
        file_put_contents($this->listUrlPath, $data);

        return [
            'shortUrl' => $this->shortUrl,
        ];
    }

    /**
     * Общедоступный метод для получения URL без сокращения.
     *
     * @return string - URL без сокращения
     */
    public function getFullUrl()
    {
        $objUrl = json_decode(file_get_contents($this->listUrlPath));
        foreach ($objUrl as $key => $val) {
            if ($val == $this->shortUrl) {
                $this->url = $key;
            }
        }
        return $this->url;
    }

}