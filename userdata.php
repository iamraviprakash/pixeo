<?php
	$servername = "localhost";
	$username = "pixeo_root";
	$password = "root@123";
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
				$str=$row['likes'].",".$row['dislikes'].",0";
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
					$str=$row['likes'].",".$row['dislikes'].",1";
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
					$str=$row['likes'].",".$row['dislikes'].",1";
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
				$str=$row['likes'].",".$row['dislikes'].",0";
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
					$str=$row['likes'].",".$row['dislikes'].",-1";
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
					$str=$row['likes'].",".$row['dislikes'].",-1";
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
			if(isset($_GET['u_name']))
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
			else{
				$conn->query("update videos set views=views+1 where video_id=$vid");
				$sql="select views from videos where video_id=$vid";
				$result=$conn->query($sql);
				$row=$result->fetch_assoc();
				$str=$row['views'];
				echo $str;
			
			}
		}
		else if($_GET['value']=='delete')
		{
			$sql="select video_path,videothumbnail_path from videos where video_id=$vid";
			$result=$conn->query($sql);
			$row=$result->fetch_assoc();
			$deleteVideo_path="rm ".$row['video_path']."";
			$deleteVideoThumbnail_path="rm ".$row['videothumbnail_path']."";
			exec($deleteVideo_path,$output,$returnVal1);
			exec($deleteVideoThumbnail_path,$output,$returnVal2);
			if($returnVal1==0 && $returnVal2==0)
			{
				$sql="Delete from videos where video_id=$vid;";
				$conn->query($sql);
				echo "Deleted";
			}
			else{
				echo "Delete";
			}
		}
		else if($_GET['value']=='deny' or $_GET['value']=='allow')
		{
			if($_GET['value']=='deny')
			{
				$sql="update videos set status='D',remarks='Denied by ".$_GET['u_name']."' where video_id=$vid;";
				$conn->query($sql);
				echo "Denied";
			}
			else
			{
				$sql="update videos set status='A',remarks='Allowed by ".$_GET['u_name']."' where video_id=$vid;";
				$conn->query($sql);
				echo "Allowed";
			}
		}
		else if($_GET['value']=='chklikedislike')
		{
			$sql="select * from liked_videos where video_id=$vid and user_id=$uid";
			$result=$conn->query($sql);
			if($result->num_rows>0)
			{
				echo "1";
			}
			$sql="select * from disliked_videos where video_id=$vid and user_id=$uid";
			$result1=$conn->query($sql);
			if($result1->num_rows>0)
			{
				echo "-1";
			}
			if($result->num_rows==0 and $result1->num_rows==0)
			{
				echo "0";
			}
		}
		else if($_GET['value']=='getCategoryList')
		{
			$sql="select category_name, category_id from categories where category_id in ( select distinct(category_id) from videos );";
			$result=$conn->query($sql);
			$str="";
			while($row=$result->fetch_assoc())
			{
				$str=$str.$row['category_name'].":".$row['category_id'].",";
			}
			echo $str;
		}
	}
	$conn->close();
?>
