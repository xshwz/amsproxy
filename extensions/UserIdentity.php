<?php
/**
 * 用户标识
 */
class UserIdentity extends CUserIdentity {
    private $_id;

    public function authenticate() {
        $this->_id = $this->username;
        return isset($_SESSION['student']);
    }
 
    public function getId() {
        return $this->_id;
    }
}
