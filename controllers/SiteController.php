<?php
/**
 * 默认控制器
 */
class SiteController extends BaseController {
    public $layout = '/layouts/site';

    public function actionIndex() {
        $this->pageTitle = '';
        $this->render('index');
    }

    public function actionLogin() {
        $this->pageTitle = '登录';

        if ($this->isLogged()) {
            $this->success('你已经成功登录。');
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sid = $_POST['sid'];
            $pwd = $_POST['pwd'];

            if ($this->login($sid, $pwd)) {
                if (isset($_GET['returnUri']))
                    $this->redirect($_GET['returnUri']);
                else
                    $this->redirect(array('personal/archives'));
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

    public function actionAbout() {
        $this->render('about');
    }

    public function actionCompatibility() {
        $this->render('compatibility');
    }

}
