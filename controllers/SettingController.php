<?php
/**
 *  设置控制器
 */
class SettingController extends StudentController {
    public function actionClear() {
        $this->pageTitle = '清除缓存';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->student->info = json_encode($this->getAmsProxy()->getStudentInfo());
            $this->student->course = null;
            $this->student->score = null;
            $this->student->rankExam = null;
            $this->student->theorySubject = null;
            $this->student->save();
            $this->success('清除缓存成功');
        } else {
            $this->render('clear');
        }
    }

    public function actionWechat() {
        $this->render('wechat');
    }
}
