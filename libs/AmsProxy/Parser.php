<?php

/**
 * 解析 html
 */
class Parser {
    /**
     * @var DOMDocument
     */
    public $dom;

    /**
     * @param string $html
     */
    public function __construct($html='') {
        error_reporting(E_ERROR);
        $this->dom = new DOMDocument();
        if ($html) $this->loadHtml($html);
    }

    /**
     * 加载 html
     * @param string $html
     */
    public function loadHtml($html) {
        $this->dom->loadHTML($this->preProcess($html));
    }

    /**
     * html 预处理
     * @param string $html
     * @return string
     */
    public function preProcess($html) {
        $html = str_replace('<br>', '', $html);
        $html = str_replace('&nbsp;', '', $html);
        $html = '
            <meta
                http-equiv="Content-Type"
                content="text/html;
                charset=utf-8"
            >' . $html;
        return $html;
    }

    /**
     * 移除空白字符
     * @param string $s
     * @return string
     */
    public function strip($s) {
        return str_replace(' ', '', $s);
    }

    /**
     * @return array 学生信息
     */
    public function studentInfo() {
        $table = $this->dom->getElementsByTagName('table')->item(0);
        foreach ($table->getElementsByTagName('tr') as $tr) {
            $tds = $tr->getElementsByTagName('td');
            for ($i = 1; $i < $tds->length; $i += 2) {
                $key = $this->strip($tds->item($i - 1)->textContent);
                $value = $this->strip($tds->item($i)->textContent);
                if ($value) $studentInfo[$key] = $value;
            }
        }
        return $studentInfo;
    }

    /**
     * @return array 有效成绩
     */
    public function effectiveScore() {
        $score = array(
            'thead' => array(
                '课程/环节',
                '学分',
                '类别',
                '课程类别',
                '考核方式',
                '修读性质',
                '成绩',
                '取得学分',
                '绩点',
                '学分绩点',
            ),
        );
        $tables = $this->dom->getElementsByTagName('table');
        foreach ($tables->item(2)->getElementsByTagName('tr') as $tr) {
            $tds = $tr->getElementsByTagName('td');
            if ($term_name = trim($tds->item(0)->textContent))
                $termName = $term_name;
            $score['tbody'][$termName][] = array(
                $tds->item(1)->textContent,
                $tds->item(2)->textContent,
                $tds->item(3)->textContent,
                $tds->item(4)->textContent,
                $tds->item(5)->textContent,
                $tds->item(6)->textContent,
                $tds->item(7)->textContent,
                $tds->item(8)->textContent,
                $tds->item(9)->textContent,
                $tds->item(10)->textContent,
            );
        }
        return $score;
    }

    /**
     * @return array 原始成绩
     */
    public function originalScore() {
        $score = array(
            'thead' => array(
                '课程/环节',
                '学分',
                '类别',
                '课程类别',
                '考核方式',
                '修读性质',
                '平时',
                '中考',
                '末考',
                '技能',
                '综合',
            ),
        );
        $tables = $this->dom->getElementsByTagName('table');
        for ($i = 1; $i < $tables->length; $i += 3) {
            $termName = $tables
                ->item($i)
                ->getElementsByTagName('td')
                ->item(0)
                ->textContent;
            $termName = substr($termName, 15);
            $termScore = $tables->item($i + 2);
            foreach ($termScore->getElementsByTagName('tr') as $tr) {
                $tds = $tr->getElementsByTagName('td');
                $score['tbody'][$termName][] = array(
                    $tds->item(1)->textContent,
                    $tds->item(2)->textContent,
                    $tds->item(3)->textContent,
                    $tds->item(4)->textContent,
                    $tds->item(5)->textContent,
                    $tds->item(6)->textContent,
                    $tds->item(7)->textContent,
                    $tds->item(8)->textContent,
                    $tds->item(9)->textContent,
                    $tds->item(10)->textContent,
                    $tds->item(11)->textContent,
                );
            }
        }
        return $score;
    }

    /**
     * @return array 成绩分布
     */
    public function distributionScore() {
        $score = array(
            'thead' => array(
                '课程/环节',
                '学分',
                '类别',
                '考核方式',
                '修读性质',
                '[100, 90]优秀',
                '(90, 80]良好',
                '(80, 70]中等',
                '(70, 60]及格',
                '(60, 0]不及格',
            ),
        );
        $tables = $this->dom->getElementsByTagName('table');
        foreach ($tables->item(1)->getElementsByTagName('tr') as $tr) {
            $tds = $tr->getElementsByTagName('td');
            if ($term_name = trim($tds->item(0)->textContent))
                $termName = $term_name;
            if ($termName == '合计') break;
            $score['tbody'][$termName][] = array(
                $tds->item(1)->textContent,
                $tds->item(2)->textContent,
                trim($tds->item(3)->textContent),
                trim($tds->item(4)->textContent),
                $tds->item(5)->textContent,
                $tds->item(6)->textContent,
                $tds->item(7)->textContent,
                $tds->item(8)->textContent,
                $tds->item(9)->textContent,
                $tds->item(10)->textContent,
            );
        }
        return $score;
    }

