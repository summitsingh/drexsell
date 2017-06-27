<?
include('session.php');

if ($_GET['productid'] == '') {
header('Location: index.php'); }

$productid = mysqli_real_escape_string($connection, $_GET['productid']);
$product = mysqli_query($connection,"SELECT * FROM products WHERE productid = '$productid' LIMIT 1");
$product = mysqli_fetch_array($product);

if($login['id']!=$product['userid']||$product['sold']==1)
{
	header('Location: error.php');
}

if (isset($_POST['action'])) {
    if ($_POST['action'] == "submit") {
        foreach ($_FILES["productimage"]["name"] as $key => $error) {
            if (basename($_FILES["productimage"]["name"][$key]) != "") {
                $imageFileType = pathinfo(basename($_FILES["productimage"]["name"][$key]), PATHINFO_EXTENSION);
                $imageFileType = strtolower($imageFileType);
                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $message  = '<div class="alert alert-danger" role="alert">
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					Sorry, only JPG, JPEG, PNG & GIF files are allowed.
					</div>';
                    $uploadOk = 0;
                    $class    = "has-error";
                    break;
                }
                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["productimage"]["tmp_name"][$key]);
                if ($check !== false) {
                    //$message = "File is an image - " . $check["mime"] . ".";
                } else {
					$message  = '<div class="alert alert-danger" role="alert">
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					File is not an image. Sorry, there was an error uploading your file.
					</div>';
                    $uploadOk = 0;
                    $class    = "has-error";
                    break;
                }
            }
        }
        if ($uploadOk !== 0) {
            foreach ($_FILES["productimage"]["name"] as $key => $error) {
                if (basename($_FILES["productimage"]["name"][$key]) != "") {
                    $target_dir  = "uploads/products/";
                    $newfilename = time() . '_' . rand(100, 999) . '_' . $login['id'] . '.' . pathinfo(basename($_FILES["productimage"]["name"][$key]), PATHINFO_EXTENSION);
					$newfilename = strtolower($newfilename);
                    $target_file = $target_dir . $newfilename;
                    $filename[]  = $newfilename;
                    if (move_uploaded_file($_FILES["productimage"]["tmp_name"][$key], $target_file)) {
                        //$message = "The file ". basename( $_FILES["productimage"]["name"][$key]). " has been uploaded.";
                    }
                }
                /*// Check if file already exists
                if (file_exists($target_file)) {
                $message .= "Sorry, file already exists.";
                $uploadOk = 0;
                }*/
                /*// Check file size
                if ($_FILES["productimage"]["size"][$key] > 500000) {
                $message .= "Sorry, your file is too large.";
                $uploadOk = 0;
                }*/
            }
            $userid = mysqli_real_escape_string($connection, $login['id']);
            $productname = mysqli_real_escape_string($connection, $_POST['productname']);
            $productprice = mysqli_real_escape_string($connection, round($_POST['productprice']));
            $productcategory = mysqli_real_escape_string($connection, $_POST['productcategory']);
			if($filename!='')
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
				$productimage1 = mysqli_real_escape_string($connection, $filename[0]);
				$productimage2 = mysqli_real_escape_string($connection, $filename[1]);
				$productimage3 = mysqli_real_escape_string($connection, $filename[2]);
				$productimage4 = mysqli_real_escape_string($connection, $filename[3]);
				$productimage5 = mysqli_real_escape_string($connection, $filename[4]);
			}
			else
			{
				$productimage1 = $product['productimage1'];
				$productimage2 = $product['productimage2'];
				$productimage3 = $product['productimage3'];
				$productimage4 = $product['productimage4'];
				$productimage5 = $product['productimage5'];
			}
            $productinformation = mysqli_real_escape_string($connection, $_POST['productinformation']);
            $paymentinformation = mysqli_real_escape_string($connection, $_POST['paymentinformation']);
            mysqli_query($connection, "UPDATE products SET productname='$productname', productprice='$productprice', productcategory='$productcategory', productimage1='$productimage1', productimage2='$productimage2', productimage3='$productimage3', productimage4='$productimage4', productimage5='$productimage5', productinformation='$productinformation', paymentinformation='$paymentinformation' where productid='$productid'");
			$product = mysqli_query($connection,"SELECT * FROM products WHERE productid = '$productid' LIMIT 1");
			$product = mysqli_fetch_array($product);
			header('Location: product.php?productid='.$product['productid']);
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
        <title>Edit product - <?=$site_name?></title>
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
            <form class="<? echo $class; ?>" action="editproduct.php?productid=<?=$_GET['productid']?>" method="post" enctype="multipart/form-data">
                <legend>Edit a product</legend>
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
						<div class="row">
							<div class="col-md-8">
								<input type="text" class="form-control" id="productName" name="productname" placeholder="Product Name" value="<? if($_POST['productname']=='') echo $product['productname']; else echo $_POST['productname'];?>" required autofocus>
							</div>
							<div class="col-md-4">
								<select class="form-control" id="productcategory" name="productcategory" required>
									<option value="Electronics" <? if($_POST['productcategory']=='')
										{if($product['productcategory']=='Electronics')
										echo 'selected';}
									 else
										if($_POST['productcategory']=='Electronics')
										echo 'selected';?>>Electronics</option>
									<option value="Books" <? if($_POST['productcategory']=='')
										{if($product['productcategory']=='Books')
										echo 'selected';}
									 else
										if($_POST['productcategory']=='Books')
										echo 'selected';?>>Books</option>
									<option value="Home" <? if($_POST['productcategory']=='')
										{if($product['productcategory']=='Home')
										echo 'selected';}
									 else
										if($_POST['productcategory']=='Home')
										echo 'selected';?>>Home</option>
									<option value="Furniture" <? if($_POST['productcategory']=='')
										{if($product['productcategory']=='Furniture')
										echo 'selected';}
									 else
										if($_POST['productcategory']=='Furniture')
										echo 'selected';?>>Furniture</option>
									<option value="Clothing" <? if($_POST['productcategory']=='')
										{if($product['productcategory']=='Clothing')
										echo 'selected';}
									 else
										if($_POST['productcategory']=='Clothing')
										echo 'selected';?>>Clothing</option>
									<option value="Vehicles" <? if($_POST['productcategory']=='')
										{if($product['productcategory']=='Vehicles')
										echo 'selected';}
									 else
										if($_POST['productcategory']=='Vehicles')
										echo 'selected';?>>Vehicles</option>
									<option value="Miscellaneous" <? if($_POST['productcategory']=='')
										{if($product['productcategory']=='Miscellaneous')
										echo 'selected';}
									 else
										if($_POST['productcategory']=='Miscellaneous')
										echo 'selected';?>>Miscellaneous</option>
								</select>
							</div>
						</div>
                        </div>
                        <!--<div class="form-group">
							<div class="radio">
								<label class="radio-inline">
								  <input type="radio" name="productcategory" id="productcategory1" value="Electronics"
								  <? if($_POST['productcategory']=='')
										{if($product['productcategory']=='Electronics')
										echo 'checked';}
									 else
										if($_POST['productcategory']=='Electronics')
										echo 'checked';?>
								  > Electronics
								</label>
								<label class="radio-inline">
								  <input type="radio" name="productcategory" id="productcategory2" value="Books"
								  <? if($_POST['productcategory']=='')
										{if($product['productcategory']=='Books')
										echo 'checked';}
									 else
										if($_POST['productcategory']=='Books')
										echo 'checked';?>
								  > Books
								</label>
								<label class="radio-inline">
								  <input type="radio" name="productcategory" id="productcategory3" value="Home"
								  <? if($_POST['productcategory']=='')
										{if($product['productcategory']=='Home')
										echo 'checked';}
									 else
										if($_POST['productcategory']=='Home')
										echo 'checked';?>
								  > Home
								</label>
								<label class="radio-inline">
								  <input type="radio" name="productcategory" id="productcategory4" value="Furniture"
								  <? if($_POST['productcategory']=='')
										{if($product['productcategory']=='Furniture')
										echo 'checked';}
									 else
										if($_POST['productcategory']=='Furniture')
										echo 'checked';?>
								  > Furniture
								</label>
								<label class="radio-inline">
								  <input type="radio" name="productcategory" id="productcategory5" value="Clothing"
								  <? if($_POST['productcategory']=='')
										{if($product['productcategory']=='Clothing')
										echo 'checked';}
									 else
										if($_POST['productcategory']=='Clothing')
										echo 'checked';?>
								  > Clothing
								</label>
								<label class="radio-inline">
								  <input type="radio" name="productcategory" id="productcategory6" value="Miscellaneous"
								  <? if($_POST['productcategory']=='')
										{if($product['productcategory']=='Miscellaneous')
										echo 'checked';}
									 else
										if($_POST['productcategory']=='Miscellaneous')
										echo 'checked';?>
								  > Miscellaneous
								</label>
							</div>
                        </div>-->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" class="form-control" id="productPrice" name="productprice" placeholder="Product Price ($0 for FREE)" value="<? if(round($_POST['productprice'])=='') echo $product['productprice']; else echo round($_POST['productprice']);?>" required>
								<span class="input-group-addon">.00</span>
                            </div>
                            <small id="paymentinformationHelp" class="form-text text-muted">Type $0 to sell this product for FREE</small>
                        </div>
                        <div class="form-group">
							<div class="radio">
								<label class="radio-inline">
								  <input type="radio" name="paymentinformation" id="paymentInformation1" value="Cash"
								  <? if($_POST['paymentinformation']=='')
										{if($product['paymentinformation']=='Cash')
										echo 'checked';}
									 else
										if($_POST['paymentinformation']=='Cash')
										echo 'checked';?>
								  > Cash
								</label>
								<label class="radio-inline">
								  <input type="radio" name="paymentinformation" id="paymentInformation2" value="Venmo"
								  <? if($_POST['paymentinformation']=='')
										{if($product['paymentinformation']=='Venmo')
										echo 'checked';}
									 else
										if($_POST['paymentinformation']=='Venmo')
										echo 'checked';?>
									> Venmo
								</label>
							</div>
                            <small id="paymentinformationHelp" class="form-text text-muted">How do you want to get paid? You can edit Venmo username in your <a href="/profile.php">profile settings</a></small>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
						<div class="form-group">
							<img class="img-responsive img-thumbnail" src="https://i0.wp.com/<?=$_SERVER["HTTP_HOST"]?>/uploads/products/<?=$product['productimage1']?>?w=150&h=150" alt="..." width="150">
							<?
							if($product['productimage2']!='')
								echo '<img class="img-responsive img-thumbnail" src="https://i0.wp.com/'.$_SERVER["HTTP_HOST"].'/uploads/products/'.$product['productimage2'].'?w=150&h=150" alt="..." width="150">';
							if($product['productimage3']!='')
								echo '<img class="img-responsive img-thumbnail" src="https://i0.wp.com/'.$_SERVER["HTTP_HOST"].'/uploads/products/'.$product['productimage3'].'?w=150&h=150" alt="..." width="150">';
							if($product['productimage4']!='')
								echo '<img class="img-responsive img-thumbnail" src="https://i0.wp.com/'.$_SERVER["HTTP_HOST"].'/uploads/products/'.$product['productimage4'].'?w=150&h=150" alt="..." width="150">';
							if($product['productimage5']!='')
								echo '<img class="img-responsive img-thumbnail" src="https://i0.wp.com/'.$_SERVER["HTTP_HOST"].'/uploads/products/'.$product['productimage5'].'?w=150&h=150" alt="..." width="150">';
							?>
						</div>
						<div class="form-group">
                            <label for="productImage">Product Image</label>
                            <small id="fileHelp" class="form-text text-muted">Uploading new images will remove all old images</small>
                            <input type="file" class="form-control-file" id="productImage" name="productimage[]" aria-describedby="fileHelp">
                            <br>
                            <input type="file" class="form-control-file" id="productImage" name="productimage[]" aria-describedby="fileHelp">
                            <br>
                            <input type="file" class="form-control-file" id="productImage" name="productimage[]" aria-describedby="fileHelp">
                            <br>
                            <input type="file" class="form-control-file" id="productImage" name="productimage[]" aria-describedby="fileHelp">
                            <br>
                            <input type="file" class="form-control-file" id="productImage" name="productimage[]" aria-describedby="fileHelp">
                            <small id="fileHelp" class="form-text text-muted">Only JPG, JPEG, PNG & GIF files are allowed</small>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="exampleTextarea" name="productinformation" rows="10" placeholder="Describe your product... (optional)"><? if($_POST['productinformation']=='') echo $product['productinformation']; else echo $_POST['productinformation'];?></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="action" value="submit">Submit</button>
            </form>
        </div>
	<? include('footer.php'); ?>
    </body>
	</html>
