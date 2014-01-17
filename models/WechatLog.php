<?php
class WechatLog extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'wechat_log';
    }

    static public $status = array(
        'default' => 0,
        'success' => 1,
        'failure' => 2,
    );
}
