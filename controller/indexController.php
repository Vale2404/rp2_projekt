<?php 

class IndexController extends BaseController
{
	public function index() 
	{
		// Samo preusmjeri na books podstranicu.
		header('Location: ' . __SITE_URL . '/index.php?rt=books');
	}
}; 

?>