<?php
class SettingController extends AdminController {
    public function actionIndex() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->setting->updateAll($_POST);
            $this->setting = Setting::model()->find();
        }

        $this->render('index');
    }
}
