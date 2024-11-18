<?php
$pdo = new PDO('mysql:host=localhost;dbname=plan_lekcji', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Pobierz dane tylko dla jednej klasy
$klasaId = 1; // Przykładowa klasa o ID 1
$klasa = $pdo->query("SELECT * FROM klasa WHERE id_k = $klasaId")->fetch(PDO::FETCH_ASSOC);
$przedmioty = $pdo->query("SELECT * FROM przedmiot_klasa WHERE id_k = $klasaId")->fetchAll(PDO::FETCH_ASSOC);
$nauczyciele = $pdo->query("SELECT * FROM nauczyciele")->fetchAll(PDO::FETCH_ASSOC);
$sale = $pdo->query("SELECT * FROM sala")->fetchAll(PDO::FETCH_ASSOC);
$dniWolne = $pdo->query("SELECT * FROM dni_wolne WHERE id_k = $klasaId")->fetch(PDO::FETCH_ASSOC);
$dostepniNauczyciele = $pdo->query("SELECT * FROM nauczyciele_klasa WHERE id_k = $klasaId")->fetchAll(PDO::FETCH_ASSOC);
$godziny = $pdo->query("SELECT * FROM godzina")->fetchAll(PDO::FETCH_ASSOC);

// Zmienna na ID (jeśli nie korzystasz z AUTO_INCREMENT)
$idCounter = 1;
$harmonogram = [];

// Pobierz dni wolne
$dzienWolny = $dniWolne['dni_wolne'] ?? null;

// Przechowujemy już użyte dni, godziny i sale
$uzyteGodziny = []; // Tablica, która będzie trzymać zajęte godziny w dniach
$uzyteSale = []; // Tablica, która będzie trzymać zajęte sale w dniach i godzinach

// Pobierz nauczycieli przypisanych do przedmiotów
foreach ($przedmioty as $przedmiot) {
    $iloscGodzin = $przedmiot['ilosc_godzin'];
    $iloscGrup = $przedmiot['ilosc_grup'];
    $przedmiotId = $przedmiot['id_p'];

    // Pobieramy nauczycieli dla tego przedmiotu
    $nauczycieleDlaPrzedmiotu = $pdo->query("SELECT nauczyciele.* 
                                               FROM nauczyciele 
                                               JOIN nauczyciele_przedmiot 
                                               ON nauczyciele.id_n = nauczyciele_przedmiot.id_n 
                                               WHERE nauczyciele_przedmiot.id_p = $przedmiotId")
                                    ->fetchAll(PDO::FETCH_ASSOC);

    // Sprawdź, czy nauczyciele zostali przypisani do przedmiotu
    if (empty($nauczycieleDlaPrzedmiotu)) {
        echo "Brak nauczycieli dla przedmiotu o ID $przedmiotId.\n";
        continue;
    }

    // Pętla przez dni tygodnia (1-5)
    for ($dzien = 1; $dzien <= 5; $dzien++) {
        if ($dzien == $dzienWolny) continue; // Skip dzień wolny

        // Pętla przez godziny (z losowaniem)
        $usedHours = []; // Przechowujemy już użyte godziny w tym dniu

        for ($godzina = 1; $godzina <= 9; $godzina++) {
            // Sprawdzamy, czy godzina jest już zajęta w tym dniu
            if (in_array($godzina, $uzyteGodziny[$dzien] ?? [])) {
                continue; // Jeśli godzina jest już zajęta, przechodzimy do kolejnej
            }

            // Dodajemy godzinę do użytych godzin w tym dniu
            $uzyteGodziny[$dzien][] = $godzina;

            // Losowanie nauczyciela (pierwszy dostępny nauczyciel)
            $nauczyciel = $nauczycieleDlaPrzedmiotu[array_rand($nauczycieleDlaPrzedmiotu)];

            // Sprawdzamy dostępność sali
            $sala = array_values(array_filter($sale, function($s) use ($iloscGrup, $dzien, $godzina) {
                // Sprawdzamy, czy sala jest dostępna w tym dniu i godzinie
                if (isset($GLOBALS['uzyteSale'][$dzien][$godzina]) && in_array($s['id_s'], $GLOBALS['uzyteSale'][$dzien][$godzina])) {
                    return false; // Jeśli sala jest już zajęta w tej godzinie, pomijamy ją
                }
                return $s['rozmiar'] >= ($iloscGrup > 1 ? 1 : 2); // Sala powinna mieć odpowiedni rozmiar
            }));

            if (empty($sala)) {
                echo "Brak sali dla przedmiotu $przedmiotId.\n";
                continue;
            }

            // Wybieramy pierwszą dostępną salę
            $sala = $sala[0];

            // Dodajemy salę do zajętej w tym dniu i godzinie
            $uzyteSale[$dzien][$godzina][] = $sala['id_s'];

            // Debugowanie przypisania
            echo "Przypisano: Klasa ID: $klasaId, Przedmiot ID: $przedmiotId, Nauczyciel: {$nauczyciel['imie_nazwisko']}, Sala: {$sala['numer']}, Dzień: $dzien, Godzina: $godzina\n";

            // Dodajemy do harmonogramu
            $harmonogram[] = [
                'id' => $idCounter++, 
                'id_k' => $klasaId,
                'id_p' => $przedmiotId,
                'id_n' => $nauczyciel['id_n'],
                'id_s' => $sala['id_s'],
                'id_g' => $godzina,
                'dzien' => $dzien
            ];

            $iloscGodzin--;
            if ($iloscGodzin <= 0) break 2; // Jeśli ilość godzin spadnie do 0, kończymy dla tego przedmiotu
        }
    }
}

// Zapisujemy do bazy
$stmt = $pdo->prepare("INSERT INTO plan_lekcji (id, id_k, id_p, id_n, id_s, id_g, dzien) VALUES (:id, :id_k, :id_p, :id_n, :id_s, :id_g, :dzien)");
foreach ($harmonogram as $zajecia) {
    $stmt->execute($zajecia);
}

echo "Plan lekcji wygenerowany dla klasy o ID $klasaId!";
?>
