<?
include('session.php');

if ($_GET['productid'] == '') {
header('Location: index.php'); }

$productid = mysqli_real_escape_string($connection, $_GET['productid']);
$product = mysqli_query($connection,"SELECT * FROM products WHERE productid = '$productid' LIMIT 1");
$product = mysqli_fetch_array($product);
$userid = $product['userid'];
$user = mysqli_query($connection,"SELECT * FROM users WHERE id = '$userid' LIMIT 1");
$user = mysqli_fetch_array($user);

if ($_GET['action'] == "delete")
{
	if($login['id']==$product['userid']&&$product['sold']==0)
	{
		unlink('uploads/products/'.$product['productimage1']);
		if($product['productimage2']!='')
			unlink('uploads/products/'.$product['productimage2']);
		if($product['productimage3']!='')
			unlink('uploads/products/'.$product['productimage3']);
		if($product['productimage4']!='')
			unlink('uploads/products/'.$product['productimage4']);
		if($product['productimage5']!='')
			unlink('uploads/products/'.$product['productimage5']);
		mysqli_query($connection, "DELETE FROM products WHERE productid = '$productid' LIMIT 1");
		header('Location: profile.php?action=productdeleted');
	}
	else
	{
		header('Location: error.php');
	}
}
if ($_GET['action'] == "productsold")
{
	if($login['id']==$product['userid']&&$product['sold']==0)
	{
		mysqli_query($connection, "UPDATE products SET sold='1' where productid='$productid'");
		mysqli_query($connection, "UPDATE users SET points=points+10 where id='$userid'");
		$product = mysqli_query($connection,"SELECT * FROM products WHERE productid = '$productid' LIMIT 1");
		$product = mysqli_fetch_array($product);
		$message = '<div class="alert alert-success alert-dismissible" role="alert">
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Thankyou for selling your product with Drexsell.com! We have added 10 Drexsell Points as appreciation :) <a href="index.php">Check homepage</a></strong>
		</div>';
		$login=mysqli_query($connection,"SELECT * FROM users WHERE id='$session_userid'");
		$login=mysqli_fetch_assoc($login);
	}
	else
	{
		header('Location: error.php');
	}
}
if (isset($_POST['action'])) {
    if ($_POST['action'] == "sendmessage") {
		if($login['contactnumber']=='')
		{
			header("location: profile.php?action=incomplete");
		}
		if($login['displaypicture']=='')
		{
			header("location: displaypicture.php?action=incomplete");
		}
		$to = $user['name'].' <'.$user['email'].'>';
		$subject = $login['name'].' is interested in your product - Drexsell';
		$from = "Drexsell.com <admin@drexsell.com>";
		$body='Hi '.$user['name'].',<br><br>'.$login['name'].' is interested in your product ('.$product['productname'].') (<a href="https://'.$_SERVER["HTTP_HOST"].'/product.php?productid='.$product['productid'].'">https://'.$_SERVER["HTTP_HOST"].'/product.php?productid='.$product['productid'].'</a>)<br><br><a href="https://'.$_SERVER["HTTP_HOST"].'/user.php?userid='.$login['id'].'">Click here to contact '.$login['name'].' and send your contact information.</a><br><br>==================================================================<br>Below is the message sent by '.$login['name'].':<br>==================================================================<br><br>'.$_POST['message-text'].'<br><br>==================================================================<br><br>Thank you,<br>Drexsell.com Team<br><br><img src="https://'.$_SERVER["HTTP_HOST"].'/images/logo.png" alt="Drexsell.com">';
		$headers = "From: " . $from . "\r\n";
		$headers .= "Reply-To: ". $from . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		mail($to,$subject,$body,$headers,'-fadmin@drexsell.com');
		$message = '<div class="alert alert-success" role="alert">
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		<strong>Your message has been successfully sent to the seller. Seller will send you contact information if interested. <a href="index.php">Check homepage</a></strong>
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
	<title><?=$product['productname']?> - <?=$site_name?></title>
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
                <h1 class="page-header"><?=$product['productname']?>
                    <small><?=$product['productcategory']?></small>
					<p class="pull-right text-success bg-success">$<?=$product['productprice']?></p>
					<?if($product['sold']==1) echo '<p class="pull-right text-danger bg-danger">(SOLD)</p>';?>
                </h1>
            </div>
        </div>

        <div class="row">

            <div class="col-md-8">
				<div id="carousel-images" class="carousel slide" data-ride="carousel">
				  <!-- Indicators -->
				  <ol class="carousel-indicators">
					<li data-target="#carousel-images" data-slide-to="0" class="active"></li>
					<?
					if($product['productimage2']!='')
						echo '<li data-target="#carousel-images" data-slide-to="1"></li>';
					if($product['productimage3']!='')
						echo '<li data-target="#carousel-images" data-slide-to="2"></li>';
					if($product['productimage4']!='')
						echo '<li data-target="#carousel-images" data-slide-to="3"></li>';
					if($product['productimage5']!='')
						echo '<li data-target="#carousel-images" data-slide-to="4"></li>';
					?>
				  </ol>

				  <!-- Wrapper for slides -->
				  <div class="carousel-inner" role="listbox">
					<div class="item active">
					  <img style="margin: auto;" src="https://i0.wp.com/<?=$_SERVER["HTTP_HOST"]?>/uploads/products/<?=$product['productimage1']?>?w=500&h=500" alt="...">
					</div>
					<?
					if($product['productimage2']!='')
						echo '
					<div class="item">
					  <img style="margin: auto;" src="https://i0.wp.com/'.$_SERVER["HTTP_HOST"].'/uploads/products/'.$product['productimage2'].'?w=500&h=500" alt="...">
					</div>';
					if($product['productimage3']!='')
						echo '
					<div class="item">
					  <img style="margin: auto;" src="https://i0.wp.com/'.$_SERVER["HTTP_HOST"].'/uploads/products/'.$product['productimage3'].'?w=500&h=500" alt="...">
					</div>';
					if($product['productimage4']!='')
						echo '
					<div class="item">
					  <img style="margin: auto;" src="https://i0.wp.com/'.$_SERVER["HTTP_HOST"].'/uploads/products/'.$product['productimage4'].'?w=500&h=500" alt="...">
					</div>';
					if($product['productimage5']!='')
						echo '
					<div class="item">
					  <img style="margin: auto;" src="https://i0.wp.com/'.$_SERVER["HTTP_HOST"].'/uploads/products/'.$product['productimage5'].'?w=500&h=500" alt="...">
					</div>';
					?>
				  </div>

				  <!-- Controls -->
				  <a class="left carousel-control" href="#carousel-images" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				  </a>
				  <a class="right carousel-control" href="#carousel-images" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				  </a>
				</div>
            </div>

            <div class="col-md-4">
				<h3>Seller Information:</h3>
                <ul>
                    <li>Seller Name: <a href="/user.php?userid=<?=$user['id']?>"><b><?=$user['name']?></b></a></li>
                    <li>Payment accepted by <b><?=$product['paymentinformation']?></b> <? if($product['paymentinformation']=='Venmo') echo ': @'.$user['venmousername']; ?></li>
                    <li>Location: <b><?=$user['address3']?></b></li>
                </ul>
				<?
				if($login['id']==$product['userid']&&$product['sold']==0)
				{
					echo '
					<div class="btn-group">
						<a href="/editproduct.php?productid='.$product['productid'].'" class="btn btn-warning">Edit Product</a>
					</div>
					<div class="btn-group">
						<a href="?productid='.$product['productid'].'&action=delete" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete?\')">Delete Product</a>
					</div>
					<div class="btn-group">
						<a href="?productid='.$product['productid'].'&action=productsold" class="btn btn-success" onclick="return confirm(\'Are you sure you want to mark this product as sold? (marking this product as sold will remove it from active listings) (you will get 10 points to marks this product as sold)\')">Mark as Sold</a>
					</div>
					';
				}
				?>
				<?
				if($login['id']!=$user['id'])
				{
				?>
				<div class="btn-group">
					<a href="/user.php?userid=<?=$user['id']?>" class="btn btn-success">View <?=$user['name']?>'s Profile</a>
				</div>
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Contact Seller</button>
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
							<textarea class="form-control" id="message-text" name="message-text" rows="10">I'm interested in this product. Please give me this product for $<?=$product['productprice']?>. Send me your contact information.</textarea>
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
            </div>
        </div>

		<div class="row">
            <div class="col-lg-12">
				<h3>Product Information</h3>
                <p><?=$product['productinformation']?></p>
			</div>
		</div>

        <div class="row">

            <div class="col-lg-12">
                <h3 class="page-header">Related Products</h3>
            </div>

            <div class="col-md-12">
                <div class="row">
		<?
		$page = $_GET['page'];
		if ($page == '') { $page = 1; }
		$limit = 6;
		$offset = $limit * ($page-1);
		$result = mysqli_query($connection, "SELECT * FROM products WHERE productcategory like '%".mysqli_real_escape_string($connection, $product['productcategory'])."%' AND sold = 0 AND productid != $productid ORDER BY productid DESC LIMIT $offset, $limit");
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
                    <div class="col-xs-6 col-sm-6 col-lg-2 col-md-2">
                        <div class="thumbnail" style="height:240px;">
                            <a href="/product.php?productid=<?=$row['productid']?>" title="<?=$row['productname']?>"><img src="https://i0.wp.com/<?=$_SERVER["HTTP_HOST"]?>/uploads/products/<?=$row['productimage1']?>?w=320&h=150px" alt="">
                            <div class="caption">
                                <h4 class="pull-right text-success bg-success">$<?=$row['productprice']?></h4>
                                <h4><?=$d_name?></a>
                                </h4>
                            </div>
                        </div>
                    </div>
		<?
		}
		if ($i==0)
			echo '<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			No related products found
			</div>';
		?>
                </div>
            </div>

        </div>

    </div>

	<? include('footer.php'); ?>
	
</body>

</html>
