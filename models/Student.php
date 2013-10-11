<?php
/**
 * 学生数据模型
 */
class Student extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * 获取学籍档案
     * @return array
     */
    public function getArchives() {
        return json_decode($this->archives);
    }
}
