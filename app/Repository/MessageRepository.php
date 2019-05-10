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
            $sql = "INSERT INTO `message` (`id`, `message`, `user_id`, `created_at`, `is_deleted`) 
                  VALUES (NULL, :message , :userId, :createdAt ,0)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':message', $message->getMessage(), PDO::PARAM_STR);
            $stmt->bindParam(':userId', $message->getUserID(), PDO::PARAM_INT);
            $stmt->bindParam(':createdAt', $message->getCreatedAt(), PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            return ["error" => true, "msg" => "Insert failed because " . $e->getMessage()];
        }
    }


    public function saveReply(Reply $reply)
    {

        try {
            $pdo = BaseConfig::connect();
            $query = "INSERT INTO `reply` (`id`, `message_id`, `user_id`, `created_at`, `reply`) 
                  VALUES (NULL, :idMessage ,:userId ,:createdAt ,:reply)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':idMessage', $reply->getMessageId(), PDO::PARAM_INT);
            $stmt->bindParam(':userId', $reply->getUserID(), PDO::PARAM_INT);
            $stmt->bindParam(':createdAt', $reply->getCreatedAt(), PDO::PARAM_STR);
            $stmt->bindParam(':reply', $reply->getReply(), PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            return ["error" => true, "msg" => "Insert reply failed because " . $e->getMessage()];
        }

    }

    public function getAllMessages()
    {
        try {
            $pdo = BaseConfig::connect();

            $sql = "SELECT m.* ,u.name,u.surname FROM message m LEFT JOIN users u  ON u.id = m.user_id WHERE m.is_deleted = 0 ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;
        } catch (PDOException $e) {
            return ["error" => true, "msg" => "Cound not get datas because: " . $e->getMessage()];
        }
    }

    public function getMessageById($idMessage)
    {
        try {
            $pdo = BaseConfig::connect();
            $sql = "SELECT m.* ,u.name,u.surname FROM message m LEFT JOIN users u  ON u.id = m.user_id WHERE  m.is_deleted = 0 and m.id= :idMessage ";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':idMessage', $idMessage, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;
        } catch (PDOException $e) {
            return ["error" => true, "msg" => "Cound not get message because:  " . $e->getMessage()];
        }
    }

    public function getMessageReplies($idMessage)
    {
        try {

            $pdo = BaseConfig::connect();
            $sql = "SELECT r.*,u.name,u.surname FROM reply r LEFT JOIN message m  ON r.message_id = m.id LEFT JOIN users u ON r.user_id = u.id WHERE m.is_deleted = 0 AND r.message_id = :idMessage ORDER BY r.created_at; ";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':idMessage', $idMessage, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;
        } catch (PDOException $e) {
            return ["error" => true, "msg" => "Cound not get datas because: " . $e->getMessage()];
        }
    }

    public function update($message, $idMessage)
    {

        try {
            $pdo = BaseConfig::connect();
            $sql = "UPDATE message SET message= :message WHERE id= :idMessage ";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':idMessage', $idMessage, PDO::PARAM_INT);
            $stmt->bindParam(':message', $message, PDO::PARAM_STR);
            $stmt->execute();

        } catch (PDOException $e) {
            return ["error" => true, "msg" => "Update failed because " . $e->getMessage()];
        }
    }

    public function delete($idMessage)
    {
        try {
            $pdo = BaseConfig::connect();
            $sql = "UPDATE message SET is_deleted = 1 WHERE id= :idMessage  ";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':idMessage', $idMessage, PDO::PARAM_INT);
            $stmt->execute();

        } catch (PDOException $e) {
            return ["error" => true, "msg" => "Update failed because " . $e->getMessage()];
        }
    }
}
