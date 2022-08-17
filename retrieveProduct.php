<?php
$productname=$_GET['productname'];
$category=$_GET['category'];

$servername = "localhost";
$username = "id18837981_anjolaakinsoyinu";
$password = "Naingolan-101";
$sql = "SELECT * FROM $category WHERE `productname` = ? LIMIT 1 ";
try{
$conn = new PDO("mysql:host=$servername;dbname=id18837981_products",$username,$password);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$conn->setAttribute(PDO::ATTR_CURSOR,PDO::CURSOR_SCROLL);
$results = $conn->prepare($sql);
$results->bindParam(1,$productname);
$results->execute();
$result=$results->fetchAll(PDO::FETCH_ASSOC);
if(count($result) != 0){

header('Content-Type:application/json');
echo json_encode($result);
$conn=null;
}else{
	echo "Product does not exist";
}

}catch(PDOException $e) {
echo "<script>alert('Couldn't connect to database')</script>";
}


?>
