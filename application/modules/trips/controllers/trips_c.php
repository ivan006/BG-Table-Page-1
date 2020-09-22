<?php
class Trips_c extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->load->view('trips_v');
	}

}
