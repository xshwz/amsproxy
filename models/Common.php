<?php
class Common extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
}