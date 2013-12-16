<?php
class BaseWechatController extends BaseController {
    /**
     * @var Student
     */
    public $student;

    /**
     * @var object
     */
    public $request;

    /**
     * @var array
     */
    public $config;

    public function init() {
        parent::init();

        if (isset($_GET['echostr'])) {
            echo $_GET['echostr'];
            Yii::app()->end();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->request = simplexml_load_string(
                file_get_contents('php://input'));
            $this->student = Student::model()->find('wechat_openid=:openId',
                array(':openId' => $this->request->FromUserName));
            $this->config = json_decode(
                file_get_contents($this->getConfigFile()));

            switch ($this->request->MsgType) {
                case 'text':
                    $this->textHandler();
                    break;

                case 'event':
                    $this->eventHandler();
            }
        }
    }

    public function actionIndex() {}

    /**
     * @param string $content
     */
    public function responseText($content) {
        $this->render('/common/text', array('content' => $content));
    }

    /**
     * @param array $articles
     */
    public function responseNews($articles) {
        $this->render('/common/news', array('articles' => $articles));
    }

    public function eventHandler() {
        switch ($this->request->Event) {
            case 'subscribe':
                $this->execHandler($this->config->onSubscribe);
        }
    }

    public function textHandler() {
        foreach ($this->config->text as $item) {
            preg_match('/' . $item->pattern . '/i',
                $this->request->Content, $matches);

            if (!empty($matches)) {
                $this->execHandler($item->handler, $matches);
            }
        }
    }

    /**
     * @param array $handler
     * @param array $args
     */
    public function execHandler($handler, $args=null) {
        switch ($handler->type) {
            case 'text':
                $this->responseText($handler->content);
                break;

            case 'news':
                $this->responseNews($handler->articles);
                break;

            case 'function':
                if ($handler->requireBind)
                    $this->requireBind();

                $this->{$handler->function}($args);
        }
    }

    public function responseCourse($args) {
        $wday = (int)$args[2];
        if (!$wday) $wday = (int)date('N');

        $weekCourses = $this->student->getWeekCourses($wday);
        $responseText = '';

        if ($weekCourses) {
            foreach ($weekCourses as $course) {
                $timeStart = Setting::$timetable[$course->lessonStart][0];
                $timeTo = Setting::$timetable[$course->lessonTo][1];

                if (count($course->location) > 1)
                    $more = '…';
                else
                    $more = '';

                $responseText .= "课程：{$course->courseName}\n";
                $responseText .= "教室：{$course->location[0]}$more\n";
                $responseText .= "教师：{$course->teacherName[0]}$more\n";
                $responseText .= "时间：{$course->lessonStart} - {$course->lessonTo}";
                $responseText .= "（{$timeStart} - {$timeTo}）\n";
                $responseText .= "周次：{$course->weekStart} - {$course->weekTo}\n\n";
            }
        } else {
            $responseText .= '今天没课～';
        }

        $this->responseNews(array(
            (object)array(
                'title' => '第' . $this->weekNumber() . '周 ' .
                    Setting::$weeksName[$wday],
                'description' => trim($responseText),
                'url' => $this->createAbsoluteUrl(
                    '/site/wechat/weekCourse',
                    array(
                        'openId' => $this->student->wechat_openid,
                        'wday' => $wday,
                    )
                ),
            ),
        ));
    }

    public function responseCurriculum($args=null) {
        $this->responseNews(array(
            (object)array(
                'title' => '课程表',
                'description' => '点击查看',
                'url' => $this->createAbsoluteUrl(
                    '/site/wechat/curriculum',
                    array(
                        'openId' => $this->student->wechat_openid,
                    )
                ),
            ),
        ));
    }

    public function responseScore($args) {
        preg_match('/([1-8]?)\s?([0-1]?)/', $args[2], $params);

        $scoreType = $params[2] ? (int)$params[2] : 1; 
        $scoreTable = json_decode($this->student->score, true);
        $scoreTable = $scoreTable[$scoreType]['tbody'];
        $termNames = array_keys($scoreTable);
        $termIndex = $params[1] ? (int)($params[1]) - 1 : count($termNames) - 1;

        if ($scoreTable) {
            $responseText = '';
            foreach ($scoreTable[$termNames[$termIndex]] as $score) {
                $courseName = preg_replace('/\[.*?\]/', '', $score[0]);
                $responseText .= "课程：{$courseName}\n";
                $responseText .= "学分：{$score[1]}\n";
                $responseText .= "成绩：{$score[6]}\n\n";
            }
        } else {
            $responseText = '暂无数据';
        }

        $this->responseNews(array(
            (object)array(
                'title' => $termNames[$termIndex],
                'description' => trim($responseText),
                'url' => $this->createAbsoluteUrl(
                    '/site/wechat/score',
                    array(
                        'openId' => $this->student->wechat_openid,
                    )
                ),
            ),
        ));
    }

    public function responseRankExam($args=null) {
        $rankExamScoreTable = json_decode($this->student->rank_exam);
        $rankExamScoreTable = $rankExamScoreTable->score->tbody;

        if ($rankExamScoreTable) {
            $responseText = '';
            foreach($rankExamScoreTable as $group) {
                foreach ($group as $row) {
                    $responseText .= "考试科目：{$row[0]}\n";
                    $responseText .= "考试年月：{$row[1]}\n";
                    $responseText .= "理论成绩：{$row[2]}\n";
                    $responseText .= "操作成绩：{$row[3]}\n";
                    $responseText .= "综合成绩：{$row[4]}\n\n";
                }
            }
        } else {
            $responseText = '暂无数据';
        }

        $this->responseNews(array(
            (object)array(
                'title' => '等级考试成绩',
                'description' => trim($responseText),
                'url' => $this->createAbsoluteUrl(
                    '/site/wechat/rankExam',
                    array(
                        'openId' => $this->student->wechat_openid,
                    )
                ),
            ),
        ));
    }

    public function responseArchives($args=null) {
        $responseText = '';
        foreach (json_decode($this->student->archives) as $key => $value)
            $responseText .= "{$key}：\n{$value}\n\n";
        $this->responseNews(array(
            (object)array(
                'title' => '学籍档案',
                'description' => trim($responseText),
                'url' => $this->createAbsoluteUrl(
                    '/site/wechat/archives',
                    array(
                        'openId' => $this->student->wechat_openid,
                    )
                ),
            ),
        ));
    }

    public function requireBind() {
        if (!$this->student) {
            $this->responseNews(array(
                (object)array(
                    'title' => '你还没有绑定哦',
                    'description' => '点击此消息进行页面跳转，登录成功后即可完成绑定！',
                    'url' => $this->createAbsoluteUrl(
                        '/proxy/wechat/bind',
                        array(
                            'openId' => $this->request->FromUserName,
                        )
                    ),
                )
            ));

            Yii::app()->end();
        }
    }
}
