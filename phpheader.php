<?
include('includes/connect.php');
?>
<?
$site_name='Drexsell.com';
?>
<?
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
?>
<?
function alternate() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= str_replace("www.", "m.", $_SERVER['SERVER_NAME']).":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= str_replace("www.", "m.", $_SERVER['HTTP_HOST']).$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
?>