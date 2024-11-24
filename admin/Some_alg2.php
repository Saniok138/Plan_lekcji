<?php
try {
    // Подключение к базе данных
    $pdo = new PDO('mysql:host=localhost;dbname=plan_lekcji', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

// Получение данных из базы
$classes = $pdo->query("SELECT * FROM klasa")->fetchAll(PDO::FETCH_ASSOC);
$rooms = $pdo->query("SELECT * FROM sala")->fetchAll(PDO::FETCH_ASSOC);
$teachers = $pdo->query("SELECT * FROM nauczyciele")->fetchAll(PDO::FETCH_ASSOC);
$hours = $pdo->query("SELECT * FROM godzina")->fetchAll(PDO::FETCH_ASSOC);

// Проверка наличия необходимых данных
if (empty($classes) || empty($rooms) || empty($hours) || empty($teachers)) {
    die("Отсутствуют необходимые данные в базе данных.");
}

// Инициализация переменных
$schedule = []; // Итоговое расписание
$idCounter = 1; // Счетчик уникальных ID записей
$usedRooms = []; // Занятые аудитории
$usedTeachers = []; // Занятые учителя
$usedSubjects = []; // Занятые предметы
$reservedRooms = []; // Занятые аудитории [day][hour] => [roomId, ...]
$reservedTeachers = []; // Занятые учителя [day][hour] => [teacherId, ...]
$reservedSubjects = []; // Занятые предметы [day][hour] => [subjectId, ...]


// Функция: Получение доступной аудитории
function getAvailableRoom($rooms, &$reservedRooms, $day, $hour, $groupSize, $subjectType) {
    foreach ($rooms as $room) {
        // Проверка, свободна ли аудитория
        if (empty($reservedRooms[$day][$hour]) || !in_array($room['id_s'], $reservedRooms[$day][$hour])) {
            // Проверка на размер аудитории и тип
            if ($room['rozmiar'] >= $groupSize && $room['typ'] == $subjectType) {
                // Резервируем аудиторию
                $reservedRooms[$day][$hour][] = $room['id_s'];
                return $room;
            }
        }
    }
    return null;
}

// Функция: Получение доступного учителя
function getAvailableTeacher($teachers, &$reservedTeachers, $day, $hour) {
    foreach ($teachers as $teacher) {
        // Проверка, свободен ли учитель
        if (empty($reservedTeachers[$day][$hour]) || !in_array($teacher['id_n'], $reservedTeachers[$day][$hour])) {
            // Резервируем учителя
            $reservedTeachers[$day][$hour][] = $teacher['id_n'];
            return $teacher;
        }
    }
    return null;
}

// Функция: Получение доступного предмета
function getAvailableSubject($subjects, &$reservedSubjects, $day, $hour, $classId, $numberOfGroups, $group) {
    foreach ($subjects as $subject) {
        // Проверка, свободен ли предмет
        if (empty($reservedSubjects[$day][$classId][$group][$numberOfGroups]) || 
            !in_array($subject['id_p'], $reservedSubjects[$day][$classId][$group][$numberOfGroups])) {
            if ($subject['ilosc_grup'] == $numberOfGroups) {
                // Резервируем предмет
                $reservedSubjects[$day][$classId][$group][$numberOfGroups][] = $subject['id_p'];
                return $subject;
            }
        }
    }
    return null;
}

// Функция: Получение учителей для класса и предмета
function getTeacher($pdo, $classId, $subject) {
    $teacherStmt = $pdo->prepare("
        SELECT * FROM nauczyciele 
        JOIN nauczyciele_przedmiot ON nauczyciele.id_n = nauczyciele_przedmiot.id_n 
        JOIN nauczyciele_klasa ON nauczyciele.id_n = nauczyciele_klasa.id_n 
        WHERE nauczyciele_przedmiot.id_p = :id_p AND nauczyciele_klasa.id_k = :id_k
    ");
    $teacherStmt->execute(['id_p' => $subject['id_p'], 'id_k' => $classId]);
    return $teacherStmt->fetchAll(PDO::FETCH_ASSOC);
}

// Функция: Получение типа предмета
function getTypes($pdo, $subject) {
    $typeStmt = $pdo->prepare("SELECT typ FROM przedmiot WHERE id_p = :id_p");
    $typeStmt->execute(['id_p' => $subject['id_p']]);
    $type = $typeStmt->fetch(PDO::FETCH_ASSOC);
    return $type['typ'] ?? null;
}

// Функция для проверки и резервирования времени для учителя или аудитории
function reserveSlot(&$reservedArray, $day, $hour, $id) {
    // Проверяем, существует ли день и час в массиве резерваций
    if (!isset($reservedArray[$day])) {
        $reservedArray[$day] = [];
    }
    if (!isset($reservedArray[$day][$hour])) {
        $reservedArray[$day][$hour] = [];
    }

    // Если слот уже занят, возвращаем false
    if (in_array($id, $reservedArray[$day][$hour])) {
        return false;
    }

    // Резервируем слот
    $reservedArray[$day][$hour][] = $id;
    return true;
}

// Функция для формирования расписания
function getSchedule($idCounter, $classId, $subject, $groupLabel, $teacher, $room, $hour, $day) {
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

// Генерация расписания
for ($day = 1; $day <= 5; $day++) {
    for ($hour = 1; $hour <= 9; $hour++) {

        foreach ($classes as $class) {
            $classId = $class['id_k'];
            $freedays = $pdo->query("SELECT dni_wolne FROM dni_wolne WHERE id_k = $classId")->fetch(PDO::FETCH_ASSOC);
            $freeday = $freedays['dni_wolne'] ?? null;
            if (!empty($freeday) && $day == $freeday) continue;

            $stmt = $pdo->prepare("SELECT * FROM przedmiot_klasa WHERE id_k = :id_k");
            $stmt->execute(['id_k' => $classId]);
            $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $group = 1;
            $numberOfGroups = 1;
            $groupLabel = "{$group}/{$numberOfGroups}";
            
            $subject = getAvailableSubject($subjects, $reservedSubjects, $day, $hour, $classId, $numberOfGroups, $group);
            
            if ($subject) {
                $teachers = getTeacher($pdo, $classId, $subject);
                $teacher = getAvailableTeacher($teachers, $reservedTeachers, $day, $hour);
                $subjectType = getTypes($pdo, $subject);
                $room = getAvailableRoom($rooms, $reservedRooms, $day, $hour, $numberOfGroups, $subjectType);
                
                if ($teacher && $room && $subject) {
                    // Резервируем слот для учителя и аудитории
                    $teacherReserved = reserveSlot($reservedTeachers, $day, $hour, $teacher['id_n']);
                    $roomReserved = reserveSlot($reservedRooms, $day, $hour, $room['id_s']);

                    // Если удалось зарезервировать и учителя, и аудиторию
                    if ($teacherReserved && $roomReserved) {
                        $schedule[] = getSchedule($idCounter++, $classId, $subject, $groupLabel, $teacher, $room, $hour, $day);
                    } else {
                        // Если зарезервировать не удалось
                        echo "Не удалось зарезервировать слот для учителя или аудитории. День: $day, Час: $hour<br>";
                    }
                }
            }
        }
    }
}

// Вставка расписания в базу данных
try {
    $pdo->beginTransaction(); // Начало транзакции
    $stmt = $pdo->prepare("
        INSERT INTO plan_lekcji (id, id_k, id_p, grupa, id_n, id_s, id_g, dzien) 
        VALUES (:id, :id_k, :id_p, :grupa, :id_n, :id_s, :id_g, :dzien)
    ");
    
    foreach ($schedule as $lesson) {
        $stmt->execute($lesson); // Вставляем каждое занятие
    }
    $pdo->commit(); // Завершаем транзакцию
} catch (Exception $e) {
    $pdo->rollBack(); // Откат транзакции при ошибке
    die("Ошибка при вставке расписания: " . $e->getMessage());
}

echo "Расписание успешно сгенерировано!";
?>
