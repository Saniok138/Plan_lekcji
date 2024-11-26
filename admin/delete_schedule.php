<?php
try {
    // Connect to the database
    $pdo = new PDO('mysql:host=localhost;dbname=plan_lekcji', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Execute the DELETE query
    $pdo->exec("DELETE FROM `plan_lekcji`");

    // Redirect back to the main page with a success message
    header("Location: ../index.php");
    exit;
} catch (PDOException $e) {
    // Handle any errors
    die("Failed to clear the schedule: " . $e->getMessage());
}
?>
