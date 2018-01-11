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
        if ($data !== false)
            return $this->parse($this->createDom($data),$data);
        else
            return array();
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
    public function createDom($html) {
        $dom = new DOMDocument;
        @$dom->loadHTML($this->htmlFinishing($html));
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
    //public function parse($data,$raw) {}

    /**
     * 2015.1 ~ 2015.2
     *  get 20140
     * 2015.3 ~ 2015.7
     *  get 20141
     * 2015.8 ~ 2015.12
     *  get 20150
     * @return string
     */
    public function getXNXQ() {
        return $this->getXN() . $this->getXQ();
    }
    public function getXN() {
        $month = (int) date('m');
        $year = (int) date('Y');
        $day = (int) date('d');
        if ($month < 7)
            $year -= 1;
        return $year;
    }
    public function getXQ() {
        $month = (int) date('m');
        $day = (int) date('d');
        return ( $month <= 2 || ($month >= 6) ) ? '0' : '1';
    }
    public function lastXN(){
        return (!$this->lastXQ())? $this->getXN() : $this->getXN() -1;
    }
    public function lastXQ(){
        return ($this->getXQ()) ? 0 : 1 ;
    }
}
