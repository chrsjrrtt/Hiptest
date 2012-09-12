<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of instagramimage
 *
 * @author joeyjones
 */
class InstagramImage {

    private $id;
    private $thumb_url;
    private $standard_url;
    private $thumb_width;
    private $thumb_height;

    public function __construct($inID) {
        $this->id = $inID;

        $url = "https://api.instagram.com/v1/media/" . $this->id .
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

        $this->thumb_url = $parsedData['data']['images']['thumbnail']['url'];
        $this->standard_url = $parsedData['data']['images']['standard_resolution']['url'];
        $this->thumb_height = $parsedData['data']['images']['thumbnail']['height'];
        $this->thumb_width = $parsedData['data']['images']['thumbnail']['widtrh'];
    }

    public function getImage() {
        $image = new Image($this->thumb_url, $this->standard_url, $this->thumb_height, $this->thumb_width);
        return $image;
    }

}

?>
