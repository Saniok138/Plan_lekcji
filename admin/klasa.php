<form action="admin/insert_into.php" method="post">
<?php $sql = "SELECT MAX(id_k) FROM klasa";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    $result = $row['MAX(id_k)'];?>
    <input name="id_k" value="<?php echo $result+1; ?>" type="number" readonly>
    <input name="numer_k" type="text" required>
    <input name="wychowawca" type="text" required>
    <input name="insert" value="k" type="hidden">
    <button type="submit">Dodaj wiersz</button>
</form>
<form action="admin/delete.php" method="post">
    <input name="id_k" type="number" required>
    <input name="numer_k" type="text" required>
    <input name="wychowawca" type="text" required>
    <input name="delete" value="k" type="hidden">
    <button type="submit">Usuń wiersz</button>
</form>
<?php
$sql = "SELECT * FROM klasa";
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