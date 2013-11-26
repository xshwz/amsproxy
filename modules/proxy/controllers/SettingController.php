<?php
class SettingController extends ProxyController {
    public function actionClear() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->student->archives = json_encode(
                $this->AmsProxy()->invoke('getArchives'));
            $this->student->course = null;
            $this->student->score = null;
            $this->student->rank_exam = null;
            $this->student->theory_subject = null;
            $this->student->save();
            $this->success('清除缓存成功');
        } else {
            $this->render('clear');
        }
    }

    public function actionPassword() {
        $this->render('password');
    }
}
