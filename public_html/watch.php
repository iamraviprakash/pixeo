<?php
header("Cache-Control: no-store, must-revalidate, max-age=0");
header("Pragma: no-cache"); 
if(isset($_GET['vid']))
{
	$servername = "localhost";
	$username = "pixeo_user";
	$password = "user@123";
	$dbname = "pixeo";
	$sql="";
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<link rel="stylesheet" href="pixeostyle.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<meta name="google-signin-client_id" content="545353333488-qda3stvg095h0nrm5kjt5ulkr6r5nk6i.apps.googleusercontent.com">
	<script src="https://apis.google.com/js/platform.js" async defer></script>
</head>
<style>
	
	#main-body{
		background: none;
		min-height:90vh;
		margin-left: 250px;
		padding: 0px;
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
		background: white;
		box-shadow: 1px 1px 2px grey;
		min-width: 755px;
		font-size: 1em;
		padding: 10px;
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
	.comment-username{
		color:#66a3ff;
		font-weight: bold;
	}
	.comment-text{
		padding-left: 35px;
	}
	.likedislikebutton{
		background: none;
		border-width: 0px;
	}
	#show-more-less{
		background: none;
		width: 100%;
		height: 25px;
		color: grey;
		font-size: 0.7em;
		font-weight: bold;
		border-width: 0px;
		border-top: 1px solid lightgrey; 
		padding-bottom: 0px;
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
		  calltype(4);
		  calltype(5);
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
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return null;
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
	//var username=document.cookie;
	var varurl;
	//username=username.split(";");
	//username=username[1].split("=");
	var username=getCookie('username');
	var status=getCookie('G_AUTHUSER_H');
	//console.log(document.cookie);
	var v_id=window.location.href;
	v_id=v_id.split("?");
	v_id=v_id[1].split("=");
	//console.log(username);
	if(username!="''" && username!=null && status==0)
	{
		if(type==1)
		{
			varurl="userdata.php?value=like&u_name="+username+"&v_id="+v_id[1];
			sendtoserver(varurl,setlike);
		}
		else if(type==2)
		{
			varurl="userdata.php?value=dislike&u_name="+username+"&v_id="+v_id[1];
			sendtoserver(varurl,setdislike);
		}
		else if(type==3)
		{
			var text=document.getElementById("comment-box").value;
			//document.getElementById("myTextarea").disabled = true;
			varurl="userdata.php?value=comment&u_name="+username+"&v_id="+v_id[1]+"&text="+text;
			sendtoserver(varurl,setcomment);
		}
		else if(type==4)
		{
			varurl="userdata.php?value=views&u_name="+username+"&v_id="+v_id[1];
			//console.log("hello");
			sendtoserver(varurl,setviews);
		}
		else if(type==5)
		{
			varurl="userdata.php?value=chklikedislike&u_name="+username+"&v_id="+v_id[1];
			//console.log("hello");
			sendtoserver(varurl,setlikedislikebutton);
		}
	
	}	
	if(type==6)
	{
		varurl="userdata.php?value=views&v_id="+v_id[1];
		sendtoserver(varurl,setviews);
	}
}
function setlike(serverresponse)
{
	serverresponse=serverresponse.split(",");
	document.getElementById("like-text").innerHTML=serverresponse[0];
	document.getElementById("dislike-text").innerHTML=serverresponse[1];
	setlikedislikebutton(serverresponse[2]);
}
function setdislike(serverresponse)
{
	serverresponse=serverresponse.split(",");
	document.getElementById("like-text").innerHTML=serverresponse[0];
	document.getElementById("dislike-text").innerHTML=serverresponse[1];
	setlikedislikebutton(serverresponse[2]);
}
function setlikedislikebutton(serverresponse)
{
	if(serverresponse=="-1")
	{
		document.getElementById("likebutton").style.color="grey";
		document.getElementById("dislikebutton").style.color="#66a3ff";
	}
	else if(serverresponse=="0")
	{
		document.getElementById("likebutton").style.color="grey";
		document.getElementById("dislikebutton").style.color="grey";
	}
	else if(serverresponse=="1")
	{
		document.getElementById("likebutton").style.color="#66a3ff";
		document.getElementById("dislikebutton").style.color="grey";
	}
}
function setcomment(serverresponse)
{
	var imageSource=document.getElementById("imgsrc").src;
	var commentText=document.getElementById("comment-box").value;
	document.getElementById("comment-box").value="";
	var textToAppend='<div>\
						<span class="comment-userpic"><img src='+imageSource+' width="30"></span>\
						<span class="comment-username">'+getCookie("username")+'</span><br>\
						<div class="comment-text">'+commentText+'</div>\
					 </div><br>';
	$("#other-comments" ).prepend(textToAppend);
}
function setviews(serverresponse)
{
	document.getElementById("video-views").innerHTML=serverresponse+" views";
}
function initialize()
{
	videoObj=document.getElementById("video-screen");
	videoObj.play();
	videoObj.focus();
	calltype(6);
}
function eventControls(event)
{
	event.preventDefault();
	if(event.keyCode==32)//space
	{
		//console.log(event.keyCode);
		if(videoObj.paused==true)
		{
			//console.log("1");
			videoObj.play();
		}
		else
		{	
			//console.log("2");
			videoObj.pause();
		}
	}
	if(event.keyCode==39)//right
	{
		if(videoObj.currentTime<(videoObj.duration-10))
			videoObj.currentTime+=10;
		
	}
	else if(event.keyCode==37)//left
	{
		if(videoObj.currentTime>10)
			videoObj.currentTime-=10;
		
	}
	else if(event.keyCode==38)//up
	{
		if(videoObj.volume<=0.8)
			videoObj.volume+=0.2;
		
	}
	else if(event.keyCode==40)//down
	{
		if(videoObj.volume>=0.2)
			videoObj.volume-=0.2;
	}
	else if(event.keyCode==77)//m
	{
		if(videoObj.muted)
		{
			videoObj.muted=false;
		}
		else
			videoObj.muted=true;
	}

}
function focusNow()
{
	videoObj.focus();
	if(videoObj.paused)
	{
		videoObj.play();
	}
	else
		videoObj.pause();
}
function showMoreLess()
{
	var showStatus = document.getElementById("show-more-less").innerHTML;
	if(showStatus=="SHOW MORE")
	{
		document.getElementById("desciption-text-less").style.display="none";
		document.getElementById("desciption-text-full").style.display="block";
		document.getElementById("show-more-less").innerHTML = "SHOW LESS";
	}
	else
	{
		document.getElementById("desciption-text-less").style.display="block";
		document.getElementById("desciption-text-full").style.display="none";
		document.getElementById("show-more-less").innerHTML = "SHOW MORE";
	}
	
}

