<form action="admin/insert_into.php" method="post">
    <input name="id_k" type="text" required>
    <input name="id_p" type="text" required>
    <input name="ilosc_godzin" type="number" required>
    <input name="ilosc_grup" value="1" type="number" required>
    <input name="insert" value="pk" type="hidden">
    <button type="submit">Dodaj wiersz</button>
</form>
<form action="admin/delete.php" method="post">
    <input name="id_k" type="text" required>
    <input name="id_p" type="text" required>
    <input name="ilosc_godzin" type="number" required>
    <input name="ilosc_grup" value="1" type="number" required>
    <input name="delete" value="pk" type="hidden">
    <button type="submit">Usuń wiersz</button>
</form>
<?php
echo'<form action="" method="post">
    Limit:<input name="limit_pk" type="number">
    <input type="submit" name="submit" value="change">
</form>';
if(!isset($_POST["limit_pk"]))
$limit_pk=10;
else
$limit_pk=$_POST["limit_pk"];
$sql = "SELECT * FROM widok_przedmiot_klasa LIMIT $limit_pk";
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