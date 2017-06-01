<?php


class Pages extends Controller
{

	public function index()
	{
		require 'application/views/_templates/'.TEMPLATE.'/header.php';
		
        $blog_model = $this->loadModel('PagesModel');
        $posts = $blog_model->getAllPages();
		$postUrl = POSTURL;
		$onepage = $blog_model->getOnePage($postUrl);
		if(!empty($postUrl)){
			require 'application/views/pages/onepage.php';
		}else{
			require 'application/views/pages/index.php';
		}
        require 'application/views/_templates/'.TEMPLATE.'/footer.php';	
	}


}