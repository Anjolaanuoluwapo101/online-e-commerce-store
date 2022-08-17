<?php
session_name("XCart");
session_start();
if(!empty($_SESSION['XCart'])){
$cartItems=count($_SESSION['XCart']);
$cartSymbol=<<<HTML

<style>
.cartSymbol{
	position:fixed;
	bottom:30px;
	left:68%;
	z-index:100000;
	width:30%;
	background:rgba(255,0,0,0.5);
	border-radius:20px;
	height:40px;
	line-height:40px;
	vertical-align:middle;
	text-align:center;
}
</style>

<a href="displaycart.php" class="cartSymbol" >
<i class="fa fa-shopping-cart" > </i>
<sub>$cartItems</sub>
</a>
HTML;
session_write_close();
 }else{
$cartSymbol=<<<HTML
<style>
.cartSymbol{
	position:fixed;
	bottom:30px;
	left:68%;
	z-index:1000000;
	width:30%;
	background:rgba(255,0,0,0.5);
	border-radius:20px;
	height:40px;
	line-height:40px;
	vertical-align:middle;
	text-align:center;
}
</style>
<a class="cartSymbol" >
  <i class="fa fa-shopping-cart" > </i>

  </a>
HTML;
session_write_close();
 }
?>
