<?php
class __base__ {
    public static $weekDict = array(
        '一' => 1,
        '二' => 2,
        '三' => 3,
        '四' => 4,
        '五' => 5,
        '六' => 6,
        '日' => 7,
    );

    public function __construct($amsProxy, $args) {
        $this->amsProxy = $amsProxy;
        $this->args = $args;
    }

    /**
     * @return mixed
     */
    public function run() {
        $data = $this->getData();
        $data = $this->htmlFinishing($data);
        return $this->parse($this->dom($data));
    }

    /**
     * @param string $html
     * @return string
     */
    public function htmlFinishing($html) {
        $html = str_replace('<br>', '', $html);
        $html = str_replace('&nbsp;', '', $html);
        $html = '
            <meta
                http-equiv="Content-Type"
                content="text/html; charset=utf-8">' . $html;
        return $html;
    }

    /**
     * @param string $html
     * @return DOMDocument
     */
    public function dom($html) {
        $error_reporting_level = error_reporting();
        error_reporting(0);

        $dom = new DOMDocument;
        $dom->loadHTML($html);

        error_reporting($error_reporting_level);
        return $dom;
    }

    /**
     * @param string $string
     * @return string
     */
    public function strip($string) {
        return str_replace(' ', '', $string);
    }

    /**
     * @return string
     */
    public function getData() {}

    /**
     * @param mixed $data
     * @return array
     */
    public function parse($data) {}

    /**
     * TODO: auto calculate or get
     *
     * @return string
     */
    public function getXNXQ() {
        return '20130';
    }
}
