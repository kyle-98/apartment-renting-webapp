<?php session_start(); 

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;  
}

?>
<!DOCTYPE html>
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
  input[id="searchSub" i] {
    color: white;
    background-color: var(--button-blue);
    text-decoration: none;
    border-radius: 5px;
    border-color: transparent;
    cursor: pointer;
    font-size: 17px;
    filter: drop-shadow(2px 2px 2px black);
    margin-bottom: 25px;
    margin-top: 0px;
    padding-right: 10px;
    padding-left: 10px;
    padding-top: 5px;
    padding-bottom: 5px;
  }
  input[id="selectSub" i] {
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
    padding-right: 10px;
    padding-left: 10px;
    padding-top: 5px;
    padding-bottom: 5px;
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
  top: 85px;
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

#cancelBtn{
  color: white;
  background-color: var(--button-blue);
  text-decoration: none;
  border-radius: 5px;
  border-color: transparent;
  cursor: pointer;
  font-size: 17px;
  filter: drop-shadow(2px 2px 2px black);
  margin-bottom: 25px;
  margin-top: 50px;
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
<h1>Apartment Application</h1>

<?php
  $server = "******";
  $user = "******";
  $pass = "******";
  $database = "******";

    $session_user = $_SESSION["username"];
    $connect = mysql_connect($server, $user, $pass);
    mysql_select_db($database);
    $result = mysql_query("SELECT * FROM owned WHERE USERNAME = '$session_user'");
    if(mysql_num_rows($result) == 0){
    $connect = mysql_connect($server, $user, $pass);
  	$query = "SELECT APART_ID, BED_TYPE, BATH_TYPE, SQ_FT, PRICE, AVAILABILITY FROM apartments"; 
  	mysql_select_db($database);
  	$result_id = mysql_query($query, $connect);
    
    ?>
        <div id="searchMenu" class="search_menu">
        <form action="searchApart.php" method="post">
          <center>
          <label for="bedtype">Number of Beds</label>
          <select name="bed_type" id="bedtype">
              <option value="0">Don't Search</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
          </select>
          <br><br>
          <label for="bedtype">Number of Bathrooms</label>
          <select name="bath_type" id="bathtype">
              <option value="0">Don't Search</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
          </select>
          <br><br>
          <label for="sq_ft">Square Footage</label>
          <select name="sq_ft" id="squarefeet">
              <option value="0">Don't Search</option>
              <option value="1">Less than 1,000 sqft</option>
              <option value="2">More than 1,000 sqft</option>
          </select>
          <br><br>
        </center>
          <input id="searchSub" type="submit" value="Search">
          <br><br>
        </form>
    </div>

    <?php
    $j = 1;
        
  		if($result_id) {
        print("<form action='lease_confirm.php' method='post'>");
    		print("<table id='apart_table' border='1'>");
        print("<thead>");
    		print("<th> Apartment ID <th> Beds <th> Baths <th> Sqare Feet <th> Price <th> Status <th> Register<br>");	
        print("</thead>");
    		while($row = mysql_fetch_row($result_id)) {
    	  	print("<tr>");
      		foreach($row as $field) {
        		print("<td class='testing'> $field </td>");
      		}
      		print("<td><center><input type='radio' name='selectedApart' value='$j'></center></td>");		
      		print("</tr>");
      		$j++;
      	}
      	print("</table>");
        print("<input id='selectSub' type='submit' name='submit' value='Select Apartment'>");
        print("</form>");
  		}	
  		else {
    		print("Fail.<p>");
  		}
    	mysql_close($connect);

    }
    else {
    	print("<h4 class='invalid-feedback'>The below apartment is already tied to this account! Please cancel your lease if you would like to drop/change/upgrade apartments!</h4>");
    	$query = "SELECT * FROM owned WHERE USERNAME = '$session_user'";
    	mysql_select_db($database);
    	$result_id = mysql_query($query, $connect);
    	if($result_id) {
    		print("<table border=1>");
    		print("<th> Username <th> Apartment ID <th> Beds <th> Baths <th> Sqare Feet <th> Price Range");
    		while($row = mysql_fetch_row($result_id)) {
    	  		print("<tr>");
      			foreach($row as $field) {
        			print("<td> $field </td>");
      			}	
      			print("</tr>");
      		}
      		print("</table>");
          
          $connect = mysql_connect($server, $user, $pass);
          mysql_select_db($database);
          $checking = mysql_query("SELECT * FROM cancellation WHERE USERNAME = '$session_user'");
          $info = mysql_fetch_row($checking);
          if($info[0]) {
            print("<br>");
            print("Your lease cancellation is pending! Come back later to check to see if it was approved.");
          }
          else {
            print("<br>");
            print("<a href=lease_cancel.php id=cancelBtn class=btn btn-warning>Cancel Lease</a>");
          }
          mysql_close($connect);
  		}
  		else {
    		print("Fail.<p>");
  		}
    		mysql_close($connect);
    	}
    mysql_close($connect);

?>
<br><br>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script>
  $(document).ready(function(){
    $('td:contains("Occupied")').parent().toggle();
  });

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
</html>
