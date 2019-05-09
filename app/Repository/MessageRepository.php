<?php
/**
 * Created by PhpStorm.
 * User: inakacidhe
 * Date: 19-05-09
 * Time: 10.17.MD
 */

class MessageRepository
{

    public function save(Message $message)
    {

        try {
            $pdo = BaseConfig::connect();
            $query = "INSERT INTO `message` (`id`, `message`, `user_id`, `created_at`, `is_deleted`) 
                  VALUES (NULL, '" . $message->getMessage() . "','" . $message->getUserID() . "','" . $message->getCreatedAt() . "',0)";
            $statement = $pdo->prepare($query);
            $statement->execute();
        } catch (PDOException $e) {
            return ["error" => true, "msg" => "Insert failed because " . $e->getMessage()];
        }

    }

    public function getAllMessages(){
        try {
            $pdo = BaseConfig::connect();
            // the main query
            $sql = "SELECT m.* ,u.name,u.surname FROM message m LEFT JOIN users u  ON u.id = m.user_id WHERE m.is_deleted = 0 ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;
        } catch (PDOException $e) {
            return ["error" => true, "msg" => "Insert failed because " . $e->getMessage()];
        }
    }

    public function getMessageById($idMessage){
        try {
            $pdo = BaseConfig::connect();
            // the main query
            $sql = "SELECT m.* ,u.name,u.surname FROM message m LEFT JOIN users u  ON u.id = m.user_id WHERE  `m.is_deleted` = 0 and `m.id`=$idMessage ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;
        } catch (PDOException $e) {
            return ["error" => true, "msg" => "Insert failed because " . $e->getMessage()];
        }
    }

    public function update($message,$idMessage){

        try {
            $pdo = BaseConfig::connect();
            // the main query
            $params = [':message' => $message->getMessage(), ':idMessage' => $idMessage];
            $sql = "UPDATE message SET message= :message  WHERE `id`= :idMessage ";
            $sqlReady = BaseConfig::build_pdo_query($sql, $params);
            $stmt = $pdo->prepare($sqlReady);
            $stmt->execute();

        } catch (PDOException $e) {
            return ["error" => true, "msg" => "Update failed because " . $e->getMessage()];
        }
    }
}
