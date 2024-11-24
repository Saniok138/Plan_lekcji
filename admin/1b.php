<?php
try {
    // Подключение к базе данных
    $pdo = new PDO('mysql:host=localhost;dbname=plan_lekcji', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Получение ID класса "1P"
$classId = getClassId($pdo, '1P');
if (!$classId) {
    die("Class '1P' not found in the database.");
}

// Получение расписания для класса "1P"
$schedule = getClassSchedule($pdo, $classId);

// Проверяем, есть ли расписание
if (empty($schedule)) {
    die("No schedule found for class '1P'.");
}

// Отображение расписания
renderSchedule($schedule);

// --- Функции ---

// Получить ID класса по его имени
function getClassId($pdo, $className) {
    $query = $pdo->prepare("SELECT id_k FROM klasa WHERE numer_k = :numer_k");
    $query->execute(['numer_k' => $className]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result['id_k'] ?? null;
}

// Получить расписание для заданного ID класса
function getClassSchedule($pdo, $classId) {
    $query = $pdo->prepare("
        SELECT 
            godzina.start AS start_time,
            godzina.koniec AS end_time,
            przedmiot.nazwa AS subject_name,
            nauczyciele.imie_nazwisko AS teacher_name,
            sala.numer AS room_number,
            plan_lekcji.dzien AS day_of_week
        FROM plan_lekcji
        JOIN godzina ON plan_lekcji.id_g = godzina.id_g
        JOIN przedmiot ON plan_lekcji.id_p = przedmiot.id_p
        JOIN nauczyciele ON plan_lekcji.id_n = nauczyciele.id_n
        JOIN sala ON plan_lekcji.id_s = sala.id_s
        WHERE plan_lekcji.id_k = :id_k
        ORDER BY plan_lekcji.dzien, godzina.id_g
    ");
    $query->execute(['id_k' => $classId]);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// Отобразить расписание в формате HTML-таблицы
function renderSchedule($schedule) {
    echo "<h1>Schedule for Class 1P</h1>";
    echo "<table border='1' cellpadding='10' cellspacing='0'>";
    echo "<thead>
            <tr>
                <th>Day</th>
                <th>Time</th>
                <th>Subject</th>
                <th>Teacher</th>
                <th>Room</th>
            </tr>
          </thead>";
    echo "<tbody>";

    $currentDay = null;

    foreach ($schedule as $lesson) {
        // Если начинается новый день, выводим его название
        if ($currentDay !== $lesson['day_of_week']) {
            $currentDay = $lesson['day_of_week'];
            echo "<tr><td colspan='5' style='text-align:center; font-weight:bold; background-color:#f0f0f0;'>"
                . getDayName($currentDay) . "</td></tr>";
        }

        // Выводим урок
        echo "<tr>
                <td></td> <!-- Пустая ячейка, так как день уже выведен -->
                <td>{$lesson['start_time']} - {$lesson['end_time']}</td>
                <td>{$lesson['subject_name']}</td>
                <td>{$lesson['teacher_name']}</td>
                <td>{$lesson['room_number']}</td>
              </tr>";
    }

    echo "</tbody>";
    echo "</table>";
}

// Перевести номер дня недели в название
function getDayName($dayNumber) {
    $days = [
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday'
    ];
    return $days[$dayNumber] ?? 'Unknown';
}
?>
