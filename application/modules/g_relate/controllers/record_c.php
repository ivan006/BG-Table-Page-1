<?php
class Record_c extends MY_Controller
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

	public function index($table, $record_id)
	{
		$data["data"]["table"] = $table;
		$data["data"]["record_id"] = $record_id;
		// header('Content-Type: application/json');
		// echo json_encode($data);
		// exit;
		$this->load->view('record_v', $data);

	}


}
