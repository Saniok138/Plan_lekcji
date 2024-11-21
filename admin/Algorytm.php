<?php
$pdo = new PDO('mysql:host=localhost;dbname=plan_lekcji', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Pobierz dane tylko dla jednej klasy
$classId = 1; // Przykładowa klasa o ID 1
$class = $pdo->query("SELECT * FROM klasa WHERE id_k = $classId")->fetch(PDO::FETCH_ASSOC);
$subjects = $pdo->query("SELECT * FROM przedmiot_klasa WHERE id_k = $classId")->fetchAll(PDO::FETCH_ASSOC);
$teachers = $pdo->query("SELECT * FROM nauczyciele")->fetchAll(PDO::FETCH_ASSOC);
$rooms = $pdo->query("SELECT * FROM sala")->fetchAll(PDO::FETCH_ASSOC);
$freedays = $pdo->query("SELECT * FROM dni_wolne WHERE id_k = $classId")->fetch(PDO::FETCH_ASSOC);
//$class_teachers = $pdo->query("SELECT * FROM nauczyciele_klasa WHERE id_k = $classId")->fetchAll(PDO::FETCH_ASSOC);
$hours = $pdo->query("SELECT * FROM godzina")->fetchAll(PDO::FETCH_ASSOC);

// Zmienna na ID (jeśli nie korzystasz z AUTO_INCREMENT)
$idCounter = 1;
$schedule = [];

// Pobierz dni wolne
$freeday = $freedays['dni_wolne'] ?? null;

// Przechowujemy już użyte dni, godziny i sale
$usedHours = []; // Tablica, która będzie trzymać zajęte godziny w dniach
$usedRooms = []; // Tablica, która będzie trzymać zajęte sale w dniach i godzinach
$teacherAvailability = []; // Dodaj tablicę dla zajętości nauczycieli

foreach ($subjects as $subject) {
    $subjectId = $subject['id_p'];
    $numberOfHours = $subject['ilosc_godzin'];
    $numberOfGroups = $subject['ilosc_grup'];
    $totalLessons = $numberOfHours * $numberOfGroups;

    $subjectType = $pdo->query("SELECT typ FROM przedmiot WHERE id_p = $subjectId")->fetch(PDO::FETCH_ASSOC);
    $subjectType = $subjectType['typ'];
    $teachers = $pdo->query("SELECT nauczyciele.* FROM nauczyciele JOIN nauczyciele_przedmiot ON(nauczyciele.id_n = nauczyciele_przedmiot.id_n) JOIN nauczyciele_klasa ON (nauczyciele.id_n = nauczyciele_klasa.id_n) WHERE nauczyciele_przedmiot.id_p = $subjectId AND nauczyciele_klasa.id_k = $classId")->fetchAll(PDO::FETCH_ASSOC);

    // Liczba lekcji dla każdej grupy
    $groupLessonCount = array_fill(1, $numberOfGroups, 0);

    // Specjalna logika dla WF
    $isPE = ($subjectType === 'wf');
    $peDayAssigned = false;

    // Dni tygodnia i godziny
    for ($day = 1; $day <= 5; $day++) {
        if ($day == $freeday) continue; // Pomijamy dni wolne

        $dayGroupHours = array_fill(1, $numberOfGroups, 0); // Licznik godzin grup w danym dniu

        for ($hour = 1; $hour <= 9; $hour++) {
            if (isset($usedHours[$day][$hour])) continue; // Godzina już zajęta

            // Obsługa WF: jeśli to WF, dwie godziny w jednym dniu
            if ($isPE && !$peDayAssigned && $dayGroupHours[1] === 2) {
                $peDayAssigned = true;
                continue;
            }

            foreach (range(1, $numberOfGroups) as $group) {
                if ($groupLessonCount[$group] >= $numberOfHours) continue; // Grupa ma już zaplanowane wszystkie lekcje
                if ($dayGroupHours[$group] >= 2 && $isPE) continue; // Limit WF w jednym dniu dla grupy

                // Sprawdź, czy inna grupa ma ten sam przedmiot w tej godzinie
                $isSubjectTaken = false;
                foreach ($schedule as $lesson) {
                    if ($lesson['id_p'] == $subjectId && $lesson['dzien'] == $day && $lesson['id_g'] == $hour) {
                        $isSubjectTaken = true;
                        break;
                    }
                }

                if ($isSubjectTaken) continue; // Przejdź do następnej grupy, jeśli przedmiot jest już zajęty

                // Oznaczenie grupy w formacie `numer_grupy/ilość_grup`
                $groupLabel = "{$group}/{$numberOfGroups}";

                // Wybór nauczyciela
                $teacher = getAvailableTeacher($teachers, $day, $hour);
                if (!$teacher) {
                    echo "Brak dostępnego nauczyciela dla przedmiotu $subjectId, grupy $groupLabel w dniu $day, godzinie $hour\n";
                    continue;
                }

                // Wybór sali według typu
                $room = getAvailableRoom($rooms, $day, $hour, $numberOfGroups, $subjectType);
                if (!$room) {
                    echo "Brak dostępnej sali dla przedmiotu $subjectId, grupy $groupLabel w dniu $day, godzinie $hour\n";
                    continue;
                }

                // Dodanie lekcji do harmonogramu
                $schedule[] = [
                    'id' => $idCounter++,
                    'id_k' => $classId,
                    'id_p' => $subjectId,
                    'grupa' => $groupLabel,
                    'id_n' => $teacher['id_n'],
                    'id_s' => $room['id_s'],
                    'id_g' => $hour,
                    'dzien' => $day
                ];

                // Oznaczamy godzinę jako zajętą
                $usedHours[$day][$hour][$group] = true;

                // Aktualizujemy liczbę lekcji dla grupy
                $groupLessonCount[$group]++;
                $dayGroupHours[$group]++;

                // Jeśli zaplanowano wszystkie lekcje, przerywamy
                if (array_sum($groupLessonCount) >= $totalLessons) break 2;
            }
        }
    }
}

// Funkcja do wyboru sali według typu
function getAvailableRoom($rooms, $day, $hour, $groupSize, $subjectType) {
    foreach ($rooms as $room) {
        if (!isset($GLOBALS['usedRooms'][$day][$hour]) || !in_array($room['id_s'], $GLOBALS['usedRooms'][$day][$hour])) {
            if ($room['rozmiar'] >= $groupSize && $room['typ'] === $subjectType) { // Tylko sale o odpowiednim typie
                $GLOBALS['usedRooms'][$day][$hour][] = $room['id_s'];
                return $room;
            }
        }
    }
    return null;
}


function getAvailableTeacher($teachers, $day, $hour) {
    foreach ($teachers as $teacher) {
        if (!isset($GLOBALS['teacherAvailability'][$teacher['id_n']][$day][$hour])) {
            $GLOBALS['teacherAvailability'][$teacher['id_n']][$day][$hour] = true;
            return $teacher;
        }
    }
    return null;
}





// Zapisujemy do bazy
$stmt = $pdo->prepare("INSERT INTO plan_lekcji (id, id_k, id_p, grupa, id_n, id_s, id_g, dzien) VALUES (:id, :id_k, :id_p, :grupa, :id_n, :id_s, :id_g, :dzien)");
foreach ($schedule as $lessons) {
    $stmt->execute($lessons);
}

echo "Plan lekcji wygenerowany dla klasy o ID $classId!";
echo'<br><br><form action="../index.php" method="post">
      <input type="submit" class="return" name="submit" value="return">
  </form>';
?>
