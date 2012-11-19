<?
session_start();
require 'logincheck.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Welcome</title>
    </head>
    <body>
        <?
        if (logincheck()) {
            echo '<p>Witaj ' . $_SESSION['user'] . '!</p>';
            echo (isset($_GET['color']) ? '<p style="color:' . $_GET['color'] . '">' : '<p>') . 'per aspera ad astra</p>';
        } else {
            echo '<p><a href="login.html">Nie jesteś zalogowany!</a></p>';
        }
        ?>
    </body>
</html>