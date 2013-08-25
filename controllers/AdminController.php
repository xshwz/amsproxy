<?php
/**
 * 后台管理控制器
 */
class AdminController extends CController {
    public $layout = '/admin/layout';

    /**
     * @var array 未读信息
     */
    public $unReadMsg = array();

    /**
     * @var string 密码
     */
    public $pwd = '123';

    public function init() {
        if ($_GET['r'] != 'admin/login') {
            if (isset($_SESSION['admin'])) {
                define('IS_ADMIN', true);

                /** 获取未读消息 */
                $this->unReadMsg = Message::model()->findAll(array(
                    'condition' => 'receiver=:receiver AND state=1',
                    'params' => array(':receiver' => 0),
                ));
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
        if (isset($_GET['keyword'])) {
            $criteria->addSearchCondition('info',
                str_replace('"', '%', json_encode($_GET['keyword'])),
                false);
        }
        $count = Student::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $this->render('student', array(
            'students' => Student::model()->findAll($criteria),
            'count' => $count,
            'pages' => $pages,
        ));
    }

    public function actionSend() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $message = new Message;
            $message->receiver = $_POST['receiver'];
            $message->sender = 0;
            $message->message = $_POST['message'];
            $message->time = date('Y-m-d H:i:s');
            $message->state = 1;
            $message->save();
        }
        $this->render('send');
    }

    public function actionFeedback() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $message = Message::model()->findByPk($_POST['id']);
            if (isset($_POST['state'])) $message->state = 0;
            else                        $message->state = 1;
            $message->save();

            /** 重新获取未读消息 */
            $this->unReadMsg = Message::model()->findAll(array(
                'condition' => 'receiver=:receiver AND state=1',
                'params' => array(':receiver' => 0),
            ));
        }

        $this->render('feedback', array(
            'messages' => Message::model()->findAll(array(
                'condition' => 'receiver=:receiver',
                'order' => 'time DESC',
                'params' => array(
                    ':receiver' => 0,
                ),
            )),
        ));
    }
}
