<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of instagramuser
 *
 * @author joeyjones
 */
class InstagramUser {

    private $userID;
    private $username;
    private $name;

    function __construct() {
        $this->userID = $_SESSION['instagram_user_id'];

        $url = "https://api.instagram.com/v1/users/" . $this->userID .
                "?access_token=" . $_SESSION['instagram_access_token'];
        $curl = curl_init($url);

        //set curl options we need
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($curl, CURLOPT_HTTPGET, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        //actually use the api
        $result = curl_exec($curl);

        //parse the data into an array and toss it out
        $parsedData = json_decode($result, true);

        $this->username = $parsedData['data']['username'];
        $this->name = $parsedData['data']['full_name'];
    }

    public function getName() {
        return $this->name;
    }

}

?>
