<?php
class WechatLog extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'wechat_log';
    }

    /**
     * @param string $message
     */
    public static function add($message) {
        $log = new WechatLog;
        $log->message = $message;
        $log->save();
    }
}
