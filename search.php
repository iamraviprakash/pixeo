<?php if(isset($_GET['field']))
		{
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>
		Pixeo | A Video Sharing Hub
	</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="pixeostyle.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<meta name="google-signin-client_id" content="545353333488-qda3stvg095h0nrm5kjt5ulkr6r5nk6i.apps.googleusercontent.com">
	<script src="https://apis.google.com/js/platform.js" async defer></script>
</head>
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
	  //console.log(document.cookie);
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
</script>
<body>
	<div class="container-fluid">
		<div class="row" id="header">
			<div class="col-xs-9">
				<form action="search.php" id="header-search">
					<font id="logo-text">PI<b>X</b>EO</font><input type="text" placeholder="Search" name="field" id="header-searchbar">
					<button id="header-searchbutton"><span class="glyphicon glyphicon-search"></span></button>
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
					<button onclick="signOut()" id="signout">Sign Out</button>
				</div>
			</div>
		</div>
		<div class="row" id="main">
			<div class="col-xs-2" id="sidepane">
				<ul type="none">
					<li><a href="index.php"><button class="sidepane-button"><span class="glyphicon glyphicon-home"></span> Home</button></a></li>
					<li><a href="trending.php"><button class="sidepane-button"><span class="glyphicon glyphicon-fire"></span> Trending</button></a></li>
					<li><a href="myspace.php"><button class="sidepane-button"><span class="glyphicon glyphicon-user"></span> Myspace</button></a></li>
					<li><a href="history.php"><button class="sidepane-button"><span class="glyphicon glyphicon-hourglass"></span> History</button></a></li>
					<hr>
					<li><a href="liked_videos.php"><button class="sidepane-button"><span class="glyphicon glyphicon-thumbs-up"></span> Liked Videos</button></a></li>
					<hr>
				</ul>
			</div>
			<div class="col-xs-7" id="main-body">
				<?php
				$servername = "localhost";
				$username = "root";
				$password = "ravi";
				$dbname = "pixeo";
				$count=0;
				$sql="";
				$conn = new mysqli($servername, $username, $password, $dbname);
				if ($conn->connect_error) {
				    die("Connection failed: " . $conn->connect_error);
				}
				if(isset($_GET['field']))
				{
				$value=$_GET['field'];
				$sql = "select b.views views,c.user_username user_username,b.videothumbnail_path videothumbnail_path,
				b.video_id video_id,b.video_name video_name from videos b 
				join GUser c on b.user_id=c.user_id where b.video_name like '%".$value."%';";
				}
				
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
					   		$i=0;
					   		$video_id=$row['video_id'];
					   		echo '<td>';
							echo '<a href="watch.php?vid='.$video_id.'"><img src='.$row['videothumbnail_path'].'width="250"></a>';
							echo "</td>";
							echo '<td style="padding:20px;vertical-align:top">';
							echo '<a href="watch.php?vid='.$video_id.'">'.$row['video_name'].'</a><br>';
							echo "<div ><font size='2.5' color='grey' >".$row['user_username']."</font></div>";
							echo "<div ><font size='2.5' color='grey' >".$row['views']." Views</font></div>";
							echo '</td>';
					   		echo "</tr>";
						}
						echo "</table>";
					} 
					else 
					{
				   		echo "<br><br><center>No relevant results found.</center>";
					}
				}
				$conn->close();
				?>
			</div>
		</div>
	</div>
</body>
</html>
<?php }
	else
		header('Location:index.php');
 ?>
