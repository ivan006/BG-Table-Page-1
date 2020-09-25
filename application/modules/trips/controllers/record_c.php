<?php
class Record_c extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('trip');
		$this->load->library('../modules/trips/controllers/g_tbls');
	}

	public function index($table, $record_id)
	{
		$data['rows'] = $this->g_tbls->table_rows($g_tbls_table);
		$data['table'] = $g_tbls_table;
		$this->load->view('record_v', $data);

	}


}
