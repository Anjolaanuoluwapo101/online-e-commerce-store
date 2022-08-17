<?php
$productname="";

if(isset($_POST['productname'])){
$productname = htmlspecialchars(stripslashes($_POST['productname']));
$category =$_POST['category'];

$whitespaces = array("  ","   ");
$productname=str_ireplace($whitespaces,"",$productname);



$invalids= array(" and "," or "," not ");
$productname=str_ireplace($invalids,"",$productname);


/*connect to db for upload */
/*$servername = "localhost";
$username = "id18837981_anjolaakinsoyinu";
$password = "Naingolan-101";id18837981_products
*/

$servername="localhost";
$username="root";
$password="";

try{
$conn = new PDO("mysql:host=$servername;dbname=Products",$username,$password);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$conn->setAttribute(PDO::ATTR_CURSOR,PDO::CURSOR_SCROLL);
$deletedRow = $conn->exec("DELETE FROM $category WHERE `productname`= '$productname' ");
/*$deletedRow->bindParam(1,$productname);
$deletedRow->execute();
$check= $deletedRow->fetchAll();*/

if($deletedRow !=FALSE ){
echo "<script>alert('Deleted')</script>";
$productname="";
}else{
echo "<script>alert('No row deleted as product does not exist')</script>";
$productnameEr = "<span style='color:red'>*Product doesn't exist </span>";
}


}catch(PDOException $e) {
echo "<script>alert('Could not connect to database')</script>";
}	
}


?>


<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css" >
<link rel="stylesheet" href="css/w3.css" >
<link rel="stylesheet" type="text/css" href="css/style.css" >

<title>Delete Product</title>
</head>
<body>
<fieldset >
	<legend>
		DELETE PRODUCT
	</legend>
	<form class="w3-container" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" >
		<label > Product name</label><br>
               	<input value="<?php echo $productname; ?>" name="productname" type="text" required>
               	<br> 	
               	<label >Category </label><br>
               	<select name="category" required>
              	<option value="wristwatches" >Wristwatches</option>
              	<option value="bags" >Bags</option>
               	</select>
               	<br>
               	<button type="submit"> DELETE PRODUCT</button>
               
	</form>
</fieldset>
</body>
</html>