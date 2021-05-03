
        <form name="submitform" id="submitform" method="post" action="">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="title">Order Form</h1>
                    <?=(isset($errorMessage))?$errorMessage:"";?>
                </div>
                <div class="col-lg-6">
                    <h3>Buyer's Information</h3>
                    <?php
                        formInput("text", "firstname", "First Name", "");
                        formInput("text", "lastname", "Last Name", "");
                        formInput("text", "email", "Email", "", $error["email"]);
                        formInput("text", "phone", "Phone Number", "", $error["phone"]);
                    ?>
                    <h3>Shipping Address</h3>
                    <?php
                        formInput("text", "address", "Address", "");
                        formInput("text", "city", "City", "");
                        formInput("text", "state", "State", "");
                        echo '<div id="stateList"></div>';
                        formInput("number", "zip", "Zip", "");
                        formInput("text", "phone", "Phone Number", "", $error["phone"]);
                    ?>
                    <div class="form-group">
                        <input id="same-address" type="checkbox" checked="checked" name="sameaddr" />
                        Billing address same as shipping
                    </div>
                    <div id="billing-address">
                        <h3>Billing Address</h3>
                        <?php
                            formInput("text", "billaddr", "Address", "");
                            formInput("text", "billcity", "City", "");
                            formInput("text", "billstate", "State", "");
                            echo '<div id="stateList"></div>';
                            formInput("number", "billzip", "Zip", "");
                        ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h3>Order Details</h3>
                    <div class="form-group">
                        <label for="quantity">Quantity
                        <?= (isset($error["quantity"])) ? $error["quantity"] : ""; ?></label>
                        <select id="quantity" class="form-control" onchange="updatePrice()" name="quantity">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="method">Shipping method</label>
                        <select id="method" class="form-control" name="method">
                            <option>Overnight ($11.00)</option>
                            <option selected>2-day expedited ($9.50)</option>
                            <option>7-day ground ($6.25)</option>
                        </select>
                    </div>
                    <h3>Payment Information</h3>
                    <?php
                        formInput("text", "cardname", "Name on Card", "");
                        formInput("text", "cardnumber", "Credit card number", "", $error["cardnumber"]);
                        formInput("number", "expmonth", "Exp Month", "", $error["expmonth"]);
                        formInput("number", "expyear", "Exp Year", "", $error["expyear"]);
                        formInput("number", "cvv", "CVV", "", $error["cvv"]);
                    ?>

                    <div id="price-table">
                        <div>Total Price:</div>
                        <div class="price-item">&nbsp; &nbsp;$<span id="total-price"></span></div>

                        <div>Total Tax: </div>
                        <div class="price-item">+ $<span id="tax-amount"></span></div>
                        <div>
                            <div>Shipping: </div>
                            <div class="price-item">+ $<span id="shipping"></span></div>
                        </div>

                        <div>
                            <h4>Final Price</h4>
                            <div class="price-item">= $<span id="final-price"></span></div>
                            <input type="hidden" id="totalPrice" name="totalPrice" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <br />
                        <input type="hidden" id="products" name="products" value='<?php echo $products_id_qual;?>' />
                        <button type="submit" class="btn btn-danger btn-block" id="formSubmit" name="purchase">
                            Place Order
                        </button>
                    </div>
                </div>
            </div>
        </form>