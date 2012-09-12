<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author joeyjones
 */
class User {

    private $userID;
    private $db;
    private $name;
    private $email;
    private $phone;
    private $address;
    private $city;
    private $postal;
    private $prov;

    public function __construct($userID, $db) {
        $this->userID = $userID;
        $this->db = $db;

        $query = "SELECT * FROM `user` WHERE `user`.`user_id`='" . $this->userID . "';";
        $result = mysqli_query($this->db, $query);
        $data = mysqli_fetch_assoc($result);

        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->address = $data['address'];
        $this->phone = $data['phone'];
        $this->city = $data['city'];
        $this->postal = $data['postal_code'];
        $this->prov = $data['province'];
    }

    public function getProv() {
        return $this->prov;
    }
    
    public function getEmail() {
        return$this->email;;
    }

    public function getInfo($complete=false) {
        if($complete) {
            $returnHTML = "<tr><td>Name </td><td>". $this->name . "</td></tr>";
        $returnHTML .= "<tr><td>Email </td><td>" . $this->email . "</td></tr>";
        $returnHTML .= "<tr><td>Phone </td><td>" . $this->phone . "</td></tr>";
        $returnHTML .= "<tr><td>Address </td><td>" . $this->address . "</td></tr>";
        $returnHTML .= "<tr><td>City </td><td>" . $this->city . "</td></tr>";
        $returnHTML .= "<tr><td>Postal Code </td><td>" . $this->postal . "</td></tr>";
        $returnHTML .= "<tr><td>Province </td><td>". $this->prov. "</td></tr>";
        return $returnHTML;
        }
        $returnHTML = "<tr><td>Name </td><td><input type='text' name='name' value='" . $this->name . "' /></td></tr>";
        $returnHTML .= "<tr><td>Email </td><td><input type='text' name='email' value='" . $this->email . "' /></td></tr>";
        $returnHTML .= "<tr><td>Phone </td><td><input type='text' name='phone' value='" . $this->phone . "' /></td></tr>";
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

    public function update($inArray) {
        $this->name = mysqli_real_escape_string($this->db, $inArray['name']);
        $this->email = mysqli_real_escape_string($this->db, $inArray['email']);
        $this->phone = mysqli_real_escape_string($this->db, $inArray['phone']);
        $this->address = mysqli_real_escape_string($this->db, $inArray['address']);
        $this->city = mysqli_real_escape_string($this->db, $inArray['city']);
        $this->postal = mysqli_real_escape_string($this->db, $inArray['postal']);
        $this->prov = mysqli_real_escape_string($this->db, $inArray['prov']);
    }

    public function write() {
        $query = "UPDATE `user` SET" .
                "`name`='" . $this->name . "'," .
                "`email`='" . $this->email . "'," .
                "`phone`='" . $this->phone . "'," .
                "`address`='" . $this->address . "'," .
                "`city`='" . $this->city . "'," .
                "`postal_code`='" . $this->postal . "'," .
                "`province`='" . $this->prov . "'" .
                " WHERE `user_id`='" . $this->userID . "';";
        mysqli_query($this->db, $query);
    }

}

?>
