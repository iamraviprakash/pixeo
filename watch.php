<!DOCTYPE html>
<html lang="en">
<head>
	<title>
		Pixeo | A Video Sharing Hub
	</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<meta name="google-signin-client_id" content="545353333488-qda3stvg095h0nrm5kjt5ulkr6r5nk6i.apps.googleusercontent.com">
	<script src="https://apis.google.com/js/platform.js" async defer></script>
</head>
<style>
	body{
		background-color: #f7f7f7;
	}
	ul{
		padding-left: 20px;
	}
	table {
	    border-collapse: separate;
	    border: 0px solid black;
	    table-layout: fixed;
	    color:#4d94ff;
	    font-size: 19px;
	} 
	td{
	    word-wrap: break-word;         /* All browsers since IE 5.5+ */
	    overflow-wrap: break-word;     /* Renamed property in CSS3 draft spec */
	    border: 0px solid black;
	    height:180px;
	}
	.container-fluid{
		margin: 0px;
	}
	#header{
		position: fixed;
		background: #66a3ff;
		height: 8vh;
		width:100vw;
		padding-top: 10px;
		min-height: 50px;
		max-height: 55px;
		z-index: 1;
	}
	#signout{
		background: #66a3ff;
		border-width: 0px;
		width:90px;
		height:30px;
		color: white;
		font-size: 0.9em;
	}
	#sidepane{
		position: fixed;
		height:90vh;
		background-color:white;
		padding-top: 10px;
		max-width: 216px;
		min-width: 210px;
		z-index: 1; /* z-index change make change to all*/
	}
	#main{
		margin-top: 60px;
		
	}
	.sidepane-button{
		color:#666666;
		border-width:0px;
		background: none;
		height:35px;
		width:100%;
		font-size: 1.1em;
		text-align: left;
	}
	#disc{
		width:30px;
		height:30px;
		border-radius: 15px;
		border-width: 0px;
		padding: 0px;
		display: none;
	}
	#box{
		width:180px;
		height:200px;
		background: white;
		padding: 10px;
		display: none;
		color:grey;
		position: relative;
		right:150px;
		box-shadow: 0.5px 0.5px 0.5px 1px grey;
	}
	#main-body{
		background: none;
		min-height:90vh;
		margin-left: 250px;
		padding: 0px;
	}
	#header-searchbar{
		border-width: 0px;
		width:70%;
		height:30px;
		border-radius: 1px;
		padding-left: 5px;
		color: grey;
		font-size: 1.15em;
	}
	#header-searchbutton{
		background: white;
		border-width: 0px;
		color:grey;
		width:30px;
		height:30px;
		border-radius: 1px;
	}
	#header-search{
		text-align: center;
	}
	#logo-text{
		font-size:20px;
		color:white;
		margin-right:5px;
	}
	#imgsrc{
		border-radius: 15px;
	}
	#box-img{
		border-radius: 20px;
	}
	#header-upload,#header-profile{
		text-align: center;
	}
	#header-uploadbutton{
		background: none;
		border-width: 0px;
		color: white;
		width:30px;
		height: 30px;
	}
	#video-screen{
		width:100%;
		height: 100%;
	}
	#video-area{
		width:100%;
		background: white;
		padding: 0px;
		box-shadow: 1px 1px 2px grey;
		min-width: 755px;
		height: 65vh;
		min-height: 440px;
		min-width: 755px;
	}
	#video-details{
		width:100%;
		background: white;
		box-shadow: 1px 1px 2px grey;
		padding: 10px;
		color:#5e5e5e;
		min-width: 755px;
	}
	#video-name{
		text-align: left;
		font-size: 1.6em;
		word-wrap: break-word;
	}
	#video-uploader{
		text-align: left;
	}
	#video-views{
		text-align: right;
		font-size: 1.3em;
	}
	#video-likesdislikes{
		text-align: right;
		font-size: 1.1em;
	}
	#video-description{
		width:100%;
		height:20vh;
		min-height: 100px;
		background: white;
		box-shadow: 1px 1px 2px grey;
		min-width: 755px;
	}
	#comment-area
	{
		width:100%;
		background: white;
		box-shadow: 1px 1px 2px grey;
		padding: 10px;
		color:#5e5e5e;
		min-width: 755px;
		height:auto;
		clear:both;
	}
	#comment-box{
		width:100%;
		resize:none;
	}
	#comment-button-area{
		text-align:right;
	}
	#comment-button{
		color:white;
		border-width: 0px;
		background: #66a3ff;
	    font-size: 1em;
	}
	#comment-username{
		color:#66a3ff;
		font-weight: bold;
	}
	#comment-text{
		padding-left: 35px;
	}
	.likedislikebutton{
		background: none;
		border-width: 0px;
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
	  calltype(4);
	  console.log(document.cookie);

	  
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
function sendtoserver(varurl,varfunction)
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     varfunction(this.responseText);
    }
  };
  xhttp.open("GET",varurl,true);
  xhttp.send();
}
function calltype(type)
{
	var username=document.cookie;
	var varurl;
	username=username.split(";");
	username=username[1].split("=");
	var v_id=window.location.href;
	v_id=v_id.split("?");
	v_id=v_id[1].split("=");
	if(username[1]!='')
	{
		if(type==1)
		{
			varurl="userdata.php?value=like&u_name="+username[1]+"&v_id="+v_id[1];
			sendtoserver(varurl,setlikedislike);
		}
		else if(type==2)
		{
			varurl="userdata.php?value=dislike&u_name="+username[1]+"&v_id="+v_id[1];
			sendtoserver(varurl,setlikedislike);
		}
		else if(type==3)
		{
			var text=document.getElementById("comment-box").value;
			//document.getElementById("myTextarea").disabled = true;
			varurl="userdata.php?value=comment&u_name="+username[1]+"&v_id="+v_id[1]+"&text="+text;
			sendtoserver(varurl,setcomment);
		}
		else if(type==4)
		{
			varurl="userdata.php?value=views&u_name="+username[1]+"&v_id="+v_id[1];
			console.log("hello");
			sendtoserver(varurl,setviews);
		}
	}
}
function setlikedislike(serverresponse)
{
	serverresponse=serverresponse.split(",");
	document.getElementById("like-text").innerHTML=serverresponse[0];
	document.getElementById("dislike-text").innerHTML=serverresponse[1];
}
function setcomment(serverresponse)
{

}
function setviews(serverresponse)
{
	document.getElementById("video-views").innerHTML=serverresponse+" views";
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
					if(isset($_GET['vid']))
					{
						$value=$_GET['vid'];
						$sql = "select b.views views,b.likes likes,b.dislikes dislikes,b.video_path video_path,c.user_profilepic user_profilepic,c.user_username user_username,b.video_name video_name from videos b join GUser c on b.user_id=c.user_id where b.video_id=$value";
					}
					$result = $conn->query($sql);
					$row=$result->fetch_assoc();
					?>
				<div id="video-area">
					<video id="video-screen" controls>
					  <source src=<?php echo $row['video_path'] ?> type="video/mp4">
					</video>
				</div>
				<br>
				<div id="video-details">
					<div id="video-name">
						<?php echo $row['video_name'] ?>
					</div>
					<br>
					<div id="video-uploader">
						<img src=<?php echo $row['user_profilepic'] ?> width="35"> <?php echo $row['user_username'] ?>
					</div>
					<div id="video-views">
						<?php echo $row['views'] ?> views
					</div>
					<hr>
					<div id="video-likesdislikes">
						<button onclick="calltype(1)" class="likedislikebutton"><span class="glyphicon glyphicon-thumbs-up"></span></button> <span id="like-text"> <?php echo $row['likes'] ?> </span> <button onclick="calltype(2)" class="likedislikebutton"><span class="glyphicon glyphicon-thumbs-down"></span></button> <span id="dislike-text"> <?php echo $row['dislikes'] ?> </span> 
					</div>
				</div>
				<br>
				<div id="video-description">
				</div>
				<br>
				<div id="comment-area">
					<textarea rows="3" id="comment-box"></textarea>
					<div id="comment-button-area">
						<button id="comment-button" onclick="calltype(3)">Comment</button>
					</div>
					<hr>
					<div id="other-comments">
						<?php
							$sql = "select b.text text,c.user_profilepic user_profilepic,c.user_username user_username from comments b join GUser c on b.user_id=c.user_id where b.video_id=$value";
							$result = $conn->query($sql);
							while($row=$result->fetch_assoc()) 
					   		{
						?>
								<div>
									<span id="comment-userpic"><img src=<?php echo $row['user_profilepic'] ?> width="30"> </span><span id="comment-username"> <?php echo $row['user_username'] ?></span>
									<br>
									<div id="comment-text">
										<?php echo $row['text'] ?>
									</div>
								</div>
								<br>
						<?php

							}
							$conn->close();
						?>
					</div>
				</div>
				<br>
			</div>
		</div>
	</div>
</body>
</html>
