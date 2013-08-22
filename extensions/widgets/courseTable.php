<?php
class courseTable extends CWidget {
    public $courseTable = array();

    public static $timeTable = array(
		 1 => array( '7:50',  '8:30'),
		 2 => array( '8:40',  '9:20'),
		 3 => array( '9:30', '10:10'),
		 4 => array('10:30', '11:10'),
		 5 => array('11:20', '12:00'),
		 6 => array('14:30', '15:10'),
		 7 => array('15:20', '16:00'),
		 8 => array('16:10', '16:50'),
		 9 => array('17:00', '17:40'),
		10 => array('19:40', '20:20'),
		11 => array('20:30', '21:10'),
        12 => array('21:20', '22:00'),
    );

    public function run() {
        $courseTable = $this->getCourseTable();

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
                    </tr>
                </thead>
                <tbody>
EOT;
        for ($lessonNum = 1; $lessonNum <= 12; $lessonNum++) {
            echo '<tr>';
            echo "<td>{$lessonNum}</td>";

            for ($weekDay = 1; $weekDay <= 5; $weekDay++) {
                if (isset($courseTable[$weekDay][$lessonNum])) {
                    $course = $courseTable[$weekDay][$lessonNum];
                    if ($course['isCourse']) {
                        $timeStart = self::$timeTable[$course['lessonStart']][0];
                        $timeTo = self::$timeTable[$course['lessonTo']][1];
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
                                ",
                            'data-html' => true,
                        ));
                        echo $course['courseName'];
                        echo '</div>';
                        echo '</td>';
                    } else {
                        echo CHtml::tag('td', array(
                            'rowspan' => $course['lessonSpan']));
                    }
                }
            }

            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public function getCourseTable() {
        $coursesSeq = $this->getCoursesSeq($this->courseTable);

        foreach ($this->courseTable as $course) {
            $course['seq'] = $coursesSeq[$course['courseName']];
            $course['isCourse'] = true;
            $course['lessonSpan'] = $course['lessonTo'] - $course['lessonStart'] + 1;
            $courseMap[$course['weekDay']][$course['lessonStart']] = $course;
        }

        for ($weekDay = 1; $weekDay <= 5; $weekDay++) {
            $lessonStart = 1;
            $lessonSpan = 1;
            for ($lessonNum = 1; $lessonNum <= 12; $lessonNum++) {
                if (isset($courseMap[$weekDay][$lessonNum])) {
                    $courseTable[$weekDay][$lessonNum] = $courseMap[$weekDay][$lessonNum];
                    $lessonNum += $courseMap[$weekDay][$lessonNum]['lessonSpan'] - 1;
                    $lessonStart = $lessonNum + 1;
                    $lessonSpan = 1;
                } else if (isset($courseMap[$weekDay][$lessonNum + 1]) || $lessonNum == 12) {
                    $courseTable[$weekDay][$lessonStart] = array(
                        'lessonSpan' => $lessonSpan,
                        'isCourse' => false,
                    );
                    $lessonStart = $lessonNum + 1;
                    $lessonSpan = 1;
                } else {
                    $lessonSpan++;
                }
            }
        }

        return $courseTable;
    }

    public function getCoursesSeq($courseTable) {
        foreach ($this->courseTable as $course)
            if (!array_key_exists($course['courseName'], $courses))
                $courses[$course['courseName']] = count($courses);

        return $courses;
    }
}
