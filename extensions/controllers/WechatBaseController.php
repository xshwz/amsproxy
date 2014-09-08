<?php
class WechatBaseController extends BaseController {
    /**
     * @var Student
     */
    public $student;

    /**
     * @var int
     */
    public $state;

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
            $this->state = WechatLog::$status['default'];
            $this->request = simplexml_load_string($input);
            $this->student = Student::model()->find(
                $this->openIdField . '=:openId',
                array(
                    ':openId' => $this->request->FromUserName,
                )
            );

            $this->config = json_decode(
                $this->renderFile($this->getConfigFile(), null, true));

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

    protected function afterAction($action) {
        if ($this->logger) {
            $this->logger->state = $this->state;
            $this->logger->save();
        }
    }

    public function response($type, $data, $state=null) {
        $this->render('/common/' . $type, array('data' => $data));
        if ($state === null)
            $this->state = WechatLog::$status['success'];
        else
            $this->state = $state;
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
        $handled = false;

        foreach ($this->config->text as $item) {
            preg_match('/' . $item->pattern . '/i',
                $this->request->Content, $matches);

            if (!empty($matches)) {
                $this->execHandler($item->handler, $matches);
                $handled = true;
            }
        }

        if (!$handled && $this->setting->wechat_auto_reply) {
            $this->response('news', array(
                (object)array(
                    'title' => '欢迎使用相思青果',
                    'description' =>
                        "在这里，你可以通过发送特定指令获取相应信息，比如发送“成绩”可以查询成绩，更多支持的指令以及帮助信息可以发送“帮助”获取。\n\n" .
                        "如果系统没有回复，可以多试几次哦。",
                    'url' => $this->createAbsoluteUrl('/wechat'),
                ),
            ), WechatLog::$status['untreated']);
        }
    }

