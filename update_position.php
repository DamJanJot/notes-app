<?php
session_start();
require 'config.php';

if (!isset($_SESSION['id'])) {
    die("Musisz się zalogować!");
}


$id = $_POST['id'];
$x = $_POST['x'];
$y = $_POST['y'];

$stmt = $pdo->prepare("UPDATE notatki SET pozycja_x = ?, pozycja_y = ? WHERE id = ? AND uzytkownik_id = ?");
$stmt->execute([$x, $y, $id, $_SESSION['id']]);
?>
