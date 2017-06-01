<?php

class Application {

    private $url_controller = null;
    private $url_action = null;
    private $url_parameter_1 = null;
    private $url_parameter_2 = null;
    private $url_parameter_3 = null;

    public function __construct() {
        include_once('email.php');
        //sendMail("Sender Email neve", "sender@feree.hu", "netkorszak@gmail.com", "tárgy", "üzenet");
        //néhány hiba kód.  
        define('HIBASRANK', 'Nincs megfelelő jogosultságod az oldal megtekintéséhez.');
        define('NINCSGALERIA', 'Nincs ilyen galéria!');
 

 
        // tömböt csinál a $url-ből
        $this->splitUrl();

        $this->splitConfigTxt(); //config.txt-t beolvassa

        $this->sessionDefine(); //session-öket define-ba rakja
        /////////////////////////////
        require './application/controller/get.php'; //get model-controllert átadja. ami alap, és nem oldal (url) függő. leginkább a sidebarnál használatos
        $get = new Get();
        $get->showGets();
        //////////////////////////////		
        // van ilyen controller?
        if (file_exists('./application/controller/' . $this->url_controller . '.php')) {

            // ha van, akkor töltse be
            // pl: ha van ilyen "asd", akkor ezt fogja betölteni:  $this->asd = new asd();
            require './application/controller/' . $this->url_controller . '.php';
            $this->url_controller = new $this->url_controller();

            // van ilyen metódus?
            if (method_exists($this->url_controller, $this->url_action)) {

                // hívja be a metódust
                if (isset($this->url_parameter_3)) {
                    // ilyesmi lesz: $this->home->method($param_1, $param_2, $param_3);
                    $this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2, $this->url_parameter_3);
                } elseif (isset($this->url_parameter_2)) {
                    // ilyesmi lesz: $this->home->method($param_1, $param_2);
                    $this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2);
                } elseif (isset($this->url_parameter_1)) {
                    // ilyesmi lesz $this->home->method($param_1);
                    $this->url_controller->{$this->url_action}($this->url_parameter_1);
                } else {
                    // ha nincs paraméter megadva, akkor anélkül hívja be: $this->home->method();
                    $this->url_controller->{$this->url_action}();
                }
            } else {
                // alapbeállításként az index()-et hívja be.
                $this->url_controller->index();
            }
        } else {
            // ha hibás vagy nem létező az elérés, akkor a home-ot mutassa
            require './application/controller/home.php';
            $home = new Home();
            $home->index();
        }
    }

    //szétszedi az URL-t
    private function splitUrl() {
        if (isset($_GET['url'])) {

            // trimmeli
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            $this->url_controller = (isset($url[0]) ? $url[0] : null);
            $this->url_action = (isset($url[1]) ? $url[1] : null);
            $this->url_parameter_1 = (isset($url[2]) ? $url[2] : null);
            $this->url_parameter_2 = (isset($url[3]) ? $url[3] : null);
            $this->url_parameter_3 = (isset($url[4]) ? $url[4] : null);
            define('CONTROLLER', $this->url_controller);
            define('POSTURL', $this->url_action); //megadjuk a bloghoz, hogy tudjunk rá hivatkozni
            define('URL_PARAMETER1', $this->url_parameter_1); //megadjuk, hogy tudjunk rá könnyen hivatkozni.
            define('URL_PARAMETER2', $this->url_parameter_2); //megadjuk, hogy tudjunk rá könnyen hivatkozni.
            define('URL_PARAMETER3', $this->url_parameter_3); //megadjuk, hogy tudjunk rá könnyen hivatkozni.
            // debuggoláshoz
            // echo 'controller: ' . $this->url_controller . '<br>';
            // echo 'action: ' . $this->url_action . '<br>';
            // echo 'parameter 1: ' . $this->url_parameter_1 . '<br>';
            // echo 'parameter 2: ' . $this->url_parameter_2 . '<br>';
            // echo 'parameter 3: ' . $this->url_parameter_3 . '<br>';
        }
    }

    private function splitConfigTxt() {
        //config.txt-ből tömbösíti a beállításokat. 
        $configfopen = fopen('application/config/config.txt', 'r');
        $open1 = fread($configfopen, 4096);
        $open2 = explode("\n", $open1);

        foreach ($open2 as $open3) {
            $open4 = explode("-->", $open3);
            $config[$open4[0]] = $open4[1];

            define($open4[0], $open4[1], true);
        }
    }

    private function sessionDefine() { //session define. Nézethez.
        if (isset($_SESSION["id"]))
            define('ID', $_SESSION["id"]);
        else
            define('ID', "");
        if (isset($_SESSION["username"]))
            define('USERNAME', $_SESSION["username"]);
        else
            define('USERNAME', "");
        if (isset($_SESSION["email"]))
            define('EMAIL', $_SESSION["email"]);
        else
            define('EMAIL', "");
        if (isset($_SESSION["rank"]))
            define('RANK', $_SESSION["rank"]);
        else
            define('RANK', "");
        if (isset($_SESSION['logged_in']) and $_SESSION['logged_in'] == 1)
            define('LOGGED_IN', 1);
        else
            define('LOGGED_IN', "");
    }

}
