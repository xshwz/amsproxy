<?php
class SubscriptionController extends BaseWechatController {
    public function getConfigFile() {
        return dirname(__FILE__) . '/subscription.json';
    }
}
