<style>
  body{
    position: block;
    background: linear-gradient(45deg, #b64c4c, #bb4e74, #845ec2, #2a9d8f);
    background-size: 350% 350%;
    }
    table{
      background: white;
    }
</style>
<?php 
session_start();
if(!isset($_SESSION["Admin"])){
    header(header: "Location: ./index.php");
    exit();
}else{
  $host = "localhost";
  $user = "root";
  $password = "";
  $database = "plan_lekcji";
  $conn = mysqli_connect($host, $user, $password, $database);
  if (!$conn) {
  die("Error connect: " . mysqli_connect_error());
  }

  echo "<h3>dni_wolne</h3>";
  include("./admin/dni_wolne.php");

  echo "<br><br><h3>nauczyciele_klasa</h3>";
  include("./admin/nauczyciele_klasa.php");

  echo "<br><br><h3>dni_nauczyciele</h3>";
  include("./admin/dni_nauczyciele.php");

  echo "<br><br><h3>nauczyciele_przedmiot</h3>";
  include("./admin/nauczyciele_przedmiot.php");

  echo "<br><br><h3>przedmiot_klasa</h3>";
  include("./admin/przedmiot_klasa.php");

  echo "<br><br><h3>godzina</h3>";
  include("./admin/godzina.php");

  echo "<br><br><h3>klasa</h3>";
  include("./admin/klasa.php");

  echo "<br><br><h3>nauczyciele</h3>";
  include("./admin/nauczyciele.php");

  echo "<br><br><h3>przedmiot</h3>";
  include("./admin/przedmiot.php");

  echo "<br><br><h3>sala</h3>";
  include("./admin/sala.php");

  echo "<br><br><h3>Update</h3>";
  echo '<form action="admin/update.php" method="post">
  <select name="tables">
  <option value="k">klasa</option>
  <option value="n">nauczyciele</option>
  <option value="p">przedmiot</option>
  <option value="g">godzina</option>
  <option value="s">sala</option>
  <option value="pk">przedmiot_klasa</option>
  <option value="nk">nauczyciele_klasa</option>
  <option value="np">nauczyciele_przedmiot</option>
  <option value="dw">dni_wolne</option>
  <option value="dn">dni_nauczyciele</option>
  </select>
  <input type="submit" name="submit" value="update">
  </form>';

  echo'<br><br><form action="./index.php" method="post">
      <input type="submit" name="submit" value="return">
  </form>';
}
?>