<?php
class Student extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return array
     */
    public function getArchives() {
        return json_decode($this->archives);
    }

    /**
     * @param int $wday
     * @return array|null
     */
    public function getWeekCourses($wday) {
        foreach (json_decode($this->course) as $course)
            if ($course->weekDay == $wday)
                $weekCourses[] = $course;

        return isset($weekCourses) ? $weekCourses : null;
    }
}
