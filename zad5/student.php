<? require 'db.php' ?>
<?
$title = "Studenci";
if (!empty($_POST['add'])) {
    $sth = $db->prepare('SELECT MAX( id_student ) AS id FROM student');
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    $sth = $db->prepare('INSERT INTO student VALUES (:id, :imie, :nazwisko, :pesel, :nr_indeksu, :data_ur, :ulica, :numer, :kod, :miejscowosc, :tel, :email, :notka)');
    $sth->bindValue(':id', $result['id'] + 1, PDO::PARAM_INT);
    $sth->bindValue(':imie', $_POST['imie'], PDO::PARAM_STR);
    $sth->bindValue(':nazwisko', $_POST['nazwisko'], PDO::PARAM_STR);
    $sth->bindValue(':pesel', $_POST['pesel'], PDO::PARAM_STR);
    $sth->bindValue(':nr_indeksu', $_POST['nr_indeksu'], PDO::PARAM_STR);
    $sth->bindValue(':data_ur', $_POST['data_ur'], PDO::PARAM_STR);
    $sth->bindValue(':ulica', $_POST['ulica'], PDO::PARAM_STR);
    $sth->bindValue(':numer', $_POST['numer'], PDO::PARAM_STR);
    $sth->bindValue(':kod', $_POST['kod'], PDO::PARAM_STR);
    $sth->bindValue(':miejscowosc', $_POST['miejscowosc'], PDO::PARAM_STR);
    $sth->bindValue(':tel', $_POST['tel'], PDO::PARAM_STR);
    $sth->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $sth->bindValue(':notka', $_POST['notka'], PDO::PARAM_STR);
    $sth->execute();
}
if (!empty($_POST['upd'])) {
    $sth = $db->prepare('UPDATE student SET imie = :imie, nazwisko = :nazwisko, pesel = :pesel, nr_indeksu = :nr_indeksu, data_ur = :data_ur, ulica = :ulica, numer = :numer, kod = :kod, miejscowosc = :miejscowosc, tel = :tel, email = :email, notka = :notka WHERE id_student = :id');
    $sth->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
    $sth->bindValue(':imie', $_POST['imie'], PDO::PARAM_STR);
    $sth->bindValue(':nazwisko', $_POST['nazwisko'], PDO::PARAM_STR);
    $sth->bindValue(':pesel', $_POST['pesel'], PDO::PARAM_STR);
    $sth->bindValue(':nr_indeksu', $_POST['nr_indeksu'], PDO::PARAM_STR);
    $sth->bindValue(':data_ur', $_POST['data_ur'], PDO::PARAM_STR);
    $sth->bindValue(':ulica', $_POST['ulica'], PDO::PARAM_STR);
    $sth->bindValue(':numer', $_POST['numer'], PDO::PARAM_STR);
    $sth->bindValue(':kod', $_POST['kod'], PDO::PARAM_STR);
    $sth->bindValue(':miejscowosc', $_POST['miejscowosc'], PDO::PARAM_STR);
    $sth->bindValue(':tel', $_POST['tel'], PDO::PARAM_STR);
    $sth->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $sth->bindValue(':notka', $_POST['notka'], PDO::PARAM_STR);
    $sth->execute();
}
if (!empty($_GET['del'])) {
    $sth = $db->prepare('DELETE FROM student WHERE id_student = :id');
    $sth->bindValue(':id', $_GET['del'], PDO::PARAM_INT);
    $sth->execute();
	$sth = $db->prepare('DELETE FROM zapis WHERE id_student = :id');
    $sth->bindValue(':id', $_GET['del'], PDO::PARAM_INT);
    $sth->execute();
    header('Location:' . $_SERVER["SCRIPT_URI"]);
}
?>
<? require 'header.php' ?>
<form id="searchform" action="<?= $_SERVER["PHP_SELF"] ?>" method="post" >
    Nazwisko: <input type="text" name="surname" maxlength="50">
    Data urodzenia: <input type="text" name="birthdate" maxlength="50">
    <input type="submit" name="search" value="Szukaj">
