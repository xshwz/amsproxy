<?php
class WechatController extends BaseController {
    /**
     * @var Student
     */
    public $student;

    /**
     * @var Wechat
     */
    public $wechat;

    /**
     * @var object
     */
    public $request;

    public function __construct() {
        Yii::import('application.libs.Wechat');
        $this->wechat = new Wechat();
        $this->request = $this->wechat->request;

        if (isset($_GET['echostr'])) {
            echo $_GET['echostr'];
            Yii::app()->end();
        }
    }

    public function actionIndex() {
        if (substr($this->request->Content, 0, 1) == '/')
            $this->commandHandler();
        else
            $this->defaultHandler();
    }

    public function commandHandler() {
        $this->student = Student::model()->find('wechat=:wechat',
            array(':wechat' => $this->request->FromUserName));

        if ($this->student) {
            ;
        } else {
            $this->unbind();
        }
    }

    public function defaultHandler() {}

    /**
     * 未绑定处理
     */
    public function unbind() {
        $this->wechat->response('你还未绑定');
    }

    /**
     * @return string
     */
    public function getBindUrl() {
        return 'http://xsh.gxun.edu.cn/' . $this->createUrl(
            'proxy/setting/wechat',
            array(
                'operate' => 'bind',
                'openId' => $this->request->FromUserName,
            ),
            '&amp;'
        );
    }
}