</script>
<body onload="initialize()">
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
					<li><a href="index.php"><button class="sidepane-button"><span class="glyphicon glyphicon-home"></span> Home</button></a></li>
					<li><a href="trending.php"><button class="sidepane-button"><span class="glyphicon glyphicon-fire"></span> Trending</button></a></li>
					<li><a href="myspace.php"><button class="sidepane-button"><span class="glyphicon glyphicon-user"></span> Myspace</button></a></li>
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
			<div class="col-xs-7" id="main-body">
				
				<?php
					if(isset($_GET['vid']))
					{
						$value=$_GET['vid'];
						$sql = "select b.views views,b.upload_time upload_time,b.likes likes,b.dislikes dislikes,b.video_description video_description,b.video_path video_path,c.user_profilepic user_profilepic,c.user_username user_username,b.video_name video_name from videos b join GUser c on b.user_id=c.user_id where b.video_id=$value";
					}
					$result = $conn->query($sql);
					$row=$result->fetch_assoc();
					?>
				<div id="video-area">
					<video id="video-screen"  onkeydown="eventControls(event)" onclick="focusNow()" controls>
					  <source src=<?php echo $row['video_path']; ?> type="video/mp4">
					</video>
				</div>
				<br>
				<div id="video-details">
					<div id="video-name">
						<?php echo $row['video_name'];?>
					</div>
					<br>
					<div id="video-uploader">
						<img src=<?php echo $row['user_profilepic']; ?> width="35"> <?php echo $row['user_username']; ?>
					</div>
					<div id="video-views">
						<?php echo $row['views']; ?> views
					</div>
					<hr>
					<div id="video-likesdislikes">
						<button onclick="calltype(1)" class="likedislikebutton"><span id="likebutton" class="glyphicon glyphicon-thumbs-up"></span></button> <span id="like-text"> <?php echo $row['likes']; ?> </span> <button onclick="calltype(2)" class="likedislikebutton"><span id="dislikebutton" class="glyphicon glyphicon-thumbs-down"></span></button> <span id="dislike-text"> <?php echo $row['dislikes']; ?> </span> 
					</div>
				</div>
				<br>
				<div id="video-description">
					<div id="desciption-text-less">
						<b>Uploaded On <?php echo $row['upload_time']; ?></b>
						<br>
						<br>
						<?php echo substr($row['video_description'],0,strpos($row['video_description'], "<br />",strpos($row['video_description'], "<br />"))+7)."...."; ?>
					</div>
					<div id="desciption-text-full" style="display:none;">
						<b>Uploaded On <?php echo $row['upload_time']; ?></b>
						<br>
						<br>
						<?php echo $row['video_description']; ?>
					</div>
					<br>
					<br>
					<button id="show-more-less" onclick="showMoreLess()">SHOW MORE</button>
				</div>
				<br>
				<div id="comment-area">
					<!--Comments : <span id="comment-numbers"><span><br><br>-->
					<textarea rows="3" id="comment-box"></textarea>
					<div id="comment-button-area">
						<button id="comment-button" onclick="calltype(3)">Comment</button>
					</div>
					<hr>
					<div id="other-comments">
						<?php
							$sql = "select b.text text,c.user_profilepic user_profilepic,c.user_username user_username from comments b 
							join GUser c on b.user_id=c.user_id where b.video_id=$value order by comment_time desc";
							$result = $conn->query($sql);
							while($row=$result->fetch_assoc()) 
					   		{
						?>
								<div>
									<span class="comment-userpic"><img src=<?php echo $row['user_profilepic']; ?> width="30"> </span>
									<span class="comment-username"> <?php echo $row['user_username']; ?></span>
									<br>
									<div class="comment-text">
										<?php echo $row['text']; ?>
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
