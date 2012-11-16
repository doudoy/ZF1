<?php
class Application_Models_DbTable_Messages extends Zend_Db_Table_Abstract
{
    protected   $_primary = 'idmessage';
    protected $_name = 'messages';

    public function getMessages($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('idmessage = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }



    public function addMessage($email, $comment, $created)
    {
        $data = array(
            'email' => $email,
            'comment' => $comment,
            'created' => $created,
        );
        $this->insert($data);
    }
    
    public function editMessage($id, $email, $comment)
    {
        $data = array(
            'email' => $email,
            'comment' => $comment,
        );
        $this->update($data, 'idmessage = '. (int)$id);
    }


    public function deleteMessage($id)
    {
        $this->delete('idmessage =' . (int)$id);
    }
}


?>
