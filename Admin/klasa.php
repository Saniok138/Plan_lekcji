<form action="admin/insert_into.php" method="post">
<?php $sql = "SELECT MAX(id_k) FROM klasa";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    $result = $row['MAX(id_k)'];?>
    <input name="id_k" value="<?php echo $result+1; ?>" type="number" readonly>
    <input name="numer_k" type="text" required>
    <input name="wychowawca" type="text" required>
    <input name="insert" value="k" type="hidden">
    <button type="submit">Dodaj</button>
</form>
<?php
echo'<form action="" method="post">
    Limit:<input name="limit_k" type="number">
    <input type="submit" name="submit" value="change">
</form>';
if(!isset($_POST["limit_k"]))
$limit_k=10;
else
$limit_k=$_POST["limit_k"];
$sql = "SELECT * FROM klasa LIMIT $limit_k";
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