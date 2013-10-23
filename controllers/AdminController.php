<?php
/**
 * 后台管理控制器
 */
class AdminController extends CController {
    public $layout = '/layouts/admin';

    /**
     * @var string
     */
    public $pageTitle = '';

    /**
     * @var array 未读消息
     */
    public $unread = array();

    /**
     * @var Setting 设置信息
     */
    public $setting;

    public function init() {
        $this->setting = Setting::model()->find();

        if ($_GET['r'] != 'admin/login') {
            if (isset($_SESSION['admin'])) {
                define('IS_ADMIN', true);
                $this->unread = Message::unread(0);
            } else {
                $this->redirect(array('admin/login'));
            }
        }
    }

	public function actionIndex() {
        $this->render('index');
    }

    public function actionLogin() {
        $this->pageTitle = '登录';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST['pwd'] == $this->setting->password) {
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
        $this->pageTitle = '学生';

        $criteria = new CDbCriteria();

        if (isset($_GET['keyword'])) {
            $criteria->addSearchCondition('archives',
                str_replace('"', '%', json_encode($_GET['keyword'])),
                false);
        }

        $criteria->order = 'last_login_time DESC';

        $count = Student::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = isset($_GET['pages']) ? (int)$_GET['pages'] : 20;
        $pages->applyLimit($criteria);
        $this->render('student', array(
            'students' => Student::model()->findAll($criteria),
            'count' => $count,
            'pages' => $pages,
        ));
    }

    public function actionSend() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Message::send(0, $_POST['receiver'], $_POST['message']);

            if (isset($_POST['reply'])) {
                $message = Message::model()->findByPk($_POST['reply']);

                if ($message->state)
                    $message->state = 0;

                $message->save();
            }
        } else {
            $this->render('send');
        }
    }

    public function actionFeedback() {
        $this->pageTitle = '反馈';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $message = Message::model()->findByPk($_POST['id']);

            if (isset($_POST['state']))
                $message->state = 0;
            else
                $message->state = 1;

            $message->save();

            /** 重新获取未读消息 */
            $this->unread = Message::unread(0);
        }

        $_messages = Message::model()->findAll(array(
            'order' => 'time DESC',
        ));

        foreach ($_messages as $message) {
            if ($message->sender == 0 && $message->receiver != 0) {
                $messages[$message->receiver]['sender'] = $message->_receiver;
                $messages[$message->receiver]['session'][] = $message;
            }

            if ($message->sender != 0 && $message->receiver == 0) {
                $messages[$message->sender]['sender'] = $message->_sender;
                $messages[$message->sender]['session'][] = $message;
            }
        }

        $this->render('feedback', array('messages' => $messages));
    }

    public function actionSetting() {
        $this->pageTitle = '设置';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->setting->updateAll($_POST);
            $this->setting = Setting::model()->find();
        }

        $this->render('setting');
    }

    public function actionStats() {
        $this->pageTitle = '统计';

        $stats = array(
            'gender' => array(
                '男' => 0,
                '女' => 0,
            ),
            'college' => array(),
            'grade' => array(),
            'nation' => array(),
        );

        foreach (Student::model()->findAll() as $student) {
            $archives = (array)$student->getArchives();
            $college = $archives['院(系)/部'];
            $discipline = $archives['专业'];
            $grade = $archives['入学年份'];
            $nation = isset($archives['民族']) ? $archives['民族'] : null;

            $stats['gender'][$archives['性别']]++;

            /** 年级统计 */
            if (array_key_exists($grade, $stats['grade']))
                $stats['grade'][$grade]++;
            else
                $stats['grade'][$grade] = 1;

            /** 民族统计 */
            if ($nation) {
                if (array_key_exists($nation, $stats['nation']))
                    $stats['nation'][$nation]++;
                else
                    $stats['nation'][$nation] = 1;
            }

            /** 学院、专业，统计 */
            if (array_key_exists($college, $stats['college'])) {
                $stats['college'][$college]['count']++;
                if (array_key_exists(
                    $discipline, $stats['college'][$college]['discipline'])) {

                    $stats['college'][$college]['discipline'][$discipline]++;
                } else {
                    $stats['college'][$college]['discipline'][$discipline] = 0;
                }
            } else {
                $stats['college'][$college] = array(
                    'count' => 1,
                    'discipline' => array(),
                );
            }
        }

        $this->render('stats', array(
            'stats' => $stats,
        ));
    }
}
