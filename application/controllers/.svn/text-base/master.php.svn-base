<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('app_model');
	} 
	
	public function index() 
	{
		$data = array();
		$data['master'] = $this->app_model->get_master();
		
		$this->load->view('master', $data);
	}
	public function master_set() 
	{
		$num = stripslashes(trim($_POST['num']));
		$can = stripslashes(trim($_POST['can']));
        $result = $this->app_model->save_master($num, $can);
		echo $result; // must return a value.
	}
}





