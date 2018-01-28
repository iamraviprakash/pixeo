<?php 
header("Cache-Control: no-store, must-revalidate, max-age=0");
header("Pragma: no-cache");
if($_COOKIE['username']!="''" && $_COOKIE['G_AUTHUSER_H']==0)
{
	$servername = "localhost";
	$username = "pixeo_user";
	$password = "user@123";
	$dbname = "pixeo";
			
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	$sql="select admin from GUser where user_username='".$_COOKIE['username']."'";
	$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>
		Pixeo | A Video Sharing Hub
	</title>
	<meta charset="utf-8">
	<link rel="shortcut icon" href="pixeo.png">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="pixeostyle.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<meta name="google-signin-client_id" content="545353333488-qda3stvg095h0nrm5kjt5ulkr6r5nk6i.apps.googleusercontent.com">
	<script src="https://apis.google.com/js/platform.js" async defer></script>
</head>
<style>
	#myspace{
		background: grey;
		color: white;
	}
	#main-body-header{
		width:100%;
		height:30vh;
		background: grey;
		min-height: 200px;
		text-align: center;
		padding-top: 50px;
	}
	#profilepic{
		border: 2px solid white;
	}
	#profilename{
		color:white;
		font-size: 1.4em;
		font-weight: bold;
	}
	#main-body-linkpanel{
		color:#66a3ff;
		font-size: 1em;
		font-weight: bold;
		text-align: center;
	}
	
	table {
	    font-size: 1.1em;
	} 
	td{
	    height:135px;
	}
	.td-thumbnail{
		width:200px;
	}
</style>
<script>
var count=0;
document.cookie = "username=''";
function onSignIn(googleUser) {
	  var profile = googleUser.getBasicProfile();
	  //console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
	  //console.log('Name: ' + profile.getName());
	  //console.log('Image URL: ' + profile.getImageUrl());
	  //console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
	  //xmlhttp.open("GET", "userdata.php?u_email=" +email+"&u_name="+email1+"&name="+name, true);
	  var username=profile.getEmail();
	  var ind=username.indexOf('@');
	  var domain=username.substring(ind+1);
	  if(domain=='iiits.in')
	  {
		  username=username.substring(0, ind);
		  var xmlhttp = new XMLHttpRequest();
		  xmlhttp.open("GET", "userdata.php?user_profilepic="+profile.getImageUrl()+"&user_email="+profile.getEmail()+"&user_username="+username+"&user_name="+profile.getName(), true);
	      xmlhttp.send();
		  document.getElementById("imgsrc").src=googleUser.getBasicProfile().getImageUrl();
		  document.getElementById("box-img").src=googleUser.getBasicProfile().getImageUrl();
		  document.getElementById("box-name").innerHTML=profile.getName();
		  document.getElementById("box-email").innerHTML=profile.getEmail();
		  document.cookie = "username="+username;
		  document.getElementById("signin").style.display="none";
		  document.getElementById("disc").style.display="block";
		  document.getElementById("profilename").innerHTML=profile.getName();
		  document.getElementById("profilepic").src=profile.getImageUrl();
		  //console.log(document.cookie);
	  }
	  else{
	  	signOut();
	  }
}
function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.disconnect().then(function () {
      console.log('User signed out.');
      document.cookie = "username=''";
      location.reload();
    });
    
}
function disp(){
  	if(count%2==0)
  	{
  		document.getElementById("box").style.display="block";
  	}
  	else{
  		document.getElementById("box").style.display="none";
  	}
  	count++;
}
function Delete(vid,var_this)
{
	var stat=var_this.innerHTML;
	if(stat=='Delete')
	{
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
	    	if (this.readyState == 4 && this.status == 200) {
	     		var_this.innerHTML=this.responseText;
	    	}
	  	};
	  	var varurl="userdata.php?value=delete&v_id="+vid;
	    xhttp.open("GET",varurl,true);
	    xhttp.send();
	}
	
}

