<?
include('session.php');

if ($_GET['userid'] == '') {
header('Location: /index.php'); }

$userid = mysqli_real_escape_string($connection, $_GET['userid']);
$user = mysqli_query($connection,"SELECT * FROM users WHERE id = '$userid' LIMIT 1");
$user = mysqli_fetch_array($user);

if (isset($_POST['action'])) {
    if ($_POST['action'] == "sendmessage") {
		$to = $user['name'].' <'.$user['email'].'>';
		$subject = $login['name'].' has sent you contact information - Drexsell';
		$from = $login['name'].' <'.$login['email'].'>';
		$body='Hi '.$user['name'].',<br><br>'.$login['name'].' has sent you contact information.<br><br><a href="https://'.$_SERVER["HTTP_HOST"].'/user.php?userid='.$login['id'].'">Click here to check '.$login['name'].'\'s active products.</a><br><br>==================================================================<br>Below is the message sent by '.$login['name'].':<br>==================================================================<br><br>'.$_POST['message-text'].'<br><br>==================================================================<br><br>Thank you,<br>Drexsell.com Team<br><br><img src="https://'.$_SERVER["HTTP_HOST"].'/images/logo.png" alt="Drexsell.com">';
		$headers = "From: " . $from . "\r\n";
		$headers .= "Reply-To: ". $from . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		mail($to,$subject,$body,$headers,'-f'.$login['email']);
		$message = '<div class="alert alert-success" role="alert">
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		<strong>Your message has been successfully sent to this user. User will reply you back if interested. <a href="index.php">Check homepage</a></strong>
		</div>';
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
	<title><?=$user['name']?> - <?=$site_name?></title>
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
        <div style="padding-top:50px;"></div>
        <div class="col-lg-3 col-md-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="media">
                        <div align="center">
							<?
							if($user['displaypicture']!='')
								echo '<img class="img-responsive img-circle" src="https://i0.wp.com/'.$_SERVER["HTTP_HOST"].'/uploads/displaypictures/'.$user['displaypicture'].'?w=200&h=200" alt="..." width="200">';
							else
								echo '<img class="img-responsive img-circle" src="https://i0.wp.com/'.$_SERVER["HTTP_HOST"].'/uploads/displaypictures/default.jpg?w=200&h=200" alt="..." width="200">';
							?>
                        </div>
						<br>
                        <div class="media-body">
						<a href="#" class="btn btn-link" style="text-decoration:none;"><i class="fa fa-lg fa-laptop" aria-hidden="true"></i></a><?=$user['permission']?>
						<a href="#" class="btn btn-link" style="text-decoration:none;"><i class="fa fa-lg fa-mortar-board" aria-hidden="true"></i></a><?=$user['type']?>
                            <hr>
                            <h3><strong>Bio</strong></h3>
                            <p><?=$user['bio']?></p>
                            <hr>
                            <h3><strong>Location</strong></h3>
                            <p><?=$user['address3']?></p>
                            <hr>
                            <h3><strong>Venmo Username</strong></h3>
                            <p>@<?=$user['venmousername']?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <span>
                        <h1 class="panel-title pull-left" style="font-size:30px;"><?=$user['name']?></h1>
                    </span>
                    <br><br>
					<?
					if($login['id']==$user['id'])
					{
						echo '
						<div class="btn-group">
							<a href="/profile.php" class="btn btn-warning">Edit Profile</a>
						</div>
						';
					}
					?>
					<?
					if($login['id']!=$user['id'])
					{
					?>
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Send Contact Information to <?=$user['name']?></button>
					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						<form action="" method="post">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="exampleModalLabel">New message</h4>
						  </div>
						  <div class="modal-body">
							  <div class="form-group">
								<label for="recipient-name" class="control-label">Recipient:</label>
								<input type="text" class="form-control" id="recipient-name" value="<?=$user['name']?>" disabled>
							  </div>
							  <div class="form-group">
								<label for="message-text" class="control-label">Message:</label>
								<textarea class="form-control" id="message-text" name="message-text" rows="10">
Email: <?=$login['email']?>

Venmo Username: <?=$login['venmousername']?>

Contact Number: <?=$login['contactnumber']?>

Address: <?=$login['address1']?>

<?=$login['address2']?>

<?=$login['address3']?></textarea>
							  </div>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary" name="action" value="sendmessage">Send message</button>
						  </div>
						</form>
						</div>
					  </div>
					</div>
					<?
					}
					?>
                    <br><br>
					<hr>
                    <span class="pull-left">
                        <!--<a href="#" class="btn btn-link" style="text-decoration:none;"><i class="fa fa-gift" aria-hidden="true"></i> active products</a>
                        <a href="#" class="btn btn-link" style="text-decoration:none;"><i class="fa fa-gift" aria-hidden="true"></i> sold products</a>-->
						<a href="#" class="btn btn-link" style="text-decoration:none;"><i class="fa fa-money" aria-hidden="true"></i> <?=$user['points']?> Drexsell Points</a>
                    </span>
                    <span class="pull-right">
						<?
						if($login['id']!=$user['id'])
						{
						?>
				        <a href="#" class="btn btn-link" style="text-decoration:none;"><i class="fa fa-lg fa-envelope-o" aria-hidden="true" data-toggle="modal" data-target="#exampleModal" title="Send Message to <?=$user['name']?>"></i></a>
						<?
						}
						?>
                    </span>
                </div>
            </div>
            <hr>
            <div class="col-md-12">
				<div>
				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#products" aria-controls="products" role="tab" data-toggle="tab"><?=$user['name']?>'s Products</a></li>
					<li role="presentation"><a href="#soldproducts" aria-controls="soldproducts" role="tab" data-toggle="tab">Sold Products</a></li>
				  </ul>
				  <!-- Tab panes -->
				  <div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="products">
						<br>
						<div class="row">
						<?
						$page = $_GET['page'];
						if ($page == '') { $page = 1; }
						/*$limit = 10;
						$offset = $limit * ($page-1);
						$result = mysqli_query($connection, "SELECT * FROM products WHERE userid = '$userid' AND sold = 0 ORDER BY productid DESC LIMIT $offset, $limit");*/
						$result = mysqli_query($connection, "SELECT * FROM products WHERE userid = '$userid' AND sold = 0 ORDER BY productid DESC");
						$i = 0;
						$r = 0;
						while ($row = mysqli_fetch_array($result))
						{
							//if ($r==3) { echo '</tr><tr style="height:270px">'; $r = 0; }
							$i ++;
							$r ++;
							$d_name = $row['productname'];

							if (strlen($d_name) > 30)
								$d_name = substr($d_name, 0, 27) . '...';
						?>
						<div class="col-xs-6 col-sm-6 col-lg-3 col-md-3">
							<div class="thumbnail" style="<?if($login['id']==$row['userid']) echo 'height:320px;'; else echo 'height:260px;';?>">
								<a href="/product.php?productid=<?=$row['productid']?>" title="<?=$row['productname']?>"><img src="https://i0.wp.com/<?=$_SERVER["HTTP_HOST"]?>/uploads/products/<?=$row['productimage1']?>?w=320&h=150px" alt="">
								<div class="caption">
									<h4 class="pull-right text-success bg-success">$<?=$row['productprice']?></h4>
									<h4><?=$d_name?></a>
									</h4>
									<p><a href="/category.php?category=<?=$row['productcategory']?>"><?=$row['productcategory']?></a></p>
								</div>
								<?
								if($login['id']==$row['userid'])
								{
								?>
								<div class="btn-group">
									<a href="/editproduct.php?productid=<?=$row['productid']?>" class="btn btn-warning">Edit</a>
								</div>
								<div class="btn-group">
									<a href="/product.php?productid=<?=$row['productid']?>&action=delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
								</div>
								<?
								}
								?>
							</div>
						</div>
						<?
						}
						if ($i==0)
							echo '<div class="alert alert-danger" role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<b>"'.$user['name'].'"</b> has 0 active products.
							</div>';
						?>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="soldproducts">
						<br>
						<div class="row">
						<?
						$page = $_GET['page'];
						if ($page == '') { $page = 1; }
						/*$limit = 10;
						$offset = $limit * ($page-1);
						$result = mysqli_query($connection, "SELECT * FROM products WHERE userid = '$userid' AND sold = 1 ORDER BY productid DESC LIMIT $offset, $limit");*/
						$result = mysqli_query($connection, "SELECT * FROM products WHERE userid = '$userid' AND sold = 1 ORDER BY productid DESC");
						$i = 0;
						$r = 0;
						while ($row = mysqli_fetch_array($result))
						{
							//if ($r==3) { echo '</tr><tr style="height:270px">'; $r = 0; }
							$i ++;
							$r ++;
							$d_name = $row['productname'];

							if (strlen($d_name) > 30)
								$d_name = substr($d_name, 0, 27) . '...';
						?>
						<div class="col-xs-6 col-sm-6 col-lg-3 col-md-3">
							<div class="thumbnail" style="height:260px;">
								<a href="/product.php?productid=<?=$row['productid']?>" title="<?=$row['productname']?>"><img src="https://i0.wp.com/<?=$_SERVER["HTTP_HOST"]?>/uploads/products/<?=$row['productimage1']?>?w=320&h=150px" alt="">
								<div class="caption">
									<h4 class="pull-right text-success bg-success">$<?=$row['productprice']?></h4>
									<h4><?=$d_name?></a>
									</h4>
									<p><a href="/category.php?category=<?=$row['productcategory']?>"><?=$row['productcategory']?></a></p>
								</div>
							</div>
						</div>
						<?
						}
						if ($i==0)
							echo '<div class="alert alert-danger" role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<b>"'.$user['name'].'"</b> has 0 sold products.
							</div>';
						?>
						</div>
					</div>
				  </div>
				</div>
            </div>
        </div>
    </div>
</div>

<? include('footer.php'); ?>

</body>

</html>
