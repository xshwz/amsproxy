<?php
class WechatController extends ProxyController {
    public function actionIndex() {
        $this->render('index');
    }

    public function actionBind() {
        $this->student->wechat_openid = $_GET['openId'];
        $this->student->save();
        $this->success('<span class="glyphicon glyphicon-ok"></span> 绑定成功');
    }

    public function actionUnbind() {
        $this->student->wechat_openid = null;
        $this->student->save();
        $this->success('<span class="glyphicon glyphicon-ok"></span> 解除绑定成功');
    }
}
