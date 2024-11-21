<form action="admin/insert_into.php" method="post">
    <?php $sql = "SELECT MAX(id_p) FROM przedmiot";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    $result = $row['MAX(id_p)'];?>
    <input name="id_p" value="<?php echo $result+1; ?>" type="number" readonly>
    <input name="nazwa" type="text" required>
    <input name="typ" type="text" required>
    <input name="insert" value="p" type="hidden">
    <button type="submit">Dodaj wiersz</button>
</form>
<form action="admin/delete.php" method="post">
    <input name="id_p" type="number" required>
    <input name="nazwa" type="text" required>
    <input name="typ" type="text" required>
    <input name="delete" value="p" type="hidden">
    <button type="submit">Usuń wiersz</button>
</form>
<?php
$sql = "SELECT * FROM przedmiot";
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