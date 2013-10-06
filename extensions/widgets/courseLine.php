<?php
/**
 * 课程时间轴部件
 */
class courseLine extends CWidget {
    /**
     * @var array 课程数组
     */
    public $courses = array();

    public function run() {
        $weekCourses = $this->getWeekCourse($this->courses, (int)date('N'));

        if (count($weekCourses) == 0) {
            echo '<p><img src="img/rage_comics/happy-epic-win.png" class="img-responsive" alt="rage comic - happy epic win"></p>';
            return;
        }

        echo '<div class="courseLine col-sm-offset-3 col-sm-6 col-lg-offset-4 col-lg-4">';
        echo '<ul>';

        foreach ($weekCourses as $course) {
            $timeStart = schedule($course['lessonStart'], 0);
            $timeTo = schedule($course['lessonTo'], 1);

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
                            {$course['lessonStart']} - {$course['lessonTo']}（{$timeStart} - {$timeTo}）
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
            if ($course['weekDay'] == $weekDay) {
                if (isset($weekCourses[$course['lessonStart']])) {
                    $weekCourses[$course['lessonStart']]['teacherName'] .= ',' . $course['teacherName'];
                    $weekCourses[$course['lessonStart']]['location'] .= ',' . $course['location'];
                }
                else
                    $weekCourses[$course['lessonStart']] = $course;
            }

        return $weekCourses;
    }
}
