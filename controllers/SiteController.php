<?php
/**
 * 默认控制器
 */
class SiteController extends BaseController {
    public $layout = '/layouts/site-default';

    public function actionIndex() {
        $this->layout = '/site/index';
        $this->pageTitle = '';
        $this->render('index');
    }

    public function actionLogin() {
        $this->pageTitle = '登录';

        if ($this->isLogged()) {
            $this->redirect(array('site/index'));
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

    public function actionAjaxLogin() {
        $sid = $_POST['sid'];
        $pwd = $_POST['pwd'];

        if ($this->login($sid, $pwd))
            echo '1';
        else
            echo '0';
    }

    public function actionAbout() {
        $this->pageTitle = '关于';
        $this->render('about');
    }

    public function actionFAQ() {
        $this->pageTitle = 'FAQ';
        $this->render('FAQ');
    }

    public function actionAPI() {
        $this->pageTitle = 'API';
        $this->render('api');
    }

    public function actionCompatibility() {
        $this->pageTitle = '浏览器兼容性';
        $this->render('compatibility');
    }
}
