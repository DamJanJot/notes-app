<?php
session_start();
require 'config.php';

if (!isset($_SESSION['id'])) {
    die("Nie jesteś zalogowany!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $note_id = $_POST['id'];
    $user_id = $_SESSION['id'];

    $stmt = $pdo->prepare("DELETE FROM notatki WHERE id = ? AND uzytkownik_id = ?");
    $stmt->execute([$note_id, $user_id]);

    if ($stmt->rowCount() > 0) {
        echo "Notatka usunięta!";
    } else {
        echo "Błąd: nie można usunąć notatki.";
    }
} else {
    echo "Błędne żądanie.";
}
