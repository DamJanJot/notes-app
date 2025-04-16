<?php
session_start();
require 'config.php';

if (!isset($_SESSION['id'])) {
    die("Nie jesteś zalogowany!");
}

$user_id = $_SESSION['id'];
$tresc = trim($_POST['tresc']);
$kolor = $_POST['kolor'];

if ($tresc) {
    $stmt = $pdo->prepare("INSERT INTO notatki (uzytkownik_id, tresc, kolor) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $tresc, $kolor]);
}
?>
