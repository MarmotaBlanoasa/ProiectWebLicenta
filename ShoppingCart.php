<?php
require_once "DBController.php";

class ShoppingCart extends DBController {
    function getAllTickets() {
        $query = "SELECT bilet.ID_Bilet, eveniment.Nume_Eveniment, bilet.Tip_Bilet, bilet.Pret FROM bilet JOIN eveniment ON bilet.ID_Eveniment = eveniment.ID_Eveniment";
        return $this->getDBResult($query);
    }

    function getTicketById($ticket_id) {
        $query = "SELECT * FROM bilet WHERE ID_Bilet = ?";
        $params = array(array("param_type" => "i", "param_value" => $ticket_id));
        return $this->getDBResult($query, $params);
    }


    // Fetch cart items for a member
    function getMemberCartItems($member_id) {
        $query = "SELECT bilet.*, tbl_cart.Cart_ID, tbl_cart.Quantity FROM bilet INNER JOIN tbl_cart ON bilet.ID_Bilet = tbl_cart.Ticket_ID WHERE tbl_cart.User_ID = ?";
        $params = array(
            array("param_type" => "i", "param_value" => $member_id)
        );
        return $this->getDBResult($query, $params);
    }
    
    
    

    // Add a ticket to the cart
    function addToCart($ticket_id, $Quantity, $member_id) {
        $query = "INSERT INTO tbl_cart (Ticket_ID, Quantity, User_ID) VALUES (?, ?, ?)";
        $params = array(
            array("param_type" => "i", "param_value" => $ticket_id),
            array("param_type" => "i", "param_value" => $Quantity),
            array("param_type" => "i", "param_value" => $member_id)
        );
        $this->updateDB($query, $params);
    }

    // Update cart quantity
    function updateCartQuantity($Quantity, $cart_id) {
        $query = "UPDATE tbl_cart SET Quantity = ? WHERE Cart_ID = ?";
        $params = array(
            array("param_type" => "i", "param_value" => $Quantity),
            array("param_type" => "i", "param_value" => $cart_id)
        );
        $this->updateDB($query, $params);
    }

    // Delete a cart item
    function deleteCartItem($cart_id) {
        $query = "DELETE FROM tbl_cart WHERE Cart_ID = ?";
        $params = array(array("param_type" => "i", "param_value" => $cart_id));
        $this->updateDB($query, $params);
    }

    // Empty the cart for a member
    function emptyCart($member_id) {
        $query = "DELETE FROM tbl_cart WHERE User_ID = ?";
        $params = array(array("param_type" => "i", "param_value" => $member_id));
        $this->updateDB($query, $params);
    }
}
?>
