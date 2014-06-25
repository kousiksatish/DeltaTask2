<?php
	require "sqlconfig.php";
	$target_path = '/var/www/';
	session_start();
	if(isset($_SESSION['deltarollno']))
	{
		
		echo '<h3>You are logged in as ' . $_SESSION['deltarollno'] . '</h3>';
	?>
		<a href="logout.php"><button>Logout</button></a><br>
	<?php
	
	$dbc = mysqli_connect($db_host, $db_user,$db_pw, 'delta')
			or die ('Error connecting to the database server');		
	
	$query="SELECT * FROM register;"
		or die('Error querying');
	$result=mysqli_query($dbc,$query);
	$check=false;
	while($row=mysqli_fetch_array($result))
	{
	
		if($row['rollno']==$_SESSION['deltarollno'])
		{
			$name = $row['name'];
			break;
		}
		
	}   
	
	echo '<h3>Hello ' . $name . '!!!</h3>';
	?>
	<h4><u>Upload pic form</u></h4>
	
	<u>Upload your picture here!!!</u><br>
	<?php
	$outputform = true;
	if(isset($_POST['filesubmit']))
	{
		$flag = true;
		
		if ($_FILES["file"]["size"] == 0 && $flag)
		{
			echo '<br>No image uploaded.';
			$flag = false;
		}
		
		if ($_FILES["file"]["size"] / 1024 >2048 && flag) 
		{
			echo '<br>Image size should be less than 2mb';
			$flag = false;
		}
		
		if(!(($_FILES["file"]["type"] == "image/gif")
			|| ($_FILES["file"]["type"] == "image/jpeg")
			|| ($_FILES["file"]["type"] == "image/jpg")
			|| ($_FILES["file"]["type"] == "image/pjpeg")
			|| ($_FILES["file"]["type"] == "image/x-png")
			|| ($_FILES["file"]["type"] == "image/png"))&&$flag)
		{
			echo '<br>File not an image file';
			$flag = false;
		}
		
		if($flag)
		{
			
			move_uploaded_file($_FILES["file"]["tmp_name"],
			   $target_path . $_SESSION['deltarollno'] . '.png')
			  or die('Error');

			echo "File uploaded successfully";
			$outputform = false;
		}
	}
	
	
	
	if($outputform)
	{
	?>
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
	
	<input type="file" name="file" id="file"><br>
	<input type="submit" name="filesubmit" value="Submit">
	</form>
	<br>
	
	
	<?php
	}
	
	}
	else
		header("location:home.php?err=true");

?>
