<?php
class ProxyController extends BaseController {
    /**
     * @var Student
     */
    public $student;

    /**
     * @var array
     */
    public $fields = array(
        // 'archives',
        'score',
        // 'course',
        // 'exam_arrangement',
        // 'rank_exam',
        // 'theory_subject',
    );

    public function init() {
        parent::init();

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

            if ($error = $this->login($sid, $pwd, $_POST['captcha'])) {
                $this->render('/common/login', array(
                    'error'   => $error,
                    'sid'     => $sid,
                    'captcha' => base64_encode(
                        $this->AmsProxy()->getCaptcha())
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('/common/login', array(
                'captcha' => base64_encode(
                    $this->AmsProxy()->getCaptcha())
            ));

            Yii::app()->end();
        }
    }

    /**
     * @return array
     */
    public function getUnreadMessage() {
        return Message::unread($_SESSION['student']['sid']);
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
            // $this->AmsProxy()->invoke('getScore', 0),
            // $this->AmsProxy()->invoke('getScore', 1),
            $this->AmsProxy()->invoke(
                'getScoreAffirm', $this->get('archives')->{'入学年份'}),
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
