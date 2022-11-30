<?php session_start();
?>

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
    position: fixed;
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

.back-btn {
	color: white;
	background-color: var(--button-blue);
	text-decoration: none;
	border-radius: 5px;
	border-color: transparent;
	cursor: pointer;
	font-size: 17px;
	filter: drop-shadow(2px 2px 2px black);
	margin-bottom: 25px;
	margin-top: 30px;
	top: 50px;
	padding-right: 10px;
	padding-left: 10px;
	padding-top: 5px;
	padding-bottom: 5px;
}
input[type="submit" i] {
	color: white;
	background-color: var(--button-blue);
	text-decoration: none;
	border-radius: 5px;
	border-color: transparent;
	cursor: pointer;
	font-size: 17px;
	filter: drop-shadow(2px 2px 2px black);
	margin-bottom: 25px;
	margin-top: 17px;
	top: 50px;
	padding-right: 10px;
	padding-left: 10px;
	padding-top: 5px;
	padding-bottom: 5px;
}
.invalid-feedback {
	color: var(--invalid-red);
}



  </style>

</head>
<body>
	<div class="account">
      <button onclick="dropDown()" class="dropbtn">Account</button>
        <div id="myDropdown" class="dropdown-content">
          <a href="reset_password.php" class="btn btn-warning">Reset Your Password</a>  
          <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        </div>
      </div>
