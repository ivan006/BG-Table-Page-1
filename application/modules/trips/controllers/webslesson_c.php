<?php
class Webslesson_c extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
	}


	function index()
	{
		// $this->load->view('header.php');
		$this->load->view('webslesson_v');
		// $this->load->view('footer.php');
	}

	function api(){
		$this->load->model("webslesson");
		$fetch_data = $this->webslesson->make_datatables();
		$data = array();
		foreach($fetch_data as $row)
		{
			$sub_array = array();
			// $sub_array[] = '<img src="'.base_url().'upload/'.$row->image.'" class="img-thumbnail" width="50" height="35" />';
			$sub_array[] = $row->event_children;
			$sub_array[] = $row->name;
			$sub_array[] = '<button type="button" name="update" id="'.$row->id.'" class="btn btn-warning btn-xs">Update</button>';
			$sub_array[] = '<button type="button" name="delete" id="'.$row->id.'" class="btn btn-danger btn-xs">Delete</button>';
			$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->webslesson->get_all_data(),
			"recordsFiltered" => $this->webslesson->get_filtered_data(),
			"data" => $data
		);
		header('Content-Type: application/json');
		echo json_encode($output);
	}

}
