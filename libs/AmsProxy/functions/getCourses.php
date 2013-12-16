<?php
/**
 * 获取课程课表
 *
 * @param string course name
 */
class getCourses extends __base__ {
    public function run() {
        include 'getCourseCode.php';
        $getCode = new getCourseCode($this->amsProxy, $this->args);
        $courses = $getCode->run();

        if (!$courses)
            return array();

        $courseTable = array();

        foreach ($courses['code'] as $courseCode) {
            $html = $this->amsProxy->POST(
                'ZNPK/KBFB_LessonSel_rpt.aspx',
                array(
                    'Sel_XNXQ' => $this->getXNXQ(),
                    'Sel_KC'   => $courseCode,
                    'gs'       => 2,
                )
            );

            $dom = $this->dom($this->htmlFinishing($html));
            $tables = $dom->getElementsByTagName('table');
            $courseTable[] = $this->parse($tables);
        }

        return $courseTable;
    }

    public function parse($tables) {
        if ($tables->length < 4)
            return;

        preg_match(
            '/承担单位：(.*)课程.*](.*)总学时：(.*)学分：(.*)/',
            $tables->item(2)->textContent,
            $matches);

        $courseTable = array(
            'department' => $matches[1],
            'courseName' => $matches[2],
            'totalHour' => $matches[3],
            'credit' => $matches[4],
            'courses' => array(),
        );

        $trs = $tables->item(3)->getElementsByTagName('tr');

        for ($i = 1; $i < $trs->length; $i++) {
            $tds = $trs->item($i)->getElementsByTagName('td');
            $week = explode('-', $tds->item(6)->textContent);
            preg_match(
                '/(.*)\[(\d+)-(\d+)/', $tds->item(7)->textContent, $lesson);
            $courseTable['courses'][] = array(
                'teacherName' => $tds->item(0)->textContent,
                'students'    => (int)$tds->item(2)->textContent,
                'courseType'  => $tds->item(3)->textContent,
                'examType'    => $tds->item(4)->textContent,
                'class'       => explode(' ', $tds->item(5)->textContent),
                'weekDay'     => self::$weekDict[$lesson[1]],
                'weekStart'   => $week[0],
                'weekTo'      => isset($week[1]) ? (int)$week[1] : (int)$week[0],
                'lessonStart' => (int)$lesson[2],
                'lessonTo'    => (int)$lesson[3],
                'location'    => $tds->item(8)->textContent,
            );
        }

        return $courseTable;
    }
}
