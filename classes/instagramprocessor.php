<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of instagramprocessor
 *
 * @author joeyjones
 */
class InstagramProcessor {

    private $code;

    public function processCode($inCode) {
        $this->code = $inCode;

        $instagram = new Instagram();
        $data = $instagram->requestAccessToken($this->code);
        $_SESSION['instagram_access_token'] = $data['access_token'];
        $_SESSION['instagram_user_id'] = $data['user']['id'];
    }

}

?>
