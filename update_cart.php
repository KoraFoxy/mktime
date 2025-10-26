<?php
session_start();
include 'connectDB.php';

// ПCheck, that user is already logged in, if not - redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check that data send by POST
if (isset($_POST['quantities']) && is_array($_POST['quantities'])) {
    foreach ($_POST['quantities'] as $cart_id => $quantity) {
        $cart_id = intval($cart_id);
        $quantity = intval($quantity);

        // if qty = 0 - delete item from cart
        if ($quantity <= 0) {
            // Удаляем товар, если количество 0
            $sql = "DELETE FROM cart WHERE cart_id = ? AND user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $cart_id, $user_id);
            $stmt->execute();
        } else {
            // if not - update qty
            $sql = "UPDATE cart SET quantity = ? WHERE cart_id = ? AND user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $quantity, $cart_id, $user_id);
            $stmt->execute();
        }
    }
}

// Redirect in cart
header("Location: cart.php");
exit();
?>