</form>
<form id="addform" action="<?= $_SERVER["PHP_SELF"] ?>" method="post" >
    <?
    if (!empty($_GET['upd'])):
        $sth = $db->prepare('SELECT * FROM student WHERE id_student = :id');
        $sth->bindValue(':id', $_GET['upd'], PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        ?>
        Imię:
        <input type="text" name="imie" value="<?= $result['imie'] ?>" maxlength="20" required="required" title="length: 1-20"><br />
        Nazwisko:
        <input type="text" name="nazwisko" value="<?= $result['nazwisko'] ?>" maxlength="30" required="required" title="length: 1-30"><br />
        Pesel:
        <input type="text" name="pesel" value="<?= $result['pesel'] ?>" maxlength="11" required="required" title="length: 11"><br />
        Nr indeksu:
        <input type="text" name="nr_indeksu" value="<?= $result['nr_indeksu'] ?>" maxlength="6" required="required" title="length: 6"><br />
        Data urodzenia:
        <input type="text" name="data_ur" value="<?= $result['data_ur'] ?>" maxlength="10" required="required" title="format: RRRR-MM-DD"><br />
        Ulica:
        <input type="text" name="ulica" value="<?= $result['ulica'] ?>" maxlength="50" required="required" title="length: 1-50"><br />
        Numer:
        <input type="text" name="numer" value="<?= $result['numer'] ?>" maxlength="10" required="required" title="length: 1-10"><br />
        Kod:
        <input type="text" name="kod" value="<?= $result['kod'] ?>" maxlength="6" required="required" title="length: 6"><br />
        Miejscowość:
        <input type="text" name="miejscowosc" value="<?= $result['miejscowosc'] ?>" maxlength="30" required="required" title="length: 1-30"><br />
        Telefon:
        <input type="text" name="tel" value="<?= $result['tel'] ?>" maxlength="9" required="required" title="length: 9"><br />
        Email:
        <input type="text" name="email" value="<?= $result['email'] ?>" maxlength="50" required="required" title="length: 1-50"><br />
        Notka:<br />
        <textarea name="notka" rows="5" cols="30" required="required" title="notka"><?= $result['notka'] ?></textarea><br />
        <input type="hidden" name="id" value="<?= $_GET['upd'] ?>">
        <? if (!empty($_REQUEST['surname'])): ?><input type="hidden" name="surname" value="<?= $_REQUEST['surname'] ?>"><? endif ?>
        <? if (!empty($_REQUEST['birthdate'])): ?><input type="hidden" name="birthdate" value="<?= $_REQUEST['birthdate'] ?>"><? endif ?>
        <input type="submit" name="upd" value="Zapisz">
    <? else: ?> 
        Imię:
        <input type="text" name="imie" maxlength="20" required="required" title="length: 1-20"><br />
        Nazwisko:
        <input type="text" name="nazwisko" maxlength="30" required="required" title="length: 1-30"><br />
        Pesel:
        <input type="text" name="pesel" maxlength="11" required="required" title="length: 11"><br />
        Nr indeksu:
        <input type="text" name="nr_indeksu" maxlength="6" required="required" title="length: 6"><br />
        Data urodzenia:
        <input type="text" name="data_ur" maxlength="10" required="required" title="format: RRRR-MM-DD"><br />
        Ulica:
        <input type="text" name="ulica" maxlength="50" required="required" title="length: 1-50"><br />
        Numer:
        <input type="text" name="numer" maxlength="10" required="required" title="length: 1-10"><br />
        Kod:
        <input type="text" name="kod" maxlength="6" required="required" title="length: 6"><br />
        Miejscowość:
        <input type="text" name="miejscowosc" maxlength="30" required="required" title="length: 1-30"><br />
        Telefon:
        <input type="text" name="tel" maxlength="9" required="required" title="length: 9"><br />
        Email:
        <input type="text" name="email" maxlength="50" required="required" title="length: 1-50"><br />
        Notka:<br />
        <textarea name="notka" rows="5" cols="30" required="required" title="notka"></textarea><br />
        <input type="submit" name="add" value="Dodaj">
    <? endif ?>
</form>
<table>
    <tr>
        <th>ID</th>
        <th>Imię</th>
        <th>Nazwisko</th>
        <th>Pesel</th>
        <th>Nr indeksu</th>
        <th>Data urodzenia</th>
        <th>Ulica</th>
        <th>Numer</th>
        <th>Kod</th>
        <th>Miejscowość</th>
        <th>Telefon</th>
        <th>Email</th>
        <th>Notka</th>
        <th>Usuń</th>
        <th>Edytuj</th>
    </tr>
    <?
    if (empty($_REQUEST['surname'])) {
        $sth = $db->prepare('SELECT * FROM student ORDER BY id_student');
    } else {
        $sth = $db->prepare('SELECT * FROM student WHERE nazwisko LIKE :nazwisko ORDER BY id_student');
        $sth->bindValue(':nazwisko', '%' . $_REQUEST['surname'] . '%', PDO::PARAM_STR);
    }
    $sth->execute();
    $sth->setFetchMode(PDO::FETCH_ASSOC);
    ?>
    <? while ($row = $sth->fetch()): ?>
        <tr>
            <? foreach ($row as &$value): ?>
                <td><?= $value ?></td>
            <? endforeach ?>
            <? if (empty($_REQUEST['surname'])): ?>
                <td><a href="<?= $_SERVER["PHP_SELF"] ?>?del=<?= $row['id_student'] ?>">X</a></td>
                <td><a href="<?= $_SERVER["PHP_SELF"] ?>?upd=<?= $row['id_student'] ?>">Y</a></td>
            <? else: ?>
                <td><a href="<?= $_SERVER["PHP_SELF"] ?>?surname=<?= $_REQUEST['surname'] ?>&amp;del=<?= $row['id_student'] ?>">X</a></td>
                <td><a href="<?= $_SERVER["PHP_SELF"] ?>?surname=<?= $_REQUEST['surname'] ?>&amp;upd=<?= $row['id_student'] ?>">Y</a></td>
            <? endif ?>
        </tr>
    <? endwhile ?>
</table>
<? require 'footer.php' ?>