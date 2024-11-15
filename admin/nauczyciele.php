<form action="admin/insert_into.php" method="post">
<?php $sql = "SELECT MAX(id_n) FROM nauczyciele";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    $result = $row['MAX(id_n)'];?>
    <input name="id_n" value="<?php echo $result+1; ?>" type="number" readonly>
    <input name="skrot" type="text" required>
    <input name="imie_nazwisko" type="text" required>
    <input name="insert" value="n" type="hidden">
    <button type="submit">Dodaj wiersz</button>
</form>
<form action="admin/delete.php" method="post">
    <input name="id_n" type="number" required>
    <input name="skrot" type="text" required>
    <input name="imie_nazwisko" type="text" required>
    <input name="delete" value="n" type="hidden">
    <button type="submit">Usuń wiersz</button>
</form>
<?php
echo'<form action="" method="post">
    Limit:<input name="limit_n" type="number">
    <input type="submit" name="submit" value="change">
</form>';
if(!isset($_POST["limit_n"]))
$limit_n=10;
else
$limit_n=$_POST["limit_n"];
$sql = "SELECT * FROM nauczyciele LIMIT $limit_n";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
echo "<table border='1'>";
echo "<tr>";
$columns = $result->fetch_fields();
foreach ($columns as $column) {
echo "<th>" . $column->name . "</th>";
}
echo "</tr>";
while($row = $result->fetch_assoc()) {
echo "<tr>";
foreach ($row as $data) {
echo "<td>" . htmlspecialchars($data) . "</td>";
}
echo "</tr>";
}
echo "</table>";
} else {
echo "Brak wyników w widoku: $viewName";
}
?>