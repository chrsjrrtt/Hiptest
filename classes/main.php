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

        $navbar .= "<div class='navcontainer'><a href='". _SITE_URL_. "'><div class='navitem'>Add Photos</div></a></div>";
        $navbar .= "<div class='navcontainer'><a href='order/'><div class='navitem'>View Order</div></a></div>";

        return $navbar;
    }

    public function getFooter() {
        return "Made by Chris Jarrett";;
    }

}

?>
