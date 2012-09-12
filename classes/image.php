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

    private $imageID;
    private $db;
    private $thumb_url;
    private $thumb_height;
    private $thumb_width;
    private $standard_url;
    private $quantity;
    private $size;
    private $border;

    public function __construct($inImageID = "-1", $inDB = "", $inThumb = "", $inStandard = "", $inHeight = "", $inWidth = "", $inQuantity = "1", $inSize = "0", $inBorder = "white", $writing=false) {
        if ($inImageID == -1) {
            $this->thumb_url = $inThumb;
            $this->standard_url = $inStandard;
            $this->thumb_height = $inHeight;
            $this->thumb_width = $inWidth;
            $this->quantity = $inQuantity;
            $this->size = $inSize;
            $this->border = $inBorder;
            return;
        }

        if (!$writing) {
            $this->imageID = $inImageID;
            $this->db = $inDB;
            $query = "SELECT * FROM `image` WHERE `image`.`image_id`='" . $this->imageID . "';";
            $result = mysqli_query($this->db, $query);
            $data = mysqli_fetch_assoc($result);

            $this->thumb_url = $data['thumbnail_url'];
            $this->standard_url = $data['standard_url'];
            $this->thumb_height = $data['thumbnail_height'];
            $this->thumb_width = $data['thumbnail_width'];
            $this->quantity = $data['quantity'];
            $this->size = $data['size_id'];
            $this->border = $data['border'];
            return;
        }
        $this->imageID = $inImageID;
        $this->db = $inDB;
        $this->thumb_url = $inThumb;
        $this->standard_url = $inStandard;
        $this->thumb_height = $inHeight;
        $this->thumb_width = $inWidth;
        $this->quantity = $inQuantity;
        $this->size = $inSize;
        $this->border = $inBorder;
    }

    public function getImageID() {
        return $this->imageID;
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

    public function write() {
        $query = "UPDATE `image` SET `quantity`='" . $this->quantity . "',`size_id`='" . $this->size . "',`border`='" . $this->border . "' WHERE `image_id`='" . $this->imageID . "';";
        mysqli_query($this->db, $query);
    }

}

?>
