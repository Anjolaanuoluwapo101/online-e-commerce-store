<?php
//error_reporting(0);
if (isset($_POST['id'], $_POST['productname'])) {
    @$values = array($_POST['id'],urldecode($_POST['productname']),$_POST['price'],$_POST['productname'].$_POST['id'],round($_POST['quantity']),$_POST['origin']);
    list($id,$productname,$price,$refId,$quantity,$Origin) = $values;
} else {
  
    $values = array($_GET['id'],urldecode($_GET['productname']),$_GET['id'].$_GET['productname'],$_GET['origin']);
    list($id,$productname,$refId,$origin) = $values;
    ini_set("session.gc_maxlifetime", 60*60*24*7);
    ini_set("session.cookie_lifetime", 60*60*24*7);
    session_name("upvoteCookie");
    session_start();
    if (!(isset($_SESSION['upvoteCookie']))) {
        $_SESSION['upvoteCookie'] = array();
    };
}

if (isset($price, $quantity, $id, $productname, $refId)) {
    session_name("XCart");
    session_start(["gc_maxlifetime"=>10000,
    "cookie_lifetime"=>10000
    
    ]);

    if (!(isset($_SESSION['XCart']))) {
        $_SESSION['XCart'] = array();
        $_SESSION['XCart'][$refId] = array('id' => $id, 'productname' => $productname, 'price' => $price, 'quantity' => $quantity, 'origin' => $Origin);
    } elseif (isset($_SESSION['XCart']) && empty($_SESSION['XCart'])) {
        $_SESSION['XCart'][$refId] = array('id' => $id, 'productname' => $productname, 'price' => $price, 'quantity' => $quantity, 'origin' => $Origin);
    } elseif (!(empty($_SESSION['XCart'])) && !(array_key_exists($refId, $_SESSION['XCart']))) {
        $_SESSION['XCart'][$refId] = array('id' => $id, 'productname' => $productname, 'price' => $price, 'quantity' => $quantity, 'origin' => $Origin);
    } elseif (isset($_SESSION['XCart'][$refId])) {
        $_SESSION['XCart'][$refId]['quantity'] = $quantity;
    }
    @session_write_close();
    echo "<script> history.back()</script>";
}

if (isset($productname, $origin, $id)) {
    if (!(in_array($refId, $_SESSION['upvoteCookie']))) {

$servername = "localhost";
$username = "id18837981_anjolaakinsoyinu";
$password = "Naingolan-101";

        $sql = "UPDATE $origin SET upvotes=upvotes+1 WHERE productname=? AND id=? ";
        try {
            //$conn = new PDO("mysql:host=$servername;dbname=id18837981_products", $username, $password);
            $conn = new PDO("mysql:host=$servername;dbname=Products", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL);
            $results = $conn->prepare($sql);
            $results->execute(array($productname, $id));
            echo "Please refresh page";
            array_push($_SESSION['upvoteCookie'], $refId);
            session_write_close();
            $conn = null;

        }catch(PDOException $e) {
            echo "Connection failed: ".$e->getMessage();
            session_write_close();
        }
    } else {
        echo 'Already Upvoted';
        session_write_close();
    }
}

?>