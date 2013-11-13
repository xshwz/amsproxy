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

    public function init() {
        parent::init();

        if (!$this->isLogged() && !$this->tryLoginFromCookie()) {
            $this->destroyRemember();
            $this->redirect(array(
                '/site/home/login',
                'returnUri' => Yii::app()->request->requestUri,
            ));
        }

        $this->student = Student::model()->findByPk(
            $_SESSION['student']['sid']);
        $this->student->last_login_time = date('Y-m-d H:i:s');
        $this->student->save();

        $this->unread = $this->getUnreadMessage();
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
     * @param int $scoreType 0、原始成绩；1、有效成绩
     * @return array
     */
    public function getScore($scoreType=1) {
        if ($this->student->score) {
            $score = json_decode($this->student->score, true);
        } else {
            $score = array(
                $this->AmsProxy()->invoke('getScore', 0),
                $this->AmsProxy()->invoke('getScore', 1),
            );

            $this->student->score = json_encode($score);
            $this->student->save();
        }

        return $score[$scoreType];
    }

    /**
     * @return array
     */
    public function getCourse() {
        if ($this->student->course) {
            return json_decode($this->student->course, true);
        } else {
            $archives = (array)$this->student->getArchives();
            $courses = array_merge(
                $this->AmsProxy()->invoke('getPersonalCourse'),
                $this->AmsProxy()->invoke(
                    'getClassCourse', $archives['行政班级']));
            $this->student->course = json_encode($courses);
            $this->student->save();

            return $courses;
        }
    }

    /**
     * @return array
     */
    public function getRankExam() {
        if ($this->student->rank_exam) {
            $rankExam = json_decode($this->student->rank_exam, true);
        } else {
            $rankExam = array(
                'form'  => $this->AmsProxy()->invoke('getRankExamForm'),
                'score' => $this->AmsProxy()->invoke('getRankExamScore'),
            );

            $this->student->rank_exam = json_encode($rankExam);
            $this->student->save();
        }

        return $rankExam;
    }

    /**
     * @return array
     */
    public function getTheorySubject() {
        if ($this->student->theory_subject) {
            return json_decode($this->student->theory_subject, true);
        } else {
            $theorySubject = $this->AmsProxy()->invoke('getTheorySubject');
            $this->student->theory_subject = json_encode($theorySubject);
            $this->student->save();
            return $theorySubject;
        }
    }
}
