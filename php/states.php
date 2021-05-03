<?php
include "php/dbconnect.php";
$stmt = $myDB->select("states", "*", "", "");
die(json_encode($stmt));
