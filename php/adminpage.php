<?php 

session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;  
  }
?>
<center>
<?php
require_once "config.php";
require "password.php";

$server = "********";
$user = "********";
$pass = "********";
$database = "********";
$connect = mysql_connect($server, $user, $pass);
$query = "SELECT USERNAME, CREATED FROM users";
mysql_select_db($database);
$result_id = mysql_query($query, $connect);

//show users accounts
print("<h4>Registered User Accounts</h4>");
if($result_id) {
    print("<table border=1>");
    print("<th> Username <th> Date Created");
    while($row = mysql_fetch_row($result_id)) {
        print("<tr>");
        foreach($row as $field){
            print("<td> $field </td>");
        }
        print("</tr>");
    }
    print("</table>");
}
else {
    print("Something went wrong! Try to refresh the page.");
}
mysql_close($connect);

print("<br><br>");
print("<h4>Registered Users Apartments</h4>");
//show users' apartments
$connect = mysql_connect($server, $user, $pass);
$query = "SELECT * FROM owned";
mysql_select_db($database);
$result_id = mysql_query($query, $connect);

if($result_id) {
    print("<table border=1>");
    print("<th>Username <th> Apartment ID <th> Beds <th> Baths <th> Sqare Feet <th> Price");
    while($row = mysql_fetch_row($result_id)) {
        print("<tr>");
        foreach($row as $field){
            print("<td> $field </td>");
        }
        print("</tr>");
    }
    print("</table>");
}
else {
    print("Something went wrong! Try to refresh the page.");
}
mysql_close($connect);

print("<br><br>");
//show apartments
print("<h4>All Apartments</h4>");
$connect = mysql_connect($server, $user, $pass);
$query = ("SELECT APART_ID, BED_TYPE, BATH_TYPE, SQ_FT, PRICE, AVAILABILITY FROM apartments");
mysql_select_db($database);
$result_id = mysql_query($query, $connect);

if($result_id) {
    print("<table border=1>");
    print("<th> Apartment ID <th> Beds <th> Baths <th> Sqare Feet <th> Price Range <th> Availability");
    while($row = mysql_fetch_row($result_id)) {
        print("<tr>");
        foreach($row as $field){
            print("<td> $field </td>");
        }
        print("</tr>");
    }
    print("</table>");
}
else {
    print("Something went wrong! Try to refresh the page.");
}
mysql_close($connect);

print("<br><br>");
//show cancellations
print("<h4>User Lease Cancellations</h4>");
$connect = mysql_connect($server, $user, $pass);
$query = "SELECT * FROM cancellation";
mysql_select_db($database);
$result_id = mysql_query($query, $connect);

    $userIDQuery = mysql_query("SELECT USERNAME FROM cancellation");
    $column = array();
    while($row1 = mysql_fetch_assoc($userIDQuery)){
        $column[] = $row1['USERNAME'];
    }
    //echo($column[0]);
    $j = 0;
    $user_id = $column[$j];

if($result_id) {
    print("<form action='lease_cancel_accept.php' method='post'>");
    print("<table border=1>");
    print("<th> Username <th> Cancellation <th> Apartment ID <th> Accept");
    while($row = mysql_fetch_row($result_id)) {
        print("<tr>");
        foreach($row as $field){
            print("<td> $field </td>");
        }
        print("<td><center><input type='radio' name='cancelConfirm' value='$user_id'></center></td>");
        print("</tr>");
        $j++;
        $user_id = $column[$j];
    }
    print("</table>");
    print("<input type='submit' value='Accept'>");
    print("</form>");
}
else {
    print("Something went wrong! Try to refresh the page.");
}
mysql_close($connect);

    if(isset($_POST['submit'])){
            if(!empty($_POST['cancelConfirm'])){
                foreach($_POST['cancelConfirm'] as $selected){
                    echo($selected);
                }
            }
        }
?>
<center>
<head>
    <link rel="stylesheet" href="finalstyle.css">
    <style>
        h1 {
      font-size: 45px;
    }
    th {
      background-color: #2B2B4F;
      padding-top: .5em;
      padding-bottom: .5em;
    }
    table {
      border-collapse: collapse;
      width: 60%;
      text-align: center;
    }
    tr:nth-child(even){
      background-color: #28282D;
    }
    table, th, td {
    border-left: none;
    border-right: none;
  }
  tr>td {
    padding-top: .5em;
    padding-bottom: .5em;
  }
  .dropbtn {
    background-color: var(--button-blue);
    color: white;
    border-radius: 5px;
    padding: 16px;
    font-size: 16px;
    right: 25px;
    top:10px;
    position: absolute;
    border: none;
    cursor: pointer;
  }

.dropbtn:hover, .dropbtn:focus {
  background-color: #2980B9;
}

.dropdown {
  position: relative;
  display: inline-block;
  border-radius: 5px;
}

.dropdown-content {
  display: none;
  position: fixed;
  right: 25px;
  top: 65px;
  background-color: #f1f1f1;
  min-width: 160px;
  overflow: auto;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  border-radius: 5px;
  background-color: #464648;
  text-decoration: none;
  color: white;
}

.dropdown-content a {
  color: white;
  background-color: #464648;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown a:hover {background-color: #464648;}

.show {display: block;}

input[type="submit" i] {
    color: white;
    background-color: var(--button-blue);
    text-decoration: none;
    border-radius: 5px;
    border-color: transparent;
    cursor: pointer;
    font-size: 17px;
    filter: drop-shadow(2px 2px 2px black);
    margin-top: 15px;
    padding-right: 10px;
    padding-left: 10px;
    padding-top: 5px;
    padding-bottom: 5px;
}


</style>
</head>
<body>
    <div class="account">
      <button onclick="dropDown()" class="dropbtn">Account</button>
        <div id="myDropdown" class="dropdown-content">
          <a href="logout.php" class="btn-logout">Sign Out of Your Account</a>
        </div>
      </div>

<script type="text/javascript">
    function dropDown() {
          document.getElementById("myDropdown").classList.toggle("show");
          }
          window.onclick = function(event) {
          if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
              var openDropdown = dropdowns[i];
              if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
              }
            }
          }
        }
</script>
</body>
