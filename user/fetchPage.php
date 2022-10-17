<?php


$number_of_result_per_page = 3;
if (isset($_GET['page'])) {
  $page = $_GET['page'];
} else {
  $page = 1;
}
$start_from = ($page-1) * $number_of_result_per_page;


if (isset($_GET['tb'])) {
  $tb = $_GET['tb'];
  $query = "SELECT * FROM $tb LIMIT $number_of_result_per_page OFFSET $start_from ";
} else {
  $item = $_GET['item'];
  $search = array("\"", "'", ":", "\\", "/", " ", "&", "#", " @", "*", ";", ">", "<", ",", ".", "+", "%", "(", ")", "-");
  $replace = "";
  $item = str_ireplace($search, $replace, $item);

  if ($item != "all") {
    $query = "SELECT * FROM (SELECT * FROM wristwatches UNION ALL SELECT * FROM bags) AS db WHERE `productname` LIKE ? LIMIT $number_of_result_per_page OFFSET $start_from ";
  } else {
    $query = "SELECT * FROM (SELECT * FROM wristwatches UNION ALL SELECT * FROM bags ) AS db LIMIT $number_of_result_per_page OFFSET $start_from";
  }
}
//$tb="wristwatches";
try {


  $servername = "localhost";
  $username = "root";
  $password = "";
  $conn = new PDO("mysql:host=$servername;dbname=Products", $username, $password, array(PDO::ATTR_PERSISTENT => true));
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn->setAttribute(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL);



  //for the products per page
  if (!(isset($_GET['item']))) {
    //this query is meant for fetching all data a category
    $results = $conn->prepare($query);
    $results->execute();
  } else {
    if ($_GET['item'] == "all") {
      //this query fetches all data in all category
      $results = $conn->prepare($query);
      $results->execute();
    } else {
      $item = "%".$item."%";
      //this query fetches all data in all categories similar to the search
      $results = $conn->prepare($query);
      $results->bindParam(1, $item);
      $results->execute();
    }
  }


  while ($result = $results->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT)) {
    $data = <<<HTML
	 <div class="col-lg-4 col-md-4 all des">
                      <div class="product-item">
                        <a href="viewproduct.php?t=$result[3]&p=$result[1]&i=$result[0]" target="_blank" ><img src=$result[2] alt=""></a>
                        <div class="down-content">
                          <a href="viewproduct.php?t=$result[3]&p=$result[1]&i=$result[0]" target="_blank"><h4>$result[1]</h4></a>
                          <h6> ₦$result[5]</h6>
                        <!--  <p>Lorem ipsume dolor sit amet, adipisicing elite. Itaque, corporis nulla aspernatur.</p>-->
                        <p>$result[8] </p>
                          <ul class="stars">
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                          </ul>
                          <span>No Reviews</span>
                        </div>
                      </div>
                    </div>
HTML;
    echo $data;

  }

  if ($results->fetchColumn()) {
    echo "heyy";
  }

  //for pagnation....
  if (isset($_GET['tb'])) {
    $query = "SELECT COUNT(*) FROM $tb ";
  } else {
    if ($query == "SELECT * FROM (SELECT * FROM wristwatches UNION ALL SELECT * FROM bags ) AS db LIMIT $number_of_result_per_page OFFSET $start_from") {
      $query = "SELECT COUNT(*) FROM (SELECT * FROM wristwatches UNION ALL SELECT * FROM bags) AS db";
    } else {
      $query = "SELECT COUNT(*) FROM (SELECT * FROM wristwatches UNION ALL SELECT * FROM bags) AS db WHERE `productname` LIKE '%$item%' ";
    }
  };

  $result = $conn->prepare($query);
  $result->execute();
  $total_records = $result->fetchColumn();
  $total_number_of_pages = ceil($total_records/$number_of_result_per_page);
  $pagLink = "";
  if (isset($_GET['tb'])) {
    $TB = '"'. $tb.'"';
    $function = "changePage";
  } else {
    $TB = '"'.$item.'"';
    $function = "searchItem";
  }
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "<div class='col-md-12' >";
  echo "<ul class='pages'>";

  //for the prev button....
  if ($page >= 2) {
    $previous_page = $page-1;
    echo "<li><a onclick='$function($previous_page,$TB)' >Prev</a></li>";
  };


  //for the 1,2,3,4_,5..etc buttons
  for ($i = 1; $i <= $total_number_of_pages; $i++) {
    if ($i == $page) {
      $pagLink .= "<li class='active'><a onclick='$function($i,$TB)'>".$i."</a></li>";
    } else {
      $pagLink .= "<li><a onclick='$function($i,$TB)'>".$i." </a></li>";
    }
  }

  echo $pagLink;

  //for the next button
  if ($page < $total_number_of_pages) {
    $page = $page+1;
    echo "<li><a onclick='$function($page,$TB) '>  Next </a></li>";
  }


  echo "</ul>";
  echo "</div>";
  echo "&nbsp";
  echo "<br>";
  echo "<br>";
  echo "<br>";
  echo "<br>";
 
  $footer = <<<FOOTER
     <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="inner-content">
              <p>Copyright &copy; 2022 SHOP CONVENIENT
            - Design: <a rel="nofollow noopener" href="" target="_blank">TemplateMo</a></p>
            </div>
          </div>
        </div>
      </div>
    </footer>

FOOTER;

  echo $footer;



}catch(PDOException $e) {
  echo "<div>Couldn't connect to Database </div>";
  echo $e->getMessage();
}


?>