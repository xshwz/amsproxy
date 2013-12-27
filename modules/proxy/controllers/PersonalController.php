<?php
class PersonalController extends ProxyController {
    public function actionArchives() {
        $this->render('archives', array(
            'archives' => $this->get('archives'),
        ));
    }
}
