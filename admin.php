<link rel="stylesheet" href="./CSS/admin-style.css">
<body class="background">
<div class="menu-main">
<form action='' method="post">
        <select class="change-classes"  id="change-classes" name="change-classes">
          <option value="dni_wolne">dni wolne</option>
          <option value="nauczyciele_klasa">nauczyciele klasa</option>
          <option value="dni_nauczyciele">dni nauczyciele</option>
          <option value="nauczyciele_przedmiot">nauczyciele przedmiot</option>
          <option value="przedmiot_klasa">przedmiot klasa</option>
          <option value="godzina">godzina</option>
          <option value="sala">sala</option>
          <option value="przedmiot">przedmiot</option>
          <option value="nauczyciele">nauczyciele</option>
          <option value="klasa">klasa</option>
        </select>
        <input type="submit" class="presentation" value="PRESENTATION">
    </form>
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
  echo '<form action="admin/update.php" method="post">
  <h2 style="color: antiquewhite;">UPDATE</h2>
  <select class="change-classes" name="tables">
  <option value="k">klasa</option>
  <option value="n">nauczyciele</option>
  <option value="p">przedmiot</option>
  <option value="g">godzina</option>
  <option value="s">sala</option>
  <option value="pk">przedmiot_klasa</option>
  <option value="nk">nauczyciele_klasa</option>
  <option value="np">nauczyciele_przedmiot</option>
  <option value="dw">dni_wolne</option>
  </select>
  <input type="submit" class="presentation" name="submit" value="UPDATE">
  </form>';

  echo'<br><br><form action="./index.php" method="post">
    <input type="submit" name="submit" class="return" value="RETURN">
  </form>';


  $option = $_POST["change-classes"] ?? null;

  if( $option == "dni_wolne"){
    echo "<h3 style='color: antiquewhite;'>dni_wolne</h3>";
    include("./admin/dni_wolne.php");
  }

  if($option == "nauczyciele_klasa"){
    echo "<h3 style='color: antiquewhite;'>nauczyciele_klasa</h3>";
    include("./admin/nauczyciele_klasa.php");
  }

  if($option == "dni_nauczyciele"){
    echo "<h3 style='color: antiquewhite;'>dni_nauczyciele</h3>";
    include("./admin/dni_nauczyciele.php");
  }

  if($option == "nauczyciele_przedmiot"){
    echo "<h3 style='color: antiquewhite;'>nauczyciele_przedmiot</h3>";
    include("./admin/nauczyciele_przedmiot.php");
  }

  if($option == "przedmiot_klasa"){
    echo "<h3 style='color: antiquewhite;'>przedmiot_klasa</h3>";
    include("./admin/przedmiot_klasa.php");
  }  

  if($option == "godzina"){
    echo "<h3 style='color: antiquewhite;'>godzina</h3>";
    include("./admin/godzina.php");
  }  

  if($option == "klasa"){
    echo "<h3 style='color: antiquewhite;'>klasa</h3>";
    include("./admin/klasa.php");
  }

  if($option == "nauczyciele"){
    echo "<h3 style='color: antiquewhite;'>nauczyciele</h3>";
    include("./admin/nauczyciele.php");
  }

  if($option == "przedmiot"){
    echo "<h3 style='color: antiquewhite;'>przedmiot</h3>";
    include("./admin/przedmiot.php");
  }

  if($option == "sala"){  
    echo "<h3 style='color: antiquewhite;'>sala</h3>";
    include("./admin/sala.php");
  }
}
?></div>
</body>