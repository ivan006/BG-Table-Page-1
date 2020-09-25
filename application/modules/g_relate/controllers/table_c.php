<?php
class Table_c extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('trip');
		$this->load->library('../modules/trips/controllers/g_tbls');
	}

	public function index($g_tbls_table)
	{
		$data['rows'] = $this->g_tbls->table_rows($g_tbls_table);
		$data['table'] = $g_tbls_table;
		$this->load->view('table_v', $data);

	}

	public function insert($g_tbls_table)
	{
		$result = $this->g_tbls->insert($g_tbls_table);
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function fetch($g_tbls_table)
	{
		$result = $this->g_tbls->fetch($g_tbls_table);
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function delete($g_tbls_table)
	{
		$result = $this->g_tbls->delete($g_tbls_table);
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function edit($g_tbls_table)
	{
		$result = $this->g_tbls->edit($g_tbls_table);
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function update($g_tbls_table)
	{
		$result = $this->g_tbls->update($g_tbls_table);
		header('Content-Type: application/json');
		echo json_encode($result);
	}
}
