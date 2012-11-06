<?
session_start();
require 'logincheck.php';
if(logincheck())
{
	echo 'Witaj '.$_SESSION['user'].'!';
}
else
{
	echo '<a href="login.html">nie jesteś zalogowany!</a>';
}
?>
