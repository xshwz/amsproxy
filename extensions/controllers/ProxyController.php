<?php
class ProxyController extends BaseController {
    /**
     * @var Student
     */
    public $student;

    /**
     * @var AmsProxy
     */
    public $amsProxy;

    /**
     * @var array
     */
    public $fields = array(
        'archives',
        'score',
        'course',
        'exam_arrangement',
        'rank_exam',
        'theory_subject',
    );

    public function init() {
        parent::init();
        $this->checkSession();

        if (!$this->isLogged())
            $this->notLoggedHandler();

        $this->student = Student::model()->findByPk(
            $_SESSION['student']['sid']);

        $this->unread = $this->getUnreadMessage();
        $this->update();
    }

    public function checkSession() {
        if (!isset($_SESSION['session'])) {
            if (isset($_COOKIE['session'])) {
                $_SESSION['session'] = $_COOKIE['session'];
            } else {
                setcookie(
                    'session', $this->AmsProxy()->getSession(),
                    time() + 4 * 365 * 24 * 60 * 60, '/');
            }
        }
    }

    public function notLoggedHandler() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $sid = $_POST['sid'];
            $pwd = $_POST['pwd'];

            if ($result = $this->AmsProxy()->_login($sid, $pwd)) {
                $this->render('/common/login', array(
                    'error'   => $result,
                    'sid'     => $sid,
                ));

                Yii::app()->end();
            } else {
                $this->saveStudent();
                $this->updateStudentLastLoginTime(
                    Student::model()->findByPk($sid));
                $_SESSION['student'] = array(
                    'sid'     => $sid,
                    'pwd'     => $pwd,
                    'isAdmin' => $this->isAdmin($sid),
                );
            }
        } else {
            $this->render('/common/login');
            Yii::app()->end();
        }
    }

    public function saveStudent() {
        if (Student::model()->findByPk($this->AmsProxy()->sid) == null) {
            $student = new Student;
            $student->sid = $this->AmsProxy()->sid;
            $student->archives = json_encode($this->get_archives());
            $student->save();
        }
    }

    /**
     * @param Student $student
     */
    public function updateStudentLastLoginTime($student) {
        $student->last_login_time = date('Y-m-d H:i:s');
        $student->save();
    }

    /**
     * @return array
     */
    public function getUnreadMessage() {
        return Message::unread($_SESSION['student']['sid']);
    }

    /**
     * @return AmsProxy
     */
    public function AmsProxy() {
        if ($this->amsProxy == null) {
            if (isset($_SESSION['session']))
                $this->amsProxy = new AmsProxy($_SESSION['session']);
            else
                $this->amsProxy = new AmsProxy;
        }

        return $this->amsProxy;
    }

    /**
     * @return array
     */
    public function get_archives() {
        return array_merge(
            $this->AmsProxy()->invoke('getArchives'),
            $this->AmsProxy()->invoke('getArchivesEx')
        );
    }

    /**
     * @return array
     */
    public function get_score() {
        return array(
            $this->AmsProxy()->invoke('getScore', 0),
            $this->AmsProxy()->invoke('getScore', 1),
        );
    }

    /**
     * @return array
     */
    public function get_course() {
        return array_merge(
            $this->AmsProxy()->invoke('getPersonalCourse'),
            $this->AmsProxy()->invoke(
                'getClassCourse', $this->get('archives')->{'行政班级'}));
    }

    /**
     * @return array
     */
    public function get_rank_exam() {
        return array(
            'score' => $this->AmsProxy()->invoke('getRankExamScore'),
        );
    }

    /**
     * @return array
     */
    public function get_theory_subject() {
        return $this->AmsProxy()->invoke('getTheorySubject');
    }

    /**
     * @return array
     */
    public function get_exam_arrangement() {
        return $this->AmsProxy()->invoke('getExamArrangement');
    }

    /**
     * @param bool $force
     */
    public function update($force=false) {
        foreach ($this->fields as $field)
            if ($force || !$this->student->{$field})
                 $this->updateItem($field);
    }

    /**
     * @param string $field
     */
    public function updateItem($field) {
        $this->student->{$field} = json_encode($this->{'get_' . $field}());
        $this->student->save();
    }

    /**
     * @param string $field
     * @param bool $json_encode
     * @return mixed
     */
    public function get($field, $json_encode=true) {
        if ($json_encode)
            return json_decode($this->student->{$field});
        else
            return $this->student->{$field};
    }
}
