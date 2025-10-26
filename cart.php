<?php

include 'header.php';
include 'connectDB.php';

//Check, that user is already logged in, if not - redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

//Get user_id from session
$user_id = $_SESSION['user_id'];

//Items from cart and item data (id,name, price,qty) from DB
$sql = "SELECT c.cart_id, p.item_name, p.item_price, p.item_img, c.quantity 
        FROM cart c 
        JOIN products p ON c.item_id = p.item_id 
        WHERE c.user_id = $user_id";

$result = $conn->query($sql);
$total = 0;
?>


<h2 class="about-title">Your cart</h2>
<form method="post" action="update_cart.php">
<table class="cart-table">
<tr><th>Items</th><th>Price</th><th>Quantity</th><th>Amount</th></tr>

<?php while ($row = $result->fetch_assoc()): 
    $sum = $row['item_price'] * $row['quantity'];
    $total += $sum;
?>
<tr>
    <td class="cart-item">
        <img src="<?= $row['item_img'] ?>" alt="<?= htmlspecialchars($row['item_name']) ?>" class="cart-img">
        <?= htmlspecialchars($row['item_name']) ?>
    </td>
    <td><?= $row['item_price'] ?> £</td>
    <td>
    <input type="number" name="quantities[<?= $row['cart_id'] ?>]" 
            value="<?= $row['quantity'] ?>" min="0" class="quantity-input">
    </td>
    <td>

    <td><?= $sum ?> £</td>
</tr>
<?php endwhile; ?>
</table>

<h3 class ="about-title">Total amount: £<?= number_format($total, 2) ?></h3>

<div class="cart-buttons">
    <button type="submit" class="btn-update">Update Cart</button>
    <a href="checkout.php" class="btn-checkout">Checkout</a>
</div>
</form>

<?php include 'includes/footer.php'; ?>
