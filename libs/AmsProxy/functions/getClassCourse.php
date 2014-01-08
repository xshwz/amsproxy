<?php
/**
 * 获取班级课表
 *
 * @param string class name
 */
class getClassCourse extends __base__ {
    public function getData() {
        include 'getClassCode.php';
        $getCode = new getClassCode($this->amsProxy, $this->args);

        if ($classCode = $getCode->run()) { // don't panic
            return $this->amsProxy->POST(
                'ZNPK/KBFB_ClassSel_rpt.aspx',
                array(
                    'Sel_XNXQ' => $this->getXNXQ(),
                    'Sel_XZBJ' => $classCode['code'][0],
                    'type'     => 2,
                    'chkrxkc'  => 1,
                ),
                null, $this->amsProxy->baseUrl . 'ZNPK/KBFB_ClassSel.aspx'
            );
        } else {
            return null;
        }
    }

    public function parse($dom) {
        if (!$dom->textContent)
            return array();

        $courses = array();
        if ($table = $dom->getElementsByTagName('table')->item(3)) {
            $tds = $table->getElementsByTagName('td');

            for ($i = 10; $i < $tds->length - 1; $i += 10) {
                for ($j = 0; $j < 10; $j++)
                    if ($tds->item($i + $j)->textContent)
                        $course[$j] = $tds->item($i + $j)->textContent;

                preg_match('/(...)\[(\d+)-?(\d+)?节\]/', $course[8], $lesson);
                $week = explode('-', $course[7]);

                $courses[] = array(
                    'courseName'  => preg_replace('/^\[.*?\]/', '', $course[0]),
                    'credit'      => $course[1],
                    'totalHour'   => $course[2],
                    'examType'    => $course[3],
                    'teacherName' => preg_replace('/^\[.*?\]/', '', $course[4]),
                    'weekStart'   => (int)$week[0],
                    'weekTo'      => isset($week[1]) ? (int)$week[1] : (int)$week[0],
                    'weekDay'     => self::$weekDict[$lesson[1]],
                    'lessonStart' => (int)$lesson[2],
                    'lessonTo'    => isset($lesson[3]) ? (int)$lesson[3] : (int)$lesson[2],
                    'location'    => isset($course[9]) ? $course[9] : '',
                );
            }

            return $courses;
        } else {
            return array();
        }
    }
}
