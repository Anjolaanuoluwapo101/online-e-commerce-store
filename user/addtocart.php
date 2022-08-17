<?php
error_reporting(0);
include "aj_create_regenerate_sessionIDScript.php";
if(isset($_POST['id'],$_POST['productname'])){
@$id=$_POST['id'];
@$productname=$_POST['productname'];
@$productname=urldecode($productname);
@$price=$_POST['price'];
@$refId=$productname.$id;
@$quantity=$_POST['quantity'];
$quantity = round($quantity);
@$Origin=$_POST['origin'];
}else{
 @$id=$_GET['id'];
@$productname=$_GET['productname'];
@$productname=urldecode($productname);
@$refId=$productname.$id;
@$origin=$_GET['origin'];
@session_write_close();
ini_set("session.gc_maxlifetime",60*60*24*7);
ini_set("session.cookie_lifetime",60*60*24*7);
session_name("upvoteCookie");
session_start();
if(!(isset($_SESSION['upvoteCookie']))){
 $_SESSION['upvoteCookie']=array();
};
}

if(isset($price,$quantity,$id,$productname,$refId)){
@session_write_close();
/*ini_set("session.gc_maxlifetime",10000);
ini_set("session.cookie_lifetime",10000);
session_name("XCart");
session_start();*/
aj_session_create_regenerate_id(1000,"XCart");
if (!(isset($_SESSION['XCart']))){
$_SESSION['XCart']=array();
$_SESSION['XCart'][$refId]=array('id'=>$id,'productname'=>$productname,'price'=>$price,'quantity'=>$quantity,'origin'=>$Origin);
echo "new session created";
session_write_close();
}elseif(isset($_SESSION['XCart']) && empty($_SESSION['XCart'])){
  $_SESSION['XCart'][$refId]=array('id'=>$id,'productname'=>$productname,'price'=>$price,'quantity'=>$quantity,'origin'=>$Origin);
  echo "first product added";
  session_write_close();
}elseif(isset($_SESSION['XCart']) && !empty($_SESSION['XCart']) && (!array_key_exists($refId,$_SESSION['XCart']))){
 $_SESSION['XCart'][$refId]=array('id'=>$id,'productname'=>$productname,'price'=>$price,'quantity'=>$quantity);
  echo "product added";
  session_write_close();
}elseif(isset($_SESSION['XCart'][$refId])){
  $_SESSION['XCart'][$refId]['quantity']=$quantity;
  echo "<script>alert('cart updated')</script>";
  echo $_SESSION['XCart'][$refId]['quantity'];
  session_write_close();
}
//print_r($_SERVER);
//echo "<script> history.back()</script>";
}

if(isset($productname,$origin,$id)){
if(!(in_array($refId,$_SESSION['upvoteCookie']))){
$servername = "localhost";
$servername = "localhost";
$username = "root";
$password = "";

$sql = "UPDATE $origin SET upvotes=upvotes+1 WHERE productname=? AND id=? ";
try{
$conn = new PDO("mysql:host=$servername;dbname=Products",$username,$password);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$conn->setAttribute(PDO::ATTR_CURSOR,PDO::CURSOR_SCROLL);
$results = $conn->prepare($sql);
$results->execute(array($productname,$id));
echo "Please refresh page";
array_push($_SESSION['upvoteCookie'],$refId);
session_write_close();
$conn=null;

}catch(PDOException $e){
 echo "Connection failed: ".$e->getMessage();
 session_write_close();
}
}else{
 echo 'Already Upvoted';
 session_write_close();
}
}

?>