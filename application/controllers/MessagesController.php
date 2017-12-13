<?php

/**
 * Created by Abderrahim El imame.
 * Email : abderrahim.elimame@gmail.com
 * Date: 27/02/2016
 * Time: 22:07
 */
class MessagesController
{


    public $_GB;
    public $Users;

    public $_Waiting, $_Sent, $_Delivered, $_Seen;

    public function __construct($_GB, $Users)
    {
        $this->_GB = $_GB;
        $this->_Users = $Users;
        $this->_Waiting = 0;
        $this->_Sent = 1;
        $this->_Delivered = 2;
        $this->_Seen = 3;
    }


    /**
     * Function to send a new message
     * @param $array
     */
    public function sendMessage($array)
    {

        foreach ($array as $key => $value) {
            $array[$key] = $this->_GB->_DB->escapeString(trim($value));
        }
        $userId = $array['senderId'];
        if ($userId != $array['recipientId']) {
            $conversationID = $this->getConversation($userId, $array['recipientId']);

            if ($conversationID != 0) {
                $array['conversationId'] = $conversationID;
            } else {
                $data = array(
                    'sender' => $userId,
                    'recipient' => $array['recipientId'],
                    'Date' => $array['date']);

                $insert = $this->_GB->_DB->insert('conversations', $data);
                if ($insert) {
                    $array['conversationId'] = $this->_GB->_DB->last_Id();
                }
            }
            


            $arrayData = array(
                'userID' => $userId,
                'message' => $array['messageBody'],
                'image' => $array['image'],
                'video' => $array['video'],
                'audio' => $array['audio'],
                'duration' => $array['duration'],
                'fileSize' => $array['fileSize'],
                'thumbnail' => $array['thumbnail'],
                'document' => $array['document'],
                'Date' => $array['date'],
                'groupID' => 0,
                'ConversationID' => $array['conversationId']
            );

            $insert = $this->_GB->_DB->insert('messages', $arrayData);
            if ($insert) {
                $arrayMessageData = array(
                    'actionType' => 'socket_new_message_server',
                    'recipientId' => $array['recipientId'],
                    'messageId' => $array['messageId'],
                    'messageBody' => $array['messageBody'],
                    'senderId' => $array['senderId'],
                    'phone' => $array['phone'],
                    'senderName' => $array['senderName'],
                    'date' => $array['date'],
                    'isGroup' => $array['isGroup'],
                    'image' => $array['image'],
                    'video' => $array['video'],
                    'audio' => $array['audio'],
                    'document' => $array['document'],
                    'thumbnail' => $array['thumbnail'],
                    'duration' => $array['duration'],
                    'fileSize' => $array['fileSize'],
                    'senderImage' => $array['senderImage']
                );


                if ($array['registered_id'] != null) {
                    $this->_GB->sendMessageThroughFCM($array['registered_id'], $arrayMessageData);
                } else {
                    $getUser = $this->_GB->_DB->select('users', '`registered_id`', '`id`=' . $array['recipientId']);
                    $fetchUser = $this->_GB->_DB->fetchAssoc($getUser);
                    if ($fetchUser['registered_id'] != null) {
                        $this->_GB->sendMessageThroughFCM($fetchUser['registered_id'], $arrayMessageData);
                    }
                }


                $arrayMessage = array(
                    'success' => true,
                    'message' => "message sent successfully"
                );
                $this->_GB->Json($arrayMessage);

            } else {

                $arrayMessageData = array(
                    'success' => false,
                    'message' => "failed to send message"
                );
                $this->_GB->Json($arrayMessageData);
            }
        }

        // }
    }

    public function getConversation($senderID, $recipientID)
    {
        $senderID = $this->_GB->_DB->escapeString($senderID);
        $recipientID = $this->_GB->_DB->escapeString($recipientID);

        $query = $this->_GB->_DB->select('conversations', 'id', "(`sender`= '{$senderID} ' AND `recipient`= '{$recipientID}') OR (`sender`= '{$recipientID} ' AND `recipient`= '{$senderID}') ");
        if ($this->_GB->_DB->numRows($query) != 0) {
            $fetch = $this->_GB->_DB->fetchAssoc($query);
            $this->_GB->_DB->free($query);
            return $fetch['id'];
        } else {
            $this->_GB->_DB->free($query);
            return 0;
        }
    }


    /******************************************** Groups methods ********************************************
     *
     ******************************************* Groups methods *********************************************/

    /**
     *  save the new group messages
     * @param $array
     */
    public function saveMessageGroup($array)
    {

        foreach ($array as $key => $value) {
            $array[$key] = $this->_GB->_DB->escapeString(trim($value));
        }
        $groupID = $array['groupID'];


        $arrayData = array(
            'groupID' => $groupID,
            'message' => $array['messageBody'],
            'image' => $array['image'],
            'video' => $array['video'],
            'audio' => $array['audio'],
            'duration' => $array['duration'],
            'fileSize' => $array['fileSize'],
            'thumbnail' => $array['thumbnail'],
            'document' => $array['document'],
            'Date' => $array['date'],
            'UserID' => $array['senderId'],
            'ConversationID' => 0
        );
        $insert = $this->_GB->_DB->insert('messages', $arrayData);
        if ($insert) {

            $arrayMessageData = array(
                'actionType' => 'socket_new_group_message_server',
                'senderId' => $array['senderId'],
                'recipientId' => $array['recipientId'],
                'messageBody' => $array['messageBody'],
                'senderName' => $array['senderName'],
                'phone' => $array['phone'],
                'GroupImage' => $array['GroupImage'],
                'GroupName' => $array['GroupName'],
                'isGroup' => $array['isGroup'],
                'date' => $array['date'],
                'video' => $array['video'],
                'thumbnail' => $array['thumbnail'],
                'image' => $array['image'],
                'audio' => $array['audio'],
                'document' => $array['document'],
                'duration' => $array['duration'],
                'fileSize' => $array['fileSize'],
                'groupID' => $array['groupID']
            );


            $getGroup = $this->_GB->_DB->select('groups', '`notification_key`', '`id`=' . $groupID);
            $fetchGroup = $this->_GB->_DB->fetchAssoc($getGroup);
            if ($fetchGroup['notification_key'] != null) {
                $this->_GB->sendGroupMessageThroughFCM($fetchGroup['notification_key'], $arrayMessageData);
            }

            $arrayMessage = array(
                'success' => true,
                'message' => "message sent successfully"
            );
            $this->_GB->Json($arrayMessage);
            $this->_GB->_DB->free($getGroup);
        } else {
            $arrayMessageData = array(
                'success' => false,
                'message' => "failed to send message"
            );
            $this->_GB->Json($arrayMessageData);
        }
    }


}
