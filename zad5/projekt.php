<? require 'db.php' ?>
<?
	$title = "Projekty";
	if(!empty($_POST['add']))
	{
		$sth = $db->prepare('SELECT MAX( id_projekt ) AS id FROM projekt');
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		$sth = $db->prepare('INSERT INTO projekt VALUES (:id, :nazwa, :opis, :data_rozp, :data_zak)');
		$sth->bindValue(':id', $result['id'] + 1, PDO::PARAM_INT);
		$sth->bindValue(':nazwa', $_POST['nazwa'], PDO::PARAM_STR);
		$sth->bindValue(':opis', $_POST['opis'], PDO::PARAM_STR);
		$sth->bindValue(':data_rozp', $_POST['data_rozp'], PDO::PARAM_STR);
		$sth->bindValue(':data_zak', $_POST['data_zak'], PDO::PARAM_STR);
		$sth->execute();
	}
	if(!empty($_POST['upd']))
	{
		$sth = $db->prepare('UPDATE projekt SET nazwa = :nazwa, opis = :opis, data_rozp = :data_rozp, data_zak = :data_zak WHERE id_projekt = :id');
		$sth->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
		$sth->bindValue(':nazwa', $_POST['nazwa'], PDO::PARAM_STR);
		$sth->bindValue(':opis', $_POST['opis'], PDO::PARAM_STR);
		$sth->bindValue(':data_rozp', $_POST['data_rozp'], PDO::PARAM_STR);
		$sth->bindValue(':data_zak', $_POST['data_zak'], PDO::PARAM_STR);
		$sth->execute();
	}
	if(!empty($_GET['del']))
	{
		$sth = $db->prepare('DELETE FROM projekt WHERE id_projekt = :id');
		$sth->bindValue(':id', $_GET['del'], PDO::PARAM_INT);
		$sth->execute();
		header('Location:'.$_SERVER["SCRIPT_URI"]);
	}
?>
<? require 'header.php' ?>
<form id="searchform" action="<?=$_SERVER["PHP_SELF"]?>" method="post" >
	Nazwa: <input type="text" name="nazwa" maxlength="50" required="required">
	<input type="submit" name="search" value="Szukaj">
</form>
<form id="addform" action="<?=$_SERVER["PHP_SELF"]?>" method="post" >
<? if(empty($_GET['upd'])): ?>
	Nazwa:
	<input type="text" name="nazwa" maxlength="50" required="required" title="length: 1-50"><br />
	Data rozpoczęcia:
	<input type="date" name="data_rozp" maxlength="10" required="required" title="format: RRRR-MM-DD"><br />
	Data zakończenia:
	<input type="date" name="data_zak" maxlength="10" required="required" title="format: RRRR-MM-DD"><br />
	Opis:<br />
	<textarea name="opis" rows="5" cols="30" required="required" title="opis"></textarea><br />
	<input type="submit" name="add" value="Dodaj">
</form>
<? else:
	$sth = $db->prepare('SELECT * FROM projekt WHERE id_projekt = :id');
	$sth->bindValue(':id', $_GET['upd'], PDO::PARAM_INT);
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_ASSOC);
?> 
	Nazwa:
	<input type="text" name="nazwa" value="<?=$result['nazwa']?>" maxlength="50" required="required" title="length: 1-50"><br />
	Data rozpoczęcia:
	<input type="date" name="data_rozp" value="<?=$result['data_rozp']?>" maxlength="10" required="required" title="format: RRRR-MM-DD"><br />
	Data zakończenia:
	<input type="date" name="data_zak" value="<?=$result['data_zak']?>" maxlength="10" required="required" title="format: RRRR-MM-DD"><br />
	Opis:<br />
	<textarea  name="opis" rows="5" cols="30" required="required" title="opis"><?=$result['opis']?></textarea><br />
	<input type="hidden" name="id" value="<?=$_GET['upd']?>">
	<input type="submit" name="upd" value="Zapisz">
<? endif ?>
</form>
<table>
	<tr>
		<th>ID</th>
		<th>Nazwa</th>
		<th>Opis</th>
		<th>Data rozpoczęcia</th>
		<th>Data zakończenia</th>
		<th>Usuń</th>
		<th>Edytuj</th>
	</tr>
<? 
	if(empty($_POST['search']) || empty($_POST['nazwa'])) 
	{
		$sth = $db->prepare('SELECT * FROM projekt ORDER BY id_projekt');
	}
	else
	{
		$sth = $db->prepare('SELECT * FROM projekt WHERE nazwa LIKE :nazwa ORDER BY id_projekt');
		$sth->bindValue(':nazwa', '%'.$_POST['nazwa'].'%', PDO::PARAM_STR);
	}
	$sth->execute();
	$result = $sth->setFetchMode(PDO::FETCH_NUM);
	while($row = $sth->fetch())
	{
		echo '<tr>';
		$length = count($row);
		for($i = 0; $i < $length; $i++)
		{
			echo '<td>';
			echo $row[$i];
			echo '</td>';
		}
		if(empty($_POST['search']) || empty($_POST['nazwa'])) 
		{
			echo '<td><a href="projekt.php?del='.$row[0].'">X</a></td>';
			echo '<td><a href="projekt.php?upd='.$row[0].'">Y</a></td>';
		}
		else
		{
			echo '<td><a href="projekt.php?nazwa='.$_POST['nazwa'].'&amp;del='.$row[0].'">X</a></td>';
			echo '<td><a href="projekt.php?nazwa='.$_POST['nazwa'].'&amp;upd='.$row[0].'">Y</a></td>';
		}
		echo '</tr>';
	}
?>
</table>
<? require 'footer.php' ?>