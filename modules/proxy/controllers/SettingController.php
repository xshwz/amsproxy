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
            $this->student->exam_arrangement = null;
            $this->student->save();

            $this->update();
            $this->success('<span class="glyphicon glyphicon-ok"></span> 更新数据成功');
        } else {
            $this->render('update');
        }
    }

    public function actionPassword() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST['origin-password'] != $_SESSION['student']['pwd']) {
                $this->render('password', array(
                    'error' => '原始密码错误'
                ));
            } elseif ($_POST['new-password'] != $_POST['new-password-t']) {
                $this->render('password', array(
                    'error' => '两次输入的密码不相同'
                ));
            } elseif ($_POST['origin-password'] == $_POST['new-password']) {
                $this->render('password', array(
                    'error' => '密码没有改变'
                ));
            } else {
                $this->AmsProxy()->invoke('ChangePassword', array(
                    'oldpwd' => $_POST['origin-password'],
                    'newpwd' => $_POST['new-password'],
                ));
                $login_url = $this->createUrl('/site/home/login');
                $this->render('/common/alert', array(
                    'type' => 'success',
                    'message' => "修改成功, 3秒后自动退出
                        <a href='{$login_url}'>重新登陆</a>",
                ));
                session_destroy();
                echo CHtml::script(
                    "setTimeout(\"window.location.href='{$login_url}'\", 3000)");
            }
        } else {
            $this->render('password');
        }
    }
}
