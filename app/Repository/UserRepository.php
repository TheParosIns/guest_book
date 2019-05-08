<?php
/**
 * Created by PhpStorm.
 * User: inakacidhe
 * Date: 19-05-07
 * Time: 10.49.MD
 */
require_once(__DIR__ . '/../../app/Controllers/BaseConfig.php');

class UserRepository
{

    public function findOneByEmail($email)
    {
        try {
            $pdo = BaseConfig::connect();
            // the main query
            $sql = "SELECT * FROM users WHERE email= '$email' LIMIT 1";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;
        } catch (PDOException $e) {
            return ["error" => true, "msg" => "Insert failed because " . $e->getMessage()];
        }
    }

    public function save(User $user)
    {
        try {
            $pdo = BaseConfig::connect();
            $query = "INSERT INTO `users` (`id`, `name`, `surname`, `email`, `password`, `created_at`) 
                  VALUES (NULL, '" . $user->getName() . "','" . $user->getSurname() . "', '" . $user->getEmail() . "', '" . $user->getPassword() . "','" . $user->getCreatedAt() . "')";

            $statement = $pdo->prepare($query);
            $statement->execute();
            $_SESSION["last_id_user"] = $pdo->lastInsertId();
        } catch (PDOException $e) {
            return ["error" => true, "msg" => "Insert failed because " . $e->getMessage()];
        }

    }

    public function updateUserPassword($newHashPassword)
    {
        try {
            $pdo = BaseConfig::connect();
            $id = $_SESSION['last_id_user'];
            // the main query
            $sql = "UPDATE users SET password= '$newHashPassword'WHERE id= '$id' ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

        } catch (PDOException $e) {
            return ["error" => true, "msg" => "Update failed because " . $e->getMessage()];
        }
    }

    public function updateLoginAttempts($email,$failedAttempts)
    {
        try {
            $pdo = BaseConfig::connect();
            // the main query
            $failedAttempts=$failedAttempts+1;
            $sql = "UPDATE users SET failed_attempts= $failedAttempts , latest_attempt = ".time()." WHERE email= '$email' ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

        } catch (PDOException $e) {
            return ["error" => true, "msg" => "Update failed because " . $e->getMessage()];
        }
    }
}
