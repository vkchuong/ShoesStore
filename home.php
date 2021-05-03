<?php
    include("components/header.php");
?>
        <section class="container-fullwidth" id="groupone">
            <div class="row">
                <div class="col-lg-6 col-md-12 home-product">
                    <div class="addMargin">
                        <h2>What is Lorem Ipsum?</h2>
                        <div class="text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.</div>
                        <div><a href="./?page=products" class="btn btn-dark">See Details</a></div>
                        <div class="thumbnail"><img src="assets/2.png" /></div>

                    </div>
                </div>
                <div class="col-lg-6 col-md-12 home-product">
                    <div class="addMargin">
                        <h2>Why do we use it?</h2>
                        <div class="text">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. </div>
                        <div><a href="./?page=products" class="btn btn-dark">See Details</a></div>
                        <div class="thumbnail"><img src="assets/4.png" /></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="container-fullwidth" id="middle-bar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>We created Harry's to be a little bit different.</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 tag">
                        <i class="bi bi-tags"></i>
                        <strong>Honestly Priced</strong>
                        By owning our factory in United State, we can offer you sharp, durable blades without the upcharging
                    </div>
                    <div class="col-lg-4 tag">
                        <i class="bi bi-chat-quote"></i>
                        <strong>Made With Integrity</strong>
                        From the steel of our blades to our sulfate-free skin-care formulations, quality always comes first.
                    </div>
                    <div class="col-lg-4 tag">
                        <i class="bi bi-emoji-laughing"></i>
                        <strong>Always Giving Back</strong>
                        Every year, we donate 1% of our sales to nonprofits that provide mental health care services to men in need
                    </div>
                </div>
            </div>
        </section>
        <section class="container-fullwidth" id="grouptwo">
            <div class="row">
                <div class="col-lg-6 col-md-12 home-product">
                    <div class="addMargin">
                        <div class="thumbnail"><img src="assets/1.png" /></div>
                        <div class="note">
                            <h2>Where does it come from?</h2>
                            <div class="text">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC.</div>
                            <div><a href="./?page=products&category=mens-shoes" class="btn-underline">Mens Shoes</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 home-product">
                    <div class="addMargin">
                        <div class="thumbnail"><img src="assets/3.png" /></div>
                        <div class="note">
                            <h2>Where can I get some?</h2>
                            <div class="text">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.</div>
                            <div><a href="./?page=products&category=womens-shoes" class="btn-underline">Womens Shoes</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 home-product">
                    <div class="addMargin">
                        <div class="thumbnail"><img src="assets/5.png" /></div>
                        <div class="note">
                            <h2>Why I use lorem?</h2>
                            <div class="text">The reason I'm using lorem a lot because I don't know what to write in the content. And I don't want to waste my time on this.</div>
                            <div><a href="./?page=products&category=mens-accessories" class="btn-underline">Mens Accessories</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 home-product">
                    <div class="addMargin">
                        <div class="thumbnail"><img src="assets/6.png" /></div>
                        <div class="note">
                            <h2>Do I like lorem?</h2>
                            <div class="text">Yes. I really like lorem, it help me save a lot if time. I can use that time to development other part of the page.</div>
                            <div><a href="./?page=products&category=womens-accessories" class="btn-underline">Womens Accessories</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="container-fullwidth" id="featured-product">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="title" align="center">Featured Products</h1>
                        <p align="center">Designed and formulated for quality.</p>
                    </div>
                </div>
                <div class="row">
                    <?php
                        $arr = $myDB->select("products", "*", "", "ORDER BY RAND() ASC LIMIT 3");
                        foreach($arr as $row) {
                            echo '<div class="col-lg-4 col-md-12 product">';
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
                <div class="row markdown">
                    <div class="col-lg-12">
                        <span>WE'RE IN THE NEWS... FOR GOOD REASONS.</span>
                    </div>
                    <div class="col-lg-4 quote">
                        <p>“A quality product at an impressively low price.”</p>
                        <small>– Esquire</small>
                    </div>
                    <div class="col-lg-4 quote">
                        <p>“This thing might just be the Hope Diamond of razors.”</p>
                        <small>– GQ</small>
                    </div>
                    <div class="col-lg-4 quote">
                        <p>“This $7 body wash changed my showers forever.”</p>
                        <small>– Men’s Health</small>
                    </div>
                </div>
            </div>
        </section>
        <section class="container">
            <div class="subscribe">
                <h3>Sign Up for the <b>NEWSDEAL</b></h3>
                <form action="" method="POST" id="signup" onsubmit="alert('Thank You For Subscribing!');">
                    <input type="text" name="email" placeholder="Enter Your Email" class="custominput"/>
                    <button type="submit">Subscribe</button>
                </form>
            </div>
        </section>
<?php include("components/footer.php");?>