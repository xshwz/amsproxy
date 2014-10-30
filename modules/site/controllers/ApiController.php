<?php
class ApiController extends BaseController {
    public function actionLogin() {
        if ($this->isLogged()) {
            echo 'true';
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($error = $this->login($_POST['sid'], $_POST['pwd'], $_POST['vcode'])) {
                echo 'false';
            } else {
                echo 'true';
            }
        } else {
            echo 'false';
        }
    }

    public function actionVcode() {
        $captcha = $this->AmsProxy()->getCaptcha();
        if (! isset($_GET['type'])) $_GET['type'] = 'image';

        switch ($_GET['type']) {
        case 'image':
            echo $captcha;
            break;
        case 'base64':
            echo base64_encode($captcha);
            break;
        case 'html':
            echo '<img src="data:image/gif;base64,'.base64_encode($captcha).'"/>';
            break;
        }
    }

    public function actionLogout() {
        session_destroy();
    }
}
