<?php
class ServerController extends WechatBaseController {
    public $openIdField = 'openid_server';

    public function getConfigFile() {
        return dirname(__FILE__) . '/server.json';
    }
}
