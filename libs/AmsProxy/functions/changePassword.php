<?php
class changePassword extends __base__ {
    public function run() {
        $this->amsProxy->post('MyWeb/User_ModPWD.aspx', array(
            'oldPWD' => $this->args['oldpwd'],
            'NewPWD' => $this->args['newpwd'],
            'CNewPWD' => $this->args['newpwd'],
        ));
    }
}
