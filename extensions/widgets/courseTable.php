<?php
class courseTable extends CWidget {
    /**
     * @var array 课程数组
     */
    public $courses = array();

    public function run() {
        $courseTable = $this->coursesConvert($this->courses);

        echo <<<EOT
            <table class="courseTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>星期一</th>
                        <th>星期二</th>
                        <th>星期三</th>
                        <th>星期四</th>
                        <th>星期五</th>
                        <th>星期六</th>
                        <th>星期日</th>
                    </tr>
                </thead>
                <tbody>
EOT;

        for ($lessonNum = 1; $lessonNum <= 12; $lessonNum++) {
            echo '<tr>';
            echo "<td>{$lessonNum}</td>";

            for ($weekDay = 1; $weekDay <= 7; $weekDay++) {
                if (isset($courseTable[$weekDay][$lessonNum])) {
                    $course = $courseTable[$weekDay][$lessonNum];
                    if ($course['isCourse']) {
                        $timeStart = schedule($course['lessonStart'], 0);
                        $timeTo = schedule($course['lessonTo'], 1);

                        echo CHtml::openTag('td', array(
                            'class' => "course course-{$course['seq']}",
                            'rowspan' => $course['lessonSpan']));

                        echo CHtml::openTag('div', array(
                            'title' => "
                                <p>
                                    <span class='glyphicon glyphicon-book'></span>
                                    {$course['courseName']}
                                </p>
                                <p>
                                    <span class='glyphicon glyphicon-map-marker'></span>
                                    {$course['location']}
                                </p>
                                <p>
                                    <span class='glyphicon glyphicon-time'></span>
                                    {$timeStart} - {$timeTo}
                                </p>
                                <p>
                                    <span class='glyphicon glyphicon-user'></span>
                                    {$course['teacherName']}
                                </p>
                                <p>
                                    <span class='glyphicon glyphicon-tag'></span>
                                    {$course['examType']}课
                                </p>
                                ",
                            'data-html' => true,
                        ));

                        echo $course['courseName'];
                        echo '</div>';
                        echo '</td>';
                    } else {
                        echo "<td rowspan='{$course['lessonSpan']}'></td>";
                    }
                }
            }

            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    /**
     * 将课程数组转换成方便遍历输出的课程表
     * @param array $courses 课程数组
     * @return array 课程表
     */
    public function coursesConvert($courses) {
        $coursesSeq = $this->getCoursesSeq($courses);

        foreach ($courses as $course) {
            $course['seq'] = $coursesSeq[$course['courseName']];
            $course['isCourse'] = true;
            $course['lessonSpan'] = $course['lessonTo'] - $course['lessonStart'] + 1;
            if (isset($courseMap[$course['weekDay']][$course['lessonStart']])) {
                $courseMap[$course['weekDay']][$course['lessonStart']]['teacherName'] .= ',' . $course['teacherName'];
                $courseMap[$course['weekDay']][$course['lessonStart']]['location'] .= ',' . $course['location'];
            }
            else
                $courseMap[$course['weekDay']][$course['lessonStart']] = $course;
        }


        for ($weekDay = 1; $weekDay <= 7; $weekDay++) {
            $lessonStart = 1;
            $lessonSpan = 1;
            for ($lessonNum = 1; $lessonNum <= 12; $lessonNum++) {
                if (isset($courseMap[$weekDay][$lessonNum])) {
                    $courseTable[$weekDay][$lessonNum] = $courseMap[$weekDay][$lessonNum];
                    $lessonNum += $courseMap[$weekDay][$lessonNum]['lessonSpan'] - 1;
                    $lessonStart = $lessonNum + 1;
                    $lessonSpan = 1;
                } else if (
                    isset($courseMap[$weekDay][$lessonNum + 1]) ||
                    $lessonNum == 5 ||
                    $lessonNum == 9 ||
                    $lessonNum == 12
                ) {
                    $courseTable[$weekDay][$lessonStart] = array(
                        'lessonSpan' => $lessonSpan,
                        'isCourse' => false);
                    $lessonStart = $lessonNum + 1;
                    $lessonSpan = 1;
                } else {
                    $lessonSpan++;
                }
            }
        }

        return $courseTable;
    }

    /**
     * 获取不重复课程及其序号
     * @param array $courses 课程数组
     * @return array “课程 => 序号”数组
     * @example return array('操作系统' => 0, '软件工程' => 1)
     */
    public function getCoursesSeq($courses) {
        $coursesSeq = array();
        foreach ($courses as $course)
            if (!array_key_exists($course['courseName'], $coursesSeq))
                $coursesSeq[$course['courseName']] = count($coursesSeq);

        return $coursesSeq;
    }
}
