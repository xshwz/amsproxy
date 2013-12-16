<?php
/**
 * 课程表部件
 */
class courseTable extends CWidget {
    /**
     * @var array
     */
    public $courses = array();

    public function run() {
        $courseTable = $this->coursesConvert($this->courses);

        echo <<<EOT
            <div class="table-responsive">
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
                    if ($course->isCourse) {
                        $timeStart = Setting::$timetable[$course->lessonStart][0];
                        $timeTo = Setting::$timetable[$course->lessonTo][1];

                        $teacherName = $this->more($course, 'teacherName');
                        $location = $this->more($course, 'location');

                        echo CHtml::openTag('td', array(
                            'class' => "course course-{$course->seq}",
                            'rowspan' => $course->lessonSpan));

                        echo CHtml::openTag('div', array(
                            'title' => "
                                <p>
                                    <span class='glyphicon glyphicon-book'></span>
                                    {$course->courseName}
                                </p>
                                <p>
                                    <span class='glyphicon glyphicon-map-marker'></span>
                                    {$location}
                                </p>
                                <p>
                                    <span class='glyphicon glyphicon-time'></span>
                                    {$course->lessonStart} - {$course->lessonTo}（{$timeStart} - {$timeTo}）
                                </p>
                                <p>
                                    <span class='glyphicon glyphicon-user'></span>
                                    {$teacherName}
                                </p>
                                <p>
                                    <span class='glyphicon glyphicon-tag'></span>
                                    {$course->examType}课
                                </p>
                                ",
                            'data-html' => true,
                        ));

                        echo $course->courseName;
                        echo '</div>';
                        echo '</td>';
                    } else {
                        echo "<td rowspan='{$course->lessonSpan}'></td>";
                    }
                }
            }

            echo '</tr>';
        }
        echo '</tbody></table></div>';
    }

    /**
     * 将课程数组转换成方便遍历输出的课程表
     *
     * @param array $courses
     * @return array
     */
    public function coursesConvert($courses) {
        $coursesSeq = $this->getCoursesSeq($courses);

        foreach ($courses as $course) {
            $course->seq = $coursesSeq[$course->courseName];
            $course->isCourse = true;
            $course->lessonSpan = $course->lessonTo - $course->lessonStart + 1;
            if (isset($courseMap[$course->weekDay][$course->lessonStart])) {
                $courseMap[$course->weekDay][$course->lessonStart]->teacherName[]
                    = $course->teacherName;
                $courseMap[$course->weekDay][$course->lessonStart]->location[]
                    = $course->location;
            } else {
                $course->teacherName = array($course->teacherName);
                $course->location = array($course->location);
                $courseMap[$course->weekDay][$course->lessonStart] = $course;
            }
        }


        for ($weekDay = 1; $weekDay <= 7; $weekDay++) {
            $lessonStart = 1;
            $lessonSpan = 1;
            for ($lessonNum = 1; $lessonNum <= 12; $lessonNum++) {
                if (isset($courseMap[$weekDay][$lessonNum])) {
                    $courseTable[$weekDay][$lessonNum] = $courseMap[$weekDay][$lessonNum];
                    $lessonNum += $courseMap[$weekDay][$lessonNum]->lessonSpan - 1;
                    $lessonStart = $lessonNum + 1;
                    $lessonSpan = 1;
                } else if (
                    isset($courseMap[$weekDay][$lessonNum + 1]) ||
                    $lessonNum == 5 ||
                    $lessonNum == 9 ||
                    $lessonNum == 12
                ) {
                    $courseTable[$weekDay][$lessonStart] = (object)array(
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
     * @param array $courses
     * @return array
     * @example return array('操作系统' => 0, '软件工程' => 1)
     */
    public function getCoursesSeq($courses) {
        $coursesSeq = array();

        foreach ($courses as $course)
            if (!array_key_exists($course->courseName, $coursesSeq))
                $coursesSeq[$course->courseName] = count($coursesSeq);

        return $coursesSeq;
    }

    /**
     * @param array $array
     * @return string
     */
    public function implode($array) {
        $result = '';
        foreach ($array as $index => $item) {
            $index += 1;
            $result .= "{$index}、{$item}\n";
        }
        return trim($result);
    }

    public function more($course, $key) {
        if (count($course->location) > 1) {
            return
                '<abbr title="' . $this->implode($course->{$key}) . '">' .
                    $course->{$key}[0] .
                '<abbr>';
        } else {
            return $course->{$key}[0];
        }
    }
}
