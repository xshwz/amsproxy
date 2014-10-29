<?php
class ApiController extends BaseController {
    public function actionLogin() {
        if ($this->isLogged()) {
            echo 'true';
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->login($_POST['sid'], $_POST['pwd'])) {
                echo 'true';
            } else {
                echo 'false';
            }
        } else {
            echo 'false';
        }
    }

    public function actionVcode() {
        $captcha = $this->AmsProxy()->getCaptcha();
        if (isset($_GET['base64']) && $_GET['base64']=='true') {
            echo base64_encode($captcha);
        }
        echo $captcha;
    }

    public function actionLogout() {
        session_destroy();
    }
}
