<?php
class AdminController extends ProxyController {
    public function init() {
        parent::init();

        if (!$this->isAdmin()) {
            $this->renderPartial('/common/isNotAdmin');
            Yii::app()->end();
        }
    }

    /**
     * @return array
     */
    public function getUnreadMessage() {
        return Message::unread(0);
    }
}
