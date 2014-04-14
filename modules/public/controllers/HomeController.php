<?php
class HomeController extends BaseController {
  public function actionIndex() {
    $this->pageTitle = '首页';
    $this->layout = '/layouts/base';
    $this->render('index');
  }

  public function actionAbout() {
    $this->pageTitle = '关于';
    $this->render('about');
  }

  public function actionFaq() {
    $this->pageTitle = '常见问题';
    $this->render('faq');
  }

  public function actionApi() {
    $this->pageTitle = 'API';
    $this->render('api');
  }
}
