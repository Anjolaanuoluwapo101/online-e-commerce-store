<?php
include "cart.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>Sixteen Clothing Products</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--

        TemplateMo 546 Sixteen Clothing

        https://templatemo.com/tm-546-sixteen-clothing

        -->

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-sixteen.css">
    <link rel="stylesheet" href="assets/css/owl.css">

</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <header class="">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="index.html"><h2>SHOP <em>CONV</em></h2></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item active">
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

    <!-- Page Content -->
    <div class="page-heading products-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-content">
                        <h4>new arrivals</h4>
                        <h2>sixteen products</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="products">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="filters">
                        <ul>
                            <li class="active" onclick="searchItem(1,'all')">All Products</li>
                            <li onclick="changePage(1,'wristwatches')">WristWatches</li>
                            <li onclick="changePage(1,'bags')">Bags</li>
                            <br>
                            <li><input placeholder="Global Search" id="searchInput" type="text" style="width:60%"> <button onclick="searchItem(1,null,1)"> HH </button></li>
                        </ul>

                    </div>
                </div>


                <!-- AJ script starts here -->

                <div class="col-md-12" style="margin-bottom:200px;">
                    <div class="filters-content">
                        <div class="row grid">



                        </div>
                    </div>
                </div>
                <br>
                <br>
                <br>


                <footer>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="inner-content">
                                    <p>
                                        Copyright &copy; 2022 SHOP CONVENIENT

                                        - Design: <a rel="nofollow noopener" href="" target="_blank">TemplateMo</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>





                <!-- AJ script Ends here -->



                <!-- Bootstrap core JavaScript -->
                <script src="vendor/jquery/jquery.min.js"></script>
                <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


                <!-- Additional Scripts -->
                <script src="assets/js/custom.js"></script>
                <script src="assets/js/owl.js"></script>
                <script src="assets/js/slick.js"></script>
                <script src="assets/js/isotope.js"></script>
                <script src="assets/js/accordions.js"></script>


                <script>
                    cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
                    function clearField(t) {
                        //declaring the array outside of the
                        if (! cleared[t.id]) {
                            // function makes it static and global
                            cleared[t.id] = 1; // you could use true and false, but that's more typing
                            t.value = ''; // with more chance of typos
                            t.style.color = '#fff';
                        }
                    }


                    // function to retrieve separate categories
                    function changePage(page, tb) {
                        var xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                document.getElementsByTagName('footer')[0].style.display = "none";
                                document.getElementsByClassName("row grid")[0].innerHTML = "";
                                if (xhttp.responseText == "<div>Couldn't connect to Database </div>") {
                                    document.getElementsByClassName("row grid")[0].innerHTML = "<div>Could not establish a connection</div>";
                                } else {
                                    document.getElementsByClassName("row grid")[0].innerHTML = xhttp.responseText;

                                }
                            }
                        };
                        var searchlink = "fetchPage.php?".concat("page=", page, "&", "tb=", tb)
                        xhttp.open("GET", searchlink, true);
                        xhttp.send();

                    }

                    //function o retrieve searched item or populate product.php when its fist loaded.
                    //the function checks if its triggered by either a search or page loading.
                    function searchItem(page, item = "", marker = 0) {
                        var item = item;
                        var searchItem = document.getElementById("searchInput").value;
                        if (item != "all" && searchItem == "") {
                            alert("Please fill in search");
                        } else {
                            if (searchItem != "" && marker != 0) {
                                item = searchItem;
                            } else {
                                item = item;
                            }
                            var xhttp = new XMLHttpRequest();
                            xhttp.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {

                                    document.getElementsByTagName('footer')[0].style.display = "none";
                                    document.getElementsByClassName("row grid")[0].innerHTML = "";
                                    if (xhttp.responseText == "<div>Couldn't connect to Database </div>") {
                                        document.getElementsByClassName("row grid")[0].innerHTML = "<div>Could not establish a connection</div>";
                                    } else {
                                        //document.getElementsByClassName("footer")[0].innerHTML="";
                                        document.getElementsByClassName("row grid")[0].innerHTML = xhttp.responseText;

                                    }
                                }
                            };
                            var searchlink = "fetchPage.php?".concat("page=", page, "&", "item=", item);
                            xhttp.open("GET", searchlink, true);
                            xhttp.send();

                        }
                    }


                </script>

                <script>
                    //triggers the function that populates the
                    setTimeout(function() {
                        searchItem(1, "all")}, 500)

                </script>


                <?php echo $cartSymbol; ?>
            </body>

        </html>