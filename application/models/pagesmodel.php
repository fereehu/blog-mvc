<?php


class PagesModel
{

    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Valami hiba történt az adatbázishoz való csatlakozással.');
        }
    }
    public function getAllPages()
    {
        $sql = "SELECT 
					*
				FROM 
					".DB_PREFIX."pages 
				ORDER BY pageDate DESC";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
    public function getOnePage($postUrl)
    {
        $sql = "SELECT 
					*			
				FROM 
					".DB_PREFIX."pages
				WHERE pageUrl = '".$postUrl."'";		
        $query = $this->db->prepare($sql);
        $query->execute();


        return $query->fetchAll();
    }
}