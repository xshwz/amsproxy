<?php
class WechatController extends BaseController {
    public function actionIndex() {
        echo file_get_contents('php://input');
    }
}
