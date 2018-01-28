<?php
	$servername = "localhost";
	$username = "root";
	$password = "ravi";
	$dbname = "cardo";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	if(isset($_GET['type']))
	{
		
		if($_GET['type']=='getUsersList')
		{
			$sql="select username, status from users;";
			$results = $conn->query($sql);
			$resultText="";

			while($row = $results->fetch_assoc())
			{
				$resultText = $resultText.$row['username']." ".$row['status'].",";
			}

			echo $resultText;
			$resultText = "";
		}
		else if($_GET['type']=='getFieldsData')
		{
			$username = $_GET['username'];
			$sql="select username, password, status from users where username='".$username."';";
			$results = $conn->query($sql);
			$row = $results->fetch_assoc();
			if($row['status'] == 'N')
			{
				echo $row['username']." ".$row['password'];
				$sql="update users set status='Y' where username='$username';";
				$conn->query($sql);
			}
			else
			{
				echo "loggedIn";
			}

		}

	}
	$conn->close();
?>