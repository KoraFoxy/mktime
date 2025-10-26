<?php
session_start();
include 'connectDB.php';

// Check, that user is already logged in, if not - redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get items from Cart
$sql = "SELECT c.item_id, c.quantity, p.item_price 
        FROM cart c 
        JOIN products p ON c.item_id = p.item_id 
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>Your cart is empty.</p>";
    echo "<a href='index.php'>Go back to shop</a>";
    exit();
}

// Create order
$total = 0;
$items = [];

while ($row = $result->fetch_assoc()) {
    $items[] = $row;
    $total += $row['item_price'] * $row['quantity'];
}

$stmt->close();

$order_sql = "INSERT INTO orders (user_id, total, order_date) VALUES (?, ?, NOW())";
$stmt = $conn->prepare($order_sql);
$stmt->bind_param("id", $user_id, $total);
$stmt->execute();

$order_id = $stmt->insert_id; // get new order ID 
$stmt->close();

// Move items to order_contents table DB
$item_sql = "INSERT INTO order_contents (order_id, item_id, quantity, price) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($item_sql);

foreach ($items as $item) {
    $stmt->bind_param("iiid", $order_id, $item['item_id'], $item['quantity'], $item['item_price']);
    $stmt->execute();
}

$stmt->close();

// Clean cart 
$delete_sql = "DELETE FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($delete_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->close();

// Show confirmation to User
include 'header.php';
?>

<div class="checkout-confirm text-center">
    <h2 class="about-title">Thank you for your order!</h2>
    <p>Your order number is <strong>#<?= $order_id ?></strong></p>
    <p>Total amount: <strong>£<?= number_format($total, 2) ?></strong></p>
    <a href="orders.php" class="btn-checkout mt-3">View My Orders</a>
</div>

<?php include 'footer.php'; ?>
