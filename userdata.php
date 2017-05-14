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
		$sql="select user_id from GUser where user_username='$uname'";
		$result=$conn->query($sql);
		$row=$result->fetch_assoc();
		$uid=$row['user_id'];
		if($_GET['value']=='like')
		{
			$sql="select * from liked_videos where video_id=$vid and user_id=$uid";
			$result=$conn->query($sql);
			if($result->num_rows>0)
			{
				//return same value
				$conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
				$conn->query("update videos set likes=likes-1 where video_id=$vid");
				$conn->query("Delete from liked_videos where video_id=$vid and user_id=$uid");
				$conn->commit();
				$sql="select likes,dislikes from videos where video_id=$vid";
				$result=$conn->query($sql);
				$row=$result->fetch_assoc();
				$str=$row['likes'].",".$row['dislikes'];
				echo $str;
			}
			else
			{
				$sql="select * from disliked_videos where video_id=$vid and user_id=$uid";
				$result=$conn->query($sql);
				if($result->num_rows>0)
				{
					//update like and dislike remove from dislike add to like
					$conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
					$conn->query("update videos set dislikes=dislikes-1 where video_id=$vid");
					$conn->query("update videos set likes=likes+1 where video_id=$vid");
					$conn->query("Delete from disliked_videos where video_id=$vid and user_id=$uid");
					$conn->query("Insert into liked_videos(video_id,user_id) values($vid,$uid)");
					$conn->commit();
					$sql="select likes,dislikes from videos where video_id=$vid";
					$result=$conn->query($sql);
					$row=$result->fetch_assoc();
					$str=$row['likes'].",".$row['dislikes'];
					echo $str;
				}
				else
				{
					//update like
					$conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
					$conn->query("update videos set likes=likes+1 where video_id=$vid");
					$conn->query("Insert into liked_videos(video_id,user_id) values($vid,$uid)");
					$conn->commit();
					$sql="select likes,dislikes from videos where video_id=$vid";
					$result=$conn->query($sql);
					$row=$result->fetch_assoc();
					$str=$row['likes'].",".$row['dislikes'];
					echo $str;
				}
			}

		}
		else if($_GET['value']=='dislike')
		{
			$sql="select * from disliked_videos where video_id=$vid and user_id=$uid";
			$result=$conn->query($sql);
			if($result->num_rows>0)
			{
				//return same value
				$conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
				$conn->query("update videos set dislikes=dislikes-1 where video_id=$vid");
				$conn->query("Delete from disliked_videos where video_id=$vid and user_id=$uid");
				$conn->commit();
				$sql="select likes,dislikes from videos where video_id=$vid";
				$result=$conn->query($sql);
				$row=$result->fetch_assoc();
				$str=$row['likes'].",".$row['dislikes'];
				echo $str;
			}
			else
			{
				$sql="select * from liked_videos where video_id=$vid and user_id=$uid";
				$result=$conn->query($sql);
				if($result->num_rows>0)
				{
						//update like and dislike remove from dislike add to like
					$conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
					$conn->query("update videos set likes=likes-1 where video_id=$vid");
					$conn->query("update videos set dislikes=dislikes+1 where video_id=$vid");
					$conn->query("Delete from liked_videos where video_id=$vid and user_id=$uid");
					$conn->query("Insert into disliked_videos(video_id,user_id) values($vid,$uid)");
					$conn->commit();
					$sql="select likes,dislikes from videos where video_id=$vid";
					$result=$conn->query($sql);
					$row=$result->fetch_assoc();
					$str=$row['likes'].",".$row['dislikes'];
					echo $str;
				}
				else
				{
					//update like
					$conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
					$conn->query("update videos set dislikes=dislikes+1 where video_id=$vid");
					$conn->query("Insert into disliked_videos(video_id,user_id) values($vid,$uid)");
					$conn->commit();
					$sql="select likes,dislikes from videos where video_id=$vid";
					$result=$conn->query($sql);
					$row=$result->fetch_assoc();
					$str=$row['likes'].",".$row['dislikes'];
					echo $str;
				}
			}

		}
		else if($_GET['value']=='comment')
		{
			$text=$_GET['text'];
			$sql="Insert into comments(text,video_id,user_id) values('$text','$vid','$uid');";
			$conn->query($sql);
			$sql="select Count(user_id) as Total_Count from comments where video_id=$vid";
			$result=$conn->query($sql);
			$row=$result->fetch_assoc();
			$str=$row['Total_Count'];
			echo $str;
		}
		else if($_GET['value']=='views')
		{
			$sql="select * from history where video_id=$vid and user_id=$uid";
			$result=$conn->query($sql);
			if ($result->num_rows == 0) 
			{
				$conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
				$conn->query("update videos set views=views+1 where video_id=$vid");
				$conn->query("Insert into history(video_id,user_id) values($vid,$uid)");
				$conn->commit();
			}
			$sql="select views from videos where video_id=$vid";
			$result=$conn->query($sql);
			$row=$result->fetch_assoc();
			$str=$row['views'];
			echo $str;
		}
	}
	$conn->close();
?>
