<?
include('session.php');
if (isset($_POST['action']))
{
    if ($_POST['action'] == "submit")
	{
		if($_POST['password'] == $_POST['password2'])
		{
            $userid = mysqli_real_escape_string($connection, $login['id']);
			$password = mysqli_real_escape_string($connection, password_hash($_POST['password'], PASSWORD_BCRYPT));
            mysqli_query($connection, "UPDATE users SET password='$password' WHERE id='$userid'");
			$class = "has-success";
			$message = '<div class="alert alert-success" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<strong>Password updated successfully. <a href="profile.php">Check profile</a></strong>
			</div>';
		}
		else
		{
			$class = "has-error";
			$message = '<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			Both passwords must be same
			</div>';
		}
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>Password settings - <?=$site_name?></title>
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
<form class="<? echo $class; ?>" action="password.php" method="post" enctype="multipart/form-data">
<legend>Change Password</legend>
<div class="row">
<div class="col-xs-12 col-md-6">
<div class="form-group">
<label for="password">Password</label>
<input type="password" class="form-control" id="password" name="password" placeholder="Type here to change password" required autofocus>
<input type="password" class="form-control" id="password" name="password2" placeholder="Type again" required>
</div>
</div>
</div>
<button type="submit" class="btn btn-primary" name="action" value="submit">Submit</button>
</form>
</div>
<? include('footer.php'); ?>
</body>
</html>
