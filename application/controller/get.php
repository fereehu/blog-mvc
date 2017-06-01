<?php

class Get extends Controller {

    public function showGets() {
        $getModel = $this->loadModel('getModel');

        $GLOBALS['catAll'] = $getModel->getCategoryMenu();
        $GLOBALS['showpages'] = $getModel->getPagesMenu();
        $GLOBALS['amount_of_posts'] = $getModel->getAmountOfPosts();
        $GLOBALS['showcomments'] = $getModel->getSidebarComments();
        $GLOBALS['amount_of_comments'] = $getModel->getAmountOfComments();
        // global $amount_of_posts;
        $GLOBALS['getarchives'] = $getModel->getArchives();



        if ($getModel->checkIfInstalled() != 0 AND file_exists("_install/")) {
            // print "<script>window.alert('Kérlek töröld az _install mappát!');</script>";
            print "Kérlek töröld az _install mappát.";
        } elseif ($getModel->checkIfInstalled() == 0) {
            header("location: _install");
        }
    }

    /*
      public function showPages()
      {
      $getModel = $this->loadModel('getModel');
      $GLOBALS['showpages'] = $getModel->getPagesMenu();
      }
      public function showAmountOfPosts()
      {
      $getModel = $this->loadModel('getModel');
      $GLOBALS['amount_of_posts'] = $getModel->getAmountOfPosts();

      } */
}
