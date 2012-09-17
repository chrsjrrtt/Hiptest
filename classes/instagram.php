<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of instagram
 *
 * @author joeyjones
 */
class Instagram {

    public static $client_id = "c04ff613a82f4f15bab41cdf8f1e5467";
    public static $client_secret = "87a53fc794314948b18214de7f3dcded";
    public static $redirect = "http://127.0.0.1/hiptest/instagram";

    function __construct() {
        
    }

    public function requestAccessToken($code) {
        $url = "https://api.instagram.com/oauth/access_token" .
                "?client_id=" . Instagram::$client_id .
                "&client_secret=" . Instagram::$client_secret .
                "&grant_type=authorization_code" .
                "&redirect_uri=" . Instagram::$redirect .
                "&code=" . $code;
        $curl = curl_init($url);

        //put all our data fields into curl
        $data = array("client_id" => Instagram::$client_id, "client_secret" => Instagram::$client_secret, "grant_type" => "authorization_code", "redirect_uri" => Instagram::$redirect, "code" => $code);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //set curl options we need
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($curl, CURLOPT_HTTPGET, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        //actually use the api
        $result = curl_exec($curl);

        //parse the data into an array and toss it out
        $parsedData = json_decode($result, true);

        //save the token and user id in the session
        $_SESSION['instagram_access_token'] = $parsedData['access_token'];
        $_SESSION['instagram_user_id'] = $parsedData['user']['id'];
    }

    public function getRecentMedia() {
        $curl = curl_init("https://api.instagram.com/v1/users/" . $_SESSION['instagram_user_id'] . "/media/recent/?access_token=" . $_SESSION['instagram_access_token']);
//        $curl = curl_init("https://api.instagram.com/v1/users/3/media/recent/?access_token=" . $_SESSION['instagram_access_token']);
        //set curl options we need
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        //actually use the api
        $result = curl_exec($curl);

        //parse the data into an array and toss it out
        $parsedData = json_decode($result, true);

        $count = 0;
        $returnHTML = "<tr>";

        if ($parsedData['meta']['code'] != 200) {
            $_SESSION['instagram_access_token'] = "";
            header('Location: ' . _SITE_URL_);
            exit;
        }
        foreach ($parsedData['data'] as $current) {
            if ($count % 4 == 0 && $count != 0) {
                $returnHTML .= "</tr><tr>";
            }
            $thumb = $current['images']['thumbnail'];
            $returnHTML .= "<td><a class='lightbox' href='" . $current['images']['standard_resolution']['url'] . "'><img src='" . $thumb['url'] . "' height='" . $thumb['height'] . "' width='" . $thumb['width'] . "' alt='An image from Instagram' /></a><p><input type='checkbox' name='selections[]' value='" . $current['id'] . "' /></p></td>";
            $count++;
        }
        $returnHTML .= "</tr>";
        return $returnHTML;
    }

}

?>
