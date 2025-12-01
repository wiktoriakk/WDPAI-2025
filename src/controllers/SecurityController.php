<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController {

    private UserRepository $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function login() {

        if ($this->isGet()) {
            return $this->render("login");
        }

        $email = $_POST["email"] ?? '';
        $password = $_POST["password"] ?? '';

        if (empty($email) || empty($password)) {
            return $this->render('login', ['message' => 'Fill all fields!']);
        }

        // pobranie użytkownika z bazy
        $userRow = $this->userRepository->getByEmail($email);

        if (!$userRow) {
            return $this->render('login', ['message' => 'User not found']);
        }

        if (!password_verify($password, $userRow['password'])) {
            return $this->render('login', ['message' => 'Wrong password']);
        }

        // TODO sesja lub token
        // $_SESSION['user'] = $userRow['id'];

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/dashboard");
        exit;
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

        // Walidacja
        if (empty($email) || empty($password1) || empty($password2) || empty($firstname)) {
            return $this->render('register', ['message' => 'Fill all fields']);
        }

        if ($password1 !== $password2) {
            return $this->render('register', ['message' => 'Passwords should be the same!']);
        }

        // sprawdzenie czy email istnieje w bazie
        if ($this->userRepository->getByEmail($email)) {
            return $this->render('register', ['message' => 'Email already exists!']);
        }

        // hashowanie
        $hashedPassword = password_hash($password1, PASSWORD_BCRYPT);

        // zapis do bazy
        $this->userRepository->createUser(
            $email,
            $hashedPassword,
            $firstname,
            $lastname
        );

        return $this->render("login", [
            'messages' => ['User registered successfully! Please log in.']
        ]);
    }
}
