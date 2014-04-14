<?php
class WechatController extends BaseController {
  public function actionIndex() {
    $this->pageTitle = '微信';
    $this->render('index');
  }
}
