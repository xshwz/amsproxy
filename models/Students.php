<?php
class Students extends EMongoDocument {
  public function collectionName() {
    return 'students';
  }

  public static function model($className=__CLASS__) {
    return parent::model($className);
  }
}
