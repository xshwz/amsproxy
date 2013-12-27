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
        'score',
        'course',
        'exam_arrangement',
        'rank_exam',
        'archives',
        'theory_subject',
    );

    public function init() {
        parent::init();

        if (!$this->isLogged() && !$this->tryLoginFromCookie())
            $this->notLoggedHandler();

        $this->student = Student::model()->findByPk(
            $_SESSION['student']['sid']);

        $this->unread = $this->getUnreadMessage();
        $this->update();
    }

    public function notLoggedHandler() {
        $this->destroyRemember();

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $sid = $_POST['sid'];
            $pwd = $_POST['pwd'];

            if (!$this->login($sid, $pwd)) {
                $this->render('/common/login', array(
                    'error' => true,
                    'sid' => $sid,
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('/common/login');
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
     * @return bool
     */
    public function tryLoginFromCookie() {
        if (isset($_COOKIE['sid']) && isset($_COOKIE['pwd'])) {
            $sid = $this->decrypt($_COOKIE['sid']);
            $pwd = $this->decrypt($_COOKIE['pwd']);

            return $this->login($sid, $pwd);
        } else {
            return false;
        }
    }

    /**
     * @return AmsProxy
     */
    public function AmsProxy() {
        if ($this->amsProxy == null) {
            $this->amsProxy = new AmsProxy(array(
                'sid'     => $_SESSION['student']['sid'],
                'pwd'     => $_SESSION['student']['pwd'],
                'session' => $_SESSION['student']['session'],
            ));
        }

        return $this->amsProxy;
    }

    /**
     * @return array
     */
    public function get_archives() {
        return $this->AmsProxy()->invoke('getArchives');
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
