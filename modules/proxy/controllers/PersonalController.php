<?php
class PersonalController extends ProxyController {
    public function actionArchives() {
        
        $this->field = 'archives';

        $this->render('archives', array(
            'archives' => $this->get('archives'),
        ));
    }
}
