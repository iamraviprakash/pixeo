<?php
	$servername = "localhost";
	$username = "root";
	$password = "ravi";
	$dbname = "pixeo";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	if(isset($_GET['user_username']) and isset($_GET['user_email']))
	{
		$uname=$_GET['user_username'];
		$name=$_GET['user_name'];
		$email=$_GET['user_email'];
		$profpic=$_GET['user_profilepic'];
		$sql="Select * from GUser where user_email='$email'";
		$result = $conn->query($sql);
		if($result->num_rows==0)
		{
			$sql="Insert into GUser(user_username,user_name,user_email,user_profilepic) values('$uname','$name','$email','$profpic');";
			$conn->query($sql);
		}
		$conn->close();
	}
	else if(isset($_GET['value']))
	{
		$vid=$_GET['v_id'];
		$uname=$_GET['u_name'];
		$len=strpos($uname,';');
		if($len>0)
			$uname=substr($uname,0,$len);
		$sql="select User_Id from GUser where User_Name='$uname'";
		$result=$conn->query($sql);
		$row=$result->fetch_assoc();
		$uid=$row['User_Id'];
		if($_GET['value']=='like')
		{
			$sql="select * from Liked_Videos where Video_Id=$vid and User_Id=$uid";
			$result=$conn->query($sql);
			if($result->num_rows>0)
			{
				//return same value
				$conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
				$conn->query("update Videos set Likes=Likes-1 where Video_Id=$vid");
				$conn->query("Delete from Liked_Videos where Video_Id=$vid and User_Id=$uid");
				$conn->commit();
				$sql="select Likes,Dislikes from Videos where Video_Id=$vid";
				$result=$conn->query($sql);
				$row=$result->fetch_assoc();
				$str=$row['Likes'].",".$row['Dislikes'];
				echo $str;
			}
			else
			{
				$sql="select * from Disliked_Videos where Video_Id=$vid and User_Id=$uid";
				$result=$conn->query($sql);
				if($result->num_rows>0)
				{
					//update like and dislike remove from dislike add to like
					$conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
					$conn->query("update Videos set Dislikes=Dislikes-1 where Video_Id=$vid");
					$conn->query("update Videos set Likes=Likes+1 where Video_Id=$vid");
					$conn->query("Delete from Disliked_Videos where Video_Id=$vid and User_Id=$uid");
					$conn->query("Insert into Liked_Videos(Video_Id,User_Id) values($vid,$uid)");
					$conn->commit();
					$sql="select Likes,Dislikes from Videos where Video_Id=$vid";
					$result=$conn->query($sql);
					$row=$result->fetch_assoc();
					$str=$row['Likes'].",".$row['Dislikes'];
					echo $str;
				}
				else
				{
					//update like
					$conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
					$conn->query("update Videos set Likes=Likes+1 where Video_Id=$vid");
					$conn->query("Insert into Liked_Videos(Video_Id,User_Id) values($vid,$uid)");
					$conn->commit();
					$sql="select Likes,Dislikes from Videos where Video_Id=$vid";
					$result=$conn->query($sql);
					$row=$result->fetch_assoc();
					$str=$row['Likes'].",".$row['Dislikes'];
					echo $str;
				}
			}

		}
		else if($_GET['value']=='dislike')
		{
			$sql="select * from Disliked_Videos where Video_Id=$vid and User_Id=$uid";
			$result=$conn->query($sql);
			if($result->num_rows>0)
			{
				//return same value
				$conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
				$conn->query("update Videos set Dislikes=Dislikes-1 where Video_Id=$vid");
				$conn->query("Delete from Disliked_Videos where Video_Id=$vid and User_Id=$uid");
				$conn->commit();
				$sql="select Likes,Dislikes from Videos where Video_Id=$vid";
				$result=$conn->query($sql);
				$row=$result->fetch_assoc();
				$str=$row['Likes'].",".$row['Dislikes'];
				echo $str;
			}
			else
			{
				$sql="select * from Liked_Videos where Video_Id=$vid and User_Id=$uid";
				$result=$conn->query($sql);
				if($result->num_rows>0)
				{
						//update like and dislike remove from dislike add to like
					$conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
					$conn->query("update Videos set Likes=Likes-1 where Video_Id=$vid");
					$conn->query("update Videos set Dislikes=Dislikes+1 where Video_Id=$vid");
					$conn->query("Delete from Liked_Videos where Video_Id=$vid and User_Id=$uid");
					$conn->query("Insert into Disliked_Videos(Video_Id,User_Id) values($vid,$uid)");
					$conn->commit();
					$sql="select Likes,Dislikes from Videos where Video_Id=$vid";
					$result=$conn->query($sql);
					$row=$result->fetch_assoc();
					$str=$row['Likes'].",".$row['Dislikes'];
					echo $str;
				}
				else
				{
					//update like
					$conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
					$conn->query("update Videos set Dislikes=Dislikes+1 where Video_Id=$vid");
					$conn->query("Insert into Disliked_Videos(Video_Id,User_Id) values($vid,$uid)");
					$conn->commit();
					$sql="select Likes,Dislikes from Videos where Video_Id=$vid";
					$result=$conn->query($sql);
					$row=$result->fetch_assoc();
					$str=$row['Likes'].",".$row['Dislikes'];
					echo $str;
				}
			}

		}
		else if($_GET['value']=='comment')
		{
			$text=$_GET['text'];
			$sql="Insert into Comments(Text,Video_Id,User_Id) values('$text','$vid','$uid');";
			$conn->query($sql);
			$sql="select Count(User_Id) as Total_Count from Comments where Video_Id=$vid";
			$result=$conn->query($sql);
			$row=$result->fetch_assoc();
			$str=$row['Total_Count'];
			echo $str;
		}
	}
	$conn->close();
?>
