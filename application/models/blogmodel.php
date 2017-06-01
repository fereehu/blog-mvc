<?php

class BlogModel {

    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Valami hiba történt az adatbázishoz való csatlakozással.');
        }
    }

    public function getAllPosts() {

        /* $sql = "SELECT count(id) as number FROM " . DB_PREFIX . "posts";
          $query = $this->db->prepare($sql);
          $query->execute();
          $number = $query->fetch()->number;

          $rec_limit = 2;
          if ($postPerSite == 2 and $page == 0) {
          $limit = "0,2";
          }
          if ($postPerSite == 2 and $page == 1) {
          $limit = "2,4";
          }

          print $number;

          if ((int) $_GET['page']) {
          $page = $_GET['page'] + 1;
          } else {
          $page = 0;
          $offset = 0;
          }

         */

        $sql = "SELECT 
					" . DB_PREFIX . "posts.id AS postid, postName, postContent, postDate, postUrl, postCreator, postCategory, 
					categoryName
				FROM 
					" . DB_PREFIX . "posts, " . DB_PREFIX . "category 
				WHERE 
					" . DB_PREFIX . "category.id = " . DB_PREFIX . "posts.postCategory
					ORDER BY postDate DESC";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function getOnePost($postUrl) {
        $sql = "SELECT 
					" . DB_PREFIX . "posts.id, " . DB_PREFIX . "posts.id AS postid, postName, postContent, postDate, postEditDate, postUrl, postCreator, postCategory,
					categoryName			
				FROM 
					" . DB_PREFIX . "posts, " . DB_PREFIX . "category 

				WHERE postUrl = '" . $postUrl . "'			
					AND 					
				" . DB_PREFIX . "category.id = " . DB_PREFIX . "posts.postCategory";
        $query = $this->db->prepare($sql);
        $query->execute();


        return $query->fetchAll();
    }

    public function getLastPost($postUrl) {
        $sql = "SELECT " . DB_PREFIX . "posts.id, " . DB_PREFIX . "posts.id AS postid, 
					postName, postContent, postDate, postUrl, postCreator, postCategory,
					categoryName			
				FROM 
					" . DB_PREFIX . "posts, " . DB_PREFIX . "category 

				WHERE " . DB_PREFIX . "category.id = " . DB_PREFIX . "posts.postCategory
				ORDER BY postDate DESC LIMIT 0,1
				  ";
        $query = $this->db->prepare($sql);
        $query->execute();


        return $query->fetchAll();
    }

    public function getAllPostByCategory($categoryUrl) {
        $sql = "SELECT DISTINCT
			" . DB_PREFIX . "posts.id AS postid, postName, postContent, postDate, postUrl, postCreator, postCategory, 
			
			categoryName
				FROM 
					" . DB_PREFIX . "posts, " . DB_PREFIX . "category 
				WHERE 
				postCategory = 
					(SELECT id 
						FROM 
							" . DB_PREFIX . "category
						WHERE	
							categoryUrl = '" . $categoryUrl . "') 
					AND 
					
						categoryUrl = '" . $categoryUrl . "'  

				ORDER BY postDate DESC";
        $query = $this->db->prepare($sql);
        $query->execute();


        return $query->fetchAll();
    }

    public function getAllCategory() { //azért hivatkozok itt rá mégegyszer, mert a másik admin felületen van (config), azt meg nem akarom keverni
        $sql = "SELECT * FROM " . DB_PREFIX . "category";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function getSearch($search) {
        $search = htmlspecialchars($search);
        $search = str_replace(array('%', '_'), '', $search);
        if (!$search) {
            exit('Hibás keresési érték: ' . $search);
        }
        $sql = "SELECT DISTINCT

			" . DB_PREFIX . "posts.id AS postid, postName, postContent, postDate, postUrl, postCreator, postCategory, 
			
			categoryName 
				FROM 
					" . DB_PREFIX . "posts, " . DB_PREFIX . "category 
				WHERE 
					postName LIKE :search 
						OR 
					postContent LIKE :search
				AND
					" . DB_PREFIX . "category.id = postCategory
				GROUP BY " . DB_PREFIX . "posts.id
			ORDER BY postDate DESC
			";
        $query = $this->db->prepare($sql);
        $query->execute(array(':search' => '%' . $search . '%'));
        return $query->fetchAll();
    }

    public function getComments($postUrl) {
        $sql = "SELECT * FROM " . DB_PREFIX . "comments 
			
		WHERE postid = 
			(SELECT id FROM " . DB_PREFIX . "posts WHERE postUrl = :postUrl)
			";
        $query = $this->db->prepare($sql);
        $query->execute(array(':postUrl' => $postUrl));

        return $query->fetchAll();
    }

    public function writeComment($post) {
        $username = htmlspecialchars($post['username']);
        $useremail = htmlspecialchars($post['useremail']);
        $userurl = htmlspecialchars($post['userurl']);
        $postid = (int) $post['postid'];
        $comment = htmlspecialchars($post['comment']);

        $sql = "INSERT INTO " . DB_PREFIX . "comments (
					username, 
					useremail, 
					userurl, 
					postid, 
					comment
				) VALUES (
				:username, 
				:useremail, 
				:userurl,
				:postid,
				:comment
				)";
        $query = $this->db->prepare($sql);
        $query->execute(array(
            ':username' => $username,
            ':useremail' => $useremail,
            ':userurl' => $userurl,
            ':postid' => $postid,
            ':comment' => $comment
        ));
        $_SESSION['commentusername'] = $username;
        $_SESSION['useremail'] = $useremail;
        $_SESSION['userurl'] = $userurl;
        return;
    }

    public function captcha($postcaptcha, $commentUnderPostAndWrongCaptcha) {
        $daynum = date("N");

        if ($daynum == 1) {
            $captcha = "hetfo";
        }
        if ($daynum == 2) {
            $captcha = "kedd";
        }
        if ($daynum == 3) {
            $captcha = "szerda";
        }
        if ($daynum == 4) {
            $captcha = "csutortok";
        }
        if ($daynum == 5) {
            $captcha = "pentek";
        }
        if ($daynum == 6) {
            $captcha = "szombat";
        }
        if ($daynum == 7) {
            $captcha = "vasarnap";
        }
        $mit = explode(",", "á,é,í,ő,ő,ó,ü,ű,ú,É,Á,Í,Ő,Ó,Ü,Ű,Ú,Ö,ö");
        $mire = explode(",", "a,e,i,o,o,o,u,u,u,E,A,I,O,O,U,U,U,O,o");
        $postcaptcha = str_replace($mit, $mire, $postcaptcha);
        $postcaptcha = substr(strtolower($postcaptcha), 0);

        if ($captcha == $postcaptcha) {
            unset($_SESSION['commentUnderPostAndWrongCaptcha']);
            return true;
        } elseif ($captcha != $postcaptcha) {
            $_SESSION['commentUnderPostAndWrongCaptcha'] = $commentUnderPostAndWrongCaptcha;
            return false; //false
        }
    }

    public function getCommentNumByPostId($postid) {
        $sql = "SELECT COUNT(id) AS comment_num_by_id FROM " . DB_PREFIX . "comments WHERE postid = :postid";
        $query = $this->db->prepare($sql);
        $query->execute(
                array(
                    ':postid' => $postid)
        );
        return $query->fetch()->comment_num_by_id;
    }

    public function galleryCount($galleryId) { //megszámolja, hogy mennyi kép van a galériában
        $sql = "SELECT COUNT(id) AS galleryCount FROM " . DB_PREFIX . "images WHERE galleryId = :galleryId";
        $query = $this->db->prepare($sql);
        $query->execute(
                array(
                    ':galleryId' => $galleryId)
        );
        return $query->fetch()->galleryCount;
    }

    public function galleryBBcode($text) {

        $find = array('~\[gallery=(.*?)\]~s'); //Megkeresi a [gallery=SZÁM]-ot
        $replace = ""; //cserélje ki a semmire, tehát ne látszódjon. ezért van a $find

        $paragraph_text = $this->multi_between('[gallery=', ']', $text);
        /* 	
          mivan a [gallery= ] között? Majd tömbbe rakja, ezért kell a for, mindig máshol lenne a szám, így sok helyen nem látszódna a galéria, illetve csak 1 galériát engedne mutatni. Ezzel lett kiküszöbölve, hogy korlátlan mennyiségben legyen az oldalon.
          1 hiba van: Mindig a post alatt látszik a galéria.
          NEM HIBA->FEATURE!!!! :D
          (cserébe nem látszik a galériás bbcode)
         */
        // print_r($paragraph_text); 

        for ($k = 1; $k < count($paragraph_text); $k++) {
            $text .= $this->showGallery($paragraph_text[$k]);
        }


        $galleryShow = preg_replace($find, $replace, $text);

        return $galleryShow;
    }

    public function multi_between($tthis, $that, $inthat) {
        $counter = 0;
        $elements = ""; //ha nincs kitöltve a post szöveg mező, akkor notice-t dob, hogy ismeretlen elements
        while ($inthat) {

            $counter++;
            $elements[$counter] = $this->before($that, $inthat);
            $elements[$counter] = $this->after($tthis, $elements[$counter]);
            $inthat = $this->after($that, $inthat);
        }
        return $elements;
    }

    public function before($tthis, $inthat) {
        return substr($inthat, 0, strpos($inthat, $tthis));
    }

    public function after($tthis, $inthat) {
        if (!is_bool(strpos($inthat, $tthis)))
            return substr($inthat, strpos($inthat, $tthis) + strlen($tthis));
    }

    public function getGalleryItems($galleryId) {
        $sql = "SELECT 
					imageFileName,
					imageName
				FROM 
					" . DB_PREFIX . "images 
				WHERE 
					galleryId = :galleryId AND showonpage = 1 ORDER BY indexImage DESC";
        $query = $this->db->prepare($sql);
        $query->execute(array(':galleryId' => $galleryId));
        return $query->fetchAll();
    }

    public function showGallery($galleryId) {
        $return = "<ul class=\"gallery clearfix\">";
        foreach ($this->getGalleryItems($galleryId) as $image) {
            //galéria visszatérési értéke, html kód, ha [gallery=123] van. Ha nincs olyan számú galéria, akkor nem ír ki semmit. 
            $return .= "
			
				<a href=\"" . URL . "public/gallery/phpthumb/phpThumb.php?src=images/" . $image->imageFileName . "\" rel=\"prettyPhoto[gallery2]\" title=\"" . $image->imageName . " \">
					<img src=\"" . URL . "public/gallery/phpthumb/phpThumb.php?src=images/" . $image->imageFileName . "&w=60\" width=\"60\" height=\"60\" alt=\"" . $image->imageFileName . "\" />
				</a>
				
				";
        }
        $return .= "</ul>";


        return $return;
    }

    public function getArchives($year, $month = null, $day = null) {
        if ((int) $year) {
            $where = "YEAR(postDate) = $year ";
        }
        if ((int) $month) {
            $where .= "AND MONTH(postDate) = $month ";
        }
        if ((int) $day) {
            $where .= "AND DAY(postDate) = $day ";
        }
        $sql = "SELECT 
            " . DB_PREFIX . "posts.id as postid,
            postName, 
            postContent, 
            postDate, 
            postEditDate, 
            postCategory, 
            postUrl, 
            postCreator,
            categoryName
                FROM 
                  " . DB_PREFIX . "posts,
                  " . DB_PREFIX . "category
                WHERE $where"
                . " AND " . DB_PREFIX . "category.id = " . DB_PREFIX . "posts.postCategory "
                . "ORDER BY postDate DESC";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

}
