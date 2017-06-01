<?php

class ConfigModel {

    private $postName;
    private $postUrl;
    private $postContent;
    private $postCategory;
    private $pageName;
    private $pageUrl;
    private $pageContent;
    private $categoryName;
    private $categoryUrl;
    private $menuShow;
    private $username;
    private $email;
    private $rank;
    private $id;
    

    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Valami hiba történt az adatbázishoz való csatlakozással.');
        }
        //Post hozzáadásánál 
        $this->postName = isset($_POST['postName']) ? $_POST['postName'] : null;
        $this->postUrl = isset($_POST['postUrl']) ? $_POST['postUrl'] : null;
        $this->postContent = isset($_POST['postContent']) ? $_POST['postContent'] : null;
        $this->postCategory = isset($_POST['postCategory']) ? $_POST['postCategory'] : null;
        //Oldalak kezelése
        $this->pageName = isset($_POST['pageName']) ? $_POST['pageName'] : null;
        $this->pageUrl = isset($_POST['pageUrl']) ? $_POST['pageUrl'] : null;
        $this->pageContent = isset($_POST['pageContent']) ? $_POST['pageContent'] : null;

        //Kategória
        $this->categoryName = isset($_POST['categoryName']) ? $_POST['categoryName'] : null;
        $this->categoryUrl = isset($_POST['categoryUrl']) ? $_POST['categoryUrl'] : null;
        $this->menuShow = isset($_POST['menuShow']) ? $_POST['menuShow'] : null; //User
        $this->username = isset($_POST['username']) ? $_POST['username'] : null;
        $this->email = isset($_POST['email']) ? $_POST['email'] : null;
        $this->rank = isset($_POST['rank']) ? $_POST['rank'] : null;
        $this->id = isset($_POST['id']) ? $_POST['id'] : null;
    }

    public function setSite($sitename, $siteurl, $adminemail, $globalemail, $linkheader1, $linkheader2, $linkheader3, $linkheaderurl1, $linkheaderurl2, $linkheaderurl3, $sitedesc, $sitedesc2, $template, $commentnumsidebar) {
        $file = fopen('application/config/config.txt', 'wb');
        //ASD-nél néhány szerveren hibát dob, tehát 1. sort nem tudja értelmezni. Ezért van csak benne. Windowsos XAMPP környezetben nem volt ilyen hiba. A hiba egy Linuxos környzetben futtatott apache/php-nél volt, ezért van csak benne (telepítésnél is)
        $fwriteText = "ASD-->asd
SITENAME-->$sitename
SITEURL-->$siteurl
URL-->$siteurl
ADMINEMAIL-->$adminemail
GLOBALEMAIL-->$globalemail
LINKHEADER1-->$linkheader1
LINKHEADERURL1-->$linkheaderurl1
LINKHEADER2-->$linkheader2
LINKHEADERURL2-->$linkheaderurl2
LINKHEADER3-->$linkheader3
LINKHEADERURL3-->$linkheaderurl3
SITEDESC-->$sitedesc
SITEDESC2-->$sitedesc2
COMMENTNUMSIDEBAR-->$commentnumsidebar
TEMPLATE-->$template";
        fwrite($file, $fwriteText);

        fclose($file);
        //echo "Sikeres írás :)";
        header("location: " . URL . "/admin/settings");
    }

    private function checkPostUrl($postUrl, $postName = null) {
        //Mivel link, ezért speciális karakterek kizárva.
        $mit = explode(",", "á,é,í,ő,ő,ó,ü,ű,ú,É,Á,Í,Ő,Ó,Ü,Ű,Ú,Ö,ö, ,?,!,%,),(,.,:,^,");
        $mire = explode(",", "a,e,i,o,o,o,u,u,u,E,A,I,O,O,U,U,U,O,o,_,-,-,-,-,-,_,-,_,");
        if ($postUrl == "" OR $postUrl == " " or empty($postUrl)) {
            $postUrl = str_replace($mit, $mire, $postName);
            $postUrl = substr(strtolower($postUrl), 0, -3);
        } else {
            $postUrl = str_replace($mit, $mire, $postUrl);
            $postUrl = substr(strtolower($postUrl), 0);
        }
        //Adjunk egy kis biztonságot, hogy véletlenül se legyen kettő ugyanolyan bejegyzés link az adatbázisban. 
        $sql = "SELECT count(*) FROM 
					" . DB_PREFIX . "posts, " . DB_PREFIX . "pages
				WHERE 
					postUrl = '" . $postUrl . "' 
						OR 
					pageUrl = '" . $postUrl . "'
				";
        //pageUrl-t beleraktam, marad minden a régiben, csak egy OR-ral lett kiegészítve.
        $query = $this->db->prepare($sql);
        $query->execute();
        $rowscount = $query->fetchColumn();
        if ($rowscount != 0) {
            $randNum = rand(00, 9999);
            $postUrl = $postUrl . $randNum;
        }
        return $postUrl;
    }

    public function addPost($post) {
        //print_r($post);

        $postName = htmlspecialchars($this->postName);
        $postContent = $this->postContent;

        $postCategory = $this->postCategory;
        $postCreator = ID;
        $postUrl = $this->checkPostUrl($this->postUrl, $this->postName);

        $sql = "INSERT INTO " . DB_PREFIX . "posts (postName, postContent, postCategory, postUrl, postCreator) VALUES (:postName, :postContent, :postCategory, :postUrl, :postCreator)";
        $query = $this->db->prepare($sql);
        $query->execute(array(':postName' => $postName, ':postContent' => $postContent, ':postCategory' => $postCategory, ':postUrl' => $postUrl, ':postCreator' => $postCreator));
      //  die();
    }

    public function getPosts() {
        $sql = "SELECT * FROM " . DB_PREFIX . "posts ORDER BY postdate DESC";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function getOnePost($id) {
        $sql = "SELECT  * FROM " . DB_PREFIX . "posts WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':id' => $id));

        return $query->fetchAll();
    }

    public function postDel($id) {
        $sql = "DELETE FROM " . DB_PREFIX . "posts WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':id' => $id));
    }

    public function postModify($post) { //post módosítása
        $sql = "UPDATE " . DB_PREFIX . "posts SET 
			postName = :postName,
			postUrl = :postUrl,
			postContent = :postContent,
			postCategory = :postCategory,
			postEditDate = :postEditDate
			WHERE id = :id
		";
        $query = $this->db->prepare($sql);
        $query->execute(
                array(':id' => $post['postid'],
                    ':postName' => $post['postName'],
                    'postUrl' => $post['postUrl'],
                    'postContent' => $post['postContent'],
                    'postCategory' => $post['postCategory'],
                    'postEditDate' => date("Y-m-d H:m:s")
        ));

// print date("Y-m-d H:m:s");	
    }

//Oldalak model
    public function addPage($post) {
        //print_r($post);

        $pageName = htmlspecialchars($this->pageName);
        $pageContent = $this->pageContent;

        $pageCreator = $_SESSION["id"];
        // $pageUrl = $this->pageUrl;
        $pageUrl = $this->checkPostUrl($this->pageUrl, $this->pageName);

        $sql = "INSERT INTO " . DB_PREFIX . "pages (pageName, pageContent, pageUrl, pageCreator) VALUES (:pageName, :pageContent, :pageUrl, :pageCreator)";
        $query = $this->db->prepare($sql);
        $query->execute(array(':pageName' => $pageName, ':pageContent' => $pageContent, ':pageUrl' => $pageUrl, ':pageCreator' => $pageCreator));
    }

    public function getPages() {
        $sql = "SELECT * FROM " . DB_PREFIX . "pages ORDER BY pageDate DESC";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function getOnePage($id) {
        $sql = "SELECT  * FROM " . DB_PREFIX . "pages WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':id' => $id));

        return $query->fetchAll();
    }

    public function pageDel($id) {
        $sql = "DELETE FROM " . DB_PREFIX . "pages WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':id' => $id));
    }

    public function pageModify($post) { //oldal módosítása
        $sql = "UPDATE " . DB_PREFIX . "pages SET 
			pageName = :pageName,
			pageUrl = :pageUrl,
			pageContent = :pageContent,
			ordering = :ordering
			WHERE id = :id
		";
        $query = $this->db->prepare($sql);
        $query->execute(
                array(':id' => $post['pageid'],
                    ':pageName' => $post['pageName'],
                    'pageUrl' => $post['pageUrl'],
                    'pageContent' => $post['pageContent'],
                    'ordering' => $post['ordering']
        ));
// print date("Y-m-d H:m:s");	
    }

//Oldalak vége	
    public function getAllCategory() {
        $sql = "SELECT * FROM " . DB_PREFIX . "category";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function getCategoryFromId($id) {
        $sql = "SELECT * FROM " . DB_PREFIX . "category WHERE id = $id";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function categoryAction() {
        $categoryName = $this->categoryName;
        $categoryUrl = $this->categoryUrl;
        $menuShow = $this->menuShow;
        $id = $this->id;

        $sql = "UPDATE " . DB_PREFIX . "category 
					SET	categoryName = :categoryName,
						categoryUrl = :categoryUrl,
						menuShow = :menuShow
				WHERE
						id = :id
		";
        $query = $this->db->prepare($sql);
        $query->execute(array(':categoryName' => $categoryName, ':categoryUrl' => $categoryUrl, ':menuShow' => $menuShow, ':id' => $id));
    }

    public function addCategory($post) {
        $categoryName = $this->categoryName;
        $categoryUrl = $this->categoryUrl;
        $menuShow = $this->menuShow;
        $sql = "INSERT INTO " . DB_PREFIX . "category (categoryName, categoryUrl, menuShow) VALUES (:categoryName, :categoryUrl, :menuShow)";
        $query = $this->db->prepare($sql);
        $query->execute(array(':categoryName' => $categoryName, ':categoryUrl' => $categoryUrl, ':menuShow' => $menuShow));
    }

    public function delCategory($id) {
        $sql = "DELETE FROM " . DB_PREFIX . "category WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':id' => $id));
    }

    public function getUsers() {
        $sql = "SELECT * FROM " . DB_PREFIX . "users";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function getOneUser($id) {
        $sql = "SELECT * FROM " . DB_PREFIX . "users WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':id' => $id));
        return $query->fetchAll();
    }

    public function userAction() {
        $username = $this->username;
        $email = $this->email;
        $rank = $this->rank;
        $id = $this->id;
        if (ID == $id) {
            return false;
        } else {


            $sql = "UPDATE " . DB_PREFIX . "users 
						SET	username = :username,
							email = :email,
							rank = :rank
					WHERE
							id = :id
			";
            $query = $this->db->prepare($sql);
            $query->execute(array(':username' => $username, ':email' => $email, ':rank' => $rank, ':id' => $id));
            return true;
        }
    }

    public function delUser($id) {
        if (ID == $id) {
            return false;
        } else {
            $sql = "DELETE FROM " . DB_PREFIX . "users WHERE id = :id";
            $query = $this->db->prepare($sql);
            $query->execute(array(':id' => $id));
            return true;
        }
    }

    public function themeLoad() {
        $theme_directory = "application/views/_templates/";
        $files = glob($theme_directory . "*");
        $themeLoad = array();
        foreach ($files as $file) {
            if (is_dir($file)) {
                $file = str_replace($theme_directory, '', $file);
                $GLOBALS["themeLoad"][] = $file;
            }
        }
    }

    public function getComments() {
        $sql = "SELECT 
			" . DB_PREFIX . "comments.id AS commentid, " . DB_PREFIX . "comments.username, " . DB_PREFIX . "comments.useremail, " . DB_PREFIX . "comments.userurl, " . DB_PREFIX . "comments.postid, " . DB_PREFIX . "comments.commentdate, " . DB_PREFIX . "comments.comment,
			
			" . DB_PREFIX . "posts.id AS postid, " . DB_PREFIX . "posts.postName, " . DB_PREFIX . "posts.postUrl

			FROM 
			" . DB_PREFIX . "comments,
			" . DB_PREFIX . "posts
			WHERE 
				" . DB_PREFIX . "comments.postid = " . DB_PREFIX . "posts.id
				
			ORDER BY commentdate DESC
		";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function delComment($id) {
        $sql = "DELETE FROM " . DB_PREFIX . "comments WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':id' => $id));
    }

    /* Galéria, képek */

    public function addGallery($post) {
        $sql = "INSERT INTO 
					" . DB_PREFIX . "gallery 
				(galleryName) 
			VALUES 
				(:galleryName)";
        $query = $this->db->prepare($sql);
        $query->execute(array(':galleryName' => htmlspecialchars($_POST['galleryName'])));
    }

    public function getGallery() {
        $sql = "SELECT id, galleryName FROM " . DB_PREFIX . "gallery ORDER BY id DESC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getGalleryById($id) {
        $sql = "SELECT id, galleryName FROM " . DB_PREFIX . "gallery WHERE id = :id ORDER BY id DESC";
        $query = $this->db->prepare($sql);
        $query->execute(array(':id' => $id));
        return $query->fetchAll();
    }

    //listázza a galériában szereplő képeket
    public function getGalleryImages($galleryId) {
        $sql = "
			SELECT
				" . DB_PREFIX . "gallery.id AS galleryId, 
				" . DB_PREFIX . "gallery.galleryName AS galleryName,
				" . DB_PREFIX . "gallery.createDate AS createDate,
				
				" . DB_PREFIX . "images.id AS id,
				" . DB_PREFIX . "images.imageFileName AS imageFileName,
				" . DB_PREFIX . "images.indexImage AS indexImage,
				" . DB_PREFIX . "images.addDate AS addDate,
				" . DB_PREFIX . "images.imageName AS imageName,
				" . DB_PREFIX . "images.imageSize AS imageSize,
				" . DB_PREFIX . "images.showonpage AS showonpage
				
			FROM 
				" . DB_PREFIX . "images, 
				" . DB_PREFIX . "gallery 
			WHERE 
				" . DB_PREFIX . "images.galleryId = " . DB_PREFIX . "gallery.id 
				AND
				" . DB_PREFIX . "gallery.id = :galleryId
			ORDER BY galleryId DESC";
        $query = $this->db->prepare($sql);
        $query->execute(array(':galleryId' => $galleryId));
        return $query->fetchAll();
    }

    public function getImageFileNameById($id) {
        $sql = "SELECT imageFileName AS filename FROM " . DB_PREFIX . "images WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':id' => $id));
        return $query->fetch()->filename;
    }

    public function getIndexImageIsInGallery($galleryId) {
        $sql = "SELECT COUNT(indeximage) AS CountIndexImage FROM " . DB_PREFIX . "images WHERE galleryId = :galleryId";
        $query = $this->db->prepare($sql);
        $query->execute(array(':galleryId' => $galleryId));
        return $query->fetch()->CountIndexImage;
    }

    public function getImageCountByFileName($imageFileName) {
        $sql = "SELECT COUNT(id) AS countImageByFileName FROM " . DB_PREFIX . "images WHERE imageFileName = :imageFileName";
        $query = $this->db->prepare($sql);
        $query->execute(array(':imageFileName' => $imageFileName));
        return $query->fetch()->countImageByFileName;
    }

    public function editImages($post) {
        // $galleryId = $post['galleryId'];
        print_r($post);
        if ($post['deleteGallery'] == 1) {
            $this->deleteGallery($post['galleryId']);
        }

        foreach ($post as $wb_postName => $wb_postValue) {
            foreach ($wb_postValue as $id => $forid) {

                if ($wb_postName == "delete") {
                    unlink("public/gallery/phpthumb/images/" . $this->getImageFileNameById($id));
                    $this->deleteImageFromSql($id); //törlés sqlből
                } else {
                    //UPDATE 
                    $this->setImagesNameWithValue($wb_postName, $forid, $id);
                    // print "sikeres módosítás! $id";
                }
            }
        }
        // header("location:".URL."admin/gallery/".$galleryId);
    }

    public function setImagesNameWithValue($name, $value, $id) {
        $sql = "UPDATE " . DB_PREFIX . "images 
						SET	$name = :value
					WHERE
							id = :id
			";
        $query = $this->db->prepare($sql);
        $query->execute(
                array(
                    ':value' => $value,
                    ':id' => $id
                )
        );
    }

    public function deleteImageFromSql($id) {
        $sql = "DELETE FROM " . DB_PREFIX . "images WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':id' => $id));
        return true;
    }

    public function selectImagesFromGalleryId($galleryId) {
        $sql = "SELECT * FROM " . DB_PREFIX . "images WHERE galleryId = :galleryId";
        $query = $this->db->prepare($sql);
        $query->execute(array(':galleryId' => $galleryId));
        return $query->fetchAll();
    }

    public function deleteGallery($galleryId) {//galéria törlése. A képekkel együtt, minden. 

        foreach ($this->selectImagesFromGalleryId($galleryId) as $image) {
            unlink("public/gallery/phpthumb/images/" . $image->imageFileName); //törlés fizikailag
            $this->deleteImageFromSql($image->id); //törlés sqlből
        }

        $sql = "DELETE FROM " . DB_PREFIX . "gallery WHERE id = :galleryId";
        $query = $this->db->prepare($sql);
        $query->execute(array(':galleryId' => $galleryId));



        return true;
    }

    /* kép feltöltés feldolgozása */

    public function uploadImage($fileskepfo) {
        $fileskepfo = $fileskepfo;

        // print_r($fileskepfo);
        //
			//elnevezés
        for ($i = 0; $i < count($fileskepfo); $i++) {
            if (strpos($fileskepfo['type'][$i], "image/") === 0) {
                $this->feltolt($fileskepfo['name'][$i], $fileskepfo['tmp_name'][$i], $fileskepfo['type'][$i], $fileskepfo['size'][$i], $i);
                // print "<font color=green>Upload complete! </font><b>".$fileskepfo['name'][$i]."</b>";
            } elseif (isset($fileskepfo['name'][$i]) and $fileskepfo['name'][$i] != null) {
                // print "<font color=red>This file was not uploaded: </font><b>".$fileskepfo['name'][$i]."</b><br>";
            }

            // print "<br>$imagename";
        }
    }

    private function feltolt($fileskepfoname, $fileskepfotmp_name, $fileskepfotype, $fileskepfoimg_size, $count) {
        $eredeti = $fileskepfoname;

        $uj = "";
        $rossz = Array("á", "é", "í", "ó", "ö", "ő", "ú", "ü", "ű", " ");
        $jo = Array("a", "e", "i", "o", "o", "o", "u", "u", "u", "_");
        $szam = "";
        $uj = str_replace($rossz, $jo, strtolower($eredeti));
        // $szam .= rand(0,9999999999);
        // print $this->getImageCountByFileName($uj);
        // $uj .= rand(0,9999999999);
        if ($this->getImageCountByFileName($uj) != 0) { //ha van ilyen nevű kép, akkor átírja
            $szam = (int) rand(100, 10000);
            if ($this->getImageCountByFileName($szam . $uj) != 0) { //és akkor még egyszer. ennyiszer csak nem lesz azonos randomra :D
                $szam = (int) rand(123, 98765432);
            }
        }
        //feltöltés
        //$honnan = $fileskepfo['tmp_name'][$i];
        $honnan = $fileskepfotmp_name;
        $hova = "";
        $mappa = "./public/gallery/phpthumb/images/";
        if (!is_dir($mappa))
            mkdir($mappa);

        $hova = $mappa . $szam . $uj;
        /* 1. ilyen kép: ize.jpg  => ../ize.jpg
          2. ilyen kép: 4231ize.jpg => ../4231ize.jpg
         */
        // print "<b>$honnan</b>";
        // print $honnan;
        // print "<br>";
        //print $hova;
        move_uploaded_file($honnan, $hova);



        if ($count == 0) { ///ha az első, akkor index image lesz. 
            $indeximage = 1;
        } else {
            $indeximage = 0;
        }
        if ($this->getIndexImageIsInGallery((int) $_POST['galleryId']) != 0) { //ha már szerepel az adatbázisban kép a galériában, ami countolja, ha van már index. ne legyen többször 1! 
            $indeximage = 0;
        }


        $fileskepfoimg_size = $fileskepfoimg_size;
        $sql = "INSERT INTO 
					" . DB_PREFIX . "images 
				(imageFileName,
				indexImage,
				galleryId,
				imageName,
				imageSize) 
			VALUES 
				(:imageFileName,
				:indexImage,
				:galleryId,
				:imageName,
				:imageSize)";
        $query = $this->db->prepare($sql);
        $query->execute(
                array(
                    ':imageFileName' => $szam . $uj,
                    ':indexImage' => $indeximage,
                    ':galleryId' => (int) $_POST['galleryId'],
                    ':imageName' => $szam . $uj,
                    ':imageSize' => $fileskepfoimg_size
                )
        );


        //új elnevezés visszaadása
        global $imagename;
        $imagename = $szam . $uj;
        return "images/" . $szam . $uj;
    }

}
