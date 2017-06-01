<?php

class Install {

    // private $db_user;
    // private $db_name;
    // private $db_pass;
    // private $db_host;
    // private $db_prefix;
    // private $db_type;
    // public $db = null;

    public function __construct() {
        // print_r($_SESSION);
        //DB adatok
        $this->db_user = isset($_POST['db_user']) ? $_POST['db_user'] : null;
        $this->db_name = isset($_POST['db_name']) ? $_POST['db_name'] : null;
        $this->db_pass = isset($_POST['db_pass']) ? $_POST['db_pass'] : null;
        $this->db_host = isset($_POST['db_host']) ? $_POST['db_host'] : null;
        $this->db_prefix = isset($_POST['db_prefix']) ? $_POST['db_prefix'] : null;
        $this->db_type = isset($_POST['db_type']) ? $_POST['db_type'] : null;

        //Oldal adatok
        $this->sitename = isset($_POST['sitename']) ? $_POST['sitename'] : null;
        $this->siteurl = isset($_POST['siteurl']) ? $_POST['siteurl'] : null;
        $this->sitedesc = isset($_POST['sitedesc']) ? $_POST['sitedesc'] : null;
        $this->sitedesc2 = isset($_POST['sitedesc2']) ? $_POST['sitedesc2'] : null;

        //Felhasználó (admin) adatok
        $this->adminusername = isset($_POST['adminusername']) ? $_POST['adminusername'] : null;
        $this->adminpassword = isset($_POST['adminpassword']) ? md5($_POST['adminpassword']) : null;
        $this->adminemail = isset($_POST['adminemail']) ? $_POST['adminemail'] : null;
        //	$adminpassword = md5($this->adminpassword);
        // $db = $this->db;
        // $this->db = $db;
        $urlget = $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI];
        $siteurl = substr($urlget, 0, - strlen("_install/"));
        // print $siteurl;
        $_SESSION['siteurl'] = "http://" . $siteurl;

