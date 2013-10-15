<?php
/**
 *  设置控制器
 */
class SettingController extends StudentController {
    public function actionClear() {
        $this->pageTitle = '清除缓存';
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

    public function actionWechat() {
        $this->pageTitle = '微信公众平台';

        if (isset($_GET['operate'])) {
            switch ($_GET['operate']) {
                case 'unbind':
                    $this->student->wechat = null;
                    $message = '解除绑定成功';
                    break;

                case 'bind':
                    $this->student->wechat = $_GET['openId'];
                    $message = '绑定成功';
                    break;
            }

            $this->student->save();
            $this->success($message);
            return;
        }

        $this->render('wechat');
    }

    public function actionPassword() {
        $this->pageTitle = '修改密码';
        $this->render('password');
    }

    public function actionUnbind() {
        $this->redirect(array('setting/wechat'));
    }
}
