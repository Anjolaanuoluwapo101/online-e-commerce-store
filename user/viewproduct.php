<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="" href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">


    <title>Sixteen Clothing HTML Template</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
   
		<link rel="stylesheet" href="css/w3.css" >
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-sixteen.css">
    <link rel="stylesheet" href="assets/css/owl.css">
		<link rel="stylesheet" href="css/custom.css" >
  </head>

  <body>

    <!-- ***** Preloader Start ***** -->
 <!--   <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  -->
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <header class="" style="position:fixed;top:0;left:0;">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <a class="navbar-brand" href="index.html"><h2>SHOP<em>CONV</em></h2></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item active">
                <a class="nav-link" href="index.php">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li> 
              <li class="nav-item">
                <a class="nav-link" href="products.php">Our Products</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.php">About Us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact Us</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    
    <body>

<?php
if(isset($_GET['t'])){
  $db=$_GET['t'];
  $productname=$_GET['p'];
  $id=$_GET['i'];
$servername = "localhost";
$username = "root";
$password = "";
$sql = "SELECT * FROM $db WHERE id=$id AND productname='$productname' ";
try{
$conn = new PDO("mysql:host=$servername;dbname=Products",$username,$password);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$conn->setAttribute(PDO::ATTR_CURSOR,PDO::CURSOR_SCROLL);
$results = $conn->prepare($sql);
$results->execute();
while($result=$results->fetch(PDO::FETCH_BOTH,PDO::FETCH_ORI_NEXT)){
$id=$result[0];
$productname=$result[1];
$refId=$productname.$id;
$productname=urlencode($productname);
$price=$result[5];
$quantity=$result[6];
$redirect=htmlspecialchars('addtocart.php');
$upvote = $result[7];
$origin=$result[3];
if($result[7] == 1){$upvotes= $result[7]." Upvote";}else{$upvotes=$result[7]." Upvotes"; };
$disabled="";
if($price == 0){$disabled="disabled";
	}else{
		$disabled="";
	};


$data=<<<HTML
<style>
.viewproduct{
	border:1px solid silver;
	padding:10px;
	margin-top:100px;
	
}

.viewproduct img{
	width:100%;
	height:250px;
}

.viewproduct #productname{
	float:left;
	font-weight:700;
	color:skyblue;
	margin-left:5px;
}

.viewproduct #price {
	float:right;
	margin-left:5px;
	font-weight:700;
}

.viewproduct #upvotes{
display:block;
	float:right;
	font-weight:200;
	font-size:10px;
}

.viewproduct button{
	border:0px;
	font-weight:200;
	float:right;
	margin-right:5px;
}


@media only screen and (min-width:300px){
.viewproduct{
width:90%;
margin-left:5%;
}
}

@media only screen and (min-width:600px){
.viewproduct{
width:70%!important;
margin-left:15%!important;
}
}


</style>
<div class="viewproduct" >
<img src="$result[2]"> </img>
<br>
<br>
<div>
<span id="productname" > $result[1] </span>

<span id="price" > ₦$result[5] </span>
</div>
<br>
<span id="upvotes">$upvotes</span>
<br>
<br>
<div> Description: <br> {$result['description']} </div>
<br>
<button onclick="upvote()" style="border:0px solid;display:block" >Upvote<i class="fa fa-caret-up"></i> </button>
<br>
<br>
<br>
<form class="w3-container" action=$redirect method="POST" >
<input type="hidden" name="productname" value=$productname >
<input type="hidden" name="id" value=$id >
<input type="hidden" name="price" value=$price >
<input type="hidden" name="origin" value=$origin >
<input class="w3-input" style="margin-left:10%;width:80%;" max=$quantity type="number" name="quantity" placeholder="Only $quantity product left" >
<br>
<br>

<button class="w3-btn" style="width:auto;float:right;margin-right:5px" type="submit" $disabled> Add to cart </button>
</form>
<br>
<br>
<br>
<br>
</div>
HTML;
echo $data;
}
$conn=null;
}catch(PDOException $e) {
echo "Connection failed: ".$e->getMessage();
}
  
}else{
  http_response_code(404);
}
?>



    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Additional Scripts -->
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/owl.js"></script>
    <script src="assets/js/slick.js"></script>
    <script src="assets/js/isotope.js"></script>
    <script src="assets/js/accordions.js"></script>


    <script language = "text/Javascript"> 
      cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
      function clearField(t){                   //declaring the array outside of the
      if(! cleared[t.id]){                      // function makes it static and global
          cleared[t.id] = 1;  // you could use true and false, but that's more typing
          t.value='';         // with more chance of typos
          t.style.color='#fff';
          }
      }
    </script>



<script>
  function upvote(){
   var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function(){
    if (this.readyState == 4 && this.status == 200) {
alert(xhttp.responseText);
    }
};
xhttp.open("GET",<?php echo "\"addtocart.php?origin=$origin&id=$id&productname=$productname\"" ?>, true);
xhttp.send();
  }

  
</script>

</body>
</html>
