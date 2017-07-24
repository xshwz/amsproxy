<?php
class HomeController extends ProxyController {
    public function actionIndex() {
        $this->render('index', array(
            ));//'examArrangement' => $this->get('exam_arrangement')
    }

    public function actionLogin() {
        echo 'true';
    }

    public function actionRefreshThis() {
        // $this->update($this->fields,$this->fileFields,true);
        if(isset($_GET['field']) && in_array($_GET['field'],$this->fields)){
            $field = $_GET['field'];
        }
        if(isset($_GET['fileField']) && in_array($_GET['fileField'],$this->fileFields)){
            $fileField = $_GET['fileField'];
        }
        if(isset($_GET['commonField']) && in_array($_GET['commonField'],$this->commonFields)){
            $commonField = $_GET['commonField'];
        }
        $field = (isset($field)) ? array($field) : array();
        $fileField = (isset($fileField)) ? array($fileField) : array();
        $commonField = (isset($commonField)) ? array($commonField) : array();
        // 打补丁咯
        if(isset($fileField[0]) && $fileField[0] == 'score')
            $fileField[] = 'scoreMinor';
        
        $this->update(array(
            'fields'=>$field,
            'fileFields'=>$fileField,
            'commonFields'=>$commonField,
            'force'=>true
        ));
        //从哪里来到哪里去,所以要用到referener
        $this->redirect($_SERVER['HTTP_REFERER'].'?refreshed=true');
    }

    public function actionLogout() {
        // session_destroy();
        // $_SESSION['student'] = null;//两个都可以
        unset($_SESSION['student']);
        $this->redirect(array('/proxy'));
    }

    public function actionFeedback() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (trim($_POST['message'])) {
                Message::send(
                    $_SESSION['student']['sid'], 0, $_POST['message']);
                $this->alert = array(
                    'type' => 'success',
                    'message' => '感谢你的反馈，我们会尽快处理并给你答复的。',
                );
            } else {
                $this->alert = array(
                    'type' => 'danger',
                    'message' => '请填写反馈内容',
                );
            }
        }

        $this->render('feedback');
    }

    public function actionMessage() {
        Message::model()->updateAll(
            array('state' => 0),
            'receiver=:receiver',
            array(
                ':receiver' => $_SESSION['student']['sid'],
            )
        );

        $this->unread = array();
        $this->render('message', array(
            'messages' => Message::model()->findAll(array(
                'condition' => 'receiver=:sid OR sender=:sid',
                'order' => 'time DESC',
                'params' => array(
                    ':sid' => $_SESSION['student']['sid'],
                ),
            )),
        ));
    }
    public function actionTest(){
        if($this->getAuthToUpdate())
            var_dump($this->AmsProxy()->GET('znpk/Pri_StuSel.aspx'));
    }
    public function actionAbout(){
        $this->render('about', array());
    }
}
