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
        if (isset($_GET['echostr'])) {
            echo $_GET['echostr'];
            Yii::app()->end();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Yii::import('application.libs.Wechat');
            $this->wechat = new Wechat();
            $this->request = $this->wechat->request;
            $this->student = Student::model()->find('wechat_openid=:openId',
                array(':openId' => $this->request->FromUserName));
        } else {
            var_dump(WechatMessage::model()->find()->student);
            Yii::app()->end();
        }
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionAPI() {
        $this->wechatInit();

        switch ($this->request->MsgType) {
            case 'text':
                $this->saveMessage();
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
        $responseText =
            "欢迎关注“相思青果”（http://xsh.gxun.edu.cn/ams/）。\n\n" .
            "在这里，你可以通过发送指令消息查看课表、成绩、等级考试成绩等信息，以及反馈在使用“相思青果”中遇到的问题。\n\n" .
            "更多关于“相思青果”公众号的详情请参考：http://xsh.gxun.edu.cn/ams/index.php?r=site/wechat\n\n" .
            "PS.\n" .
            "　　发送“帮助”可以获取帮助文档；\n" .
            "　　发送的指令不一定都能成功返回，可以多试几次哦；\n" .
            "　　由于我们的微信平台刚建设，有很多不足，还请见谅，欢迎你的反馈，让我们把微信平台建立得更好；";

        if (!$this->student)
            $responseText .= "\n\n点击链接（" . $this->getBindUrl() . '），成功登录后即可完成绑定。';

        $this->wechat->response($responseText);
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
                    'handler' =>
                        "目前支持的指令有：\n\n" .
                        "/课程\n" . 
                        "　　默认返回当天课程，可带参数，比如“/课程3”返回星期三的课程。\n\n" .
                        "/成绩\n" . 
                        "　　默认返回最近一个学期的成绩，可带参数，比如“/成绩1”返回第一个学期的成绩。\n\n" .
                        "/等级考试\n" . 
                        "　　返回等级考试成绩。\n\n" . 
                        "/学籍\n" . 
                        "　　返回个人学籍档案。\n\n\n" .
                        "PS. 发送的指令不一定都能成功返回，可以多试几次。",
                ),
                array(
                    'pattern' => '/.*/',
                    'handler' =>
                        "你输入的指令不正确哦，目前支持的指令有：\n\n" .
                        "/课程\n" . 
                        "　　默认返回当天课程，可带参数，比如“/课程3”返回星期三的课程。\n\n" .
                        "/成绩\n" . 
                        "　　默认返回最近一个学期的成绩，可带参数，比如“/成绩1”返回第一个学期的成绩。\n\n" .
                        "/等级考试\n" . 
                        "　　返回等级考试成绩。\n\n" . 
                        "/学籍\n" . 
                        "　　返回个人学籍档案。\n\n" .
                        "PS. 发送的指令不一定都能成功返回，可以多试几次。",
                ),
            ));
        } else {
            $this->wechat->response(
                "你的微信还未与“相思青果”绑定哦，点击下面的链接，登录成功后即可绑定。\n\n" .
                $this->getBindUrl()
            );
        }
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
                if (method_exists($this, $router['handler']))
                    $this->$router['handler']($matches);
                else
                    $this->wechat->response($router['handler']);

                break;
            }
        }
    }

    public function defaultTextHandler() {
        $this->dispatcher($this->request->Content, array(
            array(
                'pattern' => '/^(help|帮助)$/i',
                'handler' =>
                    "欢迎使用“相思青果”（http://xsh.gxun.edu.cn/ams/）\n\n" .
                    "“相思青果”公众号主要用于：\n" .
                    "　　1、基于微信公众平台开发模式提供消息自动回复，向我们发送消息指令（比如“/成绩”），即可返回你的课程、成绩、等级考试成绩等信息。（只有绑定后才能使用哦）\n" .
                    "　　2、反馈和解决使用“相思青果”中遇到的问题。\n\n" .
                    "提示：\n" .
                    "　　发送的指令不一定都能成功返回，可以多试几次；\n" .
                    "　　发送“/帮助”可以获取指令帮助；\n" .
                    "　　由于我们的微信平台刚建设，有很多不足，还请见谅，欢迎你的反馈，让我们把微信平台建立得更好；\n\n" .
                    "更多请参考：http://xsh.gxun.edu.cn/ams/index.php?r=site/wechat\n\n" .
                    "如果还是没有解决你的问题，可以直接发消息给我们～",
            ),
            array(
                'pattern' => '/^(成绩|查成绩)\s*\d?$/i',
                'handler' => '查成绩的指令为“/成绩”，默认返回最近一个学期的成绩，可带参数，比如“/成绩1”返回第一学期的成绩',
            ),
            array(
                'pattern' => '/^(课程|课表|查课程|查课表|课程表)\s*\d?$/i',
                'handler' => '查课程的指令为“/课程”，默认返回当天课程，可带参数，比如“/课程2”返回星期二的课程',
            ),
            array(
                'pattern' => '/^(等级考试|等级考试成绩)$/i',
                'handler' => '查等级考试成绩的指令为“/等级考试”',
            ),
            array(
                'pattern' => '/^(学籍|查看学籍)$/i',
                'handler' => '查个人学籍档案的指令为“/学籍”',
            ),
        ));
    }

    /**
     * @return string
     */
    public function getBindUrl() {
        return 'http://xsh.gxun.edu.cn' . $this->createUrl(
            '/proxy/wechat/bind',
            array(
                'openId' => $this->request->FromUserName,
            ),
            '&amp;'
        );
    }

    public function saveMessage() {
        $message = new WechatMessage;
        $message->openid = $this->request->FromUserName;
        $message->message = $this->request->Content;
        $message->time = date('Y-m-d H:i:s');
        $message->save();
    }
}
