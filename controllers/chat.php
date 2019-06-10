<?php
require_once __DIR__ . '/../models/chat.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/attachment.php';
/**
 * Controller for the Private Chat between users 
 */
class ChatController
{
    /**
     * class constructor 
     *      */
    private $user, $attachment, $chat = null;
    public function __construct()
    {
        $this->user = new User();
        $this->chat = new Chat();
        $this->attachment = new Attachment();
    }
    /**
     * Sending Messages  
     * 
     * @param String $sender this sends the messages 
     * @param String $receiver this receives the messages
     * @param String $message the actual message being sent 
     * @param String $attachment the optional attachment which can be sent with chat
     * @return Boolean returns true on successful message sent otherwise false 
     */
    public function SendMessage($sender, $receiver, $message, $attachment = null)
    {
        $aid = null;
        if ($attachment != null) {
            if ($this->attachment->insert([
                'path' => $attachment
            ]) == false) {
                return false;
            } else {
                $attachments = $this->attachment->select_all();
                foreach ($attachments as $a) {
                    if ($a['path'] == $attachment) {
                        $aid = $a['aid'];
                    }
                }
            }
        }
        $sid = $this->user->get_uid_by_username($sender);
        $rid = $this->user->get_uid_by_username($receiver);

        return $this->chat->insert([
            'senderId' = $sid,
            'receiverId' = $rid,
            'aId' = $aid
        ]);
    }
    /**
     * Get Messages sent after a specific time period 
     * @param String $start MySQL timestamp after which messages are required
     * @param String l_user left user can be eitehr sender or receiver 
     * @param String r_user right user can be either sender or receiver  
     */
    public function GetMessages($l_user, $r_user, $start = null)
    {
        $selected_messages = [];
        $messages = $this->chat->select_all();
        $l_id = $this->user->get_uid_by_username($l_user);
        $r_id = $this->user->get_uid_by_username($r_user);
        foreach ($messages as $message) {
            if ($message['senderId'] == $l_id || $message['receiverId'] == $l_id || $message['senderId'] == $r_id || $message['receiverId'] == $r_id) {
                if($start != null){
                    if ($message['timestamp'] >= $start){
                        $selected_messages[]=$message;
                    }
                    
                }
                else{
                    $selected_messages = $messages;
                }
             }
        }
        return $selected_messages;
    }
}
