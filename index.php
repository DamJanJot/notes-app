<?php
session_start();
require 'config.php';

if (!isset($_SESSION['id'])) {
    die("Musisz się zalogować!");
}

$user_id = $_SESSION['id'];
$stmt = $pdo->prepare("SELECT * FROM notatki WHERE uzytkownik_id = ? ORDER BY id DESC");
$stmt->execute([$user_id]);
$notatki = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notatnik</title>
    
        <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="./styles.css">
    
    
    <script src="https://kit.fontawesome.com/ef9d577567.js" crossorigin="anonymous"></script>

    <link rel="website icon" type="png" href="./img/kossmo.png">

    <meta name="description" content="Me website">
    
</head>
<body>

        <div class="container mt-4">
          <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
    	     <div class="btn-group" role="group">   
      		    <div class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" type="button">
                 <h5> Dodaj notatke</h5>  <i class="fa-solid fa-circle-plus" style="font-size: 32px;"></i> 
                </div>
        	    <div class="dropdown-menu">
      	            <div class="dropdown-item" href="#">
                      
                                                  <form id="notatka-form" method="post" action="add_note.php">
                            <textarea name="tresc" class="form-control" placeholder="Wpisz treść notatki" required></textarea>
                            <select name="kolor" class="form-select mt-2">
                                <option value="lightblue">Jasny niebieski</option>
                                <option value="lightgreen">Jasny zielony</option>
                                <option value="pink">Jasny różowy</option>
                                <option value="gray">Szary</option>
                                <option value="dark">Przeźroczysty</option>
                                <option value="purple">Fioletowy</option>
                                <option value="teal">Ciemna zieleń</option>
                                <option value="orange">Pomarańczowy</option>
                                <option value="black">Czarny</option>
                                <option value="yellow">Żółty</option>
                                </select>
        
        <input type="text" name="tag" class="form-control mt-2" placeholder="Dodaj tagi (opcjonalnie)">
        <button type="submit" class="btn btn-primary mt-3">Dodaj notatkę</button>
        </form>
  
</div>
  
</div>
</div>
</div>          
</div>


<div class="container mt-4" id="notatki-container">
<?php foreach ($notatki as $notatka): ?>
<div class="notatka" data-id="<?= $notatka['id'] ?>"
style="background-color: <?= htmlspecialchars($notatka['kolor']) ?>;
    left: <?= $notatka['pozycja_x'] ?>px;
    top: <?= $notatka['pozycja_y'] ?>px;">
<p><?= nl2br(htmlspecialchars($notatka['tresc'])) ?></p>
<small><?= htmlspecialchars($notatka['tag']) ?></small>
<button class="btn btn-danger delete-note float-end" data-id="<?= $notatka['id'] ?>"><i class="fa-solid fa-trash"></i></button>
<button class="btn btn-success edit-note float-end" data-id="<?= $notatka['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></button>
</div>
<?php endforeach; ?>
</div>


<script>
$(function() {
$(".notatka").draggable({
stop: function(event, ui) {
let id = $(this).data("id");
let x = ui.position.left;
let y = ui.position.top;
$.post("update_position.php", { id: id, x: x, y: y });
}
});

$(".delete-note").click(function() {
let id = $(this).data("id");
$.post("delete_note.php", { id: id }, function() {
location.reload();
});
});

$(".edit-note").click(function() {
let id = $(this).data("id");
let newContent = prompt("Edytuj treść notatki:");
if (newContent !== null) {
$.post("edit_note.php", { id: id, tresc: newContent }, function() {
    location.reload();
});
}
});
});


$(function() {
$(".notatka").draggable({
stop: function(event, ui) {
let id = $(this).data("id");
let x = ui.position.left;
let y = ui.position.top;
$.post("update_position.php", { id: id, x: x, y: y });
}
});

$(".delete-note").click(function() {
let id = $(this).data("id");
$.post("delete_note.php", { id: id }, function() {
location.reload();
});
});

$(".notatka").dblclick(function() {
let $this = $(this);
let id = $this.data("id");
let currentText = $this.find("p").text();

let input = $("<textarea>")
.val(currentText)
.addClass("edit-textarea");

$this.find("p").replaceWith(input);
input.focus();

input.on("keypress", function(e) {
if (e.which === 13) { // Enter zapisuje
e.preventDefault();
let newText = input.val().trim();
if (newText !== "") {
$.post("edit_note.php", { id: id, tresc: newText }, function() {
    input.replaceWith(`<p>${newText}</p>`);
});
}
}
});

input.on("blur", function() { // Kliknięcie poza polem anuluje edycję
input.replaceWith(`<p>${currentText}</p>`);
});
});
});


$(document).ready(function() {
$("#notatka-form").submit(function(e) {
e.preventDefault(); // Zatrzymuje domyślne przekierowanie

let formData = $(this).serialize(); // Pobiera dane z formularza

$.post("add_note.php", formData, function(response) {
location.reload(); // Po dodaniu odświeża stronę
});
});
});


$(document).ready(function() {
function checkScreenSize() {
if ($(window).width() < 768) {
$("#notatki-container").addClass("mobile-list").removeClass("desktop-grid");
$(".notatka").removeClass("draggable");
} else {
$("#notatki-container").addClass("desktop-grid").removeClass("mobile-list");
$(".notatka").addClass("draggable");
}
}

checkScreenSize();
$(window).resize(checkScreenSize);

$(".notatka").draggable({
stop: function(event, ui) {
if ($(window).width() >= 768) { // Tylko na komputerze
let id = $(this).data("id");
let x = ui.position.left;
let y = ui.position.top;
$.post("update_position.php", { id: id, x: x, y: y });
}
}
});
});








</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
crossorigin="anonymous"></script>


</body>
</html>
