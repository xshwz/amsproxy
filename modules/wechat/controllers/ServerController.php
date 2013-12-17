<?php
class ServerController extends BaseWechatController {
    public function getConfigFile() {
        return dirname(__FILE__) . '/server.json';
    }
}
