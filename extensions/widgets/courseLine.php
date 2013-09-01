<?php
/**
 * 课程时间轴部件
 */
class courseLine extends CWidget {
    /**
     * @var array 课程数组
     */
    public $courses = array();

    /**
     * @var array 上课时间表
     */
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
        $weekCourses = $this->getWeekCourse($this->courses, (int)date('N'));

        if (count($weekCourses) == 0) {
            echo '<p>今天居然没课！</p>';
            return;
        }

        echo '<div class="courseLine col-sm-offset-3 col-sm-6 col-lg-offset-4 col-lg-4">';
        echo '<ul>';

        foreach ($weekCourses as $course) {
            $timeStart = self::$timeTable[$course['lessonStart']][0];
            $timeTo = self::$timeTable[$course['lessonTo']][1];
            echo <<<EOT
            <li>
                <div>
                    <dl>
                        <dd>
                            <span class='glyphicon glyphicon-book'></span>
                            {$course['courseName']}
                        </dd>
                        <dd>
                            <span class='glyphicon glyphicon-map-marker'></span>
                            {$course['location']}
                        </dd>
                        <dd>
                            <span class='glyphicon glyphicon-time'></span>
                            {$timeStart} - {$timeTo}
                        </dd>
                        <dd>
                            <span class='glyphicon glyphicon-user'></span>
                            {$course['teacherName']}
                        </dd>
                        <dd>
                            <span class='glyphicon glyphicon-tag'></span>
                            {$course['examType']}课
                        </dd>
                    </dl>
                    <div class="arrow"></div>
                    <div class="circle"></div>
                </div>
            </li>
EOT;
        }

        echo '</ul>';
        echo '<div class="line"></div>';
        echo '</div>';
    }

    /**
     * 提取周课程
     * @param array $courses 原课程数组
     * @param int $weekDay
     * @return array 周课程数组
     */
    public function getWeekCourse($courses, $weekDay) {
        $weekCourses = array();
        foreach ($courses as $course)
            if ($course['weekDay'] == $weekDay)
                $weekCourses[] = $course;

        usort($weekCourses, function($a, $b) {
            return $a['lessonStart'] > $b['lessonStart'];
        });

        return $weekCourses;
    }
}
