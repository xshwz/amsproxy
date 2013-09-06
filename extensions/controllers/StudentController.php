<?php

/**
 * 基控制器，需要登录验证，要进行学生相关操作请继承该控制器
 */
class StudentController extends BaseController {
    /**
     * 教务系统代理对象
     * @var AmsProxy
     */
    public $amsProxy;

    public function init() {
        parent::init();

        if (!$this->isLogged()) {
            $this->redirect(array('site/login'));
        }
    }

    /**
     * 先尝试从数据库中读取，如果数据库中没有数据，则从教务系统获取
     * 获取的数据会保存到数据库
     * @param int $scoreType 0、原始成绩 1、有效成绩 2、等级考试成绩
     * @return array 成绩表
     */
    public function getScore($scoreType=0) {
        if ($this->student->score) {
            $score = json_decode($this->student->score, true);
        }
        else {
            $score = array(
                $this->getAmsProxy()->getScore(0),
                $this->getAmsProxy()->getScore(1),
            );
            $this->student->score = json_encode($score);
            $this->student->save();
        }

        return $score[$scoreType];
    }

    /**
     * 先尝试从数据库中读取，如果数据库中没有数据，则从教务系统获取
     * 获取的数据会保存到数据库
     * @return array 课程表
     */
    public function getCourse() {
        if ($this->student->course) {
            return json_decode($this->student->course, true);
        } else {
            $info = $this->getInfo();
            $courses = array_merge(
                $this->getAmsProxy()->getCourse(),
                $this->getAmsProxy()->getClassCourse(
                    $info['行政班级']));
            $this->student->course = json_encode($courses);
            $this->student->save();

            return $courses;
        }
    }

    public function getRankExam($type) {
        if ($this->student->rankExam) {
            $rankExam = json_decode($this->student->rankExam, true);
        }
        else {
            $rankExam = array(
                $this->getAmsProxy()->getRankExamSign(),
                $this->getAmsProxy()->getRankScore(),
            );
            $this->student->rankExam = json_encode($rankExam);
            $this->student->save();
        }
        return $rankExam[$type];
    }

    public function getAmsProxy() {
        if ($this->amsProxy == null) {
            $this->amsProxy = new AmsProxy(
                $_SESSION['student']['sid'],
                $_SESSION['student']['pwd']);
        }
        return $this->amsProxy;
    }
}
