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
	#upload-area{
		text-align: center;
		margin-top: 20px;
	}
	#upload-result{
		text-align: center;
	}
	input[type=file]{
		display: inline-block;
		border: 2px solid #66a3ff; 
	}
	#upload-button{
		background: none;
		color: grey;
		border: 2px solid #66a3ff;
		width:120px;
		height:40px;
		font-size: 1.2em;
	}
	#myspace{
		background: grey;
		color: white;
	}
	textarea{
		resize:none;
	}
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
	#category-list
	{
		background: none;
		color:grey;
		border: 2px solid #66a3ff;
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
  function resetUpload()
  {
  	document.getElementById("upload-button").value="Upload";
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
					<li><a href="index.php"><button class="sidepane-button"><span class="glyphicon glyphicon-home"></span> Home</button></a></li>
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
					<a href="upload.php"><u>Upload</u></a>&nbsp;&nbsp;<a href="uploaded.php">Uploaded</a>&nbsp;&nbsp;
					<a href="statistics.php">Stats</a>
				</div>
				<div id="upload-area">
					<form action="upload.php" method="post" enctype="multipart/form-data">
						<input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="123" />
					    Select a video to upload:
					    <br>
					    <br>
					    <input type="file" name="fileToUpload[]" multiple="multiple" id="browse-button" onclick="resetUpload()">
					    <br>
					    <br>
					    <select id="category-list" name="category">

					    	<option value="CSE401">Advanced Algorithms</option>
					    	<option value="ECE415">Advanced VLSI</option>
					    	<option value="ICS200">Algorithms</option>
					    	<option value="ECE444">Applied Signal Processing</option>
					    	<option value="CSE340">Artificial Intelligence</option>
						    <option value="APS">Advanced Problem Solving</option>
						    <option value="IEC102">Basic Electronic Circuits</option>
						    <option value="ISK200">Commumnication Skills-I</option>
					    	<option value="ISK201">Commumnication Skills-II</option>
					    	<option value="ISK202">Commumnication Skills-III</option>
					    	<option value="ISK203">Commumnication Skills-IV</option>
					    	<option value="ISK300">Commumnication Skills-V</option>
					    	<option value="ECE450">Communication System Design</option>
					    	<option value="CSE402">Compilers</option>
					    	<option value="IEC255">Computer and Communication Networks</option>
					    	<option value="ICS110">Computer Organisation</option>
					    	<option value="ICS100">Computer Programming</option>
						    <option value="CSE405">Computer Systems Security</option>
					    	<option value="CSE330">Database Management Systems</option>
					    	<option value="ICS101">Data Structures</option>
					    	<option value="MAT301">Differential Equations</option>
					    	<option value="IEC101">Digital Design and Electronic Circuits</option>
						    <option value="ECE442">Digital Image Processing</option>
							<option value="IEC240">Digital Signal Analysis and Applications</option>
							<option value="ECE341">Digital Signal Processing</option>
							<option value="ECE401">Electromagnet Theory</option>
							<option value="IEC311">Embedded and Intelligent Systems</option>
							<option value="IEC250">Fundamentals of Communication</option>
							<option value="GE">Good Earth</option>
							<option value="GST">Guest Talks</option>
							<option value="CSE410">High Performance Computing</option>
							<option value="CSE435">Information Retrieval</option>
					    	<option value="ECE421">Information Theory and Coding</option>
					    	<option value="MAT300">Introduction to Optimization</option>
							<option value="ECE315">Introduction to VLSI</option>
							<option value="IIW100">IT Workshop-I</option>
					    	<option value="IIW101">IT Workshop-II</option>
					    	<option value="IIW200">IT Workshop-III</option>
					    	<option value="IIW300">IT Systems</option>
							<option value="ECE303">Linear Electronic Circuits</option>
					    	<option value="IMA100">Mathematics-I</option>
					    	<option value="IMA101">Mathematics-II</option>
					    	<option value="IMA200">Mathematics-III</option>
					    	<option value="ECE430">Measurements and Instrumentation</option>
					    	<option value="ECE440">Modern Control Systems</option>
							<option value="NWK">Networking</option>
							<option value="ICS220">Operating Systems</option>
							<option value="MAT302">Operational Mathematics</option>
					    	<option value="OTH">Others</option>
							<option value="CSE403">Programming Systems</option>
							<option value="CSE450">Software Engineering</option>
							<option value="ECE443">Speech Signal Processing</option>
							<option value="CSE400">Theory of Computation</option>
							<option value="ECE451">Wireless Communication</option>
							<option value="YW">You And The World</option>
					    </select>
					 <!--   <br>
					    <br>
					    <input type="text" name="filename" placeholder="Change Name"><br>
					    (Note:leave blank for default file name)-->
					    <br>
					    <br>
					    <textarea name="description" placeholder="Video Description" rows="4" cols="50"></textarea>
					    <br>
					    <br>
					    <input type="submit" name="submit" id="upload-button" value="Upload">
					</form>
				</div>
				<br>
				<div id="upload-result">
					<?php
						//if(isset($_POST['fileToUpload']))
						$total = count($_FILES['fileToUpload']['name']);

						$target_dir = "/var/www/pixeo/Videos/";

						for($i=0; $i<$total; $i++) {

							$videoname=$_FILES["fileToUpload"]["name"][$i];
							$videoname1=$videoname;
							$videoname=str_replace("'","", $videoname); // to remove single quotes from name because ffmpeg doesn't support it.

							$target_file = $target_dir . $videoname;

							if($_FILES["fileToUpload"]["name"][$i]!="")
							{
								//echo "hello";
								//if($_POST['filename']!='')
								//	$target_file = $target_dir.$_POST['filename'];
								$uploadOk = 1;
								if ($uploadOk == 0) {
								    echo "Sorry, your file was not uploaded.";
								// if everything is ok, try to upload file
								} 
								else {
								    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
								        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
								        $username=$_COOKIE['username'];
										$sql="select user_id from GUser where user_username='".$username."';";
										$result=$conn->query($sql);
										
									 	while($row=$result->fetch_assoc()) 
									   	{
									   		$user_id=$row['user_id'];
									   	}
									   	
									   //	if($_POST['filename']!='')
										//	$videoname = $_POST['filename'];
										if($_POST['description']!='')
										{
											
											$description=nl2br($_POST['description']);
											$description=str_replace("'","\'", $description);
										}
										if($_POST['category']!='')
										{
											$category=$_POST['category'];
										}
										else
										{
											$category="OTH";
										}
										
									   	$thumbnailpath="'Thumbnails/".substr($videoname,0,strlen($videoname)-3)."jpg'";
									   	$videopath="'Videos/".$videoname."'";
									   	$exec_ffmpeg="ffmpeg -i ".$videopath." -ss 00:00:10 -vframes 1 ".$thumbnailpath;
							    		exec($exec_ffmpeg);
							   
							    		$exec_ffprobe="ffprobe -v error -show_entries format=size -of default=noprint_wrappers=1:nokey=1 ".$videopath;
							    		$video_size=(float)exec($exec_ffprobe);
							    		$video_size=$video_size/1000000;

							    		$thumbnailpath="\'Thumbnails/".substr($videoname,0,strlen($videoname)-3)."jpg\'";
							    		$videopath="\'Videos/".$videoname."\'";
							    		$videoname=substr($videoname,0,strlen($videoname)-4);
							    		$videoname1=substr($videoname1,0,strlen($videoname1)-4);

							    		$videoname=str_replace("'","\'", $videoname1);

									   	$sql="insert into videos(video_name,video_path,user_id,videothumbnail_path,video_size,video_description,category_id) 
									   	values ('$videoname','$videopath',$user_id,'$thumbnailpath',$video_size,'$description','$category');";
									    if ($conn->query($sql) === TRUE) {
	    									
										} else {
										   echo $conn->error;
										}
									   	?>
									   	<script>document.getElementById("upload-button").value="Uploaded";</script>
									   	<?php

								    } 
								    else {
								        echo "Sorry, there was an error uploading your file.";
								    }
								}
								
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
