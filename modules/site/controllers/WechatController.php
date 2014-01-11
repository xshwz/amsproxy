<?php
class WechatController extends BaseController {
    /**
     * @var Student
     */
    public $student;

    /**
     * @var Wechat
     */
    public $wechat;

    /**
     * @var object
     */
    public $request;

    /**
     * @var string
     */
    public $layout = '/layouts/wechat';

    public function init() {
        parent::init();

        if (isset($_GET['openId'])) {
            $this->student = Student::model()->find(
                $_GET['field'] . '=:openId',
                array(
                    ':openId' => $_GET['openId'],
                )
            );
        }
    }

    public function actionIndex() {
        $this->layout = '/layouts/main';
        $this->render('index');
    }

    public function actionWeekCourse() {
        $this->render('weekCourse', array(
            'courses' => json_decode($this->student->course),
            'wday' => isset($_GET['wday']) ? (int)$_GET['wday'] : (int)date('N'),
        ));
    }

    public function actionCurriculum() {
        $this->render('curriculum', array(
            'courses' => json_decode($this->student->course),
        ));
    }

    public function actionArchives() {
        $this->render('archives', array(
            'archives' => json_decode($this->student->archives),
        ));
    }

    public function actionRankExam() {
        $this->render('rankExamScore', array(
            'rankExamScore' => json_decode($this->student->rank_exam)->score,
        ));
    }

    public function actionScore() {
        $scoreType = isset($_GET['scoreType']) ? (int)$_GET['scoreType'] : 0; 
        $scoreTable = json_decode($this->student->score);
        $scoreTable = $scoreTable[$scoreType];
        $fields = array(10, 6);

        foreach ($scoreTable->tbody as $termName => &$termScore) {
            foreach ($termScore as &$row) {
                if ((float)$row[$fields[$scoreType]] < 60)
                    $row['state'] = false;
                else
                    $row['state'] = true;
            }
        }

        $this->render('score', array('score' => $scoreTable));
    }
}
