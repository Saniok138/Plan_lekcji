<form action="admin/insert_into.php" method="post">
    <input name="dni" type="number" required>
    <input name="godzina" type="number" required>
    <input name="id_n" type="text" required>
    <input name="insert" value="dn" type="hidden">
    <button type="submit">Dodaj wiersz</button>
</form>
<form action="admin/delete.php" method="post">
    <input name="dni" type="number" required>
    <input name="godzina" type="number" required>
    <input name="id_n" type="text" required>
    <input name="delete" value="dn" type="hidden">
    <button type="submit">Usuń wiersz</button>
</form>
<?php
$sql = "SELECT * FROM widok_dni_nauczyciele";
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