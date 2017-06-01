<?php

class ChatModel {

    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Valami hiba történt az adatbázishoz való csatlakozással.');
        }
    }

    public function getChatLog() {
        $sql = "SELECT
            username, 
            date, 
            CONVERT(text USING utf8) as tex2t,
            CAST(text AS CHAR CHARACTER SET utf8) as text,
            text as texts
            FROM " . DB_PREFIX . "chat";
        
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

}
