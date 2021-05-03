<?php include "components/header.php";?>
    <section class="container addSpace" id="products">
        <div class="row">
            <div class="col-md-12">
                <h1 class="title">All Products</h1>
            </div>
        </div>
        <div class="row">
            <?php
                $curPage = $_GET['p']?$_GET['p']:1;
                $query = array_filter($_GET, function($k) { return ($k != 'p' && $k != 'page'); }, ARRAY_FILTER_USE_KEY);
                $paging = $myDB->page("products", $query, $curPage, 16, 3)['html'];
                $arr = $myDB->select("products", "*", $query, "ORDER BY `id` ASC", true);
                foreach($arr as $row) {
                    echo '<div class="col-lg-3 col-md-12 product">';
                    echo '<div class="addMargin">';
                    echo '<a href="./?page=detail&id='.$row['id'].'"><img src="'.$row['thumbnail'].'" alt="'.$row['name'].' picture"></a>';
                    echo '<h2>'.$row['name'].'</h2>';
                    echo '<h3>'.$row['category'].' | $'.$row['price'].'</h3>';
                    echo '<a href="./?page=detail&id='.$row['id'].'" class="addtocart">See Details</a>';
                    echo '</div>';
                    echo '</div>';
                }
            ?>
        </div>
        <div class="d-flex flex-row-reverse" style="margin-top: 20px;">
            <?php
                echo $paging;
            ?>
        </div>
    </section>
<?php include "components/footer.php";?>