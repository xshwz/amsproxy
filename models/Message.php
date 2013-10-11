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

    /**
     * 获取未读消息
     * @param int $receiverId 接收者ID
     * @return array 未读消息
     */
    public static function unread($receiverId) {
        return self::model()->findAll(array(
            'condition' => 'receiver=:receiver AND state=1',
            'params' => array(':receiver' => $receiverId),
        ));
    }

    /**
     * 发送消息
     * @param int $senderId 发送者ID
     * @param int $receiverId 接收者ID
     * @param string $text 文本消息
     */
    public static function send($senderId, $receiverId, $text) {
        $message = new Message;
        $message->sender = $senderId;
        $message->receiver = $receiverId;
        $message->message = $text;
        $message->time = date('Y-m-d H:i:s');
        $message->state = 1;
        $message->save();
    }
}
