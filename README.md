# Notes App (Notatnik)

A simple web application for managing personal notes with drag-and-drop support.

## Features
- Add, edit, and delete personal notes
- Drag-and-drop positioning (AJAX-based)
- User authentication (each note belongs to a specific user)
- Responsive design

## Technologies Used
- PHP (with PDO)
- MySQL
- HTML/CSS/JS
- Bootstrap (optionally)

## Installation

1. Import `notatki` table into your MySQL database (see below).
2. Copy files to your web server.
3. Update `config.php` with your database credentials.
4. Log in to access your notes dashboard.

## Database Schema

```sql
CREATE TABLE notatki (
  id INT AUTO_INCREMENT PRIMARY KEY,
  uzytkownik_id INT NOT NULL,
  tresc TEXT NOT NULL,
  pozycja_x INT DEFAULT 0,
  pozycja_y INT DEFAULT 0,
  data_dodania DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

## License
MIT
