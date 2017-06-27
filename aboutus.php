<?
include('session.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>About Us - <?=$site_name?></title>
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
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">About Us</h1>
	</div>
</div>

<div class="media">
<h4>Shivansh Suhane</h4>
<h6>Project Architect and Developer</h6>
    <span class="media-left">
        <img src="/images/aboutus/shivansh.jpg" width="120p" alt="...">
    </span>
    <div class="media-body">
        <p class="media-heading">The person who wireframed and designed the website. He's a programmer and web developer who enjoys a diverse array of hobbies, including building programming, playing piano and video games. Have some suggestions? Shoot him a email at ss4328@drexel.edu</p>
    </div>
</div>
<hr>

<div class="media">
<h4>Summit Singh Thakur</h4>
<h6>Project Manager and Developer</h6>
    <span class="media-left">
        <img src="/images/aboutus/summit.jpg" width="120p" alt="...">
    </span>
    <div class="media-body">
        <p class="media-heading">The person in-charge of your data and the back-end of the website. He enjoys rap-music and travelling around Philly.  If you find any weird-behaviour with the website, you can find him at st866@drexel.edu</p>
    </div>
</div>
<hr>

<div class="media">
<h4>Chirayu Prahlad</h4>
<h6>Head of Marketing</h6>
    <span class="media-left">
        <img src="/images/aboutus/chirayu.jpg" width="120p" alt="...">
    </span>
    <div class="media-body">
        <p class="media-heading">Found some flyers where they shouldn't be? This man is to blame! Chirayu is in-charge of the Marketing aspects of Drexsell and enjoys playing Pokemon and FIFA. Shoot him an email at cp676@drexel.edu.</p>
    </div>
</div>
<hr>

<div class="media">
<h4>Matthew London</h4>
<h6>Public Relations</h6>
    <span class="media-left">
        <img src="/images/aboutus/matt.jpg" width="120p" alt="...">
    </span>
    <div class="media-body">
        <p class="media-heading">Matt is in-charge of the public relations and is the one who came up the funky name for our platform. Without him, this wouldn't have been possible! His ID is mcl97@drexel.edu</p>
    </div>
</div>
<hr>

</div>
<? include('footer.php'); ?>
</body>
</html>