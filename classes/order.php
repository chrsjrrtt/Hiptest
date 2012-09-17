<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of order
 *
 * @author joeyjones
 */
class Order {

    private $db;
    private $orderID;
    private $userID;
    private $date;
    private $completed;
    private $images;

    public function __construct($inOrderID, $db) {
        $this->orderID = $inOrderID;
        $this->db = $db;

        $query = "SELECT * FROM `order` WHERE `order`.`order_id`='" . $this->orderID . "';";
        $result = mysqli_query($db, $query);

        $data = mysqli_fetch_assoc($result);

        $this->userID = $data['user_id'];
        $this->date = $data['date'];
        $this->completed = $data['completed'];
    }

    public function getUserID() {
        return $this->userID;
    }

    public function getImages() {
        $query = "SELECT `image_id` FROM `image` WHERE `order_id`='" . $this->orderID . "';";
        $result = mysqli_query($this->db, $query);
        while ($data = mysqli_fetch_assoc($result)) {
            $this->images[] = new Image($data['image_id'], $this->db);
        }

        if (empty($this->images)) {
            $returnHTML = "<tr><td><h2>Select images to print before processing your order.</h2></td></tr>";
            return $returnHTML;
        }
        foreach ($this->images as $current) {
            if ($this->completed) {
                $returnHTML = "<div><table border='0'><tr>";
                $returnHTML .= "<td><a class='lightbox' href='" . $current->getStandardURL() . "'><img src='" . $current->getThumbURL() . "' height='" . $current->getThumbHeight() . "' width='" . $current->getThumbWidth() . "' alt='An image to be printed' /></a></td>";
                $returnHTML .= "<td><table border='0'><tr><td>Quantity </td><td>" . $current->getQuantity() . "</td></tr>";
                $returnHTML .= "<tr><td>Border </td><td>" . $current->getBorder() . "</td></tr>";

                $returnHTML .= "<tr><td>Size </td><td>";

                $query = "SELECT * FROM `size` WHERE `size_id`='" . $current->getSize() . "';";
                $result = mysqli_query($this->db, $query);
                $data = mysqli_fetch_assoc($result);
                $returnHTML .= $data['name'];

                $returnHTML .= "</td></tr></table></td>";
                $returnHTML .= "</tr></table></div>";
            } else {

                $returnHTML = "<div><table border='0'><tr>";
                $returnHTML .= "<td><input type='hidden' name='imageID[]' value='" . $current->getImageID() . "' /><img src='" . _SITE_URL_ . "/img/delete.png' class='remove' alt='Remove' /></td>";
                $returnHTML .= "<td><a class='lightbox' href='" . $current->getStandardURL() . "'><img src='" . $current->getThumbURL() . "' height='" . $current->getThumbHeight() . "' width='" . $current->getThumbWidth() . "' alt='An image to be printed' /></a></td>";
                $returnHTML .= "<td><table border='0'><tr><td>Quantity </td><td><input name='quantity[]' value='" . $current->getQuantity() . "' /></td></tr>";
                $returnHTML .= "<tr><td>Border </td><td><select name='border[]'>";
                if ($current->getBorder() == "white") {
                    $returnHTML .= "<option value='white' selected='selected'>White</option>
                    <option value='black'>Black</option>";
                } else {
                    $returnHTML .= "<option value = 'white'>White</option>
                    <option value = 'black' selected='selected'>Black</option>";
                }

                $returnHTML .= "</select></td></tr>";
                $returnHTML .= "<tr><td>Size </td><td><select name='size[]'>";

                $query = "SELECT * FROM `size`";
                $result = mysqli_query($this->db, $query);
                while ($data = mysqli_fetch_assoc($result)) {
                    $returnHTML .= "<option value='" . $data['size_id'] . "'";
                    if ($data['size_id'] == $current->getSize()) {
                        $returnHTML .= " selected='selected'";
                    }
                    $returnHTML .= ">" . $data['name'] . "</option>";
                }
                $returnHTML .= "</select></td></tr></table></td>";
                $returnHTML .= "</tr></table></div>";
            }
        }
        return $returnHTML;
    }

    public static function save($post, $db) {
        $order = new \Order($_SESSION['orderID'], $db);
        $user = new \User($order->getUserID(), $db);
        $user->update($post);
        $user->write();

        $list = "";
        $pos = 0;
        while ($post['imageID'][$pos] != false) {
            $image = new Image($post['imageID'][$pos], $db, $post['thumb'][$pos], $post['standard'][$pos], $post['height'][$pos], $post['width'][$pos], $post['quantity'][$pos], $post['size'][$pos], $post['border'][$pos], true);
            $image->write();
            $list .= $post['imageID'][$pos] . ",";
            $pos++;
        }

        $query = "DELETE FROM `image` WHERE `image_id` NOT IN (" . mb_substr($list, 0, -1) . ");";
        mysqli_query($db, $query);
    }

    public function addImage($image) {
        $query = "Insert INTO `image` (`order_id`,`thumbnail_url`,`thumbnail_height`,`thumbnail_width`,`standard_url`) VALUES ('" .
                $this->orderID . "','" .
                $image->getThumbURL() . "','" .
                $image->getThumbHeight() . "','" .
                $image->getThumbWidth() . "','" .
                $image->getStandardURL() . "');";
        mysqli_query($this->db, $query);
    }

    public function complete() {
        $this->completed = 1;
        $query = "UPDATE `order` SET `completed`='1' WHERE `order_id`='" . $this->orderID . "';";
        mysqli_query($this->db, $query);
    }

}

?>
