<?php
class SubscribeController extends WechatBaseController {
    public $openIdField = 'openid_subscribe';

    public function getConfigFile() {
        return dirname(__FILE__) . '/subscribe.json';
    }
}
