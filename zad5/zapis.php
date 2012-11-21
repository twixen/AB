<? require 'db.php' ?>
<? $title = "Zapisy" ?>
<?
error_reporting(E_ALL);
if (!empty($_POST['add'])) {
    $sth = $db->prepare('INSERT INTO zapis VALUES (:id_projekt, :id_student)');
    $sth->bindValue(':id_projekt', $_POST['id_projekt'], PDO::PARAM_INT);
    $sth->bindValue(':id_student', $_POST['id_student'], PDO::PARAM_INT);
    $sth->execute();
}
if (!empty($_GET['dels']) && !empty($_GET['delp'])) {
    $sth = $db->prepare('DELETE FROM zapis WHERE id_projekt = :id1 AND id_student = :id2');
    $sth->bindValue(':id1', $_GET['delp'], PDO::PARAM_INT);
    $sth->bindValue(':id2', $_GET['dels'], PDO::PARAM_INT);
    $sth->execute();
    header('Location:' . $_SERVER["SCRIPT_URI"]);
}
?>
<? require 'header.php' ?>

<form id="addform" action="<?= $_SERVER["PHP_SELF"] ?>" method="post" >
    Projekt: 
    <select name="id_projekt">
        <?
        $sth = $db->prepare('SELECT id_projekt, nazwa FROM projekt');
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        ?>
        <? while ($row = $sth->fetch()): ?>
            <option value="<?= $row['id_projekt'] ?>"><?= $row['nazwa'] ?></option>
        <? endwhile ?>
    </select><br />
    Student:
    <select name="id_student">
        <?
        $sth = $db->prepare('SELECT id_student, imie, nazwisko FROM student');
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        ?>
        <? while ($row = $sth->fetch()): ?>
            <option value="<?= $row['id_student'] ?>"><?= $row['imie'] ?> <?= $row['nazwisko'] ?></option>
        <? endwhile ?>
    </select><br /> 
    <input type="submit" name="add" value="Dodaj">
</form>
<table>
    <tr>
        <th>Imię</th>
        <th>Nazwisko</th>
        <th>Projekt</th>
        <th>Usuń</th>
    </tr>

    <?
    $sth = $db->prepare('SELECT projekt.id_projekt, student.id_student, imie, nazwisko, nazwa FROM student, zapis, projekt WHERE zapis.id_projekt = projekt.id_projekt AND zapis.id_student = student.id_student ORDER BY nazwa, nazwisko');
    $sth->execute();
    $sth->setFetchMode(PDO::FETCH_ASSOC);
    ?>
    <? while ($row = $sth->fetch()): ?>
        <tr>
            <td><?= $row['imie'] ?></td>
            <td><?= $row['nazwisko'] ?></td>
            <td><?= $row['nazwa'] ?></td>
            <td><a href="<?= $_SERVER["PHP_SELF"] ?>?delp=<?= $row['id_projekt'] ?>&amp;dels=<?= $row['id_student'] ?>">X</a></td></tr>
    </tr>
<? endwhile ?>
</table>
<? require 'footer.php' ?>