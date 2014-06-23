<?php
	require "sqlconfig.php";
	session_start();
	if(isset($_SESSION['deltarollno']))
		header("location:loggedin.php");
?>
<html>
<head>
<title>Welcome</title>

<style>
	


</style>
<link rel="stylesheet" href="upload.css">



</head>

<body>
	<div id="head">
		<center><h1><marquee behavior="alternate">Welcome</marquee></h1></center>
	</div>
	<div id="half1">
		<center><h1><u>Login</u></h1>
		<form action="checklogin.php" method="post">
			<label></label>
			<?php
				if($_GET['err'])
					echo '<span class="g">Authentication failed! Try again...</span>';
			?>
			<LABEL></LABEL>
			<input type = "text" name = "rno" placeholder = "Roll number">
			<br>
			<LABEL></LABEL>
			<input type = "password" name = "pwd" placeholder = "Password">
			<br><br>
			
			<LABEL></LABEL>
			<LABEL></LABEL>
			<input type = "submit" value = "Login">
		</form>
		</center>
	</div>
	<div id="half2">
		<center><h1><u>Register</u></h1></center>
	<?php
		
		$outputform = true;
		if(isset($_POST['regsubmit']))
		{
			$name = $_POST['name'];
			$rollno = $_POST['rollno'];
			$dept = $_POST['dept'];
			$sex = $_POST['sex'];
			$pass = $_POST['pass'];
			$repass = $_POST['repass'];
			$flag = true;
			
			if($name=="" || $rollno=="" ||$dept == "select" || $sex == "" || $pass == "" || $repass == "")
			{
				echo '<br>All fields are required to be filled';
				$flag = false;
			}
			
			if($rollno<100000000 || $rollno>999999999 && $flag)
			{
				echo '<br>Invalid roll number.';
				$flag = false;
			}
			
			if($flag)
			{
				$dbc = mysqli_connect($db_host, $db_user, $db_pw, 'delta')
						or die ('Error connecting to the database server');
				$query="SELECT rollno FROM register;";
				$result=mysqli_query($dbc,$query);
				$flag=true;
				while($row=mysqli_fetch_array($result))
				{
					
					 if($row['rollno']==$rollno)
					 {
						echo "</br>".'Rollno already registered!!!';
						$flag=false;
						break;
					 }
				}
			}
			if($pass != $repass&&$flag)
			{
				echo '<br>Passwords do not match.';
				$flag = false;
			}
			
			if($flag)
			{
			      $query = "INSERT INTO register (name, rollno, passwd, dept, sex) 
					VALUES ('$name', '$rollno', '$pass', '$dept', '$sex')";
				
				  $result = mysqli_query($dbc, $query)
					or die ('Error querying database');
				  echo 'Successfully registered!!';
				  echo ' <br><a href="home.php">Click here</a> to register once more!';
				  mysqli_close($dbc);
				  $outputform = false;
			}
			
					
		}
		
		
		
		if($outputform)
		{
	?>
		<form method="post" action="<?php echo $_SERVER['PHP SELF'];?>">
			<label>Name : </label><input type = "text" name = "name" placeholder = "Name">
			<br>
			<label>Roll no. : </label><input type = "text" name="rollno" placeholder = "9 digit roll no.">
			<br>
			<label>Department : </label>
			<select name="dept" value="chem">
			  <option value="select">--DEPT--</option>
			  <option value="chem">CHEM</option>
			  <option value="civ">CIV</option>
			  <option value="cse">CSE</option>
			  <option value="ece">ECE</option>
			  <option value="eee">EEE</option>
			  <option value="ice">ICE</option>
			  <option value="mech">MECH</option>
			  <option value="meta">META</option>
			  <option value="prod">PROD</option>
			</select>
			<label>Sex : </label><span class="g"><input type="radio" name="sex" value="M">Male</span>
								<span class="g"><input type="radio" name="sex" value="F">Female</span>
			<label>Password : </label><input type = "password" name = "pass" placeholder = "Password">
			<br>
			<label>Confirm Password : </label><input type = "password" name = "repass" placeholder = "Retype Password">
			<br><br>
			<label></label>
			<label></label><input type = "submit" name="regsubmit" value = "Register">
		</form>
	<?php
		}
	?>
		</center>
	
	
	</div>

</body>


</html>
