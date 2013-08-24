<?php
/**
 * 后台管理控制器
 */
class AdminController extends CController {
    public $layout = '/admin/layout';
    public $pwd = 'xsh@1970';

    public function init() {
        if ($_GET['r'] != 'admin/login') {
            if (isset($_SESSION['admin'])) {
                define('IS_ADMIN', true);
            } else {
                $this->redirect(array('admin/login'));
            }
        }
    }

	public function actionIndex() {
        $this->render('index');
    }

    public function actionLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST['pwd'] == $this->pwd) {
                $_SESSION['admin'] = true;
                $this->redirect(array('admin/index'));
            } else {
                $this->render('login', array('error' => true));
            }
        } else {
            $this->render('login');
        }
    }

    public function actionLogout() {
        session_destroy();
        $this->redirect(array('admin/login'));
    }

    public function actionStudent() {
        $criteria = new CDbCriteria();
        $pages = new CPagination(Student::model()->count($criteria));
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $this->render('student', array(
            'students' => Student::model()->findAll($criteria),
            'pages' => $pages,
        ));
    }
}
