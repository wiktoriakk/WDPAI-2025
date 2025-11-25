<?php

require_once 'AppController.php';


class SecurityController extends AppController {

    public function login() {

        if($this->isGet()) {
            return $this->render("login");
        } 

        $email = $_POST["email"] ?? '';
        $password = $_POST["password"] ?? '';

        // TODO: Implementacja weryfikacji użytkownika z bazą danych
        // 1. Połączenie z bazą danych (PDO/MySQLi)
        // 2. Przygotowanie zapytania SELECT z email
        // 3. Weryfikacja hasła (password_verify)
        // 4. Utworzenie sesji dla zalogowanego użytkownika
        // 5. Przekierowanie do dashboard
        
        // Tymczasowa implementacja - tylko dla developmentu
        var_dump($email, $password);
        
        // Po implementacji bazy danych:
        // if ($user = $this->getUserByEmail($email)) {
        //     if (password_verify($password, $user['password_hash'])) {
        //         $_SESSION['user_id'] = $user['id'];
        //         header('Location: /dashboard');
        //         exit;
        //     }
        // }
        // return $this->render("login", ["error" => "Nieprawidłowe dane logowania"]);

    }

    public function register() {

        if ($this->isGet()) {
            return $this->render("register");
        }

        $email = $_POST["email"] ?? '';
        $password1 = $_POST["password1"] ?? '';
        $password2 = $_POST["password2"] ?? '';
        $firstname = $_POST["firstname"] ?? '';
        $lastname = $_POST["lastname"] ?? '';

        // Walidacja danych
        $errors = [];
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Nieprawidłowy adres email";
        }
        
        if (empty($password1) || strlen($password1) < 8) {
            $errors[] = "Hasło musi mieć minimum 8 znaków";
        }
        
        if ($password1 !== $password2) {
            $errors[] = "Hasła nie są identyczne";
        }
        
        if (empty($firstname) || empty($lastname)) {
            $errors[] = "Imię i nazwisko są wymagane";
        }

        if (!empty($errors)) {
            return $this->render("register", ["errors" => $errors]);
        }

        // TODO: Implementacja zapisu do bazy danych
        // 1. Sprawdzenie czy email nie istnieje już w bazie
        // 2. Zahashowanie hasła (password_hash)
        // 3. INSERT do tabeli users (email, password_hash, firstname, lastname, created_at)
        // 4. Obsługa błędów bazy danych
        
        // Po implementacji bazy danych:
        // $passwordHash = password_hash($password1, PASSWORD_DEFAULT);
        // try {
        //     $stmt = $pdo->prepare("INSERT INTO users (email, password_hash, firstname, lastname, created_at) VALUES (?, ?, ?, ?, NOW())");
        //     $stmt->execute([$email, $passwordHash, $firstname, $lastname]);
        //     return $this->render("login", ["message" => "Zarejestrowano użytkownika $email"]);
        // } catch (PDOException $e) {
        //     if ($e->getCode() == 23000) { // Duplicate entry
        //         return $this->render("register", ["errors" => ["Email już istnieje w bazie"]]);
        //     }
        //     return $this->render("register", ["errors" => ["Błąd podczas rejestracji"]]);
        // }

        return $this->render("login", ["message" => "Zarejestrowano użytkownika ".$email]);
    }
}