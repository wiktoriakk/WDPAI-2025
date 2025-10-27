<?php

require_once 'src/controllers/SecurityController.php';

// TODO Controllery -> singleton
class Routing {

    public static $routes = [
        "login" => [
            "controller" => "SecurityController",
            "action" => "login"
        ],
        "register" => [
            "controller" => "SecurityController",
            "action" => "register"
        ]
        ];

    public static function run(string $path) {
        
        switch ($path) {
            case 'login':
            case 'register':
                $controller = self::$routes[$path]['controller'];
                $action = self::$routes[$path]['action'];
        
                $controllerObj = new $controller;
                $controllerObj->$action();
                break;
            case 'dashboard':
                include 'public/views/dashboard.html';
                break;
            default:
                include 'public/views/404.html';
                break;
        }
    }
}