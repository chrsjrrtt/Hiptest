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

    private $images;
    private $name;
    private $email;
    private $address;
    private $city;
    private $postal;
    private $prov;

    public function __construct() {
        $this->images = $_SESSION['images'];

        if (!empty($_SESSION['instagram_user_id'])) {
            $user = new InstagramUser();
            $this->name = $_SESSION['name'];
            $this->email = $_SESSION['email'];
            $this->address = $_SESSION['address'];
            $this->city = $_SESSION['city'];
            $this->postal = $_SESSION['postal'];
            $this->prov = $_SESSION['prov'];
        }
    }

    public function getProv() {
        return $this->prov;
    }

    public function getInfo() {
        $returnHTML = "<tr><td>Name </td><td><input type='text' name='name' value='" . $this->name . "' /></td></tr>";
        $returnHTML .= "<tr><td>Email </td><td><input type='text' name='email' value='" . $this->email . "' /></td></tr>";
        $returnHTML .= "<tr><td>Address </td><td><input type='text' name='address' value='" . $this->address . "' /></td></tr>";
        $returnHTML .= "<tr><td>City </td><td><input type='text' name='city' value='" . $this->city . "' /></td></tr>";
        $returnHTML .= "<tr><td>Postal Code </td><td><input type='text' name='postal' value='" . $this->postal . "' /></td></tr>";
        $returnHTML .= "<tr><td>Province </td><td><select name='prov'>
            <option value=''>Select One</option>
            <option value='AB'>Alberta</option>
            <option value='BC'>British Columbia</option>
            <option value='MB'>Manitoba</option>
            <option value='NB'>New Brunswick</option>
            <option value='NL'>Newfoundland and Labrador</option>
            <option value='NS'>Nova Scotia</option>
            <option value='ON'>Ontario</option>
            <option value='PE'>Prince Edward Island</option>
            <option value='QC'>Quebec</option>
            <option value='SK'>Saskatchewan</option>
            <option value='NT'>Northwest Territories</option>
            <option value='NU'>Nunavut</option>
            <option value='YT'>Yukon</option>
        </select></td></tr>";
        return $returnHTML;
    }

    public function getImages() {
        if (empty($this->images)) {
            $returnHTML = "<tr><td><h2>Select images to print before processing your order.</h2></td></tr>";
            return $returnHTML;
        }
        foreach ($this->images as $current) {

            $image = unserialize($current);

            $returnHTML .= "<input type='hidden' name='thumb[]' value='" . $image->getThumbURL() . "' />";
            $returnHTML .= "<input type='hidden' name='standard[]' value='" . $image->getStandardURL() . "' />";
            $returnHTML .= "<input type='hidden' name='height[]' value='" . $image->getThumbHeight() . "' />";
            $returnHTML .= "<input type='hidden' name='width[]' value='" . $image->getThumbWidth() . "' />";
            $returnHTML .= "<div><table border='0'><tr>";
            $returnHTML .= "<td><img src='img/delete.png' class='remove' alt='Remove' /></td>";
            $returnHTML .= "<td><a class='lightbox' href='" . $image->getStandardURL() . "'><img src='" . $image->getThumbURL() . "' height='" . $image->getThumbHeight() . "' width='" . $image->getThumbWidth() . "' alt='An image to be printed' /></a></td>";
            $returnHTML .= "<td><table border='0'><tr><td>Quantity </td><td><input name='quantity[]' value='" . $image->getQuantity() . "' /></td></tr>";
            $returnHTML .= "<tr><td>Border </td><td><select name='border[]'>";
            if ($image->getBorder() == "white") {
                $returnHTML .= "<option value='white' selected='selected'>White</option>
                    <option value='black'>Black</option>";
            } else {
                $returnHTML .= "<option value = 'white'>White</option>
                    <option value = 'black' selected='selected'>Black</option>";
            }

            $returnHTML .= "</select></td></tr>";
            $returnHTML .= "<tr><td>Size </td><td><select name='size[]'>";
            if ($image->getSize() == 12) {
                $returnHTML .= "<option value = '12' selected='selected'>12x12</option>";
                $returnHTML .= "<option value = '16'>16x16</option>";
                $returnHTML .= "<option value = '24'>24x24</option></select></td></tr></table></td>";
            } elseif ($image->getSize() == 16) {
                $returnHTML .= "<option value = '12'>12x12</option>";
                $returnHTML .= "<option value = '16' selected='selected'>16x16</option>";
                $returnHTML .= "<option value = '24'>24x24</option></select></td></tr></table></td>";
            } else {
                $returnHTML .= "<option value = '12'>12x12</option>";
                $returnHTML .= "<option value = '16'>16x16</option>";
                $returnHTML .= "<option value = '24' selected='selected'>24x24</option></select></td></tr></table></td>";
            }
            $returnHTML .= "</tr></table></div>";
        }
        return $returnHTML;
    }

    public static function save($post) {
        $_SESSION['name'] = $post['name'];
        $_SESSION['email'] = $post['email'];
        $_SESSION['address'] = $post['address'];
        $_SESSION['city'] = $post['city'];
        $_SESSION['postal'] = $post['postal'];
        $_SESSION['prov'] = $post['prov'];

        $_SESSION['images'] = "";
        $pos = 0;
        while ($post['thumb'][$pos] != false) {
            $image = new Image($post['thumb'][$pos], $post['standard'][$pos], $post['height'][$pos], $post['width'][$pos], $post['quantity'][$pos], $post['size'][$pos], $post['border'][$pos]);
            $_SESSION['images'][] = serialize($image);
            $pos++;
        }
    }

}

?>
