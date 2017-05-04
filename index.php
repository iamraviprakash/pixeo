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
	}
	#signout{
		background: white;
		border-width: 0px;
		width:90px;
		height:30px;
		color: grey;
		font-size: 0.9em;
	}
	#sidepane{
		position: fixed;
		height:90vh;
		background-color:white;
		margin-top: 10vh;
		padding-top: 10px;
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
	#home{
		background: #66a3ff;
		color: white;
	}
</style>
<script>
function onSignIn(googleUser) {
	  var profile = googleUser.getBasicProfile();
	  console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
	  console.log('Name: ' + profile.getName());
	  console.log('Image URL: ' + profile.getImageUrl());
	  console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
}
function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.disconnect().then(function () {
      console.log('User signed out.');
    });
  }
</script>
<body>
	<div class="container-fluid">
		<div class="row" id="header">
			<div class="col-xs-8">
			</div>
			<div class="col-xs-1">
				<span class="g-signin2" data-onsuccess="onSignIn" style="width:90px;height:30px;">
				</span>
			</div>
			<div class="col-xs-1">
				<button onclick="signOut()" id="signout">Sign Out</button>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-2" id="sidepane">
				<ul type="none">
					<li><a href="index.php"><button class="sidepane-button" id="home"><span class="glyphicon glyphicon-home"></span> Home</button></a></li>
					<li><a href="trending.php"><button class="sidepane-button"><span class="glyphicon glyphicon-fire"></span> Trending</button></a></li>
					<li><a href="myspace.php"><button class="sidepane-button"><span class="glyphicon glyphicon-user"></span> Myspace</button></a></li>
					<li><a href="history.php"><button class="sidepane-button"><span class="glyphicon glyphicon-hourglass"></span> History</button></a></li>
					<hr>
					<li><a href="liked_videos.php"><button class="sidepane-button"><span class="glyphicon glyphicon-thumbs-up"></span> Liked Videos</button></a></li>
					<hr>
				</ul>
			</div>
			<div class="col-xs-9">
			</div>
		</div>
	</div>
</body>
</html>