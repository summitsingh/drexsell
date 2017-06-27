<?
include('session.php');
if (isset($_POST['action']))
{
    if ($_POST['action'] == "submit")
	{
		foreach ($_FILES["displaypicture"]["name"] as $key => $error) {
            if (basename($_FILES["displaypicture"]["name"][$key]) != "") {
                $imageFileType = pathinfo(basename($_FILES["displaypicture"]["name"][$key]), PATHINFO_EXTENSION);
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
                $check = getimagesize($_FILES["displaypicture"]["tmp_name"][$key]);
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
            foreach ($_FILES["displaypicture"]["name"] as $key => $error) {
                if (basename($_FILES["displaypicture"]["name"][$key]) != "") {
                    $target_dir  = "uploads/displaypictures/";
                    $newfilename = time() . '_' . rand(100, 999) . '_' . $login['id'] . '.' . pathinfo(basename($_FILES["displaypicture"]["name"][$key]), PATHINFO_EXTENSION);
					$newfilename = strtolower($newfilename);
                    $target_file = $target_dir . $newfilename;
                    $filename[]  = $newfilename;
                    if (move_uploaded_file($_FILES["displaypicture"]["tmp_name"][$key], $target_file)) {
                        //$message = "The file ". basename( $_FILES["displaypicture"]["name"][$key]). " has been uploaded.";
                    }
                }
                /*// Check if file already exists
                if (file_exists($target_file)) {
                $message .= "Sorry, file already exists.";
                $uploadOk = 0;
                }*/
                /*// Check file size
                if ($_FILES["displaypicture"]["size"][$key] > 500000) {
                $message .= "Sorry, your file is too large.";
                $uploadOk = 0;
                }*/
            }
            $userid = mysqli_real_escape_string($connection, $login['id']);
			if($filename!='')
			{
				if($login['displaypicture']!='')
					unlink('uploads/displaypictures/'.$login['displaypicture']);
				$displaypicture = mysqli_real_escape_string($connection, $filename[0]);
			}
			else
			{
				$displaypicture = $login['displaypicture'];
			}
			mysqli_query($connection, "UPDATE users SET displaypicture='$displaypicture' where id='$userid'");
			$login=mysqli_query($connection,"SELECT * FROM users WHERE id='$userid'");
			$login=mysqli_fetch_assoc($login);
			$class = "has-success";
			$message = '<div class="alert alert-success alert-dismissible" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Display picture updated successfully. <a href="profile.php">Check profile</a></strong>
			</div>';
        }
    }
}
if ($_GET['action'] == "incomplete")
{
	$class = "has-error";
	$message = '<div class="alert alert-danger" role="alert">
	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	Please update your display picture before submitting product or contact seller
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
<title>Display picture - <?=$site_name?></title>
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
<legend>Display picture</legend>
<div class="row">
<div class="col-xs-12 col-md-6">
<div class="form-group">
<?
if($login['displaypicture']!='')
	echo '<img class="img-responsive img-circle" src="https://i0.wp.com/'.$_SERVER["HTTP_HOST"].'/uploads/displaypictures/'.$login['displaypicture'].'?w=300&h=300" alt="..." width="300">';
else
	echo '<img class="img-responsive img-circle" src="https://i0.wp.com/'.$_SERVER["HTTP_HOST"].'/uploads/displaypictures/default.jpg?w=300&h=300" alt="..." width="300">';
?>
</div>
<div class="form-group">
<input type="file" class="form-control-file" id="displaypicture" name="displaypicture[]" aria-describedby="fileHelp">
<small id="fileHelp" class="form-text text-muted">Only JPG, JPEG, PNG & GIF files are allowed</small>
</div>
</div>
</div>
<button type="submit" class="btn btn-primary" name="action" value="submit">Submit</button>
</form>
</div>
<? include('footer.php'); ?>
</body>
</html>