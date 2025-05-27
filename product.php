<?php
session_start();
include('includes/db.php');

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$product = $conn->query("SELECT * FROM products WHERE id = $id")->fetch_assoc();

if (!$product || !$product['is_customizable']) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="/assets/FavLogo.jpg" alt="brand-logo">
    <title>Customize Product</title>
    <style>
        body { font-family: Arial; background: #f1fff5; padding: 40px; }
        .box { background: white; padding: 30px; border-radius: 15px; width: 400px; margin: auto; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
        label { display: block; margin-top: 10px; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; }
        .btn { margin-top: 20px; background: green; color: white; border: none; padding: 10px; width: 100%; border-radius: 8px; }
    </style>
</head>
<body>

<div class="box">
    <h2><?= $product['name'] ?></h2>
    <p>₱<?= number_format($product['price'], 2) ?></p>
    <p><strong>Stock:</strong> <?= $product['stock'] ?></p>

    <form action="add_to_cart.php" method="POST">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <input type="hidden" name="custom" value="1">

        <label for="size">Size</label>
        <select name="size" required>
            <option value="">-- Select Size --</option>
            <option value="Small">Small</option>
            <option value="Medium">Medium</option>
            <option value="Large">Large</option>
        </select>

        <label for="flavor">Flavor</label>
        <select name="flavor" required>
            <option value="">-- Select Flavor --</option>
            <option value="Vanilla">Vanilla</option>
            <option value="Chocolate">Chocolate</option>
            <option value="Strawberry">Strawberry</option>
        </select>

        <label for="addons">Add-ons</label>
        <input type="text" name="addons" placeholder="e.g. Extra cream, toppings (optional)">

        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" min="1" max="<?= $product['stock'] ?>" value="1" required>

        <button type="submit" class="btn">Add to Cart</button>
    </form>
</div>

</body>
</html>
