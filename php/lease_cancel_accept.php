<?php session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;  
}

require_once "config.php";
require "password.php";

	$server = "*******";
  	$user = "*******";
  	$pass = "*******";
  	$database = "*******";
  	$connect = mysql_connect($server, $user, $pass);
  	mysql_select_db($database);

  	$user_id = $_POST['cancelConfirm'];

  	$deleteQuery = mysql_query("DELETE FROM cancellation WHERE USERNAME = '$user_id'");
  	$apartIDQuery = mysql_query("SELECT APART_ID FROM owned WHERE USERNAME = '$user_id'");
    $storedID = mysql_fetch_row($apartIDQuery);
    $apart_id = $storedID[0];
	$unOccupy = mysql_query("UPDATE apartments SET AVAILABILITY = 'Available' WHERE APART_ID = '$apart_id'");	
  	$deleteOwned = mysql_query("DELETE FROM owned WHERE USERNAME = '$user_id'");
  	mysql_close($connect);

  	header("location: adminpage.php");
?>

