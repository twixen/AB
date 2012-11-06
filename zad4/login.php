<?
	session_start();
	$user['jan'] = 'abcdef';
	$user['ola'] = '12345';
	$user['ala'] = 'qwerty';
	if($user[$_POST['user']] == $_POST['pass'])
	{
		$_SESSION['user'] = $_POST['user'];
		if(isset($_POST['remember']))
		{
			setcookie("user", $_POST['user'], time()+3600);
		}
	}
?>
