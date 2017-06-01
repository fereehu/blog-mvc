<?php

class Admin extends Controller {

    public function index() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        if (RANK == 10) {
            require 'application/views/admin/index.php';
        } else {
            print HIBASRANK;
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function config() { //ez most (még) nem kell
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        if (RANK == 10) {
            require 'application/views/admin/config.php';
        } else {
            print HIBASRANK;
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function settings() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        if (RANK == 10) {

            $config_model = $this->loadModel('ConfigModel');
            $themeLoad1 = $config_model->themeLoad();

            require 'application/views/admin/settings.php';
        } else {
            print HIBASRANK;
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function users() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        if (RANK == 10) {

            $config_model = $this->loadModel('ConfigModel');
            $users = $config_model->getUsers();

            require 'application/views/admin/users.php';
            if ((int) URL_PARAMETER1) {
                $users = $config_model->getOneUser(URL_PARAMETER1);
                require 'application/views/admin/userModify.php';


                if (URL_PARAMETER2 == "userAction") {

                    $users = $config_model->userAction();

                    if ($users == true) {
                        header("location: " . URL . "admin/users/" . URL_PARAMETER1 . "");
                    } elseif ($users == false) {
                        require 'application/views/admin/usersError.php';
                    }
                    // header("location: ".URL."admin/users/".URL_PARAMETER1."");
                }
                if (URL_PARAMETER2 == "delUser") {

                    $users = $config_model->delUser(URL_PARAMETER1);

                    if ($users == true) {
                        header("location: " . URL . "admin/users/" . URL_PARAMETER1 . "");
                    } elseif ($users == false) {
                        require 'application/views/admin/usersError.php';
                    }
                    // header("location: ".URL."admin/users/".URL_PARAMETER1."");
                }
            }
        } else {
            print HIBASRANK;
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function setSite() {
        if (RANK == 10) {
            if ($_POST["setsiteconfig"] == 1) {
                $config_model = $this->loadModel('ConfigModel');
                $config_model->setSite($_POST["sitename"], $_POST["siteurl"], $_POST['adminemail'], $_POST['globalemail'], $_POST["linkheader1"], $_POST["linkheader2"], $_POST["linkheader3"], $_POST["linkheaderurl1"], $_POST["linkheaderurl2"], $_POST["linkheaderurl3"], $_POST["sitedesc"], $_POST["sitedesc2"], $_POST["template"], (int) $_POST["commentnumsidebar"]
                );
            }
        } else {
            print HIBASRANK;
        }
    }

    public function posts() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        if (RANK == 10) {
            $config_model = $this->loadModel('ConfigModel');

            if ((int) URL_PARAMETER1) {//post szerkesztése
                $posts = $config_model->getOnePost(URL_PARAMETER1);
                $categorys = $config_model->getAllCategory();
                if (isset($_POST['postid'])) {
                    $postModify = $config_model->postModify($_POST);
                    header("location: " . URL . "admin/posts/" . URL_PARAMETER1 . "");
                }
                require 'application/views/admin/postModify.php';
            } elseif (URL_PARAMETER1 == "postDel") {
                if ((int) URL_PARAMETER2) {
                    if (URL_PARAMETER3 == "confirmed") {
                        $posts = $config_model->postDel(URL_PARAMETER2);
                        header("location:" . URL . "admin/posts");
                    }
                    $posts = $config_model->getOnePost(URL_PARAMETER2);
                    require 'application/views/admin/postDel.php';
                } else {
                    header("location: " . URL . "admin/posts/");
                }
            } else {
                $posts = $config_model->getPosts();
                require 'application/views/admin/posts.php';
            }
            // require 'application/views/admin/posts.php';
        } else {
            print HIBASRANK;
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function addPost() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        if (RANK == 10) {
            if (isset($_POST) and $_POST != null) {
                $config_model = $this->loadModel('ConfigModel');
                $config_model->addPost($_POST);
                header("location: " . URL . "blog/lastpost");
            } else {
                $config_model = $this->loadModel('ConfigModel');
                $categorys = $config_model->getAllCategory();

                require 'application/views/admin/addpost.php';
            }
        } else {
            print HIBASRANK;
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

//Oldalak controllerje
    public function pages() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        if (RANK == 10) {
            $config_model = $this->loadModel('ConfigModel');

            if ((int) URL_PARAMETER1) {//post szerkesztése
                $pages = $config_model->getOnePage(URL_PARAMETER1);
                if (isset($_POST['pageid'])) {
                    $pageModify = $config_model->pageModify($_POST);
                    header("location: " . URL . "admin/pages/" . URL_PARAMETER1 . "");
                }
                require 'application/views/admin/pageModify.php';
            } elseif (URL_PARAMETER1 == "pageDel") {
                if ((int) URL_PARAMETER2) {
                    if (URL_PARAMETER3 == "confirmed") {
                        $pages = $config_model->pageDel(URL_PARAMETER2);
                        header("location:" . URL . "admin/pages");
                    }
                    $pages = $config_model->getOnePage(URL_PARAMETER2);
                    require 'application/views/admin/pageDel.php';
                } else {
                    header("location: " . URL . "admin/pages/");
                }
            } else {
                $pages = $config_model->getPages();
                require 'application/views/admin/pages.php';
            }
            // require 'application/views/admin/posts.php';
        } else {
            print HIBASRANK;
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function addPage() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        if (RANK == 10) {
            if (isset($_POST) and $_POST != null) {
                $config_model = $this->loadModel('ConfigModel');
                $config_model->addPage($_POST);
                header("location: " . URL . "admin/pages");
            } else {
                $config_model = $this->loadModel('ConfigModel');

                require 'application/views/admin/addpage.php';
            }
        } else {
            print HIBASRANK;
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

//Oldalak vége

    public function category() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        if (RANK == 10) {
            if ((int) URL_PARAMETER1) {
                $config_model = $this->loadModel('ConfigModel');
                $categorys = $config_model->getCategoryFromId(URL_PARAMETER1);
                require 'application/views/admin/categoryModify.php';
            } else {
                $config_model = $this->loadModel('ConfigModel');
                $categorys = $config_model->getAllCategory();
                require 'application/views/admin/category.php';
            }
        } else {
            print HIBASRANK;
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function categoryAction() {
        if (isset($_POST)) {
            $config_model = $this->loadModel('ConfigModel');
            $categorys = $config_model->categoryAction($_POST);
            header("location: " . URL . "admin/category");
        }
    }

    public function addcategory() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        if (RANK == 10) {
            if (isset($_POST) and $_POST != null) {
                $config_model = $this->loadModel('ConfigModel');
                $categorys = $config_model->addCategory($_POST);
                header("location:" . URL . "admin");
            } else {
                require 'application/views/admin/addcategory.php';
            }
        } else {
            print HIBASRANK;
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function delCategory() {
        if (RANK == 10) {
            $config_model = $this->loadModel('ConfigModel');
            $categorys = $config_model->delCategory(URL_PARAMETER1);
            header("location:" . URL . "admin/category");
        } else {
            print HIBASRANK;
        }
    }

    public function comments() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        if (RANK == 10) {
            $config_model = $this->loadModel('ConfigModel');
            $getComments = $config_model->getComments();
            require 'application/views/admin/comments.php';
            if (URL_PARAMETER1 == "delComment") {
                if ((int) URL_PARAMETER2) {
                    $delComment = $config_model->delComment(URL_PARAMETER2);
                }
                header("location: " . URL . "admin/comments");
            }
        } else {
            print HIBASRANK;
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function gallery() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        if (RANK == 10) {
            $config_model = $this->loadModel('ConfigModel');

            if (!URL_PARAMETER1) {
                $getGallery = $config_model->getGallery();
                require 'application/views/admin/gallery.php';
            }
            if ((int) URL_PARAMETER1) {
                $getGalleryImages = $config_model->getGalleryImages(URL_PARAMETER1);

                $getGalleryById = $config_model->getGalleryById(URL_PARAMETER1);
                if (count($getGalleryById) == 0) {
                    print NINCSGALERIA;
                } else
                    require 'application/views/admin/addImagesToGallery.php';
                if (URL_PARAMETER2 == "success") {
                    require 'application/views/admin/gallerySuccess.php';
                }
                if (URL_PARAMETER2 == "deleteGallery") {
                    $deleteGallery = $config_model->deleteGallery(URL_PARAMETER1);
                    header("location: " . URL . "admin/gallery/	");
                }
                // header("location:".URL."admin/gallery/".URL_PARAMETER1);
            }
            if (URL_PARAMETER1 == "addImages") {
                //require 'application/views/admin/addImagesToGallery.php';
                header("location: " . URL . "admin/gallery/" . $_POST['gallery']);
            }
            if (URL_PARAMETER1 == "uploadImage") {
                // $config_model = $this->loadModel('ConfigModel');
                // print_r($_FILES);
                // print_r($_FILES['img_id']);
                $config_model->uploadImage($_FILES['img_id']);
                header("location: " . URL . "admin/gallery/" . $_POST['galleryId']);
            }
            if (URL_PARAMETER1 == "editImages") {
                $config_model->editImages($_POST);
                header("location:" . URL . "admin/gallery/" . $_POST['galleryId'] . "/success");
            }
            if (URL_PARAMETER1 == "addGallery") {
                require 'application/views/admin/addGallery.php';
                if (isset($_POST) and isset($_POST['galleryName']) and $_POST['galleryName'] != null) {
                    // $config_model = $this->loadModel('ConfigModel');
                    $getComments = $config_model->addGallery($_POST);

                    header("location:" . URL . "admin/gallery");
                }
            }
        } else {
            print HIBASRANK;
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    /*
      public function exportToCsv()
      {
      require 'application/views/admin/exporttocsv.php';

      $config_model = $this->loadModel('ConfigModel');
      $exportcsv = $config_model->exportToCsv();

      }
     */
}
