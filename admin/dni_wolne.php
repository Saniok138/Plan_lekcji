<link rel="stylesheet" href="admin-style.css">

<form action="admin/insert_into.php" method="post">
    <input name="id_k" type="text" class="text-input" required>
    <input name="dni_wolne" type="number" class="text-input" required>
    <input name="insert" value="dw" class="text-input" type="hidden">
    <button type="submit" class="presentation">Dodaj wiersz</button>
</form>
<form action="admin/delete.php" method="post">
    <input name="id_k" type="text" class="text-input" required>
    <input name="dni_wolne" type="number" class="text-input" required>
    <input name="delete" value="dw" type="hidden" class="text-input">
    <button type="submit" class="presentation">Usuń wiersz</button>
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