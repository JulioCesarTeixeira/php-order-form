<?php

//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables so we need to enable sessions
session_start();
//setcookie - need to be finished
if(!isset($_COOKIE["totalCounter"])){
    setcookie("totalCounter", "0");
    $currentCookie = "0";
} else {
    if(!empty($newCookie)){
        setcookie("totalCounter", strval($newCookie));
        $currentCookie = $newCookie;
    } else {
        $currentCookie = $_COOKIE["totalCounter"];
    }
}

function whatIsHappening()
{
//    echo '<h2>$_GET</h2>';
//    var_dump($_GET);
//    echo '<h2>$_POST</h2>';
//    var_dump($_POST);
//    echo '<h2>$_COOKIE</h2>';
//    var_dump($_COOKIE);
//    echo '<h2>$_SESSION</h2>';
//    var_dump($_SESSION);
//    var_dump($_GET['food']);
}

//echo "<pre>";
//print_r(date('today g:ia', $delivery));
//echo "</pre>";

$emailErr = $streetErr = $cityErr = $streetnumberErr = $zipcodeErr = "";
$email = $street = $city = $streetnumber = $zipcode = "";
$message_sent = false;
$currentTime = time() + 3600;


//Email validation
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['email']) && !empty($_POST['email'])) {
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
        } else {
            $emailErr = "Oops, input a valid e-mail format, please";
            $invalid_class_name = "form-invalid";
        }
    } else {
        $invalid_class_name = "form-invalid";
        $emailErr = "Fill in your e-mail address, please";
    }
    //form validation and local session storage
    if (isset($_POST['street']) && !empty($_POST['street']) && preg_match("/^[a-zA-Z-' ]*$/", $_POST['street'])) {
        $street = htmlspecialchars($_POST['street'], ENT_QUOTES, 'UTF-8');
    } else {
        $invalid_class_name = "form-invalid";
        $streetErr = "Invalid street name";

    }

    if (isset($_POST['city']) && !empty($_POST['city']) && preg_match("/^[a-zA-Z-' ]*$/", $_POST['city'])) {
        $city = htmlspecialchars($_POST['city'], ENT_QUOTES, 'UTF-8');
    } else {
        $invalid_class_name = "form-invalid";
        $cityErr = "invalid city";
    }
    if (isset($_POST['streetnumber']) && !empty($_POST['streetnumber']) && is_numeric($_POST['streetnumber'])) {
        $streetnumber = htmlspecialchars($_POST['streetnumber'], ENT_QUOTES, 'UTF-8');
    } else {
        $invalid_class_name = "form-invalid";
        $streetnumberErr = "input a valid number";
    }
    if (isset($_POST['zipcode']) && !empty($_POST['zipcode']) && is_numeric($_POST['zipcode'])) {
        $zipcode = htmlspecialchars($_POST['zipcode'], ENT_QUOTES, 'UTF-8');
    } else {
        $invalid_class_name = "form-invalid";
        $zipcodeErr = "input a valid zipcode number";
    }

    if ($emailErr === "" && $streetErr === "" && $streetnumberErr === "" && $cityErr === "" && $zipcodeErr === "") {
        $message_sent = true;
    }
    $_SESSION['street'] = $_POST['street'];
    $_SESSION['city'] = $_POST['city'];
    $_SESSION['streetnumber'] = $_POST['streetnumber'];
    $_SESSION['zipcode'] = $_POST['zipcode'];
}


//toggle dynamic menu for food and drinks
if(isset($_GET['food']) && $_GET['food'] === "0"){
    $products = [
        ['name' => 'Club Ham', 'price' => 3.20],
        ['name' => 'Club Cheese', 'price' => 3],
        ['name' => 'Club Cheese & Ham', 'price' => 4],
        ['name' => 'Club Chicken', 'price' => 4],
        ['name' => 'Club Salmon', 'price' => 5]
    ];
} else if (isset($_GET['food']) && $_GET['food'] === "1"){
    $products = [
        ['name' => 'Cola', 'price' => 2],
        ['name' => 'Fanta', 'price' => 2],
        ['name' => 'Sprite', 'price' => 2],
        ['name' => 'Ice-tea', 'price' => 3],
    ];
} else{
    $products = [
        ['name' => 'Club Ham', 'price' => 3.20],
        ['name' => 'Club Cheese', 'price' => 3],
        ['name' => 'Club Cheese & Ham', 'price' => 4],
        ['name' => 'Club Chicken', 'price' => 4],
        ['name' => 'Club Salmon', 'price' => 5]
    ];
    //delivery calculation
    if ($_POST['express_delivery'] ?? "") {
        $delivery = $currentTime + 45 * 60;
        echo "Expected delivery at: " . date('g:ia', $delivery);
    } else {
        $delivery = $currentTime + 2 * 60 * 60 ?? "";
        echo "Expected delivery at: " . date('g:ia', $delivery);
    }

}

whatIsHappening();

//counter plus cookie - needs fixing
$newCookie = "";
$totalValue = 0;
if (isset($_POST['products'])) {
    foreach ((array)$_POST['products'] as $product['price']) {
        $totalValue += $product['price'];
//        $_COOKIE['counter'] = $totalValue;
    }
    if (!empty($_POST['express_delivery'])) {
        $totalValue = (float)$_POST['express_delivery'] + $totalValue;
//        $_COOKIE['counter'] = $totalValue;
    }
    $newCookie = (float)$_COOKIE['totalCounter'] + $totalValue;
}

//
//if(!isset($_COOKIE["counter"])){
//    echo "cookie ". "counter" . "is not set";
//} else {
//    echo "Cookie '" . "counter" . "' is set!<br>";
//    $totalValue = $_COOKIE['counter'];
//}



require 'form-view.php';