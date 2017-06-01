<?php

class GetModel {

    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Valami hiba történt az adatbázishoz való csatlakozással.');
        }


        // $this->checkIfInstalled();
    }

    //check
    public function checkIfInstalled() {
        $sql = "SELECT COUNT(1) AS countDB FROM 
			" . DB_PREFIX . "category,
			" . DB_PREFIX . "comments,
			" . DB_PREFIX . "gallery,
			" . DB_PREFIX . "images,
			" . DB_PREFIX . "pages,
			" . DB_PREFIX . "posts,
			" . DB_PREFIX . "users
		LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetch()->countDB;
    }

    public function getCategoryMenu() {
        $sql = "SELECT * FROM " . DB_PREFIX . "category WHERE menuShow ='yes'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getPagesMenu() {
        $sql = "SELECT * FROM " . DB_PREFIX . "pages WHERE isArchived ='no' ORDER BY ordering ASC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getAmountOfPosts() {
        $sql = "SELECT COUNT(id) AS amount_of_posts FROM " . DB_PREFIX . "posts";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch()->amount_of_posts;
    }

    public function getAmountOfComments() {
        $sql = "SELECT COUNT(id) AS amount_of_comments FROM " . DB_PREFIX . "comments";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch()->amount_of_comments;
    }

    public function getSidebarComments() {
        $sql = "SELECT 
					" . DB_PREFIX . "comments.id AS commentid,
					username, commentdate, comment, " . DB_PREFIX . "posts.postUrl AS postUrl 
				FROM 
					" . DB_PREFIX . "comments, 
					" . DB_PREFIX . "posts 
				WHERE 
					" . DB_PREFIX . "comments.postid = " . DB_PREFIX . "posts.id		
				ORDER BY " . DB_PREFIX . "comments.id DESC LIMIT 0," . COMMENTNUMSIDEBAR . "";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getArchives() {

        $sql = "
                SELECT "
                . "YEAR(postDate) as year, "
                . "MONTH(postDate) as month "
                . "
                FROM 
                  " . DB_PREFIX . "posts "
                . "GROUP BY YEAR(postDate),MONTH(postDate) ORDER BY postDate DESC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    

}
