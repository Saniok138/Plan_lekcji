<form action="admin/insert_into.php" method="post">
    <input name="dni" type="number" required>
    <input name="godzina" type="number" required>
    <input name="id_n" type="number" required>
    <input name="insert" value="dn" type="hidden">
    <button type="submit">Dodaj</button>
</form>
<?php
echo'<form action="" method="post">
    Limit:<input name="limit_dn" type="number">
    <input type="submit" name="submit" value="change">
</form>';
if(!isset($_POST["limit_dn"]))
$limit_dn=10;
else
$limit_dn=$_POST["limit_dn"];
$sql = "SELECT * FROM widok_dni_nauczyciele LIMIT $limit_dn";
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