</script>
<body>
<div class="container-fluid">
		<div class="row" id="header">
			<div class="col-xs-9">
				<form action="search.php" id="header-search">
					<font id="logo-text">PI<b>X</b>EO</font><input type="text" placeholder="Search" name="field" id="header-searchbar">
					<button  id="header-searchbutton"><span class="glyphicon glyphicon-search"></span></button>
				</form>
			</div>
			<div class="col-xs-1" id="header-upload">
				<a href="upload.php"><button id="header-uploadbutton"><span class="glyphicon glyphicon-open"></span></button></a>
			</div>
			<div class="col-xs-2" id="header-profile">
				<button id="disc" onclick="disp()"><img src="" id="imgsrc" width="30"></button>
				<span class="g-signin2" data-onsuccess="onSignIn" style="width:90px;height:30px;" id="signin"></span>
				<div id="box">
					<img src="" id="box-img" width="40">
					<br>
					<br>
					<div id="box-name"></div>
					<div id="box-email"></div>
					<hr>
					<?php
					if($result->num_rows>0)
					{
						$row = $result->fetch_assoc();
						if($row['admin']=='Y')
						{
							echo "<a href='admin.php'><button id='adminButton'>Admin</button></a><br><br>";
						}
					}
					?>
					<button onclick="signOut()" id="signout">Sign Out</button>
				</div>
			</div>
		</div>
		<div class="row" id="main">
			<div class="col-xs-2" id="sidepane">
				<ul type="none">
					<li><a href="index.php"><button class="sidepane-button" ><span class="glyphicon glyphicon-home"></span> Home</button></a></li>
					<li><a href="trending.php"><button class="sidepane-button"><span class="glyphicon glyphicon-fire"></span> Trending</button></a></li>
					<li><a href="myspace.php"><button class="sidepane-button" id="myspace"><span class="glyphicon glyphicon-user"></span> Myspace</button></a></li>
					<li><a href="history.php"><button class="sidepane-button"><span class="glyphicon glyphicon-hourglass"></span> History</button></a></li>
					<hr>
					<li><a href="liked_videos.php"><button class="sidepane-button"><span class="glyphicon glyphicon-thumbs-up"></span> Liked Videos</button></a></li>
					<hr>
				</ul>
				<div id="categoryTitle">Category</div>
				<ul type="none" id="categoryList">
				<?php

					$sql="select category_name, category_id from categories where category_id in 
					( select distinct(category_id) from videos where status in ('N', 'A'));";

					$result=$conn->query($sql);

					while($row=$result->fetch_assoc())
					{
						echo '<li><a href="categories.php?category='.$row['category_id'].'">
						<button class="categoryButton">'.substr($row['category_name'],0,20).'</button>
						</a></li>';
					}
				?>		
				</ul>
			</div>
			<div class="col-xs-9" id="main-body">
				<div id="main-body-header">
					<img id="profilepic" src="" width="80">
					<br>
					<br>
					<div id="profilename"></div>
				</div>
				<div id="main-body-linkpanel">
					<a href="upload.php">Upload</a>&nbsp;&nbsp;<a href="uploaded.php"><u>Uploaded</u></a>&nbsp;&nbsp;
					<a href="statistics.php">Stats</a>
				</div>
				<div id="main-body-content">
				
				<?php
				$value=$_GET['field'];
				$uname=$_COOKIE['username'];     //find user id from username
				$sql="select user_id from GUser where user_username='$uname'";
				$result = $conn->query($sql);
				$row=$result->fetch_assoc();
				$uid=$row['user_id'];
				$sql = "select views,upload_time,videothumbnail_path,video_id,video_name 
				from videos where user_id=$uid order by upload_time desc;";
				//$sql = "select views,user_username,videothumbnail_path,video_id,video_name;"
				if($sql!="")
				{
					$result = $conn->query($sql);
					//echo "<div style='left:850px;top:0px;position:absolute;color:grey;padding-top:30px;'>No of results:".$result->num_rows."</div><br>";
					$c_name = $result->fetch_fields();
					if ($result->num_rows > 0) 
					{	echo "<hr>";
						echo "<table cellpadding='20'>";
					   	while($row=$result->fetch_assoc()) 
					   	{
					   		echo "<tr>";
					   		$video_id=$row['video_id'];
					   		echo '<td class="td-thumbnail">';
							echo '<a href="watch.php?vid='.$video_id.'"><img src='.$row['videothumbnail_path'].'width="200" height="112"></a>';
							echo "</td>";
							echo '<td style="padding:20px;vertical-align:top" class="td-details">';
							echo '<a href="watch.php?vid='.$video_id.'">'.$row['video_name'].'</a><br>';
							echo "<div><font size='2.5' color='grey' >".$row['views']." Views</font></div>";
							echo "<div><font size='2.5' color='grey' >".$row['upload_time']."</font></div><br>";
							echo '<button class="delete-button" onclick="Delete('.$video_id.',this)">Delete</button>';
							echo '</td>';
					   		echo "</tr>";
						}
						echo "</table>";
					} 
					else 
					{
				   		echo "<br><br><center>OOPS! No uploads found. Why don't you upload some.</center>";
					}
				}
				$conn->close();
				?>

				</div>
				<div id="site-description">
					<img src="pixeo.png" width="80">
					<br>
					P I <b> X</b> E O
					<br>
					<br>
					Developed by <b>Ravi Prakash</b>

				</div>
			</div>
		</div>
	</div>
</body>
</html>
<?php }
	else
		header('Location:index.php');
 ?>
