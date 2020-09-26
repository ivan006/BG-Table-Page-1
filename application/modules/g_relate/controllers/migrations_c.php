
<?php
class Migrations_c extends MY_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->library('g_migrate');
	}

	function index()
	{
		$data["sql_two"] = $this->g_migrate->sql_two();
		$data["sql_three"] = $this->g_migrate->sql_three();
		$data["model_two"] = $this->g_migrate->model_two();


		// header('Content-Type: application/json');
		// echo json_encode($class);
		// exit;

		$this->load->view('migrations_v', $data);
	}

}
