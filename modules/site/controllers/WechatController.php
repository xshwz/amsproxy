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

    public function wechatInit() {
        Yii::import('application.libs.Wechat');
        $this->wechat = new Wechat();
        $this->request = $this->wechat->request;
        $this->student = Student::model()->find('wechat_openid=:openId',
            array(':openId' => $this->request->FromUserName));


        if (isset($_GET['echostr'])) {
            echo $_GET['echostr'];
            Yii::app()->end();
        }
    }

    public function actionIndex() {
        $this->wechatInit();

        switch ($this->request->MsgType) {
            case 'text':
                $this->textHandler();
                break;

            case 'event':
                $this->eventHandler();
                break;
        }
    }

    public function eventHandler() {
        switch ($this->request->Event) {
            case 'subscribe':
                $this->subscribeHandler();
                break;
        }
    }

    public function subscribeHandler() {
        $this->wechat->response('欢迎关注“相思青果”（http://xsh.gxun.edu.cn/ams/）。');
    }

    public function textHandler() {
        if (substr($this->request->Content, 0, 1) == '\\' ||
            substr($this->request->Content, 0, 1) == '/')
            $this->commandHandler();
        else
            $this->defaultTextHandler();
    }

    public function commandHandler() {
        if ($this->student) {
            $this->dispatcher(substr($this->request->Content, 1), array(
                array(
                    'pattern' => '/^(c\b|course\b|课程)\s*(.*)/i',
                    'handler' => 'courseHandler',
                ),
                array(
                    'pattern' => '/^(s\b|score\b|成绩)\s*(.*)/i',
                    'handler' => 'scoreHandler',
                ),
                array(
                    'pattern' => '/^r\b|rank exam|等级考试/i',
                    'handler' => 'rankExamHandler',
                ),
                array(
                    'pattern' => '/^a\b|archives|学籍/i',
                    'handler' => 'archivesHandler',
                ),
                array(
                    'pattern' => '/^unbind|解除绑定/i',
                    'handler' => 'unbind',
                ),
                array(
                    'pattern' => '/^(h\b|help|帮助)/i',
                    'handler' => 'helpHandler',
                ),
                array(
                    'pattern' => '/.*/',
                    'handler' => 'unknownCommandHandler',
                ),
            ));
        } else {
            $this->unbindHandler();
        }
    }

    public function unknownCommandHandler($args=null) {
        $responseText = array(
            '啊哈？',
            '你输入的命令不正确',
            '元芳，你怎么看？',
            ':(',
            'unknow cammand');
        $this->wechat->response(
            $responseText[rand(0, count($responseText) - 1)]);
    }

    public function helpHandler($args=null) {
        $this->wechat->response(
            "请参考：http://xsh.gxun.edu.cn" . $this->createUrl('/site/wechat') . "\n\n" .
            "或者直接发消息给我们！"
        );
    }

    public function archivesHandler($args=null) {
        $responseText = '';
        foreach(json_decode($this->student->archives, true) as $key => $value)
            $responseText .= "{$key}：\n{$value}\n\n";
        $this->wechat->response(trim($responseText));
    }

    public function unbind($args=null) {
        $this->student->wechat_openid = null;
        $this->student->save();
        $this->wechat->response('解除绑定成功！');
    }

    public function rankExamHandler($args=null) {
        $rankExamScoreTable = json_decode($this->student->rank_exam);
        $rankExamScoreTable = $rankExamScoreTable->score->tbody;
        $responseText = "等级考试成绩\n\n";

        foreach($rankExamScoreTable as $group) {
            foreach ($group as $row) {
                $responseText .= "考试科目：{$row[0]}\n";
                $responseText .= "考试年月：{$row[1]}\n";
                $responseText .= "理论成绩：{$row[2]}\n";
                $responseText .= "操作成绩：{$row[3]}\n";
                $responseText .= "综合成绩：{$row[4]}\n\n";
            }
        }

        $this->wechat->response(trim($responseText));
    }

    public function scoreHandler($args) {
        preg_match('/([1-8]?)\s?([0-1]?)/', $args[2], $params);

        $scoreType = $params[2] ? (int)$params[2] : 1; 
        $scoreTable = json_decode($this->student->score, true);
        $scoreTable = $scoreTable[$scoreType]['tbody'];
        $termNames = array_keys($scoreTable);
        $termIndex = $params[1] ? (int)($params[1]) - 1 : count($termNames) - 1;

        $responseText = "{$termNames[$termIndex]}\n\n";

        foreach ($scoreTable[$termNames[$termIndex]] as $score) {
            $courseName = preg_replace('/\[.*?\]/', '', $score[0]);
            $responseText .= "课程：{$courseName}\n";
            $responseText .= "学分：{$score[1]}\n";
            $responseText .= "成绩：{$score[6]}\n\n";
        }

        $this->wechat->response(trim($responseText));
    }

    public function courseHandler($args) {
        $wday = (int)self::zh2en($args[2]);
        if (!$wday) $wday = (int)date('N');

        $weekCourses = $this->student->getWeekCourses($wday);
        $responseText =
            Setting::$weeksName[$wday] .
            ' 第' . $this->weekNumber() . "周\n\n";

        if ($weekCourses) {
            foreach ($weekCourses as $course) {
                $timeStart = Setting::$timetable[$course->lessonStart][0];
                $timeTo = Setting::$timetable[$course->lessonTo][1];

                $responseText .= "课程：$course->courseName\n";
                $responseText .= "教室：$course->location\n";
                $responseText .= "教师：$course->teacherName\n";
                $responseText .= "时间：{$course->lessonStart} - {$course->lessonTo}";
                $responseText .= "（{$timeStart} - {$timeTo}）\n";
                $responseText .= "周次：{$course->weekStart} - {$course->weekTo}\n\n";
            }
        } else {
            $responseText .= '今天没课～';
        }

        $this->wechat->response(trim($responseText));
    }

    /**
     * translate some Chinese words to English
     *
     * @param string $string
     * @return string
     */
    public static function zh2en($string) {
        return preg_replace(
            array('/一/', '/二/', '/三/', '/四/', '/五/', '/六/', '/七/', '/八/', '/九/'),
            array('1', '2', '3', '4', '5', '6', '7', '8', '9'),
            $string);
    }

    /**
     * @param string $subject
     * @param array $routers patterns and handlers
     */
    public function dispatcher($subject, $routers) {
        foreach ($routers as $router) {
            preg_match($router['pattern'], $subject, $matches);

            if (!empty($matches)) {
                $this->$router['handler']($matches);
                break;
            }
        }
    }

    public function developerHandler($args=null) {
        $this->wechat->response(
            "开发者：\n\n" .
            "姓名：丘翔\n" .
            "班级：10网络工程\n" .
            "邮箱：qiuxiang55aa@gmail.com\n\n" .
            "姓名：徐伟榕\n" .
            "班级：11软件工程1班\n" .
            "邮箱：weirongxuraidou@gmail.com\n"
        );
    }

    public function defaultTextHandler() {
        $this->dispatcher($this->request->Content, array(
            array(
                'pattern' => '/^(help|帮助)$/i',
                'handler' => 'helpHandler',
            ),
            array(
                'pattern' => '/^(about|关于)$/i',
                'handler' => 'aboutHandler',
            ),
            array(
                'pattern' => '/^(developer|开发者)$/i',
                'handler' => 'developerHandler',
            ),
        ));
    }

    public function aboutHandler() {
        $this->wechat->response(
            "关于“相思青果”订阅号\n\n" . 
            "　　“相思青果”订阅号通过微信公众平台开发模式提供消息的自动回复。\n" . 
            "　　通过向我们的订阅号发送消息指令，即可返回你的课程、成绩、等级考试成绩。\n" .
            "　　同时，任何关于或者无关于“相思青果”的问题都可以向我们吐槽。\n" .
            ""
        );
    }

    public function unbindHandler() {
        $this->wechat->response(
            "你的微信还未与“相思青果”绑定哦，点击下面的链接，登录成功后即可绑定。\n\n" .
            $this->getBindUrl()
        );
    }

    /**
     * @return string
     */
    public function getBindUrl() {
        return 'http://localhost' . $this->createUrl(
            '/proxy/wechat/bind',
            array(
                'openId' => $this->request->FromUserName,
            ),
            '&amp;'
        );
    }
}
