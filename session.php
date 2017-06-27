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
if(!isset($login['id']))
{
	header('Location: login.php?location='.urlencode($_SERVER['REQUEST_URI']));
}
if($login['status']=='0')
{
	header("location: activate.php?email=".$login['email']."&status=0");
}
?>