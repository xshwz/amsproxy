<?php
/**
 * 获取个人课表
 *
 * @param string term number
 */
class getPersonalCourse extends __base__ {
    public function getData() {
        return $this->amsProxy->POST(
            'znpk/Pri_StuSel_rpt.aspx',
            array(
                'Sel_XNXQ' => $this->args,
                'rad'      => 1,
                'px'       => 0,
            )
        );
    }

    public function parse($dom) {
        $tables = $dom->getElementsByTagName('table');
        $courseType = $tables->item(0)->getElementsByTagName('td')->item(0);

        if ($courseType->textContent == '讲授/上机') {
            $course = array();
            $trs = $tables->item(1)->getElementsByTagName('tr');

            for ($i = 2; $i < $trs->length - 1; $i++) {
                $tds = $trs->item($i)->getElementsByTagName('td');

                for ($j = 0; $j < $tds->length; $j++) {
                    if (isset($tds->item($j + 1)->textContent))
                        $course[$j] = $tds->item($j + 1)->textContent;
                }

                $courses[] = $course;
            }

            return $this->convert($courses);
        } else {
            return array();
        }
    }

    /**
     * @param array $originalCourse
     * @return array
     */
    public function convert($originalCourse) {
        $courses = array();

        foreach ($originalCourse as $course) {
            preg_match('/(...)\[(\d+)-(\d+)节\]/', $course[10], $lesson);
            $week = explode('-', $course[9]);

            $courses[] = array(
                'courseName'  => preg_replace('/^\[.*?\]/', '', $course[0]),
                'credit'      => $course[1],
                'totalHour'   => $course[2],
                'courseType'  => $course[5],
                'teachType'   => $course[6],
                'examType'    => $course[7],
                'teacherName' => $course[8],
                'weekStart'   => (int)$week[0],
                'weekTo'      => (int)$week[1],
                'weekDay'     => (int)self::$weekDict[$lesson[1]],
                'lessonStart' => (int)$lesson[2],
                'lessonTo'    => (int)$lesson[3],
                'location'    => $course[11],
            );
        }

        return $courses;
    }
}
