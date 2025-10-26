<?php
//Start session if it is still not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Connect DB
if (!isset($conn)) {
    require_once 'connectDB.php';
}


$user_logged_in = false;
$cart_count = 0;

//Check if user authorised or not
if (isset($_SESSION['user_id']) && !empty($conn) && $conn instanceof mysqli) {
    $user_logged_in = true;
    $user_id = (int) $_SESSION['user_id'];

    // Get total qty of items
    $stmt = $conn->prepare("SELECT SUM(quantity) AS total_items FROM cart WHERE user_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            $cart_count = (int) ($row['total_items'] ?? 0);
        }
        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MKTIME</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="header-image">
    <img src="img/header.jpeg" alt="Header" class="img-fluid w-100">
</div>
<nav style="background-size: cover; background-position: center;"
     class="navbar navbar-expand-lg bg-dark border-bottom border-body"
     data-bs-theme="dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">MKTIME</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="our_brand.php">Our Brand</a></li>
        <li class="nav-item"><a class="nav-link" href="contact_us.php">Contact Us</a></li>

        <?php if(isset($_SESSION['user_id'])): ?>
            <li class="nav-item"><a class="nav-link" href="cart.php"><i class="bi bi-basket-fill"></i> My Cart</a></li>
            <li class="nav-item"><a class="nav-link" href="orders.php">Orders</a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="login.php">Login /</a></li>
            <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
