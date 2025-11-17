<?php

require_once 'AppController.php';


class SecurityController extends AppController {

    // ======= LOKALNA "BAZA" UŻYTKOWNIKÓW =======
    private static array $users = [
        [
            'email' => 'anna@example.com',
            'password' => '$2y$10$wz2g9JrHYcF8bLGBbDkEXuJQAnl4uO9RV6cWJKcf.6uAEkhFZpU0i', // test123
            'first_name' => 'Anna'
        ],
        [
            'email' => 'bartek@example.com',
            'password' => '$2y$10$fK9rLobZK2C6rJq6B/9I6u6Udaez9CaRu7eC/0zT3pGq5piVDsElW', // haslo456
            'first_name' => 'Bartek'
        ],
        [
            'email' => 'celina@example.com',
            'password' => '$2y$10$Cq1J6YMGzRKR6XzTb3fDF.6sC6CShm8kFgEv7jJdtyWkhC1GuazJa', // qwerty
            'first_name' => 'Celina'
        ],
    ];

    // TODO dekarator, który definiuje, jakie metody HTTP są dostępne
    public function login() {

        if($this->isGet()) {
            return $this->render("login");
        } 

        $email = $_POST["email"] ?? '';
        $password = $_POST["password"] ?? '';

        if (empty($email) || empty($password)) {
            return $this->render('login', ['message' => 'Fill all fields!']);
        }

        // replace with search from database
        $userRow = null;
        foreach (self::$users as $u) {
            if (strcasecmp($u['email'], $email) === 0) {
                $userRow = $u;
                break;
            }
        }


        if (!$userRow) {
            return $this->render('login', ['message' => 'User not found']);
        }

        if (!password_verify($password, $userRow['password'])) {
            return $this->render('login', ['message' => 'Wrong password']);
        }

        // TODO możemy przechowywać sesje użytkowika lub token
        // setcookie("username", $userRow['email'], time() + 3600, '/');

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/dashboard");

    }

    public function register() {
        // TODO pobranie z formularza email i hasła
        // TODO insert do bazy danych
        // TODO zwrocenie informajci o pomyslnym zarejstrowaniu

        if ($this->isGet()) {
            return $this->render("register");
        }

        $email = $_POST["email"] ?? '';
        $password1 = $_POST["password1"] ?? '';
        $password2 = $_POST["password2"] ?? '';
        $firstname = $_POST["firstname"] ?? '';
        $lastname = $_POST["lastname"] ?? '';


        // TODO insert to database user

        // Walidacja - wszystkie pola wypełnione
        if (empty($email) || empty($password1) || empty($password2) || empty($firstname)) {
            return $this->render('register', ['message' => 'Fill all fields']);
        }

        // Sprawdź czy hasła się zgadzają
        if ($password1 !== $password2) {
            return $this->render('register', ['message' => 'Passwords do not match']);
        }

        // TODO this will be checked in database
        foreach (self::$users as $u) {
            if (strcasecmp($u['email'], $email) === 0) {
                return $this->render('register', ['message' => 'Email is taken']);
            }
        }

        $hashedPassword = password_hash($password1, PASSWORD_BCRYPT);

        self::$users[] = [
            'email' => $email,
            'password' => $hashedPassword,
            'first_name' => $firstname
        ];

        self::$users[] = [
        'email' => $email,
        'password' => $hashedPassword,
        'first_name' => $firstname
    ];

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/login");
        exit(); // Ważne: zatrzymaj wykonywanie po przekierowaniu
    }
}