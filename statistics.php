<?php if($_COOKIE['username']!="''")
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
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
		padding-top: 5vh;
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
	#main-body-content{
		margin-top: 20px;
		text-align: center;
		font-size: 1.2em;
		color: grey;
		font-weight: bold;
	}
	#chart_div{
		display: inline-block;
		width: 100%;
		height:30vh;
		min-height: 200px;
		overflow-x:scroll;
		overflow-y:hidden;    
	}
</style>
<script>
var count=0;
document.cookie = "username=''";
// Load the Visualization API and the corechart package.
//google.charts.load('current', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
//google.charts.setOnLoadCallback(drawLineChart);

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
	  document.getElementById("profilename").innerHTML=profile.getName();
	  document.getElementById("profilepic").src=profile.getImageUrl();
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
			</div>
			<div class="col-xs-9" id="main-body">
				<div id="main-body-header">
					<img id="profilepic" src="" width="80">
					<br>
					<br>
					<div id="profilename"></div>
				</div>
				<div id="main-body-linkpanel">
					<a href="upload.php">Upload</a>&nbsp;&nbsp;<a href="uploaded.php">Uploaded</a>&nbsp;&nbsp;
					<u><a href="statistics.php">Stats</a></u>
				</div>
				<div id="main-body-content">
					<?php
					$servername = "localhost";
					$username = "root";
					$password = "ravi";
					$dbname = "pixeo";
					$conn = new mysqli($servername, $username, $password, $dbname);
					if ($conn->connect_error) {
					    die("Connection failed: " . $conn->connect_error);
					}
					$uname=$_COOKIE['username'];
					$sql="select user_id from GUser where user_username='$uname'";
					$result=$conn->query($sql);
					$row=$result->fetch_assoc();
					$uid=$row['user_id'];
					$sql = "select sum(video_size) total_size,count(video_id) num_uploads from videos where user_id=$uid";
					$result = $conn->query($sql);
					$row=$result->fetch_assoc();
					$sql = "select upload_time ,video_size from videos where user_id=$uid";
					$result = $conn->query($sql);
					?>
					<script type="text/javascript">

				      // Load the Visualization API and the corechart package.
				      google.charts.load('current', {'packages':['corechart']});

				      // Set a callback to run when the Google Visualization API is loaded.
				      google.charts.setOnLoadCallback(drawLineChart);
				      // Callback that creates and populates a data table,
				      // instantiates the pie chart, passes in the data and
				      // draws it.
				      // To create pie chart to show space used by user
				      function drawLineChart() {

				        // Create the data table.
				        var data = new google.visualization.DataTable();
				        data.addColumn('string', 'Topping');
				        data.addColumn('number', 'Slices');
				        data.addRows([
				        <?php while($row2=$result->fetch_assoc())
				        	  {	
				        ?>
				        		["<?php echo $row2['upload_time']; ?>", <?php echo (float)$row2['video_size'];?>],
				        <?php 
				        	 }
				        ?>
		
				        ['end',0]]);
				        // Set chart options
				        var options = {'title':''
				                       };
				        // Instantiate and draw our chart, passing in some options.
				        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
				        chart.draw(data, options);
				      }
    				</script>
    				<br>
    				<br>
					Total Uploads&nbsp;:&nbsp;<?php echo round($row['num_uploads'],1);?>
					<br>
					Total Space Occupied&nbsp;:&nbsp;<?php echo round($row['total_size'],1);?> MB
					<br>
					<br>
					<div id="chart_div"></div>
					<br>
					<b>Your Uploads In This Year</b>
					<br>
					<br>
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