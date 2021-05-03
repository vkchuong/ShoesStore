<?php
include "components/header.php";
include "php/insert.php";
$_GET['id'] = empty($_GET['id']) ? 1 : $_GET['id'];
$stmt = $myDB->select("products", "*", array('id' => $_GET['id']))[0];
?>
    <section class="container addSpace">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="title"><?= $stmt['name']; ?></h1>
            </div>
            <div class="col-lg-12">

			<div class="slider slider-for">
                <?php
                    $images = json_decode($stmt['images'], true);
                    foreach($images as $i) {
                        echo '<div><img src="'.$i.'" class="thumbnail" width="50%" alt="'.$stmt['name'].'" /></div>';
                    }
                ?>
			</div>
			<div class="slider slider-nav">
                <?php
                    $images = json_decode($stmt['images'], true);
                    foreach($images as $i) {
                        echo '<div><img src="'.$i.'" class="thumbnail" width="100%" alt="'.$stmt['name'].'" /></div>';
                    }
                ?>
			</div>
            <script >
                $(document).ready(function() {
                    $('.slider-for').slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: true,
                        fade: true,
                        asNavFor: '.slider-nav'
                    });
                    $('.slider-nav').slick({
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        asNavFor: '.slider-for',
                        dots: true,
                        centerMode: true,
                        focusOnSelect: true,
                        arrows: false,
                    });
                });
            </script>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="title">Details</h1>
            </div>
            <div class="col-lg-8">
                <div class="detail"><?= $stmt['detail']; ?></div>
            </div>
            <div class="col-lg-2">
                <h4>Category:</h4>
                <p><?= $stmt['category']; ?></p>
                <h4>Price:</h4>
                <p id="unitPrice">$<?= $stmt['price']; ?></p>
                <form action="index.php?page=cart" method="post">
                    <div class="form-group">
                        <label for="quantity"><h4>Quantity:</h4></label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" placeholder="Quantity" required>
                    </div>
                    <input type="hidden" name="product_id" value="<?=$stmt['id']?>">
                    <input type="submit" value="Add To Cart" class="btn btn-danger btn-block">
                </form>
            </div>
        </div>
    </section>
<?php include "components/footer.php";?>