<?
include('phpheader.php');
session_start();
if(isset($_SESSION['userid']))
{
	$session_userid=$_SESSION['userid'];
	$login=mysqli_query($connection,"SELECT * FROM users WHERE id='$session_userid'");
	$login=mysqli_fetch_assoc($login);
}
if(isset($_COOKIE['drexsell']))
{
	$cookie=$_COOKIE['drexsell'];
	$login=mysqli_query($connection,"SELECT * FROM users WHERE password='$cookie'");
	$login=mysqli_fetch_assoc($login);
	$_SESSION['userid'] = $login['id'];
}
if(isset($_GET['action']))
{
    if($_GET['action']=="activate")
    {
        $encrypt = mysqli_real_escape_string($connection, $_GET['encrypt']);
        $email = mysqli_real_escape_string($connection, $_GET['email']);
        $users = mysqli_query($connection, "SELECT * FROM users WHERE email='$email'");
        $users = mysqli_fetch_array($users);
        if(count($users)>=1)
        {
			if (password_verify($users['email'], $encrypt))
			{
				mysqli_query($connection, "UPDATE users SET status='1' where email='$email'");
				header("location: activate.php?action=success");
			}
			else
			{
				header("location: activate.php?action=error");
			}
        }
		else
		{
			header("location: activate.php?action=error");
		}
    }
}
if(isset($_POST['action']))
{
	if($_POST['action']=="submit")
	{
		$email = mysqli_real_escape_string($connection, $_POST['email']);
		$users = mysqli_query($connection, "SELECT * FROM users WHERE email='$email'");
		$users = mysqli_fetch_array($users);
		if($users>=1)
		{
			if($users['status']=='1')
			{
				$class = "has-success";
				$message = '<div class="alert alert-success" role="alert">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<strong>Your account is already activated. <a href="login.php">Login Now</a></strong>
				</div>';
			}
			else
			{
				$encrypt = password_hash($email, PASSWORD_BCRYPT);
				$to = $users['name']." <".$email.">";
				$subject="Account Activation - Drexsell";
				$from = "Drexsell.com <admin@drexsell.com>";
				$body='Hi '.$users['name'].',<br><br>Click the link to activate your account <a href="https://'.$_SERVER["HTTP_HOST"].'/activate.php?email='.$email.'&encrypt='.$encrypt.'&action=activate">https://'.$_SERVER["HTTP_HOST"].'/activate.php?email='.$email.'&encrypt='.$encrypt.'&action=activate</a><br><br>Thank you,<br>Drexsell.com Team<br><br><img src="https://'.$_SERVER["HTTP_HOST"].'/images/logo.png" alt="Drexsell.com">';
				$headers = "From: " . $from . "\r\n";
				$headers .= "Reply-To: ". $from . "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				mail($to,$subject,$body,$headers,'-fadmin@drexsell.com');
	 
				$class = "has-success";
				$message = '<div class="alert alert-success" role="alert">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<strong>Your account activation link has been send to your email address! Check your email and <a href="login.php">Login Now</a></strong>
				</div>';
			}
		}
        else
        {
			$class = "has-error";
            $message = '<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			Invalid email address
			</div>';
        }
	}
}
if ($_GET['action'] == "success")
{
	$class = "has-success";
	$message = '<div class="alert alert-success" role="alert">
	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	<strong>Account activated successfully! <a href="login.php">Login Now</a></strong>
	</div>';
}
if ($_GET['action'] == "error")
{
	$class = "has-error";
	$message = '<div class="alert alert-danger" role="alert">
	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	Invalid key, please try again
	</div>';
}
if ($_GET['status'] == "0")
{
	$class = "has-error";
	$message = '<div class="alert alert-error" role="alert">
	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	<strong>Your account is not activated. Your account activation link was send to your email address! Check your email to activate your account. You can type your email address above to resend email.</strong>
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
<title>Account Activation - <?=$site_name?></title>
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
<form class="<? echo $class; ?>" action="activate.php" method="post">
<h2>Account Activation</h2>
<div class="row">
<div class="col-xs-12 col-md-6">
<div class="form-group">
<label for="inputEmail">Email address</label>
<input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email" value="<?=$_GET['email']?>" required>
</div>
</div>
</div>
<button type="submit" class="btn btn-primary" name="action" value="submit" <?if($users['status']=='1') echo disabled;?>>Submit</button>
</form>
</div>
<? include('footer.php'); ?>
</body>
</html>