<? require 'db.php' ?>
<?
$title = "Projekty";
if (!empty($_POST['add'])) {
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
if (!empty($_POST['upd'])) {
    $sth = $db->prepare('UPDATE projekt SET nazwa = :nazwa, opis = :opis, data_rozp = :data_rozp, data_zak = :data_zak WHERE id_projekt = :id');
    $sth->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
    $sth->bindValue(':nazwa', $_POST['nazwa'], PDO::PARAM_STR);
    $sth->bindValue(':opis', $_POST['opis'], PDO::PARAM_STR);
    $sth->bindValue(':data_rozp', $_POST['data_rozp'], PDO::PARAM_STR);
    $sth->bindValue(':data_zak', $_POST['data_zak'], PDO::PARAM_STR);
    $sth->execute();
}
if (!empty($_GET['del'])) {
    $sth = $db->prepare('DELETE FROM projekt WHERE id_projekt = :id');
    $sth->bindValue(':id', $_GET['del'], PDO::PARAM_INT);
    $sth->execute();
    header('Location:' . $_SERVER["SCRIPT_URI"]);
}
?>
<? require 'header.php' ?>
<form id="searchform" action="<?= $_SERVER["PHP_SELF"] ?>" method="post" >
    Nazwa: <input type="text" name="name" maxlength="50">
    <input type="submit" name="search" value="Szukaj">
</form>
<form id="addform" action="<?= $_SERVER["PHP_SELF"] ?>" method="post" >
    <?
    if (!empty($_GET['upd'])):
        $sth = $db->prepare('SELECT * FROM projekt WHERE id_projekt = :id');
        $sth->bindValue(':id', $_GET['upd'], PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        ?>
        Nazwa:
        <input type="text" name="nazwa" value="<?= $result['nazwa'] ?>" maxlength="50" required="required" title="length: 1-50"><br />
        Data rozpoczęcia:
        <input type="text" name="data_rozp" value="<?= $result['data_rozp'] ?>" maxlength="10" required="required" title="format: RRRR-MM-DD"><br />
        Data zakończenia:
        <input type="text" name="data_zak" value="<?= $result['data_zak'] ?>" maxlength="10" required="required" title="format: RRRR-MM-DD"><br />
        Opis:<br />
        <textarea  name="opis" rows="5" cols="30" required="required" title="opis"><?= $result['opis'] ?></textarea><br />
        <input type="hidden" name="id" value="<?= $_GET['upd'] ?>">
        <? if (!empty($_REQUEST['name'])): ?><input type="hidden" name="name" value="<?= $_REQUEST['name'] ?>"><? endif ?>
        <input type="submit" name="upd" value="Zapisz">
    <? else: ?> 
        Nazwa:
        <input type="text" name="nazwa" maxlength="50" required="required" title="length: 1-50"><br />
        Data rozpoczęcia:
        <input type="text" name="data_rozp" maxlength="10" required="required" title="format: RRRR-MM-DD"><br />
        Data zakończenia:
        <input type="text" name="data_zak" maxlength="10" required="required" title="format: RRRR-MM-DD"><br />
        Opis:<br />
        <textarea name="opis" rows="5" cols="30" required="required" title="opis"></textarea><br />
        <input type="submit" name="add" value="Dodaj">
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
    if (empty($_REQUEST['name'])) {
        $sth = $db->prepare('SELECT * FROM projekt ORDER BY id_projekt');
    } else {
        $sth = $db->prepare('SELECT * FROM projekt WHERE nazwa LIKE :nazwa ORDER BY id_projekt');
        $sth->bindValue(':nazwa', '%' . $_REQUEST['name'] . '%', PDO::PARAM_STR);
    }
    $sth->execute();
    $sth->setFetchMode(PDO::FETCH_ASSOC);
    ?>
    <? while ($row = $sth->fetch()): ?>
        <tr>
            <? foreach ($row as &$value): ?>
                <td><?= $value ?></td>
            <? endforeach ?>
            <? if (empty($_REQUEST['name'])): ?>
                <td><a href="<?= $_SERVER["PHP_SELF"] ?>?del=<?= $row['id_projekt'] ?>">X</a></td>
                <td><a href="<?= $_SERVER["PHP_SELF"] ?>?upd=<?= $row['id_projekt'] ?>">Y</a></td>
            <? else: ?>
                <td><a href="<?= $_SERVER["PHP_SELF"] ?>?name=<?= $_REQUEST['name'] ?>&amp;del=<?= $row['id_projekt'] ?>">X</a></td>
                <td><a href="<?= $_SERVER["PHP_SELF"] ?>?name=<?= $_REQUEST['name'] ?>&amp;upd=<?= $row['id_projekt'] ?>">Y</a></td>
            <? endif ?>
        </tr>
    <? endwhile ?>
</table>
<? require 'footer.php' ?>