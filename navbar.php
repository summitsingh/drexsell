<link rel="stylesheet" href="/css/bootstrap-social.css">
<link rel="stylesheet" href="/css/font-awesome.min.css">
<style>
@import url(https://fonts.googleapis.com/css?family=Oswald:400,300,700);
body {
  font-family: 'Oswald', sans-serif;
  font-size: 150%;
}
</style>
<link rel="stylesheet" href="/css/navbar.css">
<div id="custom-navbar">
	<div class="container-fluid">
        <div class="row row1">
			<ul class="col-xs-5 col-sm-5 hidden-md hidden-lg">
                <li class="upper-links dropdown"><a class="links" href="#"><i class="fa fa-cart-plus" aria-hidden="true"></i> Categories <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                    <ul class="dropdown-menu">
                        <li class="profile-li"><a class="profile-links" href="/category.php?category=Electronics"><i class="fa fa-wifi" aria-hidden="true"></i> Electronics</a></li>
						<li class="profile-li"><a class="profile-links" href="/category.php?category=Books"><i class="fa fa-book" aria-hidden="true"></i> Books</a></li>
						<li class="profile-li"><a class="profile-links" href="/category.php?category=Home"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
						<li class="profile-li"><a class="profile-links" href="/category.php?category=Furniture"><i class="fa fa-bed" aria-hidden="true"></i> Furniture</a></li>
						<li class="profile-li"><a class="profile-links" href="/category.php?category=Clothing"><i class="fa fa-users" aria-hidden="true"></i> Clothing</a></li>
						<li class="profile-li"><a class="profile-links" href="/category.php?category=Vehicles"><i class="fa fa-bicycle" aria-hidden="true"></i> Vehicles</a></li>
						<li class="profile-li"><a class="profile-links" href="/category.php?category=Miscellaneous"><i class="fa fa-cogs" aria-hidden="true"></i> Miscellaneous</a></li>
                    </ul>
                </li>
			</ul>
            <ul class="col-md-6 hidden-xs hidden-sm">
                <li class="upper-links"><a class="links" href="/category.php?category=Electronics"><i class="fa fa-wifi" aria-hidden="true"></i> Electronics</a></li>
                <li class="upper-links"><a class="links" href="/category.php?category=Books"><i class="fa fa-book" aria-hidden="true"></i> Books</a></li>
                <li class="upper-links"><a class="links" href="/category.php?category=Home"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
                <li class="upper-links"><a class="links" href="/category.php?category=Furniture"><i class="fa fa-bed" aria-hidden="true"></i> Furniture</a></li>
                <li class="upper-links"><a class="links" href="/category.php?category=Clothing"><i class="fa fa-users" aria-hidden="true"></i> Clothing</a></li>
                <li class="upper-links"><a class="links" href="/category.php?category=Vehicles"><i class="fa fa-bicycle" aria-hidden="true"></i> Vehicles</a></li>
				<li class="upper-links"><a class="links" href="/category.php?category=Miscellaneous"><i class="fa fa-cogs" aria-hidden="true"></i> Miscellaneous</a></li>
            </ul>
			<ul class="col-xs-7 col-sm-7 col-md-6" align="right">
				<li class="upper-links hidden-xs hidden-sm"><a class="links" href="/submitproduct.php"><i class="fa fa-plus" aria-hidden="true"></i> Submit Product</a></li>
				<li class="upper-links hidden-xs hidden-sm"><a class="links" href="/user.php?userid=<?=$login['id']?>"><i class="fa fa-money" aria-hidden="true"></i> My Profile (<?=$login['points']?> Drexsell Points)</a></li>
                <li class="upper-links dropdown"><a class="links" href="#"><i class="fa fa-user" aria-hidden="true"></i> <?if($login['name']!='') echo 'Hi, '.$login['name']; else echo 'Hi, Guest!';?> <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                    <ul class="dropdown-menu">
						<li class="profile-li hidden-md hidden-lg"><a class="profile-links" href="/submitproduct.php"><i class="fa fa-plus" aria-hidden="true"></i> Submit Product</a></li>
						<li class="profile-li hidden-md hidden-lg"><a class="profile-links" href="/user.php?userid=<?=$login['id']?>"><i class="fa fa-money" aria-hidden="true"></i> My Profile (<?=$login['points']?> Drexsell Points)</a></li>
                        <li class="profile-li"><a class="profile-links" href="/profile.php"><i class="fa fa-cog" aria-hidden="true"></i> Profile settings</a></li>
                        <li class="profile-li"><a class="profile-links" href="/password.php"><i class="fa fa-key" aria-hidden="true"></i> Change password</a></li>
                        <li class="profile-li"><a class="profile-links" href="/user.php?userid=<?=$login['id']?>"><i class="fa fa-pie-chart" aria-hidden="true"></i> My products</a></li>
                        <li class="profile-li"><a class="profile-links" href="/help.php"><i class="fa fa-question" aria-hidden="true"></i> Help</a></li>
                        <li class="profile-li"><a class="profile-links" href="/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Sign out</a></li>
                    </ul>
                </li>
			</ul>
        </div>
	</div>
	<div class="container">
        <div class="row row2">
			<div class="col-sm-2 pull-left">
                <a href="/index.php"><img style="max-width:180px; margin-top: -2px;" src="/images/logo-navbar1.png"></a>
            </div>
			<div class="custom-navbar-search smallsearch col-sm-8 col-xs-11">
                <div class="row">
					  <form action="/search.php" method="get">
						  <input x-webkit-speech class="custom-navbar-input col-xs-11" type="text" name="q" id="q" placeholder="Search for Products, Brands and more..." value="<?=$_GET['q']?>" style="color:black;">
					  </form>
                    <button class="custom-navbar-button col-xs-1">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <!--<div class="cart largenav col-sm-2">
                <a class="cart-button">
                    <svg class="cart-svg " width="16 " height="16 " viewBox="0 0 16 16 ">
                        <path d="M15.32 2.405H4.887C3 2.405 2.46.805 2.46.805L2.257.21C2.208.085 2.083 0 1.946 0H.336C.1 0-.064.24.024.46l.644 1.945L3.11 9.767c.047.137.175.23.32.23h8.418l-.493 1.958H3.768l.002.003c-.017 0-.033-.003-.05-.003-1.06 0-1.92.86-1.92 1.92s.86 1.92 1.92 1.92c.99 0 1.805-.75 1.91-1.712l5.55.076c.12.922.91 1.636 1.867 1.636 1.04 0 1.885-.844 1.885-1.885 0-.866-.584-1.593-1.38-1.814l2.423-8.832c.12-.433-.206-.86-.655-.86 " fill="#fff "></path>
                    </svg> Saved
                    <span class="item-number ">0</span>
                </a>
            </div>-->
        </div>
    </div>
</div>
<br>