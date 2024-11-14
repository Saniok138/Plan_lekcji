<form action="admin/insert_into.php" method="post">
<?php $sql = "SELECT MAX(id_s) FROM sala";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    $result = $row['MAX(id_s)'];?>
    <input name="id_s" value="<?php echo $result+1; ?>" type="number" readonly>
    <input name="numer" type="text" required>
    <input name="rozmiar" type="number" required>
    <input name="typ" type="text" required>
    <input name="wychowawca" type="text" required>
    <input name="insert" value="s" type="hidden">
    <button type="submit">Dodaj</button>
</form>
<?php
echo'<form action="" method="post">
    Limit:<input name="limit_s" type="number">
    <input type="submit" name="submit" value="change">
</form>';
if(!isset($_POST["limit_s"]))
$limit_s=10;
else
$limit_s=$_POST["limit_s"];
$sql = "SELECT * FROM sala LIMIT $limit_s";
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