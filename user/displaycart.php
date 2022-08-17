<?php
if(isset($_POST['delete'])){
 $refId=$_POST['delete'];
 $refId=urldecode($refId);
 @session_write_close();
 session_name("XCart");
 session_start();
 unset($_SESSION['XCart'][$refId]);
 @session_write_close();
}


session_name("XCart");
session_start();
?>


<html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css" >
<link rel="stylesheet" href="assets/css/w3.css" >
<link rel="stylesheet" type="text/css" href="css/style.css" >

<title>Shop Convenient</title>
</head>
<body>
<div class="">
 <table class="w3-table-all w3-tiny">
  <tr>
   <th> Product Name</th>
   <th> Price </th>
   <th> Quantity</th>
   <th></th>
  </tr>
<?php
if(!empty($_SESSION['XCart'])){
$cart = $_SESSION['XCart'];
foreach ($cart as $cartItem){
$origin=$cartItem['origin'];
$productname=$cartItem['productname'];
$id=$cartItem['id'];
$price=$cartItem['price'];
$quantity =$cartItem['quantity'];
$refId = $productname.$id;
$refId=urlencode($refId);
$cart=<<<HTML
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
}else{
 //echo "<script>alert('NO CART STORED')</script>";
 echo "<script> history.back()</script>";

}


?>
</table>
</div>
</body>
</html>