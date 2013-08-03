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
    public function __construct($html) {
        $this->dom = new DOMDocument();
        $this->loadHtml($html);
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
        $html = str_replace('gb2312', 'utf-8', $html);
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
     * @return string 原始成绩
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
}
