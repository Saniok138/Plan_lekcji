<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=plan_lekcji', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
$pl_id = $pdo->query("SELECT id FROM plan_lekcji")->fetch(PDO::FETCH_ASSOC);
if(!$pl_id){
    $classes = $pdo->query("SELECT * FROM klasa")->fetchAll(PDO::FETCH_ASSOC);
    $rooms = $pdo->query("SELECT * FROM sala")->fetchAll(PDO::FETCH_ASSOC);
    $hours = $pdo->query("SELECT * FROM godzina")->fetchAll(PDO::FETCH_ASSOC);
    if (empty($classes) || empty($rooms) || empty($hours)) {
        die("Missing necessary data from the database.");
    }    
    
    $schedule = [];
    $idCounter = 1;
    $usedHours = [];
    $usedRooms = [];
    $usedTeachers = [];
    $usedSubjects = [];
    $usedLessons = [];
    $emptyHoursStart = [];
    $emptyHoursEnd = [];

    for ($day = 1; $day <= 5; $day++) {
        foreach ($classes as $class) {
            $classId = $class['id_k'];
            $emptyHoursStart[$classId][$day] = rand(0, 2);
            $emptyHoursEnd[$classId][$day] = 9 - rand(0, 1);
        }
    }

    function getAvailableRoom($rooms, &$usedRooms, $day, $hour, $groupSize, $subjectType) {
        shuffle($rooms);
        foreach ($rooms as $room) {
            if (empty($usedRooms[$day][$hour]) || !in_array($room['id_s'], $usedRooms[$day][$hour])) {
                if ($room['rozmiar'] >= $groupSize && ($room['typ'] == $subjectType)) {
                    $usedRooms[$day][$hour][] = $room['id_s'];
                    return $room;
                }
            }
        }
        return null;
    }

    function getAvailableRooms($rooms, &$usedRooms, $day, $hour, $groupSize, $subjectType) {
        shuffle($rooms);
        foreach ($rooms as $room) {
            if (empty($usedRooms[$day][$hour]) || !in_array($room['id_s'], $usedRooms[$day][$hour])) {
                if ($room['rozmiar'] == 2) {
                    $usedRooms[$day][$hour][] = $room['id_s'];
                    return $room;
                }
            }
        }
        return null;
    }

    function getAvailableTeacher($teachers, &$usedTeachers, $day, $hour) {
        shuffle($teachers);
        foreach ($teachers as $teacher) {
            if (empty($usedTeachers[$day][$hour]) || !in_array($teacher['id_n'], $usedTeachers[$day][$hour])) {
                $usedTeachers[$day][$hour][] = $teacher['id_n'];
                return $teacher;
            }
        }
        return null;
    }    

    function getAvailableSubject($subjects, &$usedSubjects, $day, $hour, $classId, $numberOfGroups, $group) {
        shuffle($subjects);
        foreach ($subjects as $subject) {
            $numberOfHours = $subject['ilosc_godzin'];
            $numberOfGroup = $subject['ilosc_grup'];
            if (empty($usedSubjects[$classId][$group][$numberOfGroups]) || 
                !array_key_exists($subject['id_p'], $usedSubjects[$classId][$group][$numberOfGroups])) {
                if ($numberOfGroup == $numberOfGroups) {               
                    $usedSubjects[$classId][$group][$numberOfGroups][$subject['id_p']] = [1];
                    return $subject;
                }
            }
            if (isset($usedSubjects[$classId][$group][$numberOfGroups][$subject['id_p']])) {
                $currentCount = count($usedSubjects[$classId][$group][$numberOfGroups][$subject['id_p']]);
                if ($numberOfGroup == $numberOfGroups && $currentCount < $numberOfHours) {   
                    $usedSubjects[$classId][$group][$numberOfGroups][$subject['id_p']][] = 1; 
                    return $subject;
                }
            }
        }
        return null;
    }

    function getSchedule(&$usedLessons, $idCounter, $classId, $subject, $groupLabel, $teacher, $room, $hour, $day) {
        $usedLessons[$day][$hour][$classId] = true;
        return [ 
            'id' => $idCounter,
            'id_k' => $classId,
            'id_p' => $subject['id_p'],
            'grupa' => $groupLabel,
            'id_n' => $teacher['id_n'],
            'id_s' => $room['id_s'],
            'id_g' => $hour,
            'dzien' => $day
        ];
    }

    function getTeacher($pdo,$classId,$subject) {
        $teacherStmt = $pdo->prepare("SELECT * FROM nauczyciele JOIN nauczyciele_przedmiot ON(nauczyciele.id_n = nauczyciele_przedmiot.id_n) JOIN nauczyciele_klasa ON (nauczyciele.id_n = nauczyciele_klasa.id_n) WHERE nauczyciele_przedmiot.id_p = :id_p AND nauczyciele_klasa.id_k = :id_k");
        $teacherStmt->execute(['id_p' => $subject['id_p'], 'id_k' => $classId]);
        $t = $teacherStmt->fetchAll(PDO::FETCH_ASSOC);
        return $t;
    }

    function getTeachers($pdo,$classId,$subject) {
        $teacherStmt = $pdo->prepare("SELECT * FROM nauczyciele JOIN nauczyciele_przedmiot ON(nauczyciele.id_n = nauczyciele_przedmiot.id_n) WHERE nauczyciele_przedmiot.id_p = :id_p");
        $teacherStmt->execute(['id_p' => $subject['id_p']]);
        $t = $teacherStmt->fetchAll(PDO::FETCH_ASSOC);
        return $t;
    }

    function getTypes($pdo,$subject) {
        $typeStmt = $pdo->prepare('SELECT typ FROM przedmiot WHERE id_p = :id_p');
        $typeStmt->execute(['id_p' => $subject['id_p']]);
        $s = $typeStmt->fetch(PDO::FETCH_ASSOC);
        return $s['typ'];
    }

    for ($day = 1; $day <= 5; $day++) {
        for ($hour = 1; $hour <= 9; $hour++) {
            foreach ($classes as $class) {
                $classId = $class['id_k'];
                if($emptyHoursStart[$classId][$day]>=$hour) continue;
                if($emptyHoursEnd[$classId][$day]<$hour) continue;
                
                $freedays = $pdo->query("SELECT dni_wolne FROM dni_wolne WHERE id_k = $classId")->fetch(PDO::FETCH_ASSOC);
                $freeday = $freedays['dni_wolne'] ?? null;                
                if (!empty($freeday) && $day == $freeday) continue;
                $stmt = $pdo->prepare("SELECT * FROM przedmiot_klasa WHERE id_k = :id_k");
                $stmt->execute(['id_k' => $classId]);
                $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach(range(1,2) as $group){
                    $numberOfGroups = 2;
                    $groupLabel = "{$group}/{$numberOfGroups}";
                    $subject = getAvailableSubject($subjects, $usedSubjects, $day, $hour, $classId, $numberOfGroups, $group);
                    if(!$subject && ($group == 1 || $group == 2)){
                        continue;
                    }else{
                        $teachers = getTeacher($pdo, $classId, $subject);
                        $teacher = getAvailableTeacher($teachers, $usedTeachers, $day, $hour, $pdo);
                        if(!$teacher){
                            $teachers = getTeachers($pdo, $classId, $subject);                    
                            $teacher = getAvailableTeacher($teachers, $usedTeachers, $day, $hour, $pdo);
                        }
                        $subjectType = getTypes($pdo, $subject);
                        $room = getAvailableRoom($rooms, $usedRooms, $day, $hour, $numberOfGroups, $subjectType);
                        if(!$room){
                            $room = getAvailableRooms($rooms, $usedRooms, $day, $hour, $numberOfGroups, $subjectType);
                        }
                        if((!$room || !$teacher || !$subject)){
                            $key = array_search($subject['id_p'], $usedSubjects[$classId][$group][$numberOfGroups]);
                            if ($key != false) {
                                unset($usedSubjects[$classId][$group][$amount][$numberOfGroups][$key]);
                            }
                        }
                    }
                    if($teacher && $room && $subject)
                        $schedule[] = getSchedule($usedLessons, $idCounter++, $classId, $subject, $groupLabel, $teacher, $room, $hour, $day);
                    }
                }
            }
        }
    
    for ($day = 1; $day <= 5; $day++) {
        for ($hour = 1; $hour <= 9; $hour++) {
            foreach ($classes as $class) {
                $classId = $class['id_k'];
                if($emptyHoursStart[$classId][$day]>=$hour) continue;
                if($emptyHoursEnd[$classId][$day]<$hour) continue;
                if (isset($usedLessons[$day][$hour][$classId])) continue;  
                $freedays = $pdo->query("SELECT dni_wolne FROM dni_wolne WHERE id_k = $classId")->fetch(PDO::FETCH_ASSOC);
                $freeday = $freedays['dni_wolne'] ?? null;
                if (!empty($freeday) && $day == $freeday) continue;
                $stmt = $pdo->prepare("SELECT * FROM przedmiot_klasa WHERE id_k = :id_k");
                $stmt->execute(['id_k' => $classId]);
                $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $group = 1;
                $numberOfGroups = 1;
                $groupLabel = "{$group}/{$numberOfGroups}";
                $subject = getAvailableSubject($subjects, $usedSubjects, $day, $hour, $classId, $numberOfGroups, $group);
                if($subject){
                    $teachers = getTeacher($pdo, $classId, $subject);
                    $teacher = getAvailableTeacher($teachers, $usedTeachers, $day, $hour, $pdo);
                    if(!$teacher){
                        $teachers = getTeachers($pdo, $classId, $subject);                    
                        $teacher = getAvailableTeacher($teachers, $usedTeachers, $day, $hour, $pdo);
                    }
                    $subjectType = getTypes($pdo, $subject);
                    $room = getAvailableRoom($rooms, $usedRooms, $day, $hour, $numberOfGroups, $subjectType);
                    if(!$room){
                        $room = getAvailableRooms($rooms, $usedRooms, $day, $hour, $numberOfGroups, $subjectType);
                    }
                    if((!$room || !$teacher || !$subject)){
                        $key = array_search($subject['id_p'], $usedSubjects[$classId][$group][$numberOfGroups]);
                        if ($key != false) {
                            unset($usedSubjects[$classId][$group][$amount][$numberOfGroups][$key]);
                        }
                    }
                    if($teacher && $room){
                        $schedule[] = getSchedule($usedLessons, $idCounter++, $classId, $subject, $groupLabel, $teacher, $room, $hour, $day);
                    }
                }
            }
        }
    }
    $stmt = $pdo->prepare("
        INSERT INTO plan_lekcji (id, id_k, id_p, grupa, id_n, id_s, id_g, dzien) 
        VALUES (:id, :id_k, :id_p, :grupa, :id_n, :id_s, :id_g, :dzien)
    ");
    try {
        $pdo->beginTransaction();
        foreach ($schedule as $lessons) {
            $stmt->execute($lessons);
        }
        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        die("Failed to insert schedule: " . $e->getMessage());
    }    
    header("Refresh:1");
}
if($pl_id){
    echo "Schedule generated";
    echo '<form method="POST" action="delete_schedule.php" onsubmit="return confirm(\'Are you sure you want to delete all lessons from the schedule?\');">
        <button type="submit">Clear Schedule</button>
        </form>
        <form method="POST" action="../index.php">
        <button type="submit">RETURN</button>
        </form>';
    try {
        $sql = "SELECT * FROM widok_plan_lekcji";
        $stmt = $pdo->query($sql);
        if ($stmt->rowCount() > 0) {
            echo "<table border='1'>";
            $columns = $stmt->columnCount();
            echo "<tr>";
            for ($i = 0; $i < $columns; $i++) {
                $column = $stmt->getColumnMeta($i);
                echo "<th>" . htmlspecialchars($column['name']) . "</th>";
            }
            echo "</tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                foreach ($row as $data) {
                    echo "<td>" . htmlspecialchars($data) . "</td>";
                }
                echo "</tr>";
            }
            
            echo "</table>";
        } else {
            echo "Brak wyników w widoku: widok_plan_lekcji";
        }
    } 
    catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>