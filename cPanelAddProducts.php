<?php
$nameEr ="";
$imageEr ="";
if(isset($_POST['productname'])){
/* initialize variables */
$name =htmlspecialchars(stripslashes($_POST['productname']));
$brand =htmlspecialchars($_POST['brand']);
$quantity=htmlspecialchars($_POST['quantity']);
$price =htmlspecialchars(stripslashes($_POST['price']));
$category =$_POST['category'];
$description =htmlspecialchars($_POST['description']);

/*End of initialize*/


/*confirm image type */
if($_FILES['image']['type']== "image/jpeg" ||$_FILES['image']['type'] == "image/png"){

/*connect to db for upload */
//$servername = "localhost";
//$username = "id18837981_anjolaakinsoyinu";
//$password = "Naingolan-101";id18837981_products
$servername="localhost";
$username="root";
$password="";
$sql = "SELECT * FROM (SELECT * FROM wristwatches UNION ALL SELECT * FROM bags) AS db WHERE `productname` = '$name'";
try{
echo 'hey';
$conn = new PDO("mysql:host=$servername;dbname=Products",$username,$password);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$conn->setAttribute(PDO::ATTR_CURSOR,PDO::CURSOR_SCROLL);
$results = $conn->prepare($sql);
$results->execute();
$result=$results->fetchAll();
if(count($result)!=0){
	echo "heyy";
	$conn=null;
	$nameEr="<span style='color:red'> *Product Name already exists </span>";
	
}else{
	echo "inside";
	$imageName =$_FILES['image']['name'];
	$invalid=array(' ','  ','   ');
	$name =str_replace($invalid,'',$name);
	$Name =$name;
	if($_FILES['image']['type']== "image/jpeg"){
	$name=$name.".jpg";
	}else{
		$name=$name.".png";
	}
echo "further";
	$oldpath=$_FILES['image']['tmp_name'];
	if(move_uploaded_file($oldpath,"user/imgUpload/$name")){
	echo "<script> alert('File Uploaded') </script>";
	$sql="INSERT INTO $category(productname,brand,price,quantity,origin,imagepath,description) VALUES(?,?,?,?,?,?,? )";
	$results=$conn->prepare($sql);
	$results->bindParam(1,$Name);
	$results->bindParam(2,$brand);
	$results->bindParam(3,$price);
	$results->bindParam(4,$quantity);
	$results->bindParam(5,$category);
	$results->bindParam(6,$name);
	$results->bindParam(7,$description);
	
	$results->execute();
}
}


}catch(PDOException $e) {
echo "<script>alert('Could not connect to database')</script>";
echo $e->getMessage();
}
}else {
$imageEr = "<span style='color:red'>*Invalid File Type </span>";
}


	
}



?>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css" >
<link rel="stylesheet" href="css/w3.css" >-->
<link rel="stylesheet" type="text/css" href="admim/cPanelcss/style.css" >

<title>Shop Convenient</title>
</head>
     <body>
          <fieldset>
               <legend>
                    ADD PRODUCTS HERE
               </legend>
               <div class="w3-container">
               <form enctype="multipart/form-data" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
               	<label > Product name</label><?php echo $nameEr; ?><br>
               	<input type="text" name="productname" required>
               	<br>
               	<label > Brand </label><br> 
               	<input type="text" name="brand" required> 
               	<br>
								<label >Category </label><br>
               	<select name="category" required>
              	<option value="wristwatches" >Wristwatches</option>
              	<option value="bags" >Bags</option>
               	</select>
               	<br>
              	<label >Price </label><br> 
               	<input type="number" name="price" required>
               	<br>
               	<label >Quantity </label><br>
               	<input type="number" min="1" value="1" name="quantity" required>
               	<br>
               	<label > Description </label><br>
               	<input type="text" name="description" required >
               	<br>
              	<label >Image </label><?php echo $imageEr ?><br>
               	<input placeholder="JPEG and PNG files only" type="file" name="image" required >
               	<br>
               	<button type="submit" >Upload to site</button>
               </form>
               </div>
          </fieldset>
     
     </body>
</htm>