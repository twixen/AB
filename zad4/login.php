<?

session_start();
$users['jan'] = 'abcdef';
$users['ola'] = '12345';
$users['ala'] = 'qwerty';
if (isset($_POST['user']) && isset($users[$_POST['user']]) && $users[$_POST['user']] == $_POST['pass']) {
    $_SESSION['user'] = $_POST['user'];
    if (isset($_POST['remember'])) {
        setcookie("user", $_POST['user'], time() + 3600);
    }
}
?>
