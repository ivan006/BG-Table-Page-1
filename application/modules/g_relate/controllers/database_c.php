<?php
class Database_c extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		// $this->load->model('trip');
		// $this->load->library('../modules/trips/controllers/g_tbls');
		$this->load->library('g_tbls');
	}

	public function database()
	{
		$data['tables'] = $this->g_tbls->db_tables();




		$data["rows"]["visible"] = array("name"=>array());
		$data["name"]["table_id"] = "";
		$data["data_endpoint"] = "g_relate/database_api";
		$data['title'] = "Database";
		$this->load->view('table_header_v', $data);
		$this->load->view('table_block_readonly_v', $data);
		$this->load->view('table_footer_v');

	}

	public function database_api()
	{
		$data = $this->g_tbls->db_tables();
		header('Content-Type: application/json');
		echo json_encode($data, JSON_PRETTY_PRINT);

	}

}
