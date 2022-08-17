


<?php
$nameEr ="";
$imageEr="";


?>


<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css" >
<link rel="stylesheet" href="css/w3.css" >-->
<link rel="stylesheet" type="text/css" href="cPanelcss/style.css" >

<title>Update products</title>
</head>
<body>
   
               <div class="w3-container">
               	<div >
               <form enctype="multipart/form-data" method="POST" action="<?php echo htmlspecialchars($_SERVER['retrieveProduct.php']) ?>" >
               	<label > Product name</label><br>
               	<input id="oldname" type="text" required>
               	<br> 	
               	<label >Category </label><br>
               	<select id="category" required>
              	<option value="wristwatches" >Wristwatches</option>
              	<option value="bags" >Bags</option>
               	</select>
               	<br>	
               	</form>
               	</div>
               	<button onclick='retrieveProduct()'> Get product</button>
               	
         <fieldset >
               <legend>
                    UPDATE PRODUCTS HERE
               </legend>	
               <form enctype="multipart/form-data" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" >
              	<input id="oldnameForm"  type="hidden"  name="oldnameForm">
               	<br>
               	<label > Product name</label><?php echo $nameEr; ?><br>
               	<input id="newName" type="text" name="newName" required>
               	<br>
               	<label > Brand </label><br> 
               	<input id="brand" type="text" name="brand" required> 
               	<br>
		<label >Category </label><br>
               	<select id="Category" name="category" required>
              	<option value="wristwatches" >Wristwatches</option>
              	<option value="bags" >Bags</option>
               	</select>
               	<br>
              	<label >Price </label><br> 
               	<input id="price" type="number" name="price" required>
               	<br>
               	<label >Quantity </label><br>
               	<input id="quantity" type="number" min="1" value="1" name="quantity" required>
               	<br>
               	<label > Description </label><br>
               	<input id="description" type="text" name="description" required >
               	<br>
              	<label >Image </label><?php echo $imageEr ?><br>
               	<input placeholder="JPEG and PNG files only" type="file" name="image" required >
               	<br>
               	<button type="submit" >UPDATE PRODUCT</button>
               </form>
               </div>
          </fieldset>
     
	
	
	
	
	
	
	
<script>




function retrieveProduct(){
	if(document.getElementById("oldname").value != ""){

var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200){
 	var result=xhttp.responseText;
// 	alert(product);
if(result != "Product does not exist") {
alert("good");
var product=JSON.parse(result);
var Product = [];
for(var i in product){
	Product.push(product[i]);
}
document.getElementById("oldnameForm").value=Product[0]["productname"];
document.getElementById("newName").value=Product[0]["productname"];
document.getElementById("brand").value=Product[0]["brand"];
//document.getElementById("id").value=Product[0]["id"];
document.getElementById("price").value=Product[0]["price"];
document.getElementById("quantity").value=Product[0]["quantity"];
document.getElementById("description").value=Product[0]["description"];
document.getElementById("Category").value=Product[0]["origin"];
alert("Data loaded from DB")

}else if(result == "Product does not exist"){
	alert(result);
}
   
};
}
var productname=document.getElementById("oldname").value;
var category=document.getElementById("category").value;
alert(productname+category);
var searchlink=".php?".concat("productname=",productname,"&","category=",category);
xhttp.open("GET","retrieveProduct"+searchlink, true);
xhttp.send();

}
}

</script>

</body>
</html>




<?php

if(isset($_POST['newName'])){
/* initialize variables */
$oldname =$_POST['oldnameForm'];
$newName =htmlspecialchars(stripslashes($_POST['newName']));
$brand =htmlspecialchars(stripslashes($_POST['brand']));
$quantity=htmlspecialchars(stripslashes($_POST['quantity']));
$price =htmlspecialchars(stripslashes($_POST['price']));
$category =$_POST['category'];
$description =$_POST['description'];

/*End of initialize*/


/*confirm image type */
if($_FILES['image']['type']== "image/jpeg" ||$_FILES['image']['type'] == "image/png"){

/*connect to db for upload */

$servername = "localhost";
$username = "id18837981_anjolaakinsoyinu";
$password = "Naingolan-101";
try{
$conn = new PDO("mysql:host=$servername;dbname=id18837981_products",$username,$password);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$conn->setAttribute(PDO::ATTR_CURSOR,PDO::CURSOR_SCROLL);
$imageName =$_FILES['image']['name'];
$nameOfProductImage =$newName;
$invalid=array(' ','  ','   ');
$nameOfProductImage =str_replace($invalid,'',$nameOfProductImage);
if($_FILES['image']['type']== "image/jpeg"){
$nameOfProductImage=$nameOfProductImage.".jpg";
}else{
	$nameOfProductImage=$nameOfProductImage.".png";
}

$oldpath=$_FILES['image']['tmp_name'];
if(move_uploaded_file($oldpath,"user/imgUpload/$nameOfProductImage")){
echo "moved";
$sql="UPDATE $category SET `brand`=?,`productname`=?,`quantity`=?,`price`=?,`description`=?,`imagepath`=? WHERE `productname`='$oldname' ";
$results=$conn->prepare($sql);
$results->execute(array($brand,$newName,$quantity,$price,$description,"imgUpload/".$nameOfProductImage));
echo "complete";
}


}catch(PDOException $e) {
echo "<script>alert('Could not connect to database')</script>";
echo $e->getMessage();
}
}else {
$imageEr = "<span style='color:red'>*Invalid File Type </span>";
}


	
}

