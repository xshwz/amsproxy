<?php
class WechatMessage extends CActiveRecord {
    public function relations() {
        return array(
            'student' => array(
                self::BELONGS_TO,
                'Student',
                array(
                    'openid' => 'wechat_openid',
                ),
                'select' => 'archives',
            ),
        );
    }

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'wechat_message';
    }
}
