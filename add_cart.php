<?php

session_start();

include 'connectDB.php';

//Check, that user is already logged in, if not - redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

//Get user_id from session
$user_id = $_SESSION['user_id'];

// Get item_id and qty from POST request
$item_id = intval($_POST['item_id']);
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

// Check, is there any item in cart already
$sql = "SELECT * FROM cart WHERE user_id = $user_id AND item_id = $item_id";
$result = $conn->query($sql);

//If item is already in a cart - than update qty
if ($result->num_rows > 0) {
    $conn->query("UPDATE cart SET quantity = quantity + $quantity 
                  WHERE user_id = $user_id AND item_id = $item_id");
} else { // if not - insert new record in DB
    $conn->query("INSERT INTO cart (user_id, item_id, quantity) 
                  VALUES ($user_id, $item_id, $quantity)");
}

header("Location: cart.php");
exit();
?>
