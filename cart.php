<?php
if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    $product = $myDB->select("products", "*", array("id" => $_POST['product_id']))[0];
    if ($product && $quantity > 0) {
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                $_SESSION['cart'][$product_id] = $quantity;
            }
        } else {
            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }
    header('location: index.php?page=cart');
    exit;
}
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    header('location: index.php?page=cart');
    exit;
}
//index.php?page=cart&remove=1.
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int)$v;
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }
    header('location: index.php?page=cart');
    exit;
}
if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    header('Location: index.php?page=confirmation');
    exit;
}
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;
if ($products_in_cart) {
    $products_id = implode(",", array_keys($products_in_cart));
    $products_id_qual = json_encode($products_in_cart);
    $products = $myDB->select('products', '*', 'id IN (' . $products_id . ')');
    foreach ($products as $product) {
        $subtotal += (float)$product['price'] * (int)$products_in_cart[$product['id']];
    }
}
function formInput($type, $name, $display, $placeholder, $error = "") {
    echo '<div class="form-group">';
    echo '<label for="'.$name.'">'.$display.$error.'</label>';
    echo '<input type="'.$type.'" class="form-control" name="'.$name.'" id="'.$name.'" value="'.$_POST[$name].'" placeholder="'.$placeholder.'">';
    echo '</div>';
}
include "php/insert.php";
include "components/header.php";
?>
<div class="container">
    <div class="cart content-wrapper">
        <h1>Shopping Cart</h1>
        <form action="index.php?page=cart" method="post">
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
                            <br>
                            <a href="index.php?page=cart&remove=<?=$product['id']?>" class="remove">Remove</a>
                        </td>
                        <td class="price">&dollar;<?=$product['price']?></td>
                        <td class="quantity">
                            <input type="number" name="quantity-<?=$product['id']?>" value="<?=$products_in_cart[$product['id']]?>" min="1" max="<?=$product['quantity']?>" placeholder="Quantity" required>
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
            <div class="buttons">
                <input type="submit" value="Update" name="update">
                <input type="submit" value="Place Order (Fake)" name="placeorder">
            </div>
        </form>
        <?php if (!empty($products)): ?>
            <?php include("components/orderForm.php");?>
        <?php endif; ?>
    </div>
</div>
<?php include("components/footer.php");?>