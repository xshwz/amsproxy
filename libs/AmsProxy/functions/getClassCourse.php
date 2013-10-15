<?php
/**
 * 获取班级课表
 *
 * @param string class name
 */
class getClassCourse extends __base__ {
    public function getData() {
        return $this->amsProxy->POST(
            'ZNPK/KBFB_ClassSel_rpt.aspx',
            array(
                'Sel_XNXQ' => '20130',
                'Sel_XZBJ' => $this->getClassCode($this->args),
                'type'     => 2,
                'chkrxkc'  => 1,
            )
        );
    }

    public function parse($dom) {
        $courses = array();
        $table = $dom->getElementsByTagName('table')->item(3);
        $tds = $table->getElementsByTagName('td');

        for ($i = 10; $i < $tds->length - 1; $i += 10) {
            for ($j = 0; $j < 10; $j++)
                if ($tds->item($i + $j)->textContent)
                    $course[$j] = $tds->item($i + $j)->textContent;

            preg_match('/(...)\[(\d+)-(\d+)节\]/', $course[8], $lesson);
            $week = explode('-', $course[7]);
            $courses[] = array(
                'courseName'  => preg_replace('/^\[.*?\]/', '', $course[0]),
                'credit'      => $course[1],
                'totalHour'   => $course[2],
                'examType'    => $course[3],
                'teacherName' => preg_replace('/^\[.*?\]/', '', $course[4]),
                'weekStart'   => (int)$week[0],
                'weekTo'      => (int)$week[1],
                'weekDay'     => (int)self::$weekDict[$lesson[1]],
                'lessonStart' => (int)$lesson[2],
                'lessonTo'    => (int)$lesson[3],
                'location'    => $course[9],
            );
        }

        return $courses;
    }

    /**
     * @param string $className
     * @return array
     */
    public function getClassCode($className) {
        $classInfo = $this->amsProxy->GET(
            'ZNPK/Private/List_XZBJ.aspx',
            array(
                'xnxq' => '20130',
                'xzbj' => iconv('utf-8', 'gb18030', $className),
            )
        );

        preg_match('/option value=(\d+)/', $classInfo, $matches);
        return $matches[1];
    }
}
