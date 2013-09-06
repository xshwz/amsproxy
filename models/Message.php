<?php
/**
 * 反馈数据模型
 */
class Message extends CActiveRecord {
    public function relations() {
        return array(
            'sender_info' => array(
                self::BELONGS_TO, 'Student', 'sender',
                'select' => 'info'
            ),
            'receiver_info' => array(
                self::BELONGS_TO, 'Student', 'receiver',
                'select' => 'info'
            )
        );
    }
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
}
