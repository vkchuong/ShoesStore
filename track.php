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
            <h1>Track Your Order</h1>
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
    <div class="row" style="margin-bottom: 50px;">
        <h1 class="title">Order Detail</h1>
        <div class="col-lg-12">
            <p>Order ID: <a href="./?page=track&id=<?=$order['id'];?>"><b><?=$order['id'];?></b></a></p>
            <p>First Name: <b><?=$order['firstname'];?></b></p>
            <p>Last Name: <b><?=$order['lastname'];?></b></p>
            <p>Email: <b><?=$order['email'];?></b></p>
            <p>Phone Number: <b><?=$order['phone'];?></b></p>
            <p>Billing Method: <b><?=$order['method'];?></b></p>
        </div>
        <h1 class="title">Shipping Information</h1>
        <div class="col-lg-12">
            <p>Shipping Address: <b><?=$order['address'];?></b></p>
            <p>Shipping City: <b><?=$order['city'];?></b></p>
            <p>Shipping State: <b><?=$order['state'];?></b></p>
            <p>Shipping Zip: <b><?=$order['zip'];?></b></p>
        </div>
        <h1 class="title">Billing Information</h1>
        <div class="col-lg-12">
            <p>Billing Address: <b><?=$order['billaddr'];?></b></p>
            <p>Billing City: <b><?=$order['billcity'];?></b></p>
            <p>Billing State: <b><?=$order['billstate'];?></b></p>
            <p>Billing Zip: <b><?=$order['billzip'];?></b></p>
        </div>
    </div>
</div>
<?php include "components/footer.php"; ?>