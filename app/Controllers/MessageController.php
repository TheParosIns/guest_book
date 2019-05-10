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
        $editMessage = $message->getMessageById($idMessage);
        if ($message->checkIfUserHasCreatedThisMessage($editMessage[0]['user_id'])) {

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
        if ($message->update($message->getMessage(), $idMessage) == null) {
            Template::redirectTo('/guestBook/message/view', '', 'Message updated successfully');
        }else{
            Template::redirectTo('/guestBook/edit/' . $idMessage,"Something went wrong");
        }

    }

    public function viewMessage($idMessage)
    {
        $message = new Message();
        $message = $message->getMessageById($idMessage);
        Template::render_php('guestBook/viewMessage.php',$message);
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
