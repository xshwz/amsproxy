<?php
class Message extends CActiveRecord {
    public function relations() {
        return array(
            '_sender' => array(
                self::BELONGS_TO, 'Student', 'sender',
                'select' => 'archives'
            ),
            '_receiver' => array(
                self::BELONGS_TO, 'Student', 'receiver',
                'select' => 'archives'
            )
        );
    }

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * get unread messages
     *
     * @param int $receiverId
     * @return array
     */
    public static function unread($receiverId) {
        return self::model()->findAll(array(
            'condition' => 'receiver=:receiver AND state=1',
            'params' => array(':receiver' => $receiverId),
        ));
    }

    /**
     * @param int $senderId
     * @param int $receiverId
     * @param string $text
     * @param int $state
     */
    public static function send($senderId, $receiverId, $text, $state=1) {
        $message = new Message;
        $message->sender = $senderId;
        $message->receiver = $receiverId;
        $message->message = $text;
        $message->time = date('Y-m-d H:i:s');
        $message->state = $state;
        $message->save();
    }
}
