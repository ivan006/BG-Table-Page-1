<?php
class Events_c extends MY_Controller
{

	public $g_tbls_table = "events";

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('trip');
		// $this->load->library('../modules/trips/controllers/g_tbls');
		$this->load->library('g_tbls');
	}

	public function index()
	{
		$data['rows'] = $this->g_tbls->table_rows($this->g_tbls_table);
		$data['table'] = $this->g_tbls_table;
		$this->load->view('trips_v', $data);

	}

	public function insert()
	{
		$result = $this->g_tbls->insert($this->g_tbls_table);
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function fetch()
	{
		$result = $this->g_tbls->fetch($this->g_tbls_table);
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function delete()
	{
		$result = $this->g_tbls->delete($this->g_tbls_table);
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function edit()
	{
		$result = $this->g_tbls->edit($this->g_tbls_table);
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function update()
	{
		$result = $this->g_tbls->update($this->g_tbls_table);
		header('Content-Type: application/json');
		echo json_encode($result);
	}
}
