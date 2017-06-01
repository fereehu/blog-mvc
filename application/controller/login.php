<?php

class Login extends Controller {

    public function index() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        require 'application/views/login/index.php';
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function getlogin() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        if (isset($_POST['getLogin']) == 1) {
            $loginmodel = $this->loadModel('LoginModel');
            $loginmodel->getLogin();
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function wrongpass() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        require 'application/views/login/wrongpass.php';
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function forgotpassword() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        $loginmodel = $this->loadModel('LoginModel');

        if (URL_PARAMETER1 == "secret_code") {
            if (strlen(URL_PARAMETER2) == 0) {
                header('location: ' . URL . 'login/forgotpassword'); //Vissza léptetjük, hogy ne legyen ott a secret_code.
            }
            if ($loginmodel->checkSecretCode(URL_PARAMETER2)) {
                require 'application/views/login/forgotpasswordChangePassword.php';
            } else {
                require 'application/views/login/forgotpasswordSecretCodeError.php';
            }
        } else {
            if (isset($_POST['forgotpassword']) and $_POST['forgotpassword'] == 1) {
                $email = htmlspecialchars($_POST['email']);
                // $loginmodel->forgotPassword($email);
                if ($loginmodel->forgotPassword($email)) {
                    require 'application/views/login/forgotpasswordSuccess.php';
                } elseif (!$loginmodel->forgotPassword($email)) {
                    require 'application/views/login/forgotpasswordNoEmail.php';
                }
            }
            require 'application/views/login/forgotpassword.php';
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function forgotSetPassword() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        $loginmodel = $this->loadModel('LoginModel');
        $_SESSION['secret_code'] = $_POST['secret_code'];
        if ($loginmodel->forgotSetPassword($_POST)) {
            require 'application/views/login/forgotpasswordPasswordChanged.php';
        } else {
            require 'application/views/login/forgotpasswordErrorAfterChanged.php';
        }
        if (isset($_POST['new_password']) and $_POST['new_password'] == 1) { //jelszó változtatás
            require 'application/views/login/forgotpasswordChangePassword.php';
            // print "jelszó változataás";
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function reg() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        require 'application/views/login/reg.php';
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function regData() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        if (isset($_POST['regdata']) == 1) {
            $loginmodel = $this->loadModel('LoginModel');
            $loginmodel->regData();
            require 'application/views/login/reg.php';
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function profil() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        //Ha nincs bejelentkezve, akkor átdobja a login index-re
        if (isset($_SESSION['logged_in']) and $_SESSION['logged_in'] == 1) {
            if (URL_PARAMETER1 == "changePassword") {
                require 'application/views/login/changePassword.php';
            } else {
                require 'application/views/login/profil.php';
            }
        } else {
            require 'application/views/login/index.php';
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function logout() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        $loginmodel = $this->loadModel('LoginModel');
        $loginmodel->logout();
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function loginXML() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        require 'application/views/login/loginXML.php';

        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function getloginXML() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        if (isset($_POST['getLogin']) == 1) {
            $loginmodel = $this->loadModel('LoginModel');
            $loginmodel->getLoginXML();
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function regXML() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        require 'application/views/login/regXML.php';
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function regDataXML() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        if (isset($_POST['regdata']) == 1) {
            $loginmodel = $this->loadModel('LoginModel');
            $loginmodel->regDataXML();
            require 'application/views/login/regXML.php';
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function profilXML() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        require 'application/views/login/profilXML.php';
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function profilDataXML() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        if (isset($_POST['regdata']) == 1) {
            $loginmodel = $this->loadModel('LoginModel');
            $loginmodel->profilDataXML();
            require 'application/views/login/regXML.php';
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function changePassword() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        if (isset($_SESSION['logged_in']) and $_SESSION['logged_in'] == 1) {
            $loginmodel = $this->loadModel('LoginModel');
            require 'application/views/login/changePassword.php';
        } else {
            require 'application/views/login/index.php';
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function setPassword() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        $loginmodel = $this->loadModel('LoginModel');

        if (isset($_SESSION['logged_in']) and $_SESSION['logged_in'] == 1) {
            if(!$loginmodel->setPassword($_POST)){
                print "Hiba! A két jelszó nem egyezik, vagy hibás régi jelszó!";
            }
            require 'application/views/login/changePassword.php';
        } else {
            require 'application/views/login/index.php';
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

}
