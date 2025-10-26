<?php
session_start();
include 'header.php';
include 'connectDB.php';

// Check, that user is already logged in, if not - redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get all Users orders
$sql_orders = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";
$stmt = $conn->prepare($sql_orders);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result();

?>

<div class="container mt-5">
    <h2 class="about-title">My Orders</h2>

    <?php if ($orders->num_rows === 0): ?>
        <p>You have no orders yet.</p>
        <a href="index.php" class="btn btn-primary">Go to Shop</a>

    <?php else: ?>
        <?php while ($order = $orders->fetch_assoc()): ?>
            <div class="order-card">
                <h3>Order #<?= $order['order_id'] ?> — <span class="order-date"><?= $order['order_date'] ?></span></h3>
                <p class="order-total">Total: £<?= number_format($order['total'], 2) ?></p>

                <table class="order-table">
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>

                    <?php
                    // Get items for each order
                    $order_id = $order['order_id'];
                    $sql_items = "SELECT oc.quantity, oc.price, p.item_name, p.item_img 
                                  FROM order_contents oc
                                  JOIN products p ON oc.item_id = p.item_id
                                  WHERE oc.order_id = ?";
                    $stmt_items = $conn->prepare($sql_items);
                    $stmt_items->bind_param("i", $order_id);
                    $stmt_items->execute();
                    $items = $stmt_items->get_result();

                    while ($item = $items->fetch_assoc()):
                    ?>
                        <tr>
                            <td class="order-item">
                                <img src="<?= $item['item_img'] ?>" alt="<?= htmlspecialchars($item['item_name']) ?>" class="order-img">
                                <?= htmlspecialchars($item['item_name']) ?>
                            </td>
                            <td>£<?= number_format($item['price'], 2) ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>£<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
