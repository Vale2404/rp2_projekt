<?php 

class IndexController extends BaseController
{
	public function index() 
	{
		// Samo preusmjeri na search podstranicu.
		header('Location: ' . __SITE_URL . '/index.php?rt=search');
	}
}; 

?>