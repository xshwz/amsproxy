<?php
class WechatController extends AdminController {
    public function actionIndex() {
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';

        $count = WechatLog::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = isset($_GET['pages']) ? (int)$_GET['pages'] : 20;
        $pages->applyLimit($criteria);

        $this->render('index', array(
            'logs' => WechatLog::model()->findAll($criteria),
            'count' => $count,
            'pages' => $pages,
        ));
    }
}