<center>
      <h1>Search Results</h1>

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
<?php
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;  
}
require_once "config.php";
require "password.php";

	$server = "********";
  	$user = "********";
  	$pass = "********";
  	$database = "********";
  	$connect = mysql_connect($server, $user, $pass);
  	mysql_select_db($database);

  	$bedNum = $_POST['bed_type'];
  	$bathNum = $_POST['bath_type'];
  	$sqft = $_POST['sq_ft'];

  	if($bedNum == 0 && $bathNum == 0 && $sqft == 0){
  		print("<p class='invalid-feedback'>Please select options to search for!</p>");
  		print("<a href='index.php' class='back-btn'>Go Back</a>");
  	}
  	else {
  		//check for only bed search
          if($bedNum > 0 && $bathNum == 0 && $sqft == 0) {
              $bedQuery = "SELECT APART_ID, BED_TYPE, BATH_TYPE, SQ_FT, PRICE, AVAILABILITY FROM apartments WHERE BED_TYPE = '$bedNum' AND NOT AVAILABILITY = 'Occupied'";
              $result_id = mysql_query($bedQuery, $connect);
              $apartQuery = mysql_query("SELECT APART_ID FROM apartments WHERE BED_TYPE = '$bedNum' AND NOT AVAILABILITY = 'Occupied'");
              $column = array();
              while($row1 = mysql_fetch_assoc($apartQuery)){
              	$column[] = $row1['APART_ID'];
              }
              $j = 0;
              $apartid = $column[$j];

              if($result_id){
                  	print("<form action='lease_confirm_search.php' method='post'>");
                  	print("<table id='searched_apart_table' border='1'>");
	                print("<thead>");
	                print("<th> Apartment ID <th> Beds <th> Baths <th> Sqare Feet <th> Price <th> Status <th> Register");    
	                print("</thead>");
	                while($row = mysql_fetch_row($result_id)) {
                      print("<tr>");
                      foreach($row as $field) {
                        print("<td class='testing'> $field </td>");
                      }        
                  }
              }
              else {
                  print("Fail.<p>");
              }
              mysql_close($connect);
          }
        //check for only bath search
          if($bathNum > 0 && $bedNum == 0 && $sqft == 0){
          	$bathQuery = "SELECT APART_ID, BED_TYPE, BATH_TYPE, SQ_FT, PRICE, AVAILABILITY FROM apartments WHERE BATH_TYPE = '$bathNum' AND NOT AVAILABILITY = 'Occupied'";
              $result_id = mysql_query($bathQuery, $connect);
              if($result_id){
                  	print("<form action='lease_confirm_search.php' method='post'>");
                  	print("<table id='searched_apart_table' border='1'>");
	                print("<thead>");
	                print("<th> Apartment ID <th> Beds <th> Baths <th> Sqare Feet <th> Price <th> Status <th> Register");    
	                print("</thead>");
	                while($row = mysql_fetch_row($result_id)) {
                      print("<tr>");
                      foreach($row as $field) {
                        print("<td class='testing'> $field </td>");
                      }
                      print("<td><center><input type='radio' name='confirmApart' value='$user_id'></center></td>");   
                      print("</tr>");
                      $j++;
                      $user_id = $column[$j]; 
                  }
                  print("</table>");
				  print("<input type='submit' value='Accept'>");
				  print("</form>");
              }
              else {
                  print("Fail.<p>");
              }
              mysql_close($connect);
          }
        //check for only sqft search
	        if($sqft > 0 && $bedNum == 0 && $bathNum == 0){
	          	if($sqft == 2){
	          		$sqftQuery = "SELECT APART_ID, BED_TYPE, BATH_TYPE, SQ_FT, PRICE, AVAILABILITY FROM apartments WHERE SQ_FT LIKE '1%' AND NOT AVAILABILITY = 'Occupied'";
	          		$result_id = mysql_query($sqftQuery, $connect);
	          		$apartQuery = ("SELECT APART_ID FROM apartments WHERE SQ_FT LIKE '1%' AND NOT AVAILABILITY = 'Occupied'");
	          		$column = array();
		              while($row1 = mysql_fetch_assoc($apartQuery)){
		              	$column[] = $row1['APART_ID'];
		              }
		              $j = 0;
		              $apartid = $column[$j];
		              if($result_id){
		              		print("<form action='lease_confirm_search.php' method='post'>");
		                  	print("<table id='searched_apart_table' border='1'>");
			                print("<thead>");
			                print("<th> Apartment ID <th> Beds <th> Baths <th> Sqare Feet <th> Price <th> Status <th> Register");    
			                print("</thead>");
			                while($row = mysql_fetch_row($result_id)) {
		                      print("<tr>");
		                      foreach($row as $field) {
		                        print("<td class='testing'> $field </td>");
		                      }
		                      print("<td><center><input type='radio' name='confirmApart' value='$apartid'></center></td>");  
		                      print("</tr>");
		                      $j++;
		                      $apartid = $column[$j];      
		                  }
		                  print("</table>");
						  print("<input type='submit' value='Accept'>");
						  print("</form>");
		              }
		              else {
		                  print("Fail.<p>");
		              }
		              mysql_close($connect);
	          	}
	          	else {
	          		$sqftQuery = "SELECT APART_ID, BED_TYPE, BATH_TYPE, SQ_FT, PRICE, AVAILABILITY FROM apartments WHERE SQ_FT LIKE '___' AND NOT AVAILABILITY = 'Occupied'";
	          		$result_id = mysql_query($sqftQuery, $connect);
	          		$apartQuery = ("SELECT APART_ID FROM apartments WHERE SQ_FT LIKE '___' AND NOT AVAILABILITY = 'Occupied'");
	          		$column = array();
		              while($row1 = mysql_fetch_assoc($apartQuery)){
		              	$column[] = $row1['APART_ID'];
		              }
		              $j = 0;
		              $apartid = $column[$j];
		              if($result_id){
		              		print("<form action='lease_confirm_search.php' method='post'>");
		                  	print("<table id='searched_apart_table' border='1'>");
			                print("<thead>");
			                print("<th> Apartment ID <th> Beds <th> Baths <th> Sqare Feet <th> Price <th> Status <th> Register");    
			                print("</thead>");
			                while($row = mysql_fetch_row($result_id)) {
		                      print("<tr>");
		                      foreach($row as $field) {
		                        print("<td class='testing'> $field </td>");
		                      }   
		                      print("<td><center><input type='radio' name='confirmApart' value='$apartid'></center></td>");  
		                      print("</tr>");
		                      $j++;
		                      $apartid = $column[$j];      
		                  }
		                  print("</table>");
						  print("<input type='submit' value='Accept'>");
						  print("</form>");
		              }
		              else {
		                  print("Fail.<p>");
		              }
		              mysql_close($connect);
	          	}
	         }
	        if($bedNum > 0 && $bathNum > 0 && $sqft == 0) {
	        	$bed_bath = "SELECT APART_ID, BED_TYPE, BATH_TYPE, SQ_FT, PRICE, AVAILABILITY FROM apartments WHERE BED_TYPE = '$bedNum' AND BATH_TYPE = '$bathNum' AND NOT AVAILABILITY = 'Occupied'";
	          		$result_id = mysql_query($bed_bath, $connect);
	          		$apartQuery = mysql_query("SELECT APART_ID FROM apartments WHERE BED_TYPE = '$bedNum' AND BATH_TYPE = '$bathNum' AND NOT AVAILABILITY = 'Occupied'");
	          		$column = array();
		              while($row1 = mysql_fetch_assoc($apartQuery)){
		              	$column[] = $row1['APART_ID'];
		              }
		              $j = 0;
		              $apartid = $column[$j];
		              if($result_id){
		                  	print("<form action='lease_confirm_search.php' method='post'>");
		                  	print("<table id='searched_apart_table' border='1'>");
			                print("<thead>");
			                print("<th> Apartment ID <th> Beds <th> Baths <th> Sqare Feet <th> Price <th> Status <th> Register");    
			                print("</thead>");
			                while($row = mysql_fetch_row($result_id)) {
		                      print("<tr>");
		                      foreach($row as $field) {
		                        print("<td class='testing'> $field </td>");
		                      }
		                      print("<td><center><input type='radio' name='confirmApart' value='$apartid'></center></td>");  
		                      print("</tr>");
		                      $j++;
		                      $apartid = $column[$j];         
		                  }
		                  print("</table>");
						  print("<input type='submit' value='Accept'>");
						  print("</form>");
		              }
		              else {
		                  print("Fail.<p>");
		              }
		              mysql_close($connect);
	        }

	        if($bedNum > 0 && $bathNum > 0 && $sqft > 0){
	        	if($sqft == 1) {
	        		$allQuery = "SELECT APART_ID, BED_TYPE, BATH_TYPE, SQ_FT, PRICE, AVAILABILITY FROM apartments WHERE BED_TYPE = '$bedNum' AND BATH_TYPE = '$bathNum' AND SQ_FT LIKE '___' AND NOT AVAILABILITY = 'Occupied'";
	          		$result_id = mysql_query($allQuery, $connect);
	          		$apartQuery = mysql_query("SELECT APART_ID FROM apartments WHERE BED_TYPE = '$bedNum' AND BATH_TYPE = '$bathNum' AND SQ_FT LIKE '___' AND NOT AVAILABILITY = 'Occupied'");
		              $column = array();
		              while($row1 = mysql_fetch_assoc($apartQuery)){
		              	$column[] = $row1['APART_ID'];
		              }
		              $j = 0;
		              $apartid = $column[$j];
		              if($result_id){
		                 	print("<form action='lease_confirm_search.php' method='post'>");
		                 	print("<table id='searched_apart_table' border='1'>");
			                print("<thead>");
			                print("<th> Apartment ID <th> Beds <th> Baths <th> Sqare Feet <th> Price <th> Status <th> Register");    
			                print("</thead>");
			                while($row = mysql_fetch_row($result_id)) {
		                      print("<tr>");
		                      foreach($row as $field) {
		                        print("<td class='testing'> $field </td>");
		                      }
		                      print("<td><center><input type='radio' name='confirmApart' value='$apartid'></center></td>");  
		                      print("</tr>");
		                      $j++;
		                      $apartid = $column[$j];       
		                  }
		                  print("</table>");
						  print("<input type='submit' value='Accept'>");
						  print("</form>");
		              }
		              else {
		                  print("Fail.<p>");
		              }
		              mysql_close($connect);
	        	}
	        	else {
	        		$allQuery = "SELECT APART_ID, BED_TYPE, BATH_TYPE, SQ_FT, PRICE, AVAILABILITY FROM apartments WHERE BED_TYPE = '$bedNum' AND BATH_TYPE = '$bathNum' AND SQ_FT LIKE '1%' AND NOT AVAILABILITY = 'Occupied'";
	          		$result_id = mysql_query($allQuery, $connect);
	          		$apartQuery = mysql_query("SELECT APART_ID FROM apartments WHERE BED_TYPE = '$bedNum' AND BATH_TYPE = '$bathNum' AND SQ_FT LIKE '1%' AND NOT AVAILABILITY = 'Occupied'");
	          		$column = array();
		              while($row1 = mysql_fetch_assoc($apartQuery)){
		              	$column[] = $row1['APART_ID'];
		              }
		              $j = 0;
		              $apartid = $column[$j];

		              if($result_id){
		                  	print("<form action='lease_confirm_search.php' method='post'>");
		                  	print("<table id='searched_apart_table' border='1'>");
			                print("<thead>");
			                print("<th> Apartment ID <th> Beds <th> Baths <th> Sqare Feet <th> Price <th> Status <th> Register");    
			                print("</thead>");
			                while($row = mysql_fetch_row($result_id)) {
		                      print("<tr>");
		                      foreach($row as $field) {
		                        print("<td class='testing'> $field </td>");  
		                      }
		                      print("<td><center><input type='radio' name='confirmApart' value='$apartid'></center></td>");  
		                      print("</tr>");
		                      $j++;
		                      $apartid = $column[$j];  
		                  }
		                  print("</table>");
						  print("<input type='submit' value='Accept'>");
						  print("</form>");
		              }
		              else {
		                  print("Fail.<p>");
		              }
		              mysql_close($connect);
	        	}
	        }
  	//end of main else statement
	    print("<a href='index.php' class='back-btn'>Go Back</a>");
	}
?>
</center>
