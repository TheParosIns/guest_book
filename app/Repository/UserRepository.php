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

    public function updateLoginAttempts($email,$failedLogin,$failedAttempts)
    {
        try {
            $pdo = BaseConfig::connect();
            // the main query
            $failedAttempts= $failedLogin ? $failedAttempts+1 : $failedAttempts;
            $latestAttempt = $failedLogin  ? time() : null;
            $params = [':failedAttempts' => $failedAttempts, ':latestAttempt' => $latestAttempt,':email' => $email];
            $sql = "UPDATE users SET failed_attempts= :failedAttempts , latest_attempt = :latestAttempt WHERE email= :email ";
            $sqlReady = BaseConfig::build_pdo_query($sql, $params);
            $stmt = $pdo->prepare($sqlReady);
            $stmt->execute();

        } catch (PDOException $e) {
            return ["error" => true, "msg" => "Update failed because " . $e->getMessage()];
        }
    }

}
