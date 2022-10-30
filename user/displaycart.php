<?php
//triggered by the form submission
if (isset($_POST['delete'])) {
    $refId = $_POST['delete'];
    $refId = urldecode($refId);
    session_name("XCart");
    session_start();
    unset($_SESSION['XCart'][$refId]);

    //forcefully close session
    session_write_close();

    //since it's a post submission...we need to go back because post submission c..
    echo "<script> history.go(-1) </script>";
}
?>

<?php
session_name("XCart");
session_start();
?>
<html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/w3.css">

    <title>Shop Convenient</title>
</head>
<body>
    <div class="">
        <table class="w3-table w3-border w3-tiny">
            <tr>
                <th> Product Name</th>
                <th> Price Per Unit</th>
                <th> Quantity</th>
                <th></th>
            </tr>
            <?php
            if (!empty($_SESSION['XCart'])) {
                $cart = $_SESSION['XCart'];
                foreach ($cart as $cartItem) {

                    list($origin, $productname, $id, $price, $quantity, $refId) = array($cartItem['origin'], $cartItem['productname'], $cartItem['id'], $cartItem['price'], $cartItem['quantity'], urlencode($cartItem['productname'].$cartItem['id']));
                    $cart = <<<HTML
<tr>
<td><a href="viewproduct.php?t=$origin&i=$id&p=$productname">$productname</a></td>
<td> $price </td>
<td> $quantity </td>
<td> <form action="displaycart.php" method="POST" >
<input type="hidden" name="delete" value=$refId>
<button type="submit"> X </button>
</form>
</td>
</tr>
HTML;
                    echo $cart;
                }
            } else {
                echo "<script>alert('NO CART STORED');history.go(-1)</script>";
            }


            ?>
        </table>
    </div>
</body>
</html>