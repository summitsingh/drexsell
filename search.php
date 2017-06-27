<?
include('session.php');
if ($_GET['q'] == '') {
header('Location: index.php'); }
if ($_GET['page'] == '') {
header('Location: search.php?q='.$_GET['q'].'&page=1');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Search results for <?=$_GET['q']?> - <?=$site_name?></title>
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
        <div class="row">
            <div class="col-lg-12">
		<? if ($_GET['page'] == '1') {
		echo '<h1 class="page-header">Search results for '.$_GET['q'].'
		<small>Recent</small></h1>';
		}
		else {
		echo '<h1 class="page-header">Search results for '.$_GET['q'].'
		<small>Page '.$_GET['page'].'</small></h1>';
		}
		?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 hidden-xs hidden-sm">
                <p class="lead">Categories</p>
                <div class="list-group">
                    <a href="/category.php?category=Electronics" class="list-group-item">Electronics</a>
                    <a href="/category.php?category=Books" class="list-group-item">Books</a>
                    <a href="/category.php?category=Home" class="list-group-item">Home</a>
                    <a href="/category.php?category=Furniture" class="list-group-item">Furniture</a>
                    <a href="/category.php?category=Clothing" class="list-group-item">Clothing</a>
                    <a href="/category.php?category=Vehicles" class="list-group-item">Vehicles</a>
                    <a href="/category.php?category=Miscellaneous" class="list-group-item">Miscellaneous</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="row">
		<?
		if ($_GET['q'] != '') { $_POST['q'] = $_GET['q']; }
		$page = $_GET['page'];
		if ($page == '') { $page = 1; }
		$limit = 12;
		$offset = $limit * ($page-1);
		$_GET['q'] = strtolower($_GET['q']); 
		$_GET['q'] = strip_tags($_GET['q']); 
		$_GET['q'] = trim ($_GET['q']);
		$result = mysqli_query($connection, "SELECT * FROM products WHERE productname like '%".strtolower(mysqli_real_escape_string($connection, $_POST['q']))."%' OR productinformation like '%".strtolower(mysqli_real_escape_string($connection, $_POST['q']))."%' OR productcategory like '%".strtolower(mysqli_real_escape_string($connection, $_POST['q']))."%' ORDER BY productid DESC LIMIT $offset, $limit");
		$i = 0;
		$r = 0;
		while ($row = mysqli_fetch_array($result))
		{
			if($row['sold']==0)
			{
			//if ($r==3) { echo '</tr><tr style="height:270px">'; $r = 0; }
			$i ++;
			$r ++;
			$d_name = $row['productname'];

			if (strlen($d_name) > 30)
				$d_name = substr($d_name, 0, 27) . '...';
		?>
                    <div class="col-xs-6 col-sm-6 col-lg-3 col-md-3">
                        <div class="thumbnail">
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
		}
		if ($i==0)
			echo '<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			Your search <b>"'.$_GET['q'].'"</b> did not match any products.
			</div>';
		?>
                </div>
            </div>
        </div>

		<div class="row">
			<div class="col-lg-12" align="center">
				<nav aria-label="Page navigation">
					<ul class="pagination">
					<?
					$show_first = false;
					$current = $_GET['page'];
					if ($page == '') { $page = 1; }
					$next = $current +1;
					$previous = $current -1;
					if ($previous <= 0)
					{
						$previous = 1;
					}
					$page = $current;
					$start = $page - 2;
					$end = $page + 1;
					if ($start <= 2)
					{
						$start = 1;
						$end = 5;
						$show_first = false;
					}
					if ($i < 12) {
						$end = $current;
					}
					?>
					<?
					if ($current > 1) {
						echo '
						<li>
						  <a href="/index.php?page='.$previous.'" aria-label="Previous">
							<span aria-hidden="true">&laquo;</span>
						  </a>
						</li>';
					}
					else {
						echo '
						<li class="disabled">
						  <a href="#" aria-label="Previous">
							<span aria-hidden="true">&laquo;</span>
						  </a>
						</li>';
					}
					while ($start <= $end)
					{
						if ($start == $current)
						{
							if ($start=="1")
							{
								echo '<li class="active"><a href="/index.php">1</a></li>';
							}
							else{
								echo '<li class="active"><a href="/index.php?page='.$current.'">'.$current.'</a></li>';
							}
						}
						else
						{
							if ($start=="1")
							{
								echo '<li><a href="/index.php">1</a></li>';
							}
							else{
								echo '<li><a href="/index.php?page='.$start.'">'.$start.'</a></li>';
							}
						}
						$start ++;
					}
					if ($end != $current) {
						echo '
						<li>
						  <a href="/index.php?page='.$next.'" aria-label="Next">
							<span aria-hidden="true">&raquo;</span>
						  </a>
						</li>';
					}
					?>
					</ul>
				</nav>
			</div>
		</div>

    </div>

<? include('footer.php'); ?>

</body>

</html>
