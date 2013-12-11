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
        $weekCourses = array();

        foreach (json_decode($this->course) as $course) {
            if ($course->weekDay == $wday) {
                if (isset($weekCourses[$course->lessonStart])) {
                    $weekCourses[$course->lessonStart]->teacherName .=
                        '，' . $course->teacherName;
                    $weekCourses[$course->lessonStart]->location .=
                        '，' . $course->location;
                } else {
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
