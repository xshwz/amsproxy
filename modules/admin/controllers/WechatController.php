<?php
class WechatController extends AdminController {
    public function actionIndex() {
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';

        if (isset($_GET['status']))
            $criteria->addCondition('state=' . $_GET['status']);

        $count = WechatLog::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = isset($_GET['pages']) ? (int)$_GET['pages'] : 50;
        $pages->applyLimit($criteria);

        $this->render('index', array(
            'logs' => WechatLog::model()->findAll($criteria),
            'count' => $count,
            'pages' => $pages,
        ));
    }
}
