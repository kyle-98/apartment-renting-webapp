<?php

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;  
}

require_once "config.php";
require "password.php";

	$session_user = $_SESSION["username"];
	$server = "*******";
  $user = "*******";
  $pass = "*******";
  $database = "*******";
  $connect = mysql_connect($server, $user, $pass);
  mysql_select_db($database);

    $results = mysql_query("SELECT APART_ID FROM owned WHERE USERNAME = '$session_user'");
    $information = mysql_fetch_row($results);
    $apart_id = $information[0];

  	$sql = "INSERT INTO cancellation (USERNAME, CANCEL_LEASE, APART_ID) VALUES ('$session_user', 'True', '$apart_id')";
    mysql_query($sql, $connect);

    $update = mysql_query("UPDATE apartments SET AVAILABILITY = 'Pending' WHERE id = '$apart_id'");

    mysql_close($connect);

header("location: index.php");
?>
