<?
include('session.php');
if (isset($_POST['action']))
{
    if ($_POST['action'] == "submit")
	{
		$userid = mysqli_real_escape_string($connection, $login['id']);
		$name = mysqli_real_escape_string($connection, $_POST['name']);
		$venmousername = mysqli_real_escape_string($connection, $_POST['venmousername']);
		$contactnumber = mysqli_real_escape_string($connection, $_POST['contactnumber']);
		$address1 = mysqli_real_escape_string($connection, $_POST['address1']);
		$address2 = mysqli_real_escape_string($connection, $_POST['address2']);
		$address3 = mysqli_real_escape_string($connection, $_POST['address3']);
		$bio = mysqli_real_escape_string($connection, $_POST['bio']);
		if(!preg_match("/^[a-zA-Z ]*$/",$name))
		{
			$class = "has-error";
			$message = '<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			Your name is invalid. Only letters and white space allowed.
			</div>';
		}
		elseif(!preg_match('/^[0-9]{10}+$/',$contactnumber))
		{
			$class = "has-error";
			$message = '<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			Your contact number is invalid. Only 10 digits allowed (without hyphen).
			</div>';
		}
		else
		{
			mysqli_query($connection, "UPDATE users SET name='$name', venmousername='$venmousername', contactnumber='$contactnumber', address1='$address1', address2='$address2', address3='$address3', bio='$bio' where id='$userid'");
			$login=mysqli_query($connection,"SELECT * FROM users WHERE id='$userid'");
			$login=mysqli_fetch_assoc($login);
			$class = "has-success";
			$message = '<div class="alert alert-success alert-dismissible" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Profile updated successfully</strong>
			</div>';
		}
    }
}
if ($_GET['action'] == "incomplete")
{
	$class = "has-error";
	$message = '<div class="alert alert-danger" role="alert">
	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	Please update your profile settings before submitting product or contact seller
	</div>';
}
if ($_GET['action'] == "productdeleted")
{
	$class = "has-success";
	$message = '<div class="alert alert-success alert-dismissible" role="alert">
	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Product deleted successfully <a href="index.php">Check homepage</a></strong>
	</div>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>Profile settings - <?=$site_name?></title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
<? include('navbar.php'); ?>
<div class="container">
<? echo $message; ?>
<form class="<? echo $class; ?>" action="" method="post" enctype="multipart/form-data">
<legend>Profile settings</legend>
<div class="row">
<div class="col-xs-12 col-md-4">
<div class="form-group" align="center">
<a href="/displaypicture.php">
<?
if($login['displaypicture']!='')
	echo '<img class="img-responsive img-circle" src="https://i0.wp.com/'.$_SERVER["HTTP_HOST"].'/uploads/displaypictures/'.$login['displaypicture'].'?w=200&h=200" alt="..." width="200">';
else
	echo '<img class="img-responsive img-circle" src="https://i0.wp.com/'.$_SERVER["HTTP_HOST"].'/uploads/displaypictures/default.jpg?w=200&h=200" alt="..." width="200">';
?>
</a>
<br>
<div class="btn-group">
	<a href="/displaypicture.php" class="btn btn-success">Change Display Picture</a>
</div>
<br><br>
<div class="btn-group">
	<a href="/user.php?userid=<?=$login['id']?>" class="btn btn-primary">View Profile</a>
</div>
</div>
</div>
<div class="col-xs-12 col-md-8">
<div class="form-group">
<label for="name">Full Name</label>
<input type="text" class="form-control" id="name" name="name" placeholder="Type your full name" value="<?=$login['name']?>" required autofocus>
</div>
<div class="form-group">
<label for="email">Email address</label>
<input type="email" class="form-control" id="email" name="email" value="<?=$login['email']?>" disabled>
</div>
<div class="form-group">
<label for="venmoUsername">Venmo Username</label>
<div class="input-group">
<span class="input-group-addon">@</span>
<input type="text" class="form-control" id="venmoUsername" name="venmousername" placeholder="Type your Venmo username" value="<?=$login['venmousername']?>">
</div>
</div>
<div class="form-group">
<label for="contactNumber">Contact Number</label>
<input type="text" class="form-control" id="contactNumber" name="contactnumber" placeholder="xxxxxxxxxx" value="<?=$login['contactnumber']?>" required>
</div>
<div class="form-group">
<label for="address">Address</label>
<input type="location" class="form-control" id="address" name="address1" placeholder="Address line #1" value="<?=$login['address1']?>" required>
<input type="location" class="form-control" id="address" name="address2" placeholder="Address line #2" value="<?=$login['address2']?>" required>
<input type="location" class="form-control" id="address" name="address3" placeholder="Address line #3" value="<?=$login['address3']?>">
</div>
<div class="form-group">
<label for="address">Bio</label>
<textarea class="form-control" id="bio" name="bio" rows="8" placeholder="Computer Science, 2021 (Proud Drexel Student and Drexsell Member)" required><?=$login['bio']?></textarea>
</div>
<button type="submit" class="btn btn-primary" name="action" value="submit">Submit</button>
</div>
</div>
</form>
</div>
<? include('footer.php'); ?>
</body>
</html>
