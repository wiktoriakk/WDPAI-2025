<?php

require_once 'Repository.php';

class UserRepository extends Repository {
    public function getUsers(): ?array 
    {

    $query  = $this->database->connect()->prepare('
            SELECT * FROM users
    ');
    $query->execute();

    $users = $query->fetchAll(PDO::FETCH_ASSOC);
        // TODO close db connection
    return $users;
    }

    public function getByEmail(string $email): ?array
{
    $query = $this->database->connect()->prepare('
        SELECT * FROM users WHERE email = :email
    ');

    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();

    $user = $query->fetch(PDO::FETCH_ASSOC);
    
    return $user ?: null;
}

    public function createUser(
    string $email,
    string $hashedPassword,
    string $firstname,
    string $lastname,
    string $bio = ''
): void {
    $query = $this->database->connect()->prepare('
        INSERT INTO users (firstname, lastname, email, password, bio)
        VALUES (?, ?, ?, ?, ?);
    ');
    $query->execute([
        $firstname,
        $lastname,
        $email,
        $hashedPassword,
        $bio
    ]);
}
}