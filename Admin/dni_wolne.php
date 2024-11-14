<form action="admin/insert_into.php" method="post">
    <input name="id_k" type="number" required>
    <input name="dni_wolne" type="number" required>
    <input name="insert" value="dw" type="hidden">
    <button type="submit">Dodaj</button>
</form>
<?php
$sql = "SELECT * FROM widok_dni_wolne";
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