<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of main
 *
 * @author joeyjones
 */
class Main {

    function __construct() {
        
    }

    public function getSiteName() {
        return "Perfect Photo Printing";
    }

    public function getStyles() {
        return '<link rel="stylesheet" type="text/css" href="' . _SITE_URL_ . '/lib/styles.css" />';
    }

    public function getHeader() {
        return "<h1><a href='" . _SITE_URL_ . "'>The best photo printing site ever</a></h1>";
    }

    public function getNavbar() {

        $navbar = "<div class='navcontainer'><div class='navitem'><a href='" . _SITE_URL_ . "'>Add Photos</a></div></div>";
        $navbar .= "<div class='navcontainer'><div class='navitem'><a href='". _SITE_URL_. "/order/'>View Order</a></div></div>";

        return $navbar;
    }

    public function getFooter() {
        return "Made by Chris Jarrett";
        ;
    }

    public function initializeDB($db) {
        if (empty($_SESSION['userID'])) {
            $query = "INSERT INTO `user` VALUES();";
            mysqli_query($db, $query);
            $userID = mysqli_insert_id($db);
            $_SESSION['userID'] = $userID;
        } else {
            $userID = $_SESSION['userID'];
        }

        $query = "INSERT INTO `order` (`user_id`)VALUES('" . $userID . "');";
        mysqli_query($db, $query);
        $orderID = mysqli_insert_id($db);
        $_SESSION['orderID'] = $orderID;
    }

}

?>
