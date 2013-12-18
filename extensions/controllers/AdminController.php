<?php
class AdminController extends ProxyController {
    /**
     * @var array
     */
    public $superAdmin = array(
        '110263100136',
        '111253050122',
    );

    public function init() {
        parent::init();

        if ($this->isLogged() && !$this->isAdmin()) {
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

    /**
     * @param string $sid
     * @return bool
     */
    public function isSuperAdmin($sid=null) {
        if (!$sid) $sid = $_SESSION['student']['sid'];
        return in_array($sid, $this->superAdmin);
    }
}
