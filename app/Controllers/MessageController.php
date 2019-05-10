<?php
/**
 * Created by PhpStorm.
 * User: ina
 * Date: 5/9/19
 * Time: 2:45 PM
 */

require_once(__DIR__ . '/../Entity/Message.php');
require_once(__DIR__ . '/../Repository/MessageRepository.php');
require_once(__DIR__ . '/../Entity/Message.php');
require_once(__DIR__ . '/../Entity/Reply.php');

class MessageController
{

    public function showHomePage()
    {
        Template::render_php('guestBook/home.php', array());
    }

    public function showMessageList()
    {
        $messages = new Message();
        $messages = $messages->getAllMessages();
        Template::render_php('guestBook/messages.php', $messages);
    }

    public function createMessageForm()
    {
        Template::render_php('guestBook/create.php');
    }

    public function sendMessage()
    {

        $foundErrors = $this->validateDatas();
        if (count($foundErrors) > 0) {
            Template::render_php('guestBook/create.php', array('foundErrors' => $foundErrors));
        }
        $newMessage = new Message();
        $newMessage->setMessage(Sanitaze::sanitazeInput($_POST['message']));
        $newMessage->setUserId($_SESSION['user'][0]['id']);
        $newMessage->setCreatedAt(date('Y-m-d H:i:s'));
        if ($newMessage->save($newMessage) == null) {
            Template::redirectTo("/guestBook/message/view", "", "We thank you for your message");
        } else {
            Template::redirectTo("/guestBook/create", "Something went wrong");
        }
        Template::render_php('guestBook/create.php');
    }

    public function editMessageForm($idMessage)
    {
        $message = new Message();
        $editMessage = $message->getMessageById(Sanitaze::sanitazeInput(($idMessage)));
        if ($message->checkIfUserHasRights($editMessage[0]['user_id'])) {

            Template::render_php('guestBook/edit.php', $editMessage);
        }
        Template::redirectTo('/guestBook/message/view', "You can update only the messages you have created!!");
    }

    public function updateMessage($idMessage)
    {
        $foundErrors = $this->validateDatas();
        if (count($foundErrors) > 0) {
            Template::render_php('guestBook/edit.php', array('foundErrors' => $foundErrors));
        }
        $message = new Message();
        $message->setMessage(Sanitaze::sanitazeInput($_POST["message"]));
        if ($message->update($message->getMessage(), Sanitaze::sanitazeInput($idMessage)) == null) {
            Template::redirectTo('/guestBook/message/view', '', 'Message updated successfully');
        } else {
            Template::redirectTo('/guestBook/edit/' . $idMessage, "Something went wrong");
        }

    }


    public function viewMessage($idMessage)
    {
        $message = new Message();
        $messageData = [];
        $getMessage = $message->getMessageById(Sanitaze::sanitazeInput($idMessage));
        $messageReplies = $message->getMessageReplies(Sanitaze::sanitazeInput($idMessage));
        $messageData['message'] = $getMessage;
        $messageData['replies'] = $messageReplies;
        Template::render_php('guestBook/viewMessage.php', $messageData);
    }


    public function deleteMessage($idMessage)
    {
        $message = new Message();
        $getMessage = $message->getMessageById(Sanitaze::sanitazeInput($idMessage));
        if ($message->checkIfUserHasRights($getMessage[0]['user_id'])) {
            $deleteMessage = $message->delete(Sanitaze::sanitazeInput($idMessage));
            if ($deleteMessage == null) {
                Template::redirectTo('/guestBook/message/view', '', 'Message deleted successfully');
            }
        }
        Template::redirectTo('/guestBook/message/view', 'You can delete only the messages you have created!!');
    }

    public function replyMessage($idMessage)
    {

        $reply = filter_var($_POST["reply"], FILTER_SANITIZE_STRING);
        if (isset($reply) && $reply == null && $reply == "") {
            Template::redirectTo('/guestBook/message/viewMessage/' . $idMessage, 'If you want to reply to this message, you have to type something :) ');
        }
        $message = new Message();
        $getMessage = $message->getMessageById(Sanitaze::sanitazeInput($idMessage));
        if ($message->checkIfUserHasRights($getMessage[0]['user_id'])) {
            Template::redirectTo('/guestBook/message/viewMessage/' . $idMessage, "You can not reply your own messages!!");
        }
        $reply = new Reply();
        $reply->setMessageId($idMessage);
        $reply->setReply(Sanitaze::sanitazeInput($_POST['reply']));
        $reply->setUserId($_SESSION['user'][0]['id']);
        $reply->setCreatedAt(date('Y-m-d H:i:s'));
        if ($reply->saveReply($reply) == null) {
            Template::redirectTo('/guestBook/message/viewMessage/' . $idMessage, '', 'Thank you for your reply');
        } else {
            Template::redirectTo('/guestBook/message/viewMessage/' . $idMessage, 'Something went wrong');
        }
    }


    public function validateDatas()
    {
        $errors = [];
        $message = filter_var($_POST["message"], FILTER_SANITIZE_STRING);
        if (strlen($message) < 5) {
            $errors[] = ["field" => "message", "error" => "Message is too short."];
        }
        return $errors;
    }
}