    /**
     * @return array 等级考试报名情况表
     */
    public function rankExamSign() {
        $exam = array(
            'thead' => array(
                '等级',
                '构成',
                '考试年月',
                '收费标准（元）',
                '报名时间区段',
                '状态',
                '限定名额',
                '剩余名额',
            ),
        );
        $tables = $this->dom->getElementsByTagName('table');
        foreach ($tables->item(3)->getElementsByTagName('tr') as $tr) {
            $tds = $tr->getElementsByTagName('td');
            if ($type_name = trim($tds->item(1)->textContent))
                $typeName = $type_name;
            $exam['tbody'][$typeName][] = array(
                $tds->item(2)->textContent,
                $tds->item(3)->textContent,
                $tds->item(4)->textContent,
                $tds->item(5)->textContent,
                $tds->item(6)->textContent . ' - ' . $tds->item(7)->textContent,
                $tds->item(8)->textContent,
                $tds->item(10)->textContent,
                $tds->item(11)->textContent,
            );
        }
        return $exam;
    }

    /**
     * @return array 考试安排
     */
    public function examArrange() {
        $exam = array(
            'thead' => array(
                '课程',
                '学分',
                '类别',
                '考核方式',
                '考试时间',
                '考试地点',
                '座位号',
            ),
        );
        $tables = $this->dom->getElementsByTagName('table');
        foreach($tables->item(2)->getElementsByTagName('tr') as $tr) {
            $tds = $tr->getElementsByTagName('td');
            $exam['tbody'][] = array(
                $tds->item(1)->textContent,
                $tds->item(2)->textContent,
                $tds->item(3)->textContent,
                $tds->item(4)->textContent,
                $tds->item(5)->textContent,
                $tds->item(6)->textContent,
                $tds->item(7)->textContent,
            );
        }
        return $exam;
    }

    /**
     * @return array 理论课程
     */
    public function theorySubject() {
        $subject = array(
            'thead' => array(
                '课程',
                '学分',
                '课程类别',
                '考核方式',
                '总学时',
                '讲授学时',
                '实验学时',
                '上机学时',
                '其它学时',
                '周学时',
            ),
        );
        $tables = $this->dom->getElementsByTagName('table');
        foreach ($tables->item(2)->getElementsByTagName('tr') as $tr) {
            $tds = $tr->getElementsByTagName('td');
            if ($term_name = trim($tds->item(1)->textContent))
                $termName = $term_name;
            $subject['tbody'][$termName][] = array(
                $tds->item(2)->textContent,
                $tds->item(3)->textContent,
                $tds->item(4)->textContent,
                $tds->item(5)->textContent,
                $tds->item(6)->textContent,
                $tds->item(7)->textContent,
                $tds->item(8)->textContent,
                $tds->item(9)->textContent,
                $tds->item(10)->textContent,
                $tds->item(11)->textContent,
            );
        }
        return $subject;
    }

    /**
     * @return array 实践环节
     */
    public function practiceSubject() {
        $subject = array(
            'thead' => array(
                '环节',
                '学分',
                '环节类别',
                '考核方式',
                '周数',
            ),
        );
        $tables = $this->dom->getElementsByTagName('table');
        foreach ($tables->item(2)->getElementsByTagName('tr') as $tr) {
            $tds = $tr->getElementsByTagName('td');
            if ($term_name = trim($tds->item(1)->textContent))
                $termName = $term_name;
            $subject['tbody'][$termName][] = array(
                $tds->item(2)->textContent,
                $tds->item(3)->textContent,
                $tds->item(4)->textContent,
                $tds->item(5)->textContent,
                $tds->item(6)->textContent,
            );
        }
        return $subject;
    }

    /**
     * 课程表
     */
    public function course() {
        $course = array(
            'thead' => array(
                '课程',
                '学分',
                '总学时',
                '授课学时',
                '上机学时',
                '类别',
                '授课方式',
                '考核方式',
                '任课教师',
                '周次',
                '节次',
                '上课地点',
            ),
        );

        $tables = $this->dom->getElementsByTagName('table');
        $courseType = $tables->item(0)->getElementsByTagName('td')->item(0);

        if ($courseType->textContent == '讲授/上机') {
            $courseItem = array();
            $trs = $tables->item(1)->getElementsByTagName('tr');

            for ($i = 2; $i < $trs->length - 1; $i++) {
                $tds = $trs->item($i)->getElementsByTagName('td');

                for ($j = 0; $j < 12; $j++)
                    if ($tds->item($j + 1)->textContent)
                        $courseItem[$j] = $tds->item($j + 1)->textContent;

                $course['tbody'][] = $courseItem;
            }

            return $course;
        } else {
            return null;
        }
    }

    /**
     * @param number $type 排版类型, 0按星期, 1按科目
     * @return array 课程安排表
     */
    public function timetable($type) {
        // 未完成
    }
}
