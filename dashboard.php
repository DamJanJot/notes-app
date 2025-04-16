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


$servername = "";
$username = "";
$password = "";
$dbname = "";


$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Połączenie nieudane: " . $conn->connect_error);
}



// Pobranie liczby nieprzeczytanych wiadomości
$sql = "SELECT COUNT(*) as nowe_wiadomosci FROM wiadomosci WHERE odbiorca_id = ? AND przeczytana = FALSE";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$nowe_wiadomosci = $row['nowe_wiadomosci'];

$stmt->close();
$conn->close();
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
    <link rel="stylesheet" href="../css/main.css">
    
    
    <script src="https://kit.fontawesome.com/ef9d577567.js" crossorigin="anonymous"></script>

    <link rel="website icon" type="png" href="../img/kossmo.png">

    <meta name="description" content="Me website">
    
</head>

<body data-bs-spy="scroll" data-bs-target="#navId">







    <!-- =========================NAV======================================= -->

    <nav class="navbar navbar-expand-lg position-fixed top-0 w-100" id="navId">
        <div class="container">
            <a class="navbar-brand" href="../dashboard.php"><img src="./img/kossmo.png" style="width: 50px;" alt="logo"></a>
            
                   <h3 class="text-center"> <?php echo $_SESSION['imie']; ?></h3>

            
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <!-- <i class="fa-solid fa-bars"></i> -->
                <i class="fa-solid fa-align-justify"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">

                    <a href="../dashboard.php" type="button" class="button btn btn-outline-primary position-relative">Home <i class="fa-solid fa-house"></i></a>
                <!--    <a href="###" type="button" class="button btn btn-outline-primary position-relative"> <i class="fa-solid fa-sd-card"></i></a>   -->

                    
        <div class="btn-group">
            <button type="button" class="button btn btn-outline-primary position-relative dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                 Współdzielony <i class="fa-solid fa-people-group"></i>
            </button>
                <ul class="dropdown-menu dropdown-menu-end"> 
                    
                    <a href="../note.php" type="button" class="button btn btn-outline-primary position-relative">Notatnik treści<i class="fa-solid fa-sd-card"></i></a>
                    <a href="http://edyt.j.pl/" type="button" class="button btn btn-outline-primary position-relative">Terminal kodu Live<i class="fa-solid fa-terminal"></i></a>
                <!--    <a href="./portfel.php" type="button" class="button btn btn-outline-primary position-relative">Portfel <i class="fa-brands fa-cc-visa"></i></a>  -->
                    <a href="../dysk/dysk.php" type="button" class="button btn btn-outline-primary position-relative">Dysk do zapisu<i class="fa-solid fa-sd-card"></i></a>
                    
                                    
            </ul>
        </div>                          
                    
                    
        <div class="btn-group">
            <button type="button" class="button btn btn-outline-primary position-relative dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                 Prywatne <i class="fa-solid fa-eye-slash"></i>
            </button>
                <ul class="dropdown-menu dropdown-menu-end"> 
                    
                    <a href="./dashboard.php" type="button" class="button btn btn-outline-primary position-relative">Twój notes <i class="fa-solid fa-sd-card"></i></a>
               <!--     <a href="http://edyt.j.pl/" type="button" class="button btn btn-outline-primary position-relative">Terminal <i class="fa-solid fa-terminal"></i></a>    -->
                    <a href="../portfel.php" type="button" class="button btn btn-outline-primary position-relative">Twój portfel <i class="fa-brands fa-cc-visa"></i></a>
                <!--    <a href="http://dysk.j.pl/" type="button" class="button btn btn-outline-primary position-relative">Dysk <i class="fa-solid fa-sd-card"></i></a> -->
                    
                                    
            </ul>
        </div>                             
                    
                    
                    
        <div class="btn-group">
            <button type="button" class="button btn btn-outline-primary position-relative dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                 Profil <i class="fa-solid fa-circle-user"></i>
            </button>
                <ul class="dropdown-menu dropdown-menu-end"> 
                
            <!--       <a href="lista_kont.php" type="button" class="button btn btn-outline-success position-relative">Lista użytkowników <i class="fa-solid fa-users"></i></a> -->

                    <a href="../profil.php" type="button" class="button btn btn btn-outline-secondary position-relative">Edytuj profil <i class="fa-solid fa-user-pen"></i></a>
                    
            <!--        <a href="profil.php" type="button" class="button btn btn btn-outline-secondary position-relative">Ustawienia<i class="fa-solid fa-gear"></i></a>    -->

                    <a href="../logout.php" type="button" class="button btn btn-outline-info position-relative">Wyloguj się <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                
            </ul>
        </div>      
                    
                    
                    
   
            
                </div>
            </div>
        </div>
    </nav>            
            
    <!-- ================================ -->



 <div style="height: 10vh";></div>




        <div class="container mt-4">
          <div class="btn-group-vertical" role="group" aria-label="Vertical button group" style="border-radius: 14px; background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0)); -webkit-backdrop-filter: blur (20px); backdrop-filter: blur (20px); box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37); border: 1px solid rgba(255, 255, 255, 0.18);">
    	     <div class="btn-group" role="group">   
      		    <div class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" type="button">
                 <h5> Dodaj notatke</h5>  <i class="fa-solid fa-circle-plus" style="font-size: 32px;"></i> 
                </div>
        	    <div class="dropdown-menu">
      	            <div class="dropdown-item" href="#">
                      
                                                  <form id="notatka-form" method="post" action="add_note.php">
                            <textarea name="tresc" class="form-control" placeholder="Wpisz treść notatki" required></textarea>
                            <select name="kolor" class="form-select mt-2">
                                <option value="yellow">Żółty</option>
                                <option value="lightblue">Niebieski</option>
                                <option value="lightgreen">Zielony</option>
                                <option value="pink">Różowy</option>
                                <option value="gray">Szary</option>
                                <option value="primary">Ciemny niebieski</option>
                                <option value="secondary">Granatowy</option>
                                <option value="dark">Ciemny</option>
                                <option value="purple">Fioletowy</option>
                                <option value="teal">teal</option>
                                <option value="orange">Pomarańczowy</option>
                                <option value="danger">Czerwony</option>
                                <option value="info">Błękitny</option>
                                <option value="black">Czarny</option>
                                <option value="white">Biały</option>
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

    
    
    
    
    
    
    

   <div id="phoneButton" onclick="togglePhone()">


            <a href="../czat.php" type="button" class="btn btn-primary position-relative">
                     
                    <?php if ($nowe_wiadomosci > 0): ?>
                    
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                   <?php echo $nowe_wiadomosci; ?></span>
                    
                        <span class="visually-hidden">unread messages</span>
                    <?php endif; ?>
                    
                    
              <div class="btn-group dropup">
  <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
    
    <i class="fa-solid fa-comment">
  </button>
  <form class="dropdown-menu p-4">
           <iframe class="glass-chat" src="../chat.php"  ></iframe>
        <!--   <iframe id="receiver" class="glass" style"min-height: 450px;" src="./chat.php"  ></iframe>   -->
  </form>
</div>                  
                    
                    
                </i>    </a>     

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





    <!-- ▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀ -->
    <!-- _____________________________footer_____________________________________ -->

    <footer class="bg-dark text-light py-4 text-center">


        <p class="mb-0"> &copy; 2025 | _๔ค๓ןคภן๏t_ 👨‍💻 </p>

    </footer>



    <!-- ============================================================================= -->




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>


    <script src="./js/script.js"></script>


</body>
</html>
