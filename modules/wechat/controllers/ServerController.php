<?php
class ServerController extends WechatBaseController {
    public $openIdField = 'openid_server';

    /**
     * @var SimplePie
     */
    public $feed;

    public function init() {
        parent::init();

        $this->feed = new SimplePie;
        $this->feed->set_feed_url('http://feed.feedsky.com/aqee-net');
        $this->feed->set_cache_location('../runtime/cache');
        $this->feed->init();
    }

    public function getConfigFile() {
        return dirname(__FILE__) . '/server.json';
    }
}
