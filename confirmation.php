<?php
if(!empty($_GET['id'])){
    $order = $myDB->select("orders", "*", array("id" => $_GET['id']))[0];
} else {
    $order = $myDB->select("orders", "*", "", "ORDER BY RAND() LIMIT 1")[0];
}
$products_in_cart = json_decode($order['products'], true);
$products = array();
$subtotal = 0.00;
if ($products_in_cart) {
    $products_id = implode(",", array_keys($products_in_cart));
    $products = $myDB->select('products', '*', 'id IN (' . $products_id . ')');
    foreach ($products as $product) {
        $subtotal += (float)$product['price'] * (int)$products_in_cart[$product['id']];
    }
}
include "components/header.php";
?>
<div class="container">
    <div class="cart content-wrapper">
        <div>
            <h1>Your Order Has Been Placed</h1>
            <p>Thank you for ordering with us, we'll contact you by email with your order details.</p>
        </div>
        <table>
            <thead>
                <tr>
                    <td colspan="2">Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</td>
                </tr>
                <?php else: ?>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td class="img">
                        <a href="index.php?page=product&id=<?=$product['id']?>">
                            <img src="<?=$product['thumbnail']?>" width="60" height="60" alt="<?=$product['name']?>">
                        </a>
                    </td>
                    <td>
                        <a href="index.php?page=product&id=<?=$product['id']?>"><?=$product['name']?></a>
                    </td>
                    <td class="price">&dollar;<?=$product['price']?></td>
                    <td class="quantity">
                       <?=$products_in_cart[$product['id']]?>
                    </td>
                    <td class="price">&dollar;<?=$product['price'] * $products_in_cart[$product['id']]?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Subtotal</span>
            <span class="price">&dollar;<?=$subtotal?></span>
        </div>
    </div>
</div>
<?php include "components/footer.php"; ?>