    /**
     * @param array $handler
     * @param array $args
     */
    public function execHandler($handler, $args=null) {
        switch ($handler->type) {
            case 'text':
                $this->response('text', $handler->content);
                break;

            case 'news':
                $this->response('news', $handler->articles);
                break;

            case 'function':
                if ($handler->requireBind)
                    $this->requireBind();

                if (isset($handler->param))
                    $args = $handler->param;

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

        $this->response('news', array(
            (object)array(
                'title' => '第' . $this->weekNumber() . '周 ' .
                    Setting::$weeksName[$wday],
                'description' => trim($responseText),
                'url' => $this->createAbsoluteUrl(
                    '/site/wechat/weekCourse',
                    array(
                        'openId' => $this->student->{$this->openIdField},
                        'field' => $this->openIdField,
                        'wday' => $wday,
                    )
                ),
            ),
        ));
    }

    public function responseStats() {
        $this->response('news', array(
            (object)array(
                'title' => '成绩统计',
                'description' => '点击查看',
                'url' => $this->createAbsoluteUrl(
                    '/site/wechat/stats',
                    array(
                        'openId' => $this->student->{$this->openIdField},
                        'field' => $this->openIdField,
                    )
                ),
            ),
        ));
    }

    public function responseCurriculum() {
        $this->response('news', array(
            (object)array(
                'title' => '课程表',
                'description' => '点击查看',
                'url' => $this->createAbsoluteUrl(
                    '/site/wechat/curriculum',
                    array(
                        'openId' => $this->student->{$this->openIdField},
                        'field' => $this->openIdField,
                    )
                ),
            ),
        ));
    }

    public function responseScore($args) {
        $scoreType = $args[3] ? (int)$args[3] : 0; 
        $fields = array(10, 6);
        $scoreTable = json_decode($this->student->score, true);

        if ($scoreTable &&
            isset($scoreTable[$scoreType]['tbody']) &&
            $scoreTable[$scoreType]['tbody']) {

            $scoreTable = $scoreTable[$scoreType]['tbody'];
            $termNames = array_keys($scoreTable);
            $termIndex = $args[2] ? (int)($args[2]) - 1 : count($termNames) - 1;

            if (count($termNames) > $termIndex) {
                $responseText = '';
                foreach ($scoreTable[$termNames[$termIndex]] as $score) {
                    $courseName = preg_replace('/\[.*?\]/', '', $score[0]);
                    $responseText .= "课程：{$courseName}\n";
                    $responseText .= "学分：{$score[1]}\n";
                    $responseText .= "成绩：{$score[$fields[$scoreType]]}\n\n";
                }

                $responseText .= '注：如果没有你想要查询的成绩，可能是还没有录入（视老师心情而定），还有别忘了发送“更新”更新数据哦';

                $this->response('news', array(
                    (object)array(
                        'title'       => $termNames[$termIndex],
                        'description' => trim($responseText),
                        'url'         => $this->createAbsoluteUrl(
                            '/site/wechat/score',
                            array(
                                'openId'    => $this->student->{$this->openIdField},
                                'field'     => $this->openIdField,
                                'scoreType' => $scoreType,
                            )
                        ),
                    ),
                ));
            } else {
                $this->responseNoData();
            }
        } else {
            $this->responseNoData();
        }
    }

    public function responseRankExam() {
        $rankExamScoreTable = json_decode($this->student->rank_exam);

        if (isset($rankExamScoreTable->score->tbody)) {
            $responseText = '';
            foreach($rankExamScoreTable->score->tbody as $group) {
                foreach ($group as $row) {
                    $responseText .= "考试科目：{$row[0]}\n";
                    $responseText .= "考试年月：{$row[1]}\n";
                    $responseText .= "理论成绩：{$row[2]}\n";
                    $responseText .= "操作成绩：{$row[3]}\n";
                    $responseText .= "综合成绩：{$row[4]}\n\n";
                }
            }

            $this->response('news', array(
                (object)array(
                    'title' => '等级考试成绩',
                    'description' => trim($responseText),
                    'url' => $this->createAbsoluteUrl(
                        '/site/wechat/rankExam',
                        array(
                            'openId' => $this->student->{$this->openIdField},
                            'field' => $this->openIdField,
                        )
                    ),
                ),
            ));
        } else {
            $this->responseNoData();
        }
    }

    public function responseExam() {
        $examArrangement = json_decode(
            $this->student->exam_arrangement);

        if ($examArrangement && $examArrangement->tbody) {
            $responseText = '';
            foreach($examArrangement->tbody as $row) {
                $responseText .= "科目：{$row[0]}\n";
                $responseText .= "学分：{$row[1]}\n";
                $responseText .= "时间：{$row[4]}\n";
                $responseText .= "地点：{$row[5]}\n";
                $responseText .= "座位：{$row[6]}\n\n";
            }

            $this->response('news', array(
                (object)array(
                    'title' => '考试安排',
                    'description' => trim($responseText),
                    'url' => $this->createAbsoluteUrl('/proxy'),
                ),
            ));
        } else {
            $this->responseNoData();
        }
    }

    public function responseNoData() {
        $this->response('news', array(
            (object)array(
                'title' => '暂无数据',
                'description' => 
                    "• 可能是教务系统没有相关数据，或者还没有录入，比如考试成绩通常会在考试后至少一周（视老师心情而定）才录入\n\n" .
                    "• 也可能是我们的系统没有及时更新数据，可以尝试回复“更新”，或点击此消息进行更新。（前提是教务系统有相关数据哦）\n\n" .
                    "• 注意，没有评教会导致无法获取到成绩",
                'url' => $this->createAbsoluteUrl('/proxy/setting/update'),
            ),
        ));
    }

    public function responseArchives() {
        $responseText = '';
        foreach (json_decode($this->student->archives) as $key => $value)
            $responseText .= "{$key}：{$value}\n";
        $this->response('news', array(
            (object)array(
                'title' => '学籍档案',
                'description' => trim($responseText),
                'url' => $this->createAbsoluteUrl(
                    '/site/wechat/archives',
                    array(
                        'openId' => $this->student->{$this->openIdField},
                        'field' => $this->openIdField,
                    )
                ),
            ),
        ));
    }

    public function requireBind() {
        if (!$this->student) {
            $this->response('news', array(
                (object)array(
                    'title' => '你还没有绑定哦',
                    'description' => '点击此消息，登录成功后即可完成绑定！',
                    'url' => $this->createAbsoluteUrl(
                        '/proxy/wechat/bind',
                        array(
                            'openId' => $this->request->FromUserName,
                            'field' => $this->openIdField,
                        )
                    ),
                )
            ));

            $this->logger->state = WechatLog::$status['success'];
            $this->logger->save();
            Yii::app()->end();
        }
    }

    public function responseBind() {
        $this->response('news', array(
            (object)array(
                'title' => '绑定',
                'description' => '点击此消息，登录成功后即可完成绑定！',
                'url' => $this->createAbsoluteUrl(
                    '/proxy/wechat/bind',
                    array(
                        'openId' => $this->request->FromUserName,
                        'field' => $this->openIdField,
                    )
                ),
            )
        ));
    }

    public function responseUnBind() {
        $this->student->{$this->openIdField} = null;
        $this->student->save();
        $this->response('news', array(
            (object)array(
                'title' => '解除绑定成功',
                'description' => '如果你希望重新绑定其他学号，要先点击此消息注销相思青果的登录哦',
                'url' => $this->createAbsoluteUrl('/proxy/home/logout'),
            )
        ));
    }

    public function responseHelp() {
        $url = $this->createAbsoluteUrl('/wechat');
        $this->response('news', array(
            (object)array(
                'title' => '帮助',
                'description' =>
                    "通过发送指令，比如发送“成绩”即可查询成绩，以下是支持的指令：\n\n" .
                    "【关于】\n“相思青果”介绍\n\n" .
                    "【学籍】\n返回个人学籍档案\n\n" .
                    "【课表】\n返回一周的课表，需要点击消息查看\n\n" .
                    "【课程】\n默认返回当天课程，可带参数，比如“课程3”返回星期三的课程\n\n" .
                    "【成绩】\n默认返回最近一个学期的成绩，可带参数，比如“成绩1”返回第一个学期的成绩\n\n" .
                    "【成绩分布】\n返回成绩分布信息，点击查看详细\n\n" .
                    "【挂科】\n返回挂科科目\n\n" .
                    "【学分】\n返回学分获得情况\n\n" .
                    "【绩点】\n进入绩点、平均分计算工具\n\n" .
                    "【统计】\n返回成绩统计图\n\n" .
                    "【等级考试】\n返回等级考试成绩\n\n" .
                    "【考试安排】\n返回考试安排\n\n" .
                    "【绑定】\n当前微信号与相思青果进行绑定\n\n" .
                    "【解除绑定】\n当前微信号与相思青果解除绑定\n\n" .
                    "提示：如果系统没有回复，可以多试几次哦",
                'url' => $url,
            ),
        ));
    }

    public function responseAbout() {
        $this->response('news', array(
            (object)array(
                'title' => '关于“相思青果”',
                'description' =>
                    "“相思青果”是相思湖网站开发的教务系统代理，目的在于让同学们可以在外网使用教务系统，同时提供更好使用体验和更丰富的功能。\n\n" .
                    "“相思青果”公众号通过开发模式提供消息自动回复，向我们的公众号发送消息（比如“成绩”），即可查询成绩、课程等（前提是要绑定哦）。",
                'url' => $this->createAbsoluteUrl('/about'),
            )
        ));
    }

    public function responseCredits() {
        $credits = $this->getCredits(json_decode($this->student->score)[1]);
        $responseText = '';
        foreach ($credits['credits'] as $type => $item) {
          $responseText .= $type . '（共 ' . $item['count'] . "）：\n";
          foreach ($item['courses'] as $course) {
            if ($course['credit']) {
              $responseText .= $course['credit'] . ' ' . $course['name'] . "\n";
            }
          }
          $responseText .= "\n";
        }

        $this->response('news', array(
            (object)array(
                'title' => '总共获得学分 ' . $credits['total'],
                'description' => trim($responseText),
            )
        ));
    }

    public function responseHanged() {
        $scoreTable = (json_decode($this->student->score)[1]);
        $count = 0;
        $responseText = '';

        foreach ($scoreTable->tbody as $term) {
            foreach ($term as $row) {
                if ($row[6] < 60) {
                    $responseText .= "课程：{$row[0]}\n";
                    $responseText .= "类型：{$row[2]}\n";
                    $responseText .= "学分：{$row[1]}\n";
                    $responseText .= "成绩：{$row[6]}\n\n";
                    $count++;
                }
            }
        }

        if (!$responseText) {
            $responseText = 'What is the meaning of life, the universe and everything?';
        }

        $this->response('news', array(
            (object)array(
                'title' => '挂科科目（' . $count . '门）',
                'description' => trim($responseText),
            )
        ));
    }

    public function responseScoreDist() {
        function display($dist) {
            $s = '';
            foreach ($dist as $row) {
                $s .= "{$row[0]} {$row[1]}\n";
            }
            return $s;
        }

        $scoreDict = $this->getScoreDist(json_decode($this->student->score)[1]);
        $responseText = "【90以上】\n";
        $responseText .= display($scoreDict[0]);
        $responseText .= "\n";

        $responseText .= "【80 - 90】\n";
        $responseText .= display($scoreDict[1]);
        $responseText .= "\n";

        $responseText .= "【70 - 80】\n";
        $responseText .= display($scoreDict[2]);
        $responseText .= "\n";

        $responseText .= "【60 - 70】\n";
        $responseText .= display($scoreDict[3]);
        $responseText .= "\n";

        $responseText .= "【60以下】\n";
        $responseText .= display($scoreDict[4]);

        $this->response('news', array(
            (object)array(
                'title' => '成绩分布',
                'description' => trim($responseText),
                'url' => $this->createAbsoluteUrl(
                    '/site/wechat/stats',
                    array(
                        'openId' => $this->student->{$this->openIdField},
                        'field' => $this->openIdField,
                    )
                ),
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

    /**
     * @param string $url
     */
    public function createFeed($url) {
        $feed = new SimplePie;
        $feed->set_feed_url($url);
        $feed->enable_cache(false);
        //$feed->set_cache_location('../runtime/cache');
        $feed->init();
        return $feed;
    }

    /**
     * @param array $items
     * @param string $target
     * @return array
     */
    public function getItemsByCategory($items, $target) {
        $news = array();
        foreach ($items as $item) {
            foreach ($item->get_categories() as $category) {
                if (strpos($category->get_term(), $target) !== false) {
                    $news[] = $item;
                    break;
                }
            }
        }
        return $news;
    }

    /**
     * @param array $items
     * @return array
     */
    public function createNews($items) {
        $news = array();
        foreach ($items as $item) {
            $enclosure = $item->get_enclosure();
            if ($enclosure && isset($enclosure->link))
                $pictureUrl = ltrim($enclosure->link, '/?#');
            else
                $pictureUrl = null;

            $news[] = (object)array(
                'title' => html_entity_decode($item->get_title()),
                'url' => html_entity_decode($item->get_link()),
                'pictureUrl' => $pictureUrl,
            );
        }
        return $news;
    }

    public function responsePortal($catid) {
        $feed = $this->createFeed(
            'http://bbs.gxun.cn/portal.php?mod=rss&catid=' . $catid);
        $this->response('news', $this->createNews($feed->get_items(0, 10)));
        $this->response('text', '由于暑假期间论坛关闭，暂时无法提供数据');
    }

    public function responseBBS($fid) {
        $feed = $this->createFeed(
            'http://bbs.gxun.cn/forum.php?mod=rss&fid=' . $fid);
        $this->response('news', $this->createNews($feed->get_items(0, 10)));
        $this->response('text', '由于暑假期间论坛关闭，暂时无法提供数据');
    }

    public function responseGxunNews($catid) {
        $feed = $this->createFeed(
            'http://news.gxun.edu.cn/rssFeed.aspx?cid=17');
        $this->response('news', array_merge(
            array((object)array(
                'title' => '民大要闻',
                'pictureUrl' => 'http://news.gxun.edu.cn/style/gxun/images/head.jpg',
                'url' => 'http://news.gxun.edu.cn/list.aspx?cid=17',
            )),
            $this->createNews($feed->get_items(0, 9))
        ));
    }

    /**
     * 学分统计
     *
     * @param array $scoreTable 成绩表
     * @return array 学分统计表
     */
    public function getCredits($scoreTable) {
        $credits = array();
        $total = 0;

        foreach ($scoreTable->tbody as $term) {
            foreach ($term as $row) {
                $total += $row[7];
                $course = array(
                  'name' => $row[0],
                  'credit' => $row[7],
                );

                if (array_key_exists($row[2], $credits)) {
                    $credits[$row[2]]['count'] += $row[7];
                    $credits[$row[2]]['courses'][] = $course;
                } else {
                  $credits[$row[2]] = array(
                    'count' => $row[7],
                    'courses' => array($course),
                  );
                }
            }
        }

        return array('total' => $total, 'credits' => $credits);
    }

    /**
     * 计算成绩分布情况
     *
     * @param array $scoreTable 成绩表
     * @return array 成绩分布表
     */
    public function getScoreDist($scoreTable) {
        $scoreDict = array();
        foreach ($scoreTable->tbody as $termScore) {
            foreach ($termScore as $row) {
                if ($row[6] >= 90)
                    $index = 0;
                else if ($row[6] >= 80)
                    $index = 1;
                else if ($row[6] >= 70)
                    $index = 2;
                else if ($row[6] >= 60)
                    $index = 3;
                else
                    $index = 4;

                $scoreDict[$index][] = array(
                    preg_replace('/\[.*?\]/', '', $row[0]),
                    $row[6],
                );
            }
        }
        return $scoreDict;
    }
}
