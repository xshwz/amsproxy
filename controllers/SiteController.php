<?php
/**
 * 默认控制器
 */
class SiteController extends BaseController {
	public function actionIndex() {
		$this->render('index');
	}

    public function actionLogin() {
        if (defined('IS_LOGGED')) {
            $this->render('logged');
        }
        else {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $sid = $_POST['sid'];
                $pwd = $_POST['pwd'];

                /* 记住用户 */
                if (isset($_POST['remember']) && $_POST['remember'] == 'on')
                    $this->remember($sid, $pwd);

                try {
                    $this->login($sid, $pwd);
                } catch(Exception $e) {
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

    public function actionAbout() {
		$this->render('about');
    }

    public function actionCompatibility() {
		$this->render('compatibility');
    }

    /**
     * 保存学生到数据库
     * @param string $sid 学号
     * @param string $pwd 密码
     * @param string $studentInfo 学生信息
     * @return bool
     */
    public function saveStudent($sid, $pwd, $studentInfo) {
        $student = new Student;
        $student->sid = $sid;
        $student->pwd = md5($pwd);
        $student->info = json_encode($studentInfo);
        $student->save();
    }

    /**
     * 从数据库中获取学生
     * @param string $sid 学号
     * @return $mixed 如果学生存在返回model对象，否则返回null
     */
    public function getStudent($sid) {
        return Student::model()->findByPk($sid);
    }
}
