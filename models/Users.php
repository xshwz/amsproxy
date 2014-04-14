<?php
class Users extends EMongoDocument {
  public function collectionName() {
    return 'users';
  }

  public static function model($className=__CLASS__) {
    return parent::model($className);
  }
}