        if (isset($_POST) and ( $_POST['db_user'] != null or $_POST['db_user'] != null or $_POST['db_host'] != null)) {

            $_SESSION['db_type'] = $this->db_type;
            $_SESSION['db_user'] = $this->db_user;
            $_SESSION['db_name'] = $this->db_name;
            $_SESSION['db_pass'] = $this->db_pass;
            $_SESSION['db_host'] = $this->db_host;
            $_SESSION['db_prefix'] = $this->db_prefix;


            $_SESSION['sitename'] = $this->sitename;
            $_SESSION['siteurl'] = $this->siteurl;
            $_SESSION['sitedesc'] = $this->sitedesc;
            $_SESSION['sitedesc2'] = $this->sitedesc2;

            $_SESSION['adminusername'] = $this->adminusername;
            $_SESSION['adminpassword'] = $this->adminpassword;
            $_SESSION['adminemail'] = $this->adminemail;

            $db_type = $_SESSION['db_type'];
            $db_user = $_SESSION['db_user'];
            $db_name = $_SESSION['db_name'];
            $db_pass = $_SESSION['db_pass'];
            $db_host = $_SESSION['db_host'];
            $db_prefix = $_SESSION['db_prefix'];

            $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
            // $db = new PDO($this->db_type . ':host=' . $this->db_host . ';dbname=' . $this->db_name, $this->db_user, $this->db_pass, $options);
            $db = new PDO($db_type . ':host=' . $this->db_host . ';dbname=' . $db_name, $db_user, $db_pass, $options);

            try {
                $this->db = $db;
            } catch (PDOException $e) {
                exit('Valami hiba történt az adatbázishoz való csatlakozással.');
            }

            $this->install();
        } else {
            $this->viewForm();
        }
    }

    public function viewForm() {
        require('view.php');
    }

    public function install() {
        //sql-be helyezi a kódot.
        $sql = "

CREATE TABLE IF NOT EXISTS " . $this->db_prefix . "category (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `categoryUrl` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `menuShow` enum('yes','no') COLLATE utf8_hungarian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS " . $this->db_prefix . "pages
			(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pageName` varchar(256) COLLATE utf8_hungarian_ci NOT NULL,
  `pageContent` text COLLATE utf8_hungarian_ci NOT NULL,
  `pageUrl` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `pageDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pageCreator` int(11) NOT NULL,
  `isArchived` enum('yes','no') COLLATE utf8_hungarian_ci NOT NULL DEFAULT 'no' COMMENT 'Ha yes, akkor archiválva van, és nem fog látszani publikusan. ',
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS " . $this->db_prefix . "posts (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postName` varchar(512) COLLATE utf8_hungarian_ci NOT NULL,
  `postContent` longtext COLLATE utf8_hungarian_ci NOT NULL,
  `postDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `postEditDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `postCategory` int(11) NOT NULL,
  `postUrl` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `postCreator` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS " . $this->db_prefix . "users (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `password` varchar(256) COLLATE utf8_hungarian_ci NOT NULL,
  `rank` int(1) NOT NULL DEFAULT '0',
  `date_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `secret_code` varchar(256) COLLATE utf8_hungarian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS " . $this->db_prefix . "comments (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `useremail` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `userurl` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `postid` int(11) NOT NULL,
  `commentdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` text COLLATE utf8_hungarian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=1 ;


INSERT INTO " . $this->db_prefix . "comments (`username`, `useremail`, `userurl`, `postid`, `comment`) VALUES('Teszt Elek', 'teszt@elek.com', 'http://onlajnszemetes.com', 4, 'Aranyos kis rókák :)\r\n\r\nHa ezt látom, akkor működik az oldal\r\n\r\Jók vagyunk :)');



CREATE TABLE IF NOT EXISTS " . $this->db_prefix . "gallery (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `galleryName` varchar(128) NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



INSERT INTO " . $this->db_prefix . "gallery (`galleryName`) VALUES('Foxy');

CREATE TABLE IF NOT EXISTS " . $this->db_prefix . "images (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imageFileName` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `indexImage` int(11) NOT NULL,
  `showonpage` int(11) NOT NULL DEFAULT '1',
  `galleryId` int(11) NOT NULL,
  `addDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `imageName` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `imageSize` int(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS " . $this->db_prefix . "chat (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=1 ;




INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('36775-1920x1200.jpg', 0, 1, 1, '', 1224951);
INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('551466-bigthumbnail.jpg', 0, 1, 1, '551466-bigthumbnail.jpg', 38017);
INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('1233919-bigthumbnail.jpg', 0, 1, 1, '1233919-bigthumbnail.jpg', 82468);


INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('1426151_917976488222340_4894874789349837004_n.jpg', 0, 1, 1, '1426151_917976488222340_4894874789349837004_n.jpg', 103180);


INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('images_(1).jpg', 0, 1, 1, 'images_(1).jpg', 11578);
INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('images_(2).jpg', 0, 1, 1, 'images_(2).jpg', 7247);

INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('images_(3).jpg', 0, 0, 1, 'Ez ne jelenjen meg. Nem kell ', 5755);

INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('images_(4).jpg', 0, 1, 1, 'images_(4).jpg', 9670);
INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('images_(5).jpg', 0, 1, 1, 'images_(5).jpg', 13677);
INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('images_(6).jpg', 0, 1, 1, 'images_(6).jpg', 10375);
INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('images_(7).jpg', 0, 1, 1, 'images_(7).jpg', 6781);
INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('images.jpg', 0, 1, 1, 'images.jpg', 3253);
INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('letoltes.jpg', 0, 1, 1, 'letoltes.jpg', 7734);
INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('pretty_red_fox___updated_by_katsraven.jpg', 0, 1, 1, 'pretty_red_fox___updated_by_katsraven.jpg', 333379);
INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('red_fox_wallpaper-.jpg', 0, 1, 1, 'red_fox_wallpaper-.jpg', 450973);
INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('red_fox_2_3039x2014.jpg', 0, 1, 1, 'red_fox_2_3039x2014.jpg', 936523);
INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('red_fox_peterg-trimming_wc.jpg', 0, 1, 1, 'red_fox_peterg-trimming_wc.jpg', 561986);
INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('red_fox_wallpaper_2.jpg', 0, 1, 1, 'red_fox_wallpaper_2.jpg', 254502);

INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('red_fox_wallpaper_3.jpg', 0, 1, 1, 'red_fox_wallpaper_3.jpg', 151757);
INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('red-fox-alaska.jpg', 0, 1, 1, 'red-fox-alaska.jpg', 380883);
INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('red-fox-wallpaper_06.jpg', 0, 1, 1, 'red-fox-wallpaper_06.jpg', 196229);
INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('red-fox-wallpaper.jpg', 0, 1, 1, 'red-fox-wallpaper.jpg', 1441250);
INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('red-fox-wallpapers-beautiful-high-resolution-wallpapers-of-fox-animal.jpg', 0, 1, 1, 'red-fox-wallpapers-beautiful-high-resolution-wallpapers-of-fox-animal.jpg', 360637);
INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('sleeping_red_fox-wide.jpg', 0, 1, 1, 'sleeping_red_fox-wide.jpg', 300927);
INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('the_red_fox_wallpaper.jpg', 1, 1, 1, 'Ez egy fő kép, legyen ez az első', 75243);
INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('winter_red_fox_wallpaper-normal.jpg', 0, 1, 1, 'winter_red_fox_wallpaper-normal.jpg', 159733);
INSERT INTO " . $this->db_prefix . "images (`imageFileName`, `indexImage`, `showonpage`, `galleryId`,  `imageName`, `imageSize`) VALUES('young_red_fox_kits_louisville_kentucky.jpg', 0, 1, 1, 'young_red_fox_kits_louisville_kentucky.jpg', 226365);


INSERT INTO `" . $this->db_prefix . "category` (`categoryName`, `categoryUrl`, `menuShow`) VALUES('A blog', 'a_blog', 'yes');
INSERT INTO `" . $this->db_prefix . "category` (`categoryName`, `categoryUrl`, `menuShow`) VALUES('Videók', 'videok', 'yes');
INSERT INTO `" . $this->db_prefix . "category` (`categoryName`, `categoryUrl`, `menuShow`) VALUES('Ez ne jelenjen meg a menuben', 'nem_menus', 'no');
INSERT INTO `" . $this->db_prefix . "category` (`categoryName`, `categoryUrl`, `menuShow`) VALUES('IT', 'it', 'yes');



INSERT INTO " . $this->db_prefix . "pages (`pageName`, `pageContent`, `pageUrl`, `pageCreator`, `isArchived`, `ordering`) VALUES('Blabla', '<p>Ide valami &eacute;rdekes sz&ouml;veg fog ker&uuml;lni.</p>\r\n\r\n<p>Mint p&eacute;ld&aacute;ul...</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Blabla...</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Blabla?</p>\r\n', 'blabla', 1, 'no', 4);



INSERT INTO `" . $this->db_prefix . "users` (`username`, `email`, `password`, `rank`) VALUES('" . $this->adminusername . "', '" . $this->adminemail . "', '" . $this->adminpassword . "', 10);


INSERT INTO `" . $this->db_prefix . "pages` (`pageName`, `pageContent`, `pageUrl`, `pageCreator`, `isArchived`, `ordering`) VALUES('Jogi akadály', '<p>Minden ezen az oldalon található mű, szerzemény, avagy alkotás a programozás és Bill Gates érdeme.</p>\r\n\r\n<p>K&eacute;rlek kezeld bizalmasan.</p>\r\n\r\n<p>A diz&aacute;jn innen van:&nbsp;<a href=\"http://andreasviklund.com/dt_portfolio/andreas02-2/\">http://andreasviklund.com/dt_portfolio/andreas02-2/</a><br />\r\nLegalábbis ez akart lenni az első, és fő téma, de aztán rájöttem, hogy mi lenne, ha több téma közül lehetne-e a választani. Így erről az oldalról több témát is letöltöttem, az összeset ez a Andreas Viklund csinálta. Köszönjük neki.</p>\r\n\r\n<p>PHP MVC struktúra. Powered by Feree.</p>\r\n', 'jogi_akadaly', 2, 'no', 4);

INSERT INTO `" . $this->db_prefix . "pages` (`pageName`, `pageContent`, `pageUrl`, `pageCreator`, `isArchived`, `ordering`) VALUES('Kapcsolat', '<p>Ha b&aacute;rmi k&eacute;rd&eacute;s, &oacute;haj, s&oacute;haj, b&aacute;nat, avagy elipszilonos vagy j&eacute;s probl&eacute;ma l&eacute;pne fel a szervezetedben, k&eacute;rlek l&eacute;pj kapcsolatba...&nbsp;</p>\r\n\r\n<p>Ferivel: <a href=\"mailto:netkorszak@gmail.com\">netkorszak@gmail.com</a></p>\r\n\r\n\r\n\r\n\r\n', 'kapcsolat', 2, 'no', 10);

INSERT INTO " . $this->db_prefix . "pages (`pageName`, `pageContent`, `pageUrl`,  `pageCreator`, `isArchived`, `ordering`) VALUES('Ez egy teszt oldal', '<p>Ez egy teszt oldal, ami nyugodtan törölhető avagy átírható.</p>\r\n', 'teszt_page', 1, 'no', 0);




INSERT INTO `" . $this->db_prefix . "posts` ( `postName`, `postContent`, `postCategory`, `postUrl`, `postCreator`) VALUES('Adjunk hozzá egy sokadik teszt bejegyzést.', '<p>Akkor ez most a vide&oacute; kateg&oacute;ri&aacute;ba ker&uuml;l, ahova be&aacute;gyazok egy youtube vide&oacute;t:&nbsp;</p>\r\n\r\n<p><iframe allowfullscreen=\"\" frameborder=\"0\" height=\"360\" src=\"//www.youtube.com/embed/-jGSOX2-G6M\" width=\"480\"></iframe></p>\r\n\r\n<p>Kell?</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Igen.</p>\r\n', 2, 'adjunk_hozza_egy_sokadik_bejegyzest', 2);

INSERT INTO `" . $this->db_prefix . "posts` ( `postName`, `postContent`, `postCategory`, `postUrl`, `postCreator`) VALUES('Surface Pro 3', '<p>Eg&eacute;sz j&oacute; kis g&eacute;p lett ez a masina, &eacute;s most &iacute;rn&eacute;k r&oacute;la sok-sok mindent, de nem tudok m&aacute;r mit, sz&oacute;val tess&eacute;k, itt a vide&oacute; r&oacute;la:</p>\r\n\r\n<p><iframe allowfullscreen=\"\" frameborder=0 height=\"360\" src=\"//www.youtube.com/embed/1iqKoVnllsY\" width=\"480\"></iframe></p>\r\n', 4, 'surface_pro', 2);

INSERT INTO `" . $this->db_prefix . "posts` ( `postName`, `postContent`, `postCategory`, `postUrl`, `postCreator`) VALUES('Ez egy youtube videó.', '<p>És még okosodhatunk is.</p>\r\n\r\n<p><iframe allowfullscreen=\"\" frameborder=\"0\" height=\"360\" src=\"//www.youtube.com/embed/7TF00hJI78Y\" width=\"500\"></iframe></p>\r\n', 2, 'ez_egy_youtube_vid', 2);

INSERT INTO `" . $this->db_prefix . "posts` ( `postName`, `postContent`,  `postCategory`, `postUrl`, `postCreator`) VALUES('Róka', '<p>Ez most egy olyan post teszt lesz, ami egyfelől teszt. M&aacute;sr&eacute;szt meg sok-sok r&oacute;k&aacute;r&oacute;l sz&oacute;l.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>[gallery=1]</p>\r\n', 1, 'roka', 2);


		";
        $query = $this->db->prepare($sql);
        $query->execute(
                array(':date' => date("Y-m-d H:m:s"))
        );

        // print "Sikeresen hozzáadtad a dolgokat az adatbázisba";
//config.php-t írja át.			
        $file = fopen('../application/config/config.php', 'wb');
        $fwriteText = "<?php

define('URL', '" . $this->siteurl . "');
define('DB_TYPE', '" . $this->db_type . "');
define('DB_HOST', '" . $this->db_host . "');
define('DB_NAME', '" . $this->db_name . "');
define('DB_USER', '" . $this->db_user . "');
define('DB_PASS', '" . $this->db_pass . "');
define('DB_PREFIX', '" . $this->db_prefix . "');";
        fwrite($file, $fwriteText);
        fclose($file);

//config.txt-t módosítja
        $file = fopen('../application/config/config.txt', 'wb');
        //ASD-nél néhány szerveren hibát dob, tehát 1. sort nem tudja értelmezni. Ezért van csak benne. Windowsos XAMPP környezetben nem volt ilyen hiba. A hiba egy Linuxos környzetben futtatott apache/php-nél volt
        $fwriteText = "ASD-->asd
SITENAME-->" . $this->sitename . "
SITEURL-->" . $this->siteurl . "
URL-->" . $this->siteurl . "
LINKHEADER1-->Google 
LINKHEADERURL1-->http://google.com
LINKHEADER2-->Facebook
LINKHEADERURL2-->http://facebook.com
LINKHEADER3-->Ez egy harmadik link
LINKHEADERURL3-->http://harmadiklink.hu
SITEDESC-->" . $this->sitedesc . "
SITEDESC2-->" . $this->sitedesc2 . "
COMMENTNUMSIDEBAR-->5
TEMPLATE-->andreas02";
        fwrite($file, $fwriteText);
        fclose($file);
		
		
		/* Node JS-t configolja. */
$file = fopen('../application/nodejs/config.js', 'wb');
    

        $fwriteText = "
		
		var db_host = '".$this->db_host."';
		var db_user='".$this->db_user."';
		var db_password='".$this->db_pass."';
		var db_prefix = '".$this->db_prefix."';
		var db_name='".$this->db_name."';
		var db_debug = 'false';
		var db_charset = 'utf8_hungarian_ci';
";
        fwrite($file, $fwriteText);
        fclose($file);



        //XML - lényegében átmásoltam a loginmodelből

        $fopenxml = fopen('../application/config/userdata.xml', 'r');
        $freadxml = fread($fopenxml, 40960);
        fclose($fopenxml);

        $users = new SimpleXMLElement($freadxml);
        $email_error = 0;
        $username_error = 0;

        /* 		for($i=0;$i<$users->count();$i++){ //ellenőrizzük, hogy nem-e duplikált-e a regisztráció (email/username)
          if($this->reg_email == $users->user[$i]->email){
          $email_error=1;
          }
          if($this->reg_username == $users->user[$i]->username){
          $username_error=1;
          }
          $lastid=$users->user[$i]->id; //utolsó ID változóba, hogy jó legyen az ID mező XML-ben
          } */
        // print $lastid;
        $lastid = 1;
        $addUser = $users->addChild('user');

        $addUser->addChild('id', $lastid);
        $addUser->addChild('username', $this->adminusername);
        $addUser->addChild('email', $this->adminemail);
        $addUser->addChild('password', md5($this->adminpassword));
        $addUser->addChild('rank', '10');
        $addUser->addChild('date_registered', date("Y-m-d H:i:s"));

        // print $users->asXML();
        $fopenxml = fopen('../application/config/userdata.xml', 'w');


        $xmlwrite = (string) $users->asXML();
        fwrite($fopenxml, $xmlwrite);
        fclose($fopenxml);
        //print "Sikeres regisztráció, és sikeresen beléptél";
        $_SESSION['username'] = $this->adminusername;
        $_SESSION['email'] = $this->adminemail;
        $_SESSION['rank'] = 10; //ezt is írjuk át, ne csak az addChild-nál lévőt! 
        $_SESSION['logged_in'] = 1;



        header("location:ready.php");
    }

}
