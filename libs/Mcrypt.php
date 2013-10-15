<?php
class Mcrypt {
    public $cipher = MCRYPT_3DES;
    public $mode = MCRYPT_MODE_ECB;

    public function __construct($key) {
        $this->key = $key;
    }

    public function encrypt($text) {
        return mcrypt_encrypt(
            $this->cipher, $this->key, $text, $this->mode);
    }

    public function decrypt($text) {
        return mcrypt_decrypt(
            $this->cipher, $this->key, $text, $this->mode);
    }
}
