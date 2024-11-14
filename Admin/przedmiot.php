<form action="admin/insert_into.php" method="post">
    <?php $sql = "SELECT MAX(id_p) FROM przedmiot";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    $result = $row['MAX(id_p)'];?>
    <input name="id_p" value="<?php echo $result+1; ?>" type="number" readonly>
    <input name="nazwa" type="text" required>
    <input name="typ" type="text" required>
    <input name="insert" value="p" type="hidden">
    <button type="submit">Dodaj</button>
</form>
<?php
echo'<form action="" method="post">
    Limit:<input name="limit_p" type="number">
    <input type="submit" name="submit" value="change">
</form>';
if(!isset($_POST["limit_p"]))
$limit_p=10;
else
$limit_p=$_POST["limit_p"];
$sql = "SELECT * FROM przedmiot LIMIT $limit_p";
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