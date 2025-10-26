<?php include 'header.php';?>
<h1>Welcome to MKTIME</h1>

<div class="container mt-5">
  <div class="row row-cols-1 row-cols-md-4 g-4">
    <?php
    include 'connectDB.php';
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    if ($result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
    ?>
            <div class="col">
                <div class="card product-card">
                    <img src="<?= $row['item_img'] ?>" class="card-img-top" alt="<?= $row['item_name'] ?>">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= $row['item_name'] ?></h5>
                        <p class="card-text"><?= $row['item_desc'] ?></p>
                        <p class="card-text mt-2">£<?= $row['item_price'] ?></p>

                        <form action="add_cart.php" method="POST">
                            <input type="hidden" name="item_id" value="<?= $row['item_id'] ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-add-cart w-100">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
    <?php
        endwhile;
    else:
        echo '<p>No products found.</p>';
    endif;
    ?>
  </div>
</div>

<?php include 'footer.php'; ?>