<?php
	require "sqlconfig.php";
	session_start();
	// Define $myrollno and $mypassword 
	$myrollno=$_POST['rno']; 
	$mypassword=$_POST['pwd']; 
	

	// To protect MySQL injection
	$myrollno = stripslashes($myrollno);
	$mypassword = stripslashes($mypassword);
	$myrollno = mysql_real_escape_string($myrollno);
	$mypassword = mysql_real_escape_string($mypassword);

	$dbc = mysqli_connect($db_host, $db_user, $db_pw, 'delta')
			or die ('Error connecting to the database server');		
	
	$query="SELECT rollno,passwd FROM register;"
		or die('Error querying');
	$result=mysqli_query($dbc,$query);
	$check=false;
	while($row=mysqli_fetch_array($result))
	{
	
		if($row['passwd']==$mypassword&&$row['rollno']==$myrollno)
		{
			$check=true;
			break;
		}
		
	}   
	if($check)
	{
		$_SESSION['deltarollno']=$myrollno;
		
		header("location:loggedin.php");
	}
	else
	{
		header("location:index.php?err=true");
	}

	mysqli_close($dbc);
	
?>
	


