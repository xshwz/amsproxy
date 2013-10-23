<?php
/**
 * 微信公众平台控制器
 */
class WechatController extends BaseController {
    /**
     * @var Student
     */
    public $student;

    /**
     * @var array 上课时间表
     */
    public static $timeTable = array(
         1 => array( '7:50',  '8:30'),
         2 => array( '8:40',  '9:20'),
         3 => array( '9:30', '10:10'),
         4 => array('10:30', '11:10'),
         5 => array('11:20', '12:00'),
         6 => array('14:30', '15:10'),
         7 => array('15:20', '16:00'),
         8 => array('16:10', '16:50'),
         9 => array('17:00', '17:40'),
        10 => array('19:40', '20:20'),
        11 => array('20:30', '21:10'),
        12 => array('21:20', '22:00'),
    );


    /**
     * @var array 星期名字典
     */
    public static $weeksName = array(
        1 => '星期一',
        2 => '星期二',
        3 => '星期三',
        4 => '星期四',
        5 => '星期五',
        6 => '星期六',
        7 => '星期日',
    );

	public function actionIndex() {
        if (isset($_GET['echostr']))
            echo $_GET['echostr'];

        $wechat = new Wechat();
        $this->student = Student::model()->find( 'wechat=:wechat',
            array(':wechat' => $wechat->request->FromUserName));
        if ($this->student) {
            $command = explode(' ', $wechat->request->Content);
            switch (trim($command[0])) {
                case '学籍':
                    $wechat->response($this->getStudentInfo());
                    break;

                case '课程':
                    if (!isset($command[1]))
                        $command[1] = (int)date('N');

                    $wechat->response($this->getCourse((int)$command[1]));
                    break;

                case '成绩':
                    if (!isset($command[1]))
                        $command[1] = null;

                    if (!isset($command[2]))
                        $command[2] = 1;

                    $wechat->response($this->getScore(
                        $command[1], (int)$command[2]));
                    break;

                case '等级考试':
                    $wechat->response($this->getRankExamScore());
                    break;

                default:
                    $wechat->response('啊哈？');
            }
        } else {
            $wechat->response(
                'http://xsh.gxun.edu.cn/' .
                Yii::app()->createUrl(
                    'setting/wechat',
                    array(
                        'operate' => 'bind',
                        'openId' => $wechat->request->FromUserName,
                    ),
                    '&amp;'
                )
            );
        }
	}

    public function getStudentInfo() {
        $studentInfo = '';
        foreach(json_decode($this->student->info, true) as $key => $value)
            $studentInfo .= "{$key}：\n{$value}\n\n";
        return rtrim($studentInfo);
    }

    public function getRankExamScore() {
        $rankExamScoreTable = json_decode($this->student->rankExam);
        $rankExamScoreTable = $rankExamScoreTable[1]->tbody;
        $rankExamScores = "等级考试成绩\n\n";
        foreach($rankExamScoreTable as $group) {
            foreach ($group as $row) {
                $rankExamScores .= "考试科目：{$row[0]}\n";
                $rankExamScores .= "考试年月：{$row[1]}\n";
                $rankExamScores .= "理论成绩：{$row[2]}\n";
                $rankExamScores .= "操作成绩：{$row[3]}\n";
                $rankExamScores .= "综合成绩：{$row[4]}\n\n";
            }
        }
        return rtrim($rankExamScores);
    }

    /**
     * @return string 课程
     */
    public function getCourse($wday) {
        $courses = self::$weeksName[$wday] . "\n\n";
        foreach (json_decode($this->student->course) as $course) {
            if ($course->weekDay == $wday) {
                $timeStart = self::$timeTable[$course->lessonStart][0];
                $timeTo = self::$timeTable[$course->lessonTo][1];

                $courses .= "课程：$course->courseName\n";
                $courses .= "教室：$course->location\n";
                $courses .= "教师：$course->teacherName\n";
                $courses .= "时间：{$course->lessonStart} - {$course->lessonTo}";
                $courses .= "（{$timeStart} - {$timeTo}）\n\n";
            }
        }
        return rtrim($courses);
    }

    /**
     * @param int $termIndex 学期
     * @param int $type 1：有效成绩，0：原始成绩
     * @return string 成绩
     */
    public function getScore($termIndex = null, $type = 1) {
        $scoreTable = json_decode($this->student->score, true);
        $scoreTable = $scoreTable[$type]['tbody'];
        $termNames = array_keys($scoreTable);

        if ($termIndex)
            $termIndex = (int)($termIndex) - 1;
        else
            $termIndex = count($termNames) - 1;

        $scores = "{$termNames[$termIndex]}\n\n";
        foreach ($scoreTable[$termNames[$termIndex]] as $score) {
            $courseName = preg_replace('/\[.*?\]/', '', $score[0]);
            $scores .= "课程：{$courseName}\n";
            $scores .= "学分：{$score[1]}\n";
            $scores .= "成绩：{$score[6]}\n\n";
        }
        return rtrim($scores);
    }
}

class Wechat {
    /**
     * @var SimpleXMLElement
     */
    public $request;

    public function __construct() {
        $this->request = simplexml_load_string(file_get_contents('php://input'));
    }

    public function response($content) {
        echo "<xml>
            <ToUserName>{$this->request->FromUserName}</ToUserName>
            <FromUserName>{$this->request->ToUserName}</FromUserName>
            <CreateTime>" . time() . "</CreateTime>
            <MsgType>text</MsgType>
            <Content>{$content}</Content>
        </xml>";
    }
}
