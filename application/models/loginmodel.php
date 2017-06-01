<?php

class LoginModel {

    private $email;
    private $password;
    private $reg_username;
    private $reg_email;
    private $reg_password;
    private $reg_password2;
    private $password1;
    private $password2;

    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Valami hiba történt az adatbázishoz való csatlakozással.');
        }


        $this->email = isset($_POST['email']) ? $_POST['email'] : null;
        $this->password = isset($_POST['password']) ? $_POST['password'] : null;

        $this->reg_username = isset($_POST['reg_username']) ? $_POST['reg_username'] : null;
        $this->reg_email = isset($_POST['reg_email']) ? $_POST['reg_email'] : null;
        $this->reg_password = isset($_POST['reg_password']) ? $_POST['reg_password'] : null;
        $this->reg_password2 = isset($_POST['reg_password2']) ? $_POST['reg_password2'] : null;

        /* Profil módosítása (jelszó) */
        /*     $this->old_password = isset($_POST['old_password']) ? $_POST['old_password'] : null;
          $this->new_password1 = isset($_POST['new_password1']) ? $_POST['new_password1'] : null;
          $this->new_password2 = isset($_POST['new_password2']) ? $_POST['new_password2'] : null; */
    }

    public function getlogin() {

        $sql = "SELECT 
			id, 
			username, 
			email,
			password,
			rank
		FROM 
			" . DB_PREFIX . "users
		WHERE 
			email = '" . $this->email . "' 
				AND 
			password = '" . md5($this->password) . "' 
		";

        $query = $this->db->prepare($sql);
        $query->execute();

        $fetch = $query->fetch(PDO::FETCH_ASSOC);

        if ($fetch['id'] == null) {
            header("location: " . URL . "login/wrongpass");
// print "Hibás bejelentkezés, próbáld meg újból. Vagy a jelszó, vagy az email cím hibás.";
        } else {
            $_SESSION['id'] = $fetch['id'];
            $_SESSION['username'] = $fetch['username'];
            $_SESSION['email'] = $fetch['email'];
            $_SESSION['password'] = $fetch['password'];
            $_SESSION['rank'] = $fetch['rank'];
            $_SESSION['logged_in'] = 1;
            print "Sikeres bejelentkezés. Adatok: <br> ";
            print_r($_SESSION);



//header("location:".URL);
            header("location: " . URL . "login/profil");
        }
    }

    public function forgotPassword($email) {
//HTML-ként küldi ki az emailt
        $sql = "SELECT 
			COUNT(id) as num, 
			username, 
			email
		FROM 
			" . DB_PREFIX . "users
                WHERE 
                    email = '" . $email . "'
		";

        $query = $this->db->prepare($sql);
        $query->execute();

        $fetch = $query->fetch();

        if ($fetch->num == 0) {
            return false;
        } elseif ($fetch->num == 1) {
            $secret_code = md5(rand(000000, 9999999999) . date('Y-M-D-S-m-y-s-s-y-m-s')); //ez azért elég random lesz :)
            $sql = "UPDATE " . DB_PREFIX . "users
                SET 
			secret_code = :secret_code
                WHERE 
                email = :email
		";
            $query = $this->db->prepare($sql);
            $query->execute(
                    array(':secret_code' => $secret_code,
                        ':email' => $email
            ));
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }

            $emailText = "Kedves $fetch->username! <br><br> Te, vagy valaki más, az alábbi IP címről ($ip) a(z) <a href='" . URL . "'>" . SITENAME . "</a> oldalon jelszó emlékeztetőt kért az email címedre: $fetch->email. <br><br>
Ha nem te voltál, akkor vedd ezt az emailt figyelmen kívül, ha te voltál, akkor kérlek kattints a következő linkre: <br><br>"
                    . ""
                    . "<a href='" . URL . "login/forgotpassword/secret_code/$secret_code'>" . URL . "login/forgotpassword/secret_code/$secret_code</a>"
                    . "<br><br>Üdvözlettel, "
                    . "<br>"
                    . "" . SITENAME . ""
                    . "";

            sendMail(SITENAME, GLOBALEMAIL, $email, "Elfelejtett jelszó", $emailText);
            return true;
        }
    }

    public function checkSecretCode($secret_code) {
        $sql = "SELECT 
			count(secret_code) as secret_code_count
		FROM 
			" . DB_PREFIX . "users
                WHERE 
                    secret_code = '" . $secret_code . "'
		";

        $query = $this->db->prepare($sql);
        $query->execute();

        $fetch = $query->fetch();
        if ($fetch->secret_code_count == 1) {
            return true;
        } else {
            return false;
        }
    }
