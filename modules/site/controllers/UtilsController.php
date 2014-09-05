<?php
class UtilsController extends BaseController {
    public function actionIndex() {
        $this->render('index');
    }

    public function actionCredits() {
        $this->render('credits');
    }
}
