<?php

class Home extends Controller
{

    public function index()
    {
        require 'application/views/_templates/'.TEMPLATE.'/header.php';
		        $blog_model = $this->loadModel('blogmodel');
        $posts = $blog_model->getAllPosts();
        // require 'application/views/home/index.php';		
		require 'application/views/blog/index.php';
        require 'application/views/_templates/'.TEMPLATE.'/footer.php';
    }
/*
    public function jogiAkadaly()
    {
        require 'application/views/_templates/'.TEMPLATE.'/header.php';
        require 'application/views/home/jogiakadaly.php';
        require 'application/views/_templates/'.TEMPLATE.'/footer.php';
    }
    public function blabla()
    {
        require 'application/views/_templates/'.TEMPLATE.'/header.php';
        require 'application/views/home/blabla.php';
        require 'application/views/_templates/'.TEMPLATE.'/footer.php';
    }
    public function uj_tema()
    {
        require 'application/views/_templates/'.TEMPLATE.'/header.php';
        require 'application/views/home/blabla.php';
        require 'application/views/_templates/'.TEMPLATE.'/footer.php';
    }
    public function uj_tema_nyers()
    {
        require 'application/views/_templates/'.TEMPLATE.'/index.html';
        require 'application/views/home/blabla.php';
        require 'application/views/_templates/'.TEMPLATE.'/footer.php';
    }	
*/
}
