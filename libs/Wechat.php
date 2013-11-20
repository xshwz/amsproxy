<?php
class Wechat {
    /**
     * @var SimpleXMLElement
     */
    public $request;

    public function __construct() {
        $this->request = simplexml_load_string(file_get_contents('php://input'));
    }

    public function response($content) {
        echo "<xml>
            <ToUserName>{$this->request->FromUserName}</ToUserName>
            <FromUserName>{$this->request->ToUserName}</FromUserName>
            <CreateTime>" . time() . "</CreateTime>
            <MsgType>text</MsgType>
            <Content>{$content}</Content>
        </xml>";
    }
}
