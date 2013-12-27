<?php
class Student extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @param int $wday
     * @return array|null
     */
    public function getWeekCourses($wday) {
        return self::_getWeekCourse(json_decode($this->course), $wday);
    }

    /**
     * @param array $courses
     * @return array
     */
    public static function _getWeekCourse($courses, $wday) {
        $weekCourses = array();

        foreach ($courses as $course) {
            if ($course->weekDay == $wday) {
                if (isset($weekCourses[$course->lessonStart])) {
                    $weekCourses[$course->lessonStart]->teacherName[] =
                        $course->teacherName;
                    $weekCourses[$course->lessonStart]->location[] =
                        $course->location;
                } else {
                    $course->teacherName = array($course->teacherName);
                    $course->location = array($course->location);
                    $weekCourses[$course->lessonStart] = $course;
                }
            }
        }

        usort($weekCourses, function($a, $b){
            return $a->lessonStart > $b->lessonStart;
        });

        return $weekCourses;
    }
}
