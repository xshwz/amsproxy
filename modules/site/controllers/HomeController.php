<?php
class HomeController extends BaseController {
    public function actionIndex() {
        $this->layout = '/layouts/base';
        $this->render('index');
    }

    public function actionAbout() {
        $this->render('about');
    }

    public function actionFaq() {
        $this->render('faq');
    }

    public function actionApi() {
        $this->render('api');
    }
}
