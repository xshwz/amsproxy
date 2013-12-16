<?php
/**
 * 课程时间轴部件
 */
class courseLine extends CWidget {
    /**
     * @var array
     */
    public $courses = array();

    /**
     * @var ing
     */
    public $wday;

    public function run() {
        if (!isset($this->wday))
            $this->wday = (int)date('N');

        $weekCourses = Student::_getWeekCourse($this->courses, $this->wday);

        if (count($weekCourses) == 0) {
            echo '<p><img src="img/rage_comics/happy-epic-win.png" class="img-responsive" alt="rage comic - happy epic win"></p>';
            echo '<h2>今天居然没课～</h2>';
            return;
        }

        echo '<div class="courseLine col-sm-offset-3 col-sm-6 col-lg-offset-4 col-lg-4">';
        echo '<ul>';

        foreach ($weekCourses as $course) {
            $timeStart = Setting::$timetable[$course->lessonStart][0];
            $timeTo = Setting::$timetable[$course->lessonTo][1];

            $teacherName = $this->more($course, 'teacherName');
            $location = $this->more($course, 'location');

            echo <<<EOT
            <li>
                <div>
                    <dl>
                        <dd>
                            <span class='glyphicon glyphicon-book'></span>
                            {$course->courseName}
                        </dd>
                        <dd>
                            <span class='glyphicon glyphicon-map-marker'></span>
                            {$location}
                        </dd>
                        <dd>
                            <span class='glyphicon glyphicon-time'></span>
                            {$course->lessonStart} - {$course->lessonTo}（{$timeStart} - {$timeTo}）
                        </dd>
                        <dd>
                            <span class='glyphicon glyphicon-user'></span>
                            {$teacherName}
                        </dd>
                        <dd>
                            <span class='glyphicon glyphicon-tag'></span>
                            {$course->examType}课
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
     * @param array $array
     * @return string
     */
    public function implode($array) {
        $result = '';
        foreach ($array as $index => $item) {
            $index += 1;
            $result .= "{$index}、{$item}";
            if ($index != count($array))
                $result .= '<br>';
        }
        return $result;
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