//$post = $_POST;
    public function forgotSetPassword($post) {
        //  print_r($_POST);
        if (isset($_POST['new_password']) and $_POST['new_password'] == 1) {
            if ($_POST['new_psw1'] != $_POST['new_psw2'] AND empty($_POST['secret_code'])) {
                $_SESSION['secret_code'] = $_POST['secret_code'];
                return false;
            } elseif ($_POST['new_psw1'] == $_POST['new_psw2']) {

                $sql = "SELECT count(secret_code) as secret_code_count, secret_code FROM 
			" . DB_PREFIX . "users
		WHERE 
                    email = :email";
                $query = $this->db->prepare($sql);
                $query->execute(array(
                    ':email' => htmlspecialchars($_POST['email'])));
                $select = $query->fetch();
                if ($select->secret_code_count == 0) {
                    return false;
                } elseif ($select->secret_code == $_POST['secret_code']) {
                    $sql = "UPDATE " . DB_PREFIX . "users
                SET 
			password = :password,
                        secret_code = :null
                WHERE 
                        email = :email
                          AND 
                        secret_code = :secret_code
		";
                    $query = $this->db->prepare($sql);
                    $query->execute(
                            array(
                                ':password' => md5($_POST['new_psw2']),
                                ':email' => htmlspecialchars($_POST['email']),
                                ':secret_code' => htmlspecialchars($_POST['secret_code']),
                                ':null' => ''
                    ));

                    return true;
                }
            }
        }
    }

    public function regData() {
//print_r($_POST);
        $sql = "SELECT count(*) FROM 
			" . DB_PREFIX . "users
		WHERE 
			username = '" . $this->reg_username . "' 
				OR 
			email = '" . $this->reg_email . "'
		";


        $query = $this->db->prepare($sql);
        $query->execute();
        $rowscount = $query->fetchColumn();
        $_SESSION['reg_username'] = $_POST['reg_username'];
// define('REG_USERNAME', $_SESSION['reg_username']);
        $_SESSION['reg_email'] = $_POST['reg_email'];
// define('REG_EMAIL', $_SESSION['reg_email']);

        if ($rowscount == 1) {
            print "Hibás regisztráció, a felhasználónév vagy email cím már foglalt. Próbáld meg újból más névvel, avagy email címmel...";
        } elseif ($this->reg_password != $this->reg_password2) {
            print "<h1>Hiba</h1>A két jelszó nem egyezik! Ismételd meg a regisztrációt, újból! ";
        } else {

            $username = strip_tags($this->reg_username);
            $email = strip_tags($this->reg_email);
            $password = md5($this->reg_password);

            $sql = "INSERT INTO " . DB_PREFIX . "users (username, email, password) VALUES (:username, :email, :password)";
            $query = $this->db->prepare($sql);
            $query->execute(array(':username' => $username, ':email' => $email, ':password' => $password));


// $_SESSION['id'] = $fetch['id'];
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['rank'] = 0;
            $_SESSION['logged_in'] = 1;

            unset($_SESSION['reg_username']);
            unset($_SESSION['reg_email']);
            header("location: " . URL . "login/profil");
        }
    }

    public function getLoginXML() {
//$xml=simplexml_load_file("./application/config/userdata.xml") or die("Error: Hibás a fájl."); //1. próbálkozás... nem tetszett a megvalósítás, mentünk a 2. ötletre, ami jobb lehet (lett?). sajnos így is for-t kellett használni, de egyébként működik a bejelentkezés. 
//nem olyan könnyű, mint sqlnél :)
        $fopenxml = fopen('./application/config/userdata.xml', 'r');
        $freadxml = fread($fopenxml, 4096);
        $users = new SimpleXMLElement($freadxml); //nem object!!!! ezért kell majd (string) a sessionhöz.

        for ($i = 0; $i < $users->count(); $i++) {
            if ($users->user[$i]->email != $this->email AND $users->user[$i]->password != md5($this->password)) {
                $login_error = 1;
            } else {

                print "Sikeres bejelentkezés... most lehetne ide egy átirányítás, vagy valami, de inkább majd frissítsük a böngészőt, és látható lesz az admin menü... márha admin vagy :D";
                $_SESSION['username'] = (string) $users->user[$i]->username;
                $_SESSION['email'] = (string) $users->user[$i]->email;
                $_SESSION['rank'] = (string) $users->user[$i]->rank;
                $_SESSION['logged_in'] = 1;
// print_r($_SESSION);
                $login_error = 0;
            }
        }
        if ($login_error == 1)
            print "Hibás email/jelszó páros";
    }

    public function regdataXML() {
        if ($this->reg_password != $this->reg_password2) {
            print "<h1>Hiba</h1>A két jelszó nem egyezik! Ismételd meg a regisztrációt, újból! ";
        } else {
            $fopenxml = fopen('./application/config/userdata.xml', 'r');
            $freadxml = fread($fopenxml, 40960);
            fclose($fopenxml); //be kell zárni, majd újból megnyitni. a változókban úgyis benne van minden, és amúgyis hibát dobott, ha írásra is megnyitjuk a fájlt. 

            $users = new SimpleXMLElement($freadxml);
            $email_error = 0;
            $username_error = 0;

            for ($i = 0; $i < $users->count(); $i++) { //ellenőrizzük, hogy nem-e duplikált-e a regisztráció (email/username)
                if ($this->reg_email == $users->user[$i]->email) {
                    $email_error = 1;
                }
                if ($this->reg_username == $users->user[$i]->username) {
                    $username_error = 1;
                }
                $lastid = $users->user[$i]->id; //utolsó ID változóba, hogy jó legyen az ID mező XML-ben
            }
// print $lastid;
            if ($username_error == 0 OR $username_error == 0) {
                $addUser = $users->addChild('user');

                $addUser->addChild('id', $lastid + 1);
                $addUser->addChild('username', $this->reg_username);
                $addUser->addChild('email', $this->reg_email);
                $addUser->addChild('password', md5($this->reg_password2));
                $addUser->addChild('rank', '10'); //ez alapból most 10 lesz, majd át kell írni éles környezetben 0-ra, ha nem akarjuk, hogy mindenki admin legyen az oldalunkon. 
                $addUser->addChild('date_registered', date("Y-m-d H:i:s"));

// print $users->asXML();
                $fopenxml = fopen('./application/config/userdata.xml', 'w'); //újból meg kell nyitni, XML errort dobott, ha alapból benne hagyjuk. De itt nem olvasunk, hanem írunk. 


                $xmlwrite = (string) $users->asXML();
                fwrite($fopenxml, $xmlwrite);
                fclose($fopenxml);
                print "Sikeres regisztráció, és sikeresen beléptél";
                $_SESSION['username'] = $this->reg_username;
                $_SESSION['email'] = $this->reg_email;
                $_SESSION['rank'] = 10; //ezt is írjuk át, ne csak az addChild-nál lévőt! 
                $_SESSION['logged_in'] = 1;
            } else {
                print "Már létezik ilyen felhasználónév vagy email cím. Kérlek regisztrálj mással.";
            }
        }
    }

    public function setPassword($jelszo) {
        if (empty($jelszo['old_password']) OR $jelszo['new_password1'] != $jelszo['new_password2']) {
            return false;
        } else {
            $sql = "SELECT 
                        password
                FROM 
			" . DB_PREFIX . "users
		WHERE   username = :username,
                        email = :email,
                        password = :password
		";
            $query = $this->db->prepare($sql);
            $query->execute(
                    array(':username' => $_SESSION['username'],
                        ':email' => $_SESSION['email'],
                        ':password' => md5($jelszo['old_password'])
            ));
          //  $row = $query->rowCount();
            //NINCS BEFEJEZVE, HIBÁT DOB
            $row = $query->fetch();
            if($row->password == 0){
                print "asd";
            }
            if(md5($jelszo['old_password']) == $row->password){
                return true;
            }else{
                return false;
            }

//            return true;
        }
    }

    public function logout() {
        session_destroy();
        unset($_SESSION["id"]);
        unset($_SESSION["username"]);
        unset($_SESSION["email"]);
        unset($_SESSION["rank"]);
        unset($_SESSION['logged_in']);
        unset($_SESSION);
        echo "Sikeres kilépés.";
        header("location:" . URL);
    }

}
