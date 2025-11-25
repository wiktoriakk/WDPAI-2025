<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/UserRepository.php';

class DashboardController extends AppController {

    public function index() {
        $cards = [];

        $userRepository = new UserRepository();
        $users = $userRepository->getUsers();

        return $this->render("dashboard", [
            'cards' => $cards,
            'users' => $users
        ]);
    }

    public function show(int $id) {
        $cards = [];

        $userRepository = new UserRepository();
        $users = $userRepository->getUsers();

        var_dump($users);
        
        return $this->render("dashboard", [
            'cards' => $cards,
            'users' => $users,
            'id' => $id
        ]);
    }
}
