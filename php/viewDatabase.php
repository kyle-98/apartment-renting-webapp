<?php session_start(); ?>

<head>
    <link rel="stylesheet" href="../style.css">
    <style>
        .button-Return{
            text-decoration: none;
            background-color: var(--light-blue);
            border: none;
            color: var(--offwhite);
            text-align: center;
            margin: 4px 2px;
            padding: 10px 22px;
            display: inline-block;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
        }
    </style>
</head>

<body>
	<center>
		<h1>Viewing All Evaluations</h1>
		<hr>

	<?php

    $password = $_SESSION['pwsd'];

    if ($password != "project") {
        print ("<center><h2>Wrong Password.  Please try again and enter the correct password.</h2><br><br>");
        print ("<a type=submit class=button-Return href=evalLogin.php>Return to Login</a>");
    } 
    else {

	$server = "*******";
        $user = "*******";
        $pass = "*******";
        $database = "*******";

        $connect = mysql_connect($server, $user, $pass);
        $query = "select * from EVALUATION;";
        mysql_select_db($database);
        $result_id = mysql_query($query, $connect);
        
        if($result_id) {
                print("<table border=1>");
                print("<th> GENDER <th> GRADE <th> COURSE <th> LECT_QUAL <th> STUD_ENGAG <th> PROF_HELP");
                while($row = mysql_fetch_row($result_id)) {
                    print("<tr>");
                    foreach($row as $field) {
                        print("<td> $field </td>");
                    }
                    print("</tr>");
                }
                print("</table>");
            }
            else {
                print("Fail.<p>");
            }
                mysql_close($connect);
                print("<a type=submit class=button-Return href=evalLogin.php>Return to Login</a>");
                print("<a type=submit class=button-Return href=evalCourse.php>Return to Evaluation Page</a>");
    }       

        ?>
        <br><br>
	</center>
</body>
