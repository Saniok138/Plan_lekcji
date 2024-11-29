<?php
$room = $_POST["room"] ?? 'AA';
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLAN <?php echo $room; ?></title>
    <link rel="stylesheet" href="../CSS/admin-style.css">
</head>

<body class="background">
    <div class="menu-main">
        <?php
        $pdo = new PDO('mysql:host=localhost;dbname=plan_lekcji',  'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM widok_plan_lekcji WHERE sala = :class ORDER BY dzien, id_g";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':class', $room, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            $schedule = [];
            foreach ($results as $row) {
                $schedule[$row['dzien']][$row['id_g']][] = [
                    'przedmiot' => $row['przedmiot'],
                    'grupa' => $row['grupa'],
                    'klasa' => $row['klasa'],
                    'nauczyciele' => $row['nauczyciele']
                ];
            }

            echo "<h2>Plan lekcji dla sali: $room</h2>";
            echo "<table cellspacing='0>";
            echo "<tr class='column'><th class='rekord'>Godzina</th>";

            $daysOfWeek = ['Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek'];
            foreach ($daysOfWeek as $day) {
                echo "<th class='rekord'>$day</th>";
            }
            echo "</tr>";

            for ($hour = 1; $hour <= 9; $hour++) {
                echo "<tr class='column'>";
                echo "<td class='rekord'>Lekcja $hour</td>";

                for ($day = 1; $day <= 5; $day++) {
                    echo "<td class='rekord'>";
                    if (!empty($schedule[$day][$hour])) {
                        foreach ($schedule[$day][$hour] as $lesson) {
                            if($lesson['grupa']=='1/1')
                            echo htmlspecialchars($lesson['przedmiot']) . " ";
                            else
                            echo htmlspecialchars($lesson['przedmiot']) . "-" . htmlspecialchars($lesson['grupa']) . " ";
                            echo "<form style='display: inline;' method='post' action='../classes/classes.php'><button type='submit' name='class' value='" . htmlspecialchars($lesson['klasa']) . "' 
                                style='
                                    background: none; 
                                    border: none; 
                                    color: inherit; 
                                    font: inherit; 
                                    cursor: pointer; 
                                    padding: 0;
                                '>" . 
                                htmlspecialchars($lesson['klasa']) . 
                            "</button></form> ";
                            echo "<form style='display: inline;' method='post' action='../classes/teachers.php'><button type='submit' name='teacher' value='" . htmlspecialchars($lesson['nauczyciele']) . "' 
                                style='
                                    background: none; 
                                    border: none; 
                                    color: inherit; 
                                    font: inherit; 
                                    cursor: pointer; 
                                    padding: 0;
                                '>" . 
                                htmlspecialchars($lesson['nauczyciele']) . 
                            "</button></form><br>";
                        }
                    } else {
                        echo "—";
                    }
                    echo "</td>";
                }

                echo "</tr>";
            }

            echo "</table>
            <form action='../index.php' method='post'>
                <input type='submit' name='submit' class='return' value='RETURN'>
            </form>";
        } else {
            echo "<p>Brak wyników для sali $room</p>";
        }
        ?>
    </div>
</body>

</html>