<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of image
 *
 * @author joeyjones
 */
class Image {

    private $thumb_url;
    private $thumb_height;
    private $thumb_width;
    private $standard_url;
    private $quantity;
    private $size;
    private $border;

    public function __construct($inThumb, $inStandard, $inHeight, $inWidth, $inQuantity = "1", $inSize = "0", $inBorder = "white") {
        $this->thumb_url = $inThumb;
        $this->standard_url = $inStandard;
        $this->thumb_height = $inHeight;
        $this->thumb_width = $inWidth;
        $this->quantity = $inQuantity;
        $this->size = $inSize;
        $this->border = $inBorder;
    }

    public function getThumbURL() {
        return $this->thumb_url;
    }

    public function getStandardURL() {
        return $this->standard_url;
    }

    public function getThumbHeight() {
        return $this->thumb_height;
    }

    public function getThumbWidth() {
        return $this->thumb_width;
        ;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getSize() {
        return $this->size;
    }

    public function getBorder() {
        return $this->border;
    }

}

?>
