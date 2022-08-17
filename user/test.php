<?php

session_name("XCart");
session_start();
print_r(count($_SESSION['XCart']));

?>