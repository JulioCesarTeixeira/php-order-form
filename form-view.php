<!doctype html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <link href="style.css" rel="stylesheet">
    <title>Order food & drinks</title>
</head>
<body>
<?php

if ($message_sent):
    ?>
    <h3>Thanks for ordering with us!</h3>
    <?php
    echo "Your street is: ".$_SESSION['street'].", ".$_SESSION['streetnumber'];
    echo "</br>";
    echo $_SESSION['city'] . " - " . $_SESSION['zipcode'];
    echo "</br>";
    if ($_POST['express_delivery']) {
        $delivery = $currentTime + 45 * 60;
        echo "Expected express delivery at: " . date('g:ia', $delivery);
    } else if (!isset($_POST['express_delivery'])){
        $delivery = $currentTime + 2 * 60 * 60;
        echo "Expected normal delivery at: " . date('g:ia', $delivery);
    }
    ?>
<?php
else:
?>
?>
<div class="container">
    <h1>Order food in restaurant "the Personal Ham Processors"</h1>
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="http://php-order-form.localhost/?food=0">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="http://php-order-form.localhost/?food=1">Order drinks</a>
            </li>
        </ul>
    </nav>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, 'UTF-8'); ?>">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" class="form-control <?= $invalid_class_name ?? "" ?>"
                       placeholder="example@example.com" value="<?= $email ?>" autofocus/>
                <span class="error">* <?php echo $emailErr; ?></span>
            </div>
            <div></div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:</label>
                    <input type="text" name="street" id="street" class="form-control <?= $invalid_class_name ?? "" ?>"
                           value="<?= $_SESSION['street'] ?? "" ?>" autofocus>
                    <span class="error">* <?php echo $streetErr; ?></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="streetnumber">Street number:</label>
                    <input type="text" id="streetnumber" name="streetnumber"
                           class="form-control <?= $invalid_class_name ?? "" ?>" value="<?= $_SESSION['streetnumber'] ?? "" ?>" autofocus>
                    <span class="error">* <?php echo $streetnumberErr; ?></span>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" class="form-control <?= $invalid_class_name ?? "" ?>"
                           value="<?= $_SESSION['city'] ?? "" ?>" autofocus>
                    <span class="error">* <?php echo $cityErr; ?></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode</label>
                    <input type="text" id="zipcode" name="zipcode" class="form-control <?= $invalid_class_name ?? "" ?>"
                           value="<?= $_SESSION['zipcode'] ?? "" ?>" autofocus>
                    <span class="error">* <?php echo $zipcodeErr; ?></span>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>

            <?php foreach ($products as $i => $product): ?>
                <label>
                    <input type="checkbox" value="<?php echo (float)$product['price'] ?>" name="products[<?php echo $i ?>]"/> <?php echo $product['name'] ?>
                    -
                    &euro; <?php echo number_format($product['price'], 2) ?></label><br/>
            <?php endforeach; ?>
        </fieldset>

        <label>
            <input type="checkbox" name="express_delivery" value="5"/>
            Express delivery (+ 5 EUR)
        </label>

        <button type="submit" class="btn btn-primary">Order!</button>
    </form>
    <?php
    endif;
    ?>
    <footer>You already ordered <strong>&euro; <?php echo $_COOKIE['totalCounter'] ?></strong> in food and drinks.</footer>
</div>

<style>
    footer {
        text-align: center;
    }
</style>
</body>
</html>