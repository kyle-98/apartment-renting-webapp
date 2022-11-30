<?php session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;  
}
	require_once "config.php";
	require "password.php";

	$session_user = $_SESSION["username"];
	$server = "******";
  	$user = "******";
  	$pass = "******";
  	$database = "******";
  	$connect = mysql_connect($server, $user, $pass);
  	mysql_select_db($database);

  	$apartID = $_POST['confirmApart'];
	$session_user = $_SESSION["username"];

	$results = mysql_query("SELECT APART_ID, BED_TYPE, BATH_TYPE, SQ_FT, PRICE FROM apartments WHERE APART_ID = '$apartID'");
	$information = mysql_fetch_row($results);
  	$bed_type = $information[1];
  	$bath_type = $information[2];
  	$sq_ft = $information[3];
  	$price = $information[4];

  	$sql = "INSERT INTO owned (USERNAME, APART_ID, BED_TYPE, BATH_TYPE, SQ_FT, PRICE_RANGE) values ('$session_user', '$apartID', '$bed_type', '$bath_type', '$sq_ft', '$price')";
  	mysql_query($sql, $connect);
  	$update = mysql_query("UPDATE apartments SET AVAILABILITY = 'Occupied' WHERE APART_ID = '$apartID'");

  	mysql_close($connect);

	header("location: index.php");
?>
