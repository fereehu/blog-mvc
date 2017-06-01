<?php


class Blog extends Controller {

    public function index() {
        $blog_model = $this->loadModel('blogmodel');
        $posts = $blog_model->getAllPosts();
        $postUrl = POSTURL;
        $onepost = $blog_model->getOnePost($postUrl);
        $error_comment = 0;
        
       // print "fdsf";
 //       ($to, $subject, $text) 
      //  $mailes = $get->sendMail("netkorszak@gmail.com", "tárgyunk", "fsdfsdf");
        
        if ($postUrl == "commentSubmit") {//ajaxos behívás
            if (isset($_POST['comment'])) {
                if (empty($_POST['comment'])) {
                    $error_comment = 1;
                    require 'application/views/blog/commentErrorEmpty.php';
                }
                if (empty($_POST['username'])) {
                    $error_comment = 1;
                    require 'application/views/blog/commentErrorUsernameEmpty.php';
                }
                if (empty($_POST['useremail'])) {
                    $error_comment = 1;
                    require 'application/views/blog/commentErrorEmailEmpty.php';
                }
                $captchacheck = $blog_model->captcha($_POST['captcha'], $_POST['comment']);
               if ($captchacheck == false) {
                    //   print "HIBA";
                    // require 'application/views/blog/comment.php';
                   $error_comment = 1;
                    require 'application/views/blog/commentErrorCaptcha.php';
                }
            }
            if($error_comment == 0){
                $writeComment = $blog_model->writeComment($_POST);

            }
        } elseif (URL_PARAMETER1 == "comments") {//auto újratölti az hozzászólások, egy új hsz írása után
            $getComments = $blog_model->getComments($postUrl);
            require 'application/views/blog/comments.php';
        } elseif (!empty($postUrl)) {


            require 'application/views/_templates/' . TEMPLATE . '/header.php';

            require 'application/views/blog/onepost.php';
            ////Comment rész////
            $getComments = $blog_model->getComments($postUrl);

            if (isset($_POST['comment'])) {
                $captchacheck = $blog_model->captcha($_POST['captcha'], $_POST['comment']);
                if ($captchacheck == true) {
                    $writeComment = $blog_model->writeComment($_POST);
                    header("location: " . URL . "blog/" . $postUrl);
                } elseif ($captchacheck == false) {
                    require 'application/views/blog/comment.php';
                    require 'application/views/blog/commentErrorCaptcha.php';
                }
            } else { //ki kellett ifelni, különben "Cannot modify header information" hibát dobott.
                require 'application/views/blog/comment.php';
                require 'application/views/_templates/' . TEMPLATE . '/footer.php';
            }
            ///Comment vége////
        } else {
            require 'application/views/blog/index.php';
            require 'application/views/_templates/' . TEMPLATE . '/footer.php';
        }
    }

    /*
      public function comments() {
      $postUrl = POSTURL;
      $getComments = $blog_model->getComments($postUrl);

      require 'application/views/blog/comments.php';
      }
     */

    public function lastpost() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        $blog_model = $this->loadModel('blogmodel');
        $onepost = $blog_model->getLastPost(POSTURL);
        require 'application/views/blog/onepost.php';
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function category() {

        require 'application/views/_templates/' . TEMPLATE . '/header.php';



        $blog_model = $this->loadModel('blogmodel');
        $categoryUrl = URL_PARAMETER1;
        // $url_parameter1 = URL_PARAMETER1;
        if (!empty($categoryUrl)) {
            $onepost = $blog_model->getAllPostByCategory($categoryUrl);
            require 'application/views/blog/onecategory.php';
        } else {
            $categorys = $blog_model->getAllCategory();
            require 'application/views/blog/category.php';
        }


        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function category_ajax() {
        //require 'application/views/_templates/' . TEMPLATE . '/header.php';
        $blog_model = $this->loadModel('blogmodel');
        $categoryUrl = URL_PARAMETER1;
        // $url_parameter1 = URL_PARAMETER1;
        if (!empty($categoryUrl)) {
            $onepost = $blog_model->getAllPostByCategory($categoryUrl);
            require 'application/views/blog/onecategory.php';
        } else {
            $categorys = $blog_model->getAllCategory();
            require 'application/views/blog/category.php';
        }
        // require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function search() { //keresés a blogban
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $blog_model = $this->loadModel('blogmodel');
            $getsearch = $blog_model->getSearch($_GET['search']);
            require 'application/views/blog/getsearch.php';
        } else {
            require 'application/views/blog/search.php';
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function archives() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        $year = URL_PARAMETER1;
        $month = URL_PARAMETER2;
        $day = URL_PARAMETER3;

        if (empty($year) AND empty($month) and empty($day)) {
            $posts = array();
            require 'application/views/blog/archives.php';
        } else {

            $blog_model = $this->loadModel('blogmodel');
            $posts = $blog_model->getArchives(URL_PARAMETER1, URL_PARAMETER2, URL_PARAMETER3);


            require 'application/views/blog/archives.php';
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }
    
    /* public function comment() 
      {
      require 'application/views/_templates/'.TEMPLATE.'/header.php';
      $blog_model = $this->loadModel('blogmodel');
      $getsearch = $blog_model->getSearch(htmlspecialchars($_GET['search']));
      require 'application/views/blog/comment.php';
      require 'application/views/_templates/'.TEMPLATE.'/footer.php';
      } */
}
