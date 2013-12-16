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

    public function actionLogin() {
        if ($this->isLogged()) {
            $this->success(
                '你已经成功登录，' .
                CHtml::link('进入相思青果', array('/proxy')) .
                ' 或 ' .
                CHtml::link('注销', array('/proxy/home/logout'))
            );
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sid = $_POST['sid'];
            $pwd = $_POST['pwd'];

            if ($this->login($sid, $pwd)) {
                if (isset($_GET['returnUri']))
                    $this->redirect(str_replace(
                        '\\', '/', $_GET['returnUri']));
                else
                    $this->redirect(array('/proxy'));
            } else {
                $this->render('login', array(
                    'error' => true,
                    'sid' => $sid,
                ));
            }
        } else {
            $this->render('login');
        }
    }
}
