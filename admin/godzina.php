<link rel="stylesheet" href="admin-style.css">

<form action="admin/insert_into.php" method="post">
<?php $sql = "SELECT MAX(id_g) FROM godzina";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    $result = $row['MAX(id_g)'];?>
    <input name="id_g" value="<?php echo $result+1; ?>" type="number" class="text-input" readonly>
    <input name="start" type="text" class="text-input" required>
    <input name="koniec" type="text" class="text-input" required>
    <input name="insert" value="g" type="hidden">
    <button type="submit"  class="presentation">Dodaj wiersz</button>
</form>
<form action="admin/delete.php" method="post">
    <input name="id_g" type="number" class="text-input" required>
    <input name="start" type="text" class="text-input" required>
    <input name="koniec" type="text" class="text-input" required>
    <input name="delete" value="g" type="hidden">
    <button type="submit"  class="presentation">Usuń wiersz</button>
</form>
<?php
$sql = "SELECT * FROM godzina";
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
}?>