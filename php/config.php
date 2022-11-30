<?php 

define('DB_SERVER', '******');
define('DB_USERNAME', '******');
define('DB_PASSWORD', '******');
define('DB_NAME', '******');

$connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($connect == false) {
    die("Error! Could not connect to the database" . mysqli_connect_error());
}

?>
