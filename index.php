<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="Get Instagram profile picture at full size and other user info">
	<title>INSTA PWNED</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		.propic {
		    border: 1px solid #ddd;
		    border-radius: 3px;
		    padding: 3px;
		    max-width: 100%;
		    height: auto;
		    width: auto;
		}
		.footer {
		    position: absolute;
		    bottom: 0;
		    width: 100%;
		    height: 60px;
		    line-height: 60px;
		    background-color: #f5f5f5;
		}
	</style>
</head>
<body>
<div class="container">

<?php

if(!isset($_POST['username']) || $_POST['username'] == "")
{
	echo '<h1>INSTA PWNED</h1>
		<form action="" method="POST">
			<div class="input-group mb-3">
				<input type="text" name="username" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
			</div>
			<input type="submit" value="SEARCH" class="btn btn-primary">
			<br><br><small class="text-muted">INSTA PWNED is not affiliated with Instagram™</small>
		</form></div>
		';
		
	die('<footer class="footer">
		  <div class="container">
			<span class="text-muted">
				<a href="https://github.com/Alexzava/instapwned"><img src="https://image.flaticon.com/icons/svg/25/25231.svg" width="30px"/> Source Code</a>
				<span style="float: right">Made with <img src="https://image.flaticon.com/icons/svg/148/148836.svg" width="25px"/> by Alexzava.</span>
			</span>
		  </div>
		</footer>');
}

$html = file_get_contents('https://instagram.com/'.$_POST['username']);

//Get user ID
$subData = substr($html, strpos($html, 'window._sharedData'), strpos($html, '};', $startPos));
$userID = strstr($subData, '"id":"');
$userID = str_replace('"id":"', '', $userID);
$userID = strstr($userID, '"', true);

//Download user info
$jsonData = file_get_contents('https://i.instagram.com/api/v1/users/'.$userID.'/info/');
$decodedInfo = json_decode($jsonData);

$username = $decodedInfo->user->username;
$profilePic = $decodedInfo->user->hd_profile_pic_url_info->url;
$follower = $decodedInfo->user->follower_count;
$following = $decodedInfo->user->following_count;
$full_name = $decodedInfo->user->full_name;
$isPrivate = $decodedInfo->user->is_private;
$isVerified = $decodedInfo->user->is_verified;
$bio = $decodedInfo->user->biography;

//Print info
echo '<br><a href="index.php" class="btn btn-primary">BACK</a><br><br>';

echo '<b>Username:</b> '.$username.'<br>';
//echo 'User ID: '.$userID.'<br>';
echo '<b>Full Name:</b> '.$full_name.'<br>';
echo '<b>Profile Picture (HD):</b> <a href="'.$profilePic.'">OPEN</a><br>';
echo '<b>Biography:</b> '.$bio.'<br>';
echo '<b>Follower:</b> '.$follower.'<br>';
echo '<b>Following:</b> '.$following.'<br>';
if($isPrivate)
	echo '<b>Private Profile:</b> SI<br>';
else
	echo '<b>Private Profile:</b> NO<br>';

if($isVerified)
	echo '<b>Verified:</b> SI<br>';
else
	echo '<b>Verified:</b> NO<br><br>';

echo '<img class="propic" src="'.$profilePic.'"/><br><br>';

?>
</div>
</body>
</html>
