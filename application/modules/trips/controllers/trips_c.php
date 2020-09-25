<?php
class Trips_c extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('trip');
		$this->load->library('../modules/trips/controllers/g_tbls');
	}

	public function index()
	{
		$this->load->view('trips_v');
	}

	public function insert()
	{
		$result = $this->g_tbls->insert();
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function fetch()
	{
		$result = $this->g_tbls->fetch();
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function delete()
	{
		$result = $this->g_tbls->delete();
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function edit()
	{
		$result = $this->g_tbls->edit();
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function update()
	{
		$result = $this->g_tbls->update();
		header('Content-Type: application/json');
		echo json_encode($result);
	}
}
