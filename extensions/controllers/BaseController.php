<?php
class BaseController extends CController {
    public function init() {
        if ($this->isLogged()) define('IS_LOGGED', true);
    }

    public function isLogged() {
        return isset($_SESSION['student']);
    }
}
