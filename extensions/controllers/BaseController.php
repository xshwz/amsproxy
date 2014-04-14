<?php
class BaseController extends CController {
  public $layout = '/layouts/main';
  public $config;

  public function init() {
    $this->config = include '../config/local.php';
  }

  public function isAdmin() {
    return true;
    if (isset($_SESSION['student']['isAdmin']))
      return $_SESSION['student']['isAdmin'];
  }
}
