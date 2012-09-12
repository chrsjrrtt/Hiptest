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

            $returnHTML .= "<div><table border='0'><tr>";
            $returnHTML .= "<td><input type='hidden' name='imageID[]' value='" . $current->getImageID() . "' /><img src='img/delete.png' class='remove' alt='Remove' /></td>";
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


        return $returnHTML;
    }

    public static function save($post, $db) {
        $order = new \Order($_SESSION['orderID'], $db);
        $user = new \User($order->getUserID(), $db);

        $user->update($post);
        $user->write();
        

//        $_SESSION['images'] = "";
//        $pos = 0;
//        while ($post['thumb'][$pos] != false) {
//            $image = new Image($post['thumb'][$pos], $post['standard'][$pos], $post['height'][$pos], $post['width'][$pos], $post['quantity'][$pos], $post['size'][$pos], $post['border'][$pos]);
//            $_SESSION['images'][] = serialize($image);
//            $pos++;
//        }
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

}

?>
