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
            $this->name = $user->getName();
        }
    }

    public function getInfo() {
        $returnHTML = "<tr><td>Name </td><td><input type='input' name='name' value='" . $this->name . "'</td></tr>";
        $returnHTML .= "<tr><td>Email </td><td><input type='input' name='name' value='" . $this->email . "'</td></tr>";
        $returnHTML .= "<tr><td>Address </td><td><input type='input' name='name' value='" . $this->address . "'</td></tr>";
        $returnHTML .= "<tr><td>City </td><td><input type='input' name='name' value='" . $this->city . "'</td></tr>";
        $returnHTML .= "<tr><td>Postal Code </td><td><input type='input' name='name' value='" . $this->postal . "'</td></tr>";
        $returnHTML .= "<tr><td>Province </td><td><select>
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

            $returnHTML .= "<tr>";
            $returnHTML .= "<td><a class='lightbox' href='" . $image->getStandardURL() . "'><img src='" . $image->getThumbURL() . "' height='" . $image->getThumbHeight() . "' width='" . $image->getThumbWidth() . "' /><a/></td>";
            $returnHTML .= "<td><table bored='0'><tr><td>Quantity </td><td><input name='quantity[]' value='1' /></td></tr>";
            $returnHTML .= "<tr><td>Size </td><td><select>
                <option value='12'>12x12</option>
                <option value='16'>16x16</option>
                <option value='24'>24x24</option></selectt></td></tr></table></td>";
            $returnHTML .= "</tr>";
        }
        return $returnHTML;
    }

}

?>
