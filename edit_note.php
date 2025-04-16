<?php
session_start();
require 'config.php';

if (!isset($_SESSION['id'])) {
    die("Nie jesteś zalogowany!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['tresc'])) {
    $note_id = $_POST['id'];
    $new_content = trim($_POST['tresc']);
    $user_id = $_SESSION['id'];

    if (empty($new_content)) {
        die("Treść nie może być pusta!");
    }

    $stmt = $pdo->prepare("UPDATE notatki SET tresc = ? WHERE id = ? AND uzytkownik_id = ?");
    $stmt->execute([$new_content, $note_id, $user_id]);

    if ($stmt->rowCount() > 0) {
        echo "Notatka zaktualizowana!";
    } else {
        echo "Błąd: nie można edytować notatki.";
    }
} else {
    echo "Błędne żądanie.";
}
