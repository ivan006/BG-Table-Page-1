<?php
class Database_c extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('trip');
		$this->load->library('../modules/trips/controllers/g_tbls');
	}

	public function database()
	{
		$data['tables'] = $this->g_tbls->db_tables();
		// $data['table'] = $g_tbls_table;
		$this->load->view('table_list_v', $data);

	}
	
}
