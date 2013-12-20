<?php
class ServerController extends WechatBaseController {
    public $openIdField = 'openid_server';

    public function getConfigFile() {
        return dirname(__FILE__) . '/server.json';
    }

    /*
    public function init() {
        parent::init();

        $feed = $this->createFeed('http://bbs.gxun.cn/forum.php?mod=rss&fid=131');
        print_r($this->createNews($feed->get_items()));
    }
    */

    /**
     * @param string $url
     */
    public function createFeed($url) {
        $feed = new SimplePie;
        $feed->set_feed_url($url);
        $feed->set_cache_location('../runtime/cache');
        $feed->set_cache_duration(600);
        $feed->init();
        return $feed;
    }

    /**
     * @param array $items
     * @param string $target
     * @return array
     */
    public function getItemsByCategory($items, $target) {
        $news = array();
        foreach ($items as $item) {
            foreach ($item->get_categories() as $category) {
                if (strpos($category->get_term(), $target) !== false) {
                    $news[] = $item;
                    break;
                }
            }
        }
        return $news;
    }

    /**
     * @param array $items
     * @return array
     */
    public function createNews($items) {
        $news = array();
        foreach ($items as $item) {
            $enclosure = $item->get_enclosure();
            if ($enclosure && isset($enclosure->link))
                $pictureUrl = ltrim($enclosure->link, '/?#');
            else
                $pictureUrl = null;

            $news[] = (object)array(
                'title' => html_entity_decode($item->get_title()),
                'url' => html_entity_decode($item->get_link()),
                'pictureUrl' => $pictureUrl,
            );
        }
        return $news;
    }

    public function responsePortal($catid) {
        $feed = $this->createFeed(
            'http://bbs.gxun.cn/portal.php?mod=rss&catid=' . $catid);
        $this->responseNews($this->createNews($feed->get_items(0, 10)));
    }

    public function getBBSNews($fid) {
        $feed = $this->createFeed(
            'http://bbs.gxun.cn/forum.php?mod=rss&fid=' . $fid);
        return $this->createNews($feed->get_items(0, 9));
    }

    public function responseBBS($param) {
        $this->responseNews(array_merge(
                array((object)array(
                    'title' => $param->title,
                    'pictureUrl' => $param->logo,
                    'url' => $param->url,
                )),
                $this->getBBSNews($param->fid)
            )
        );
    }
}
