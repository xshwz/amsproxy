<?php
class SettingController extends ProxyController {
    public function actionUpdate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->student->archives = json_encode(
                $this->AmsProxy()->invoke('getArchives'));
            $this->student->course = null;
            $this->student->score = null;
            $this->student->rank_exam = null;
            $this->student->theory_subject = null;
            $this->student->save();

            $this->update();
            $this->success('<span class="glyphicon glyphicon-ok"></span> 更新数据成功');
        } else {
            $this->render('update');
        }
    }

    public function actionPassword() {
        $this->render('password');
    }
}
