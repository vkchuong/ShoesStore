<?php
    if(isset($_POST['purchase'])) {

        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $error["email"] = "<small style='color: red;'>Invalid Email!</small>";
        }

        if(isset($_POST['phone'])) {
            $_POST['phone'] = str_replace("-", "", $_POST['phone']);
        }

        if(!is_numeric($_POST['phone']) || (is_numeric($_POST['phone']) && strlen((string)$_POST['phone']) != 10)) {
            $error["phone"] = "<small style='color: red'>Invalid Phone Number!</small>";
        }

        if(isset($_POST['zip'])) {
            $_POST['zip'] = substr($_POST['zip'], 0, 5);
        }

        if(!is_numeric($_POST['zip'])) {
            $error["zip"] = "<small style='color: red'>Invalid Zip Code!!</small>";
        }

        if(strlen($_POST['products']) < 1) {
            $error["products"] = "<small style='color: red'>Invalid Product id!!</small>";
        }

        if(!is_numeric($_POST['expmonth']) && $_POST['expmonth'] > 12 && $_POST['expmonth'] < 1) {
            $error["expmonth"] = "<small style='color: red'>Invalid Expiring Month!!</small>";
        }

        if(!is_numeric($_POST['expyear']) && $_POST['expyear'] > 2020 && $_POST['expyear'] < 2030) {
            $error["expyear"] = "<small style='color: red'>Invalid Expiring Year</small>";
        }

        if(!is_numeric($_POST['cvv']) ) {
            $error["cvv"] = "<small style='color: red'>Invalid CVV Number!!</small>";
        }

        if(!is_numeric($_POST['cardnumber']) && strlen($_POST['cardnumber']) > 10 && strlen($_POST['cardnumber']) < 10) {
            $error["cardnumber"] = "<small style='color: red'>Invalid Card Number!!</small>";
        }
        if(isset($_POST['sameaddr'])) {
            $billaddr = $_POST['address'];
            $billcity = $_POST['city'];
            $billstate = $_POST['state'];
            $billzip = $_POST['zip'];
        } else {
            $billaddr = $_POST['billaddr'];;
            $billcity = $_POST['billcity'];;
            $billstate = $_POST['billstate'];;
            $billzip = $_POST['billzip'];
        }
        if(empty($error)) {
            $randomOrderID = rand();
            $insertQuery = array(
                'id' => $randomOrderID,
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address'],
                'city' => $_POST['city'],
                'state' => $_POST['state'],
                'zip' => $_POST['zip'],
                'billaddr' => $billaddr,
                'billcity' => $billcity,
                'billstate' => $billstate,
                'billzip' => $billzip,
                'method' => $_POST['method'],
                'products' => $_POST['products'],
                'cardname' => $_POST['cardname'],
                'cardnumber' => $_POST['cardnumber'],
                'expmonth' => number_format($_POST['expmonth']),
                'expyear' => $_POST['expyear'],
                'cvv' => $_POST['cvv'],
                'price' => $_POST['totalPrice']
            );
            $myDB->insert("orders", $insertQuery);
            unset($_SESSION['cart']);
            header("Location: ./?page=confirmation&id=".$randomOrderID);
        } else {
            $errorMessage = "<p style='color: red; text-align:center;'>We can't proccess your purchase right now. please contact support team.</p>";
        }
    }
?>