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
     * @var WechatLog
     */
    public $logger;

    /**
     * @var array
     */
    public $config;

    public function init() {
        parent::init();

        if (!$this->checkSignature($this->setting->wechat_token))
            Yii::app()->end();

        if (isset($_GET['echostr'])) {
            echo $_GET['echostr'];
            Yii::app()->end();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $input = file_get_contents('php://input');
            $this->createLogger($input);
            $this->request = simplexml_load_string($input);
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

    /**
     * @param string $token
     * @return bool
     */
    public function checkSignature($token) {
        $array = array($token, $_GET['timestamp'], $_GET['nonce']);
        sort($array);
        return sha1(implode($array)) == $_GET['signature'];
    }

    public function actionIndex() {}

    /**
     * @param string $content
     */
    public function responseText($content) {
        $this->render('/common/text', array('content' => $content));
        $this->setLoggerState(1);
    }

    /**
     * @param array $articles
     */
    public function responseNews($articles) {
        $this->render('/common/news', array('articles' => $articles));
        $this->setLoggerState(1);
    }

    public function eventHandler() {
        switch ($this->request->Event) {
            case 'subscribe':
                $this->execHandler($this->config->event->subscribe);
                break;

            case 'CLICK':
                $this->execHandler(
                    $this->config->event->CLICK->{$this->request->EventKey});
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

    public function responseCurriculum() {
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

    public function responseRankExam() {
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

    public function responseArchives() {
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
                    'description' => '点击此消息，登录成功后即可完成绑定！',
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

    public function responseBind() {
        $this->responseNews(array(
            (object)array(
                'title' => '绑定',
                'description' => '点击此消息，登录成功后即可完成绑定！',
                'url' => $this->createAbsoluteUrl(
                    '/proxy/wechat/bind',
                    array(
                        'openId' => $this->request->FromUserName,
                    )
                ),
            )
        ));
    }

    public function responseUnBind() {
        $this->student->wechat_openid = null;
        $this->student->save();
        $this->responseText('解除绑定成功！');
    }

    public function responseHelp() {
        $this->responseNews(array(
            (object)array(
                'title' => '帮助',
                'description' =>
                    "• 涉及个人数据的指令，比如“课表“、”成绩”等需要绑定后才能使用\n\n" .
                    "• 发送的消息不一定都能成功返回，要多试几次哦\n\n" .
                    "• 欢迎你直接在微信上向我们反馈！\n\n\n" .
                    "系统没有回复的原因\n" .
                    "———————————\n" .
                    "• 可能在教务系统里并没有相关的数据，建议你先去教务系统确认\n\n" .
                    "• 如果教务系统确实有数据，那么可能是我们的系统没有获取到或者没有更新，发送指令“更新”可以更新数据\n\n" .
                    "• 可能是遇到了 Bug 或者我们的服务器挂了，导致无法正常提供服务\n\n" .
                    "\n支持的指令\n" .
                    "——————\n" .
                    "• 关于：“相思青果”介绍\n\n" .
                    "• 学籍：返回个人学籍档案\n\n" .
                    "• 课表：返回一周的课表，需要点击消息查看\n\n" .
                    "• 课程：默认返回当天课程，可带参数，比如“课程3”返回星期三的课程\n\n" .
                    "• 成绩：默认返回最近一个学期的成绩，可带参数，比如“成绩1”返回第一个学期的成绩\n\n" .
                    "• 等级考试：返回等级考试成绩\n\n" .
                    "• 绑定：不解释\n\n" .
                    "• 解除绑定：不解释",
                'url' => $this->createAbsoluteUrl('/wechat'),
            )
        ));
    }

    public function responseAbout() {
        $this->responseNews(array(
            (object)array(
                'title' => '关于“相思青果”',
                'description' =>
                    "“相思青果”是相思湖网站开发的教务系统代理，目的在于让同学们可以在外网使用教务系统，同时提供更好使用体验和更丰富的功能。\n\n" .
                    "“相思青果”公众号通过开发模式提供消息自动回复，向我们的公众号发送消息（比如“成绩”），即可查询成绩、课程等（前提是要绑定哦）。",
                'url' => $this->createAbsoluteUrl('/about'),
            )
        ));
    }

    /**
     * @param string $message
     */
    public function createLogger($message) {
        $this->logger = new WechatLog;
        $this->logger->message = $message;
        $this->logger->save();
    }

    /**
     * @param int $state
     */
    public function setLoggerState($state) {
        $this->logger->state = $state;
        $this->logger->save();
    }
}
