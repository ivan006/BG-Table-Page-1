<?php
class Trips_c extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('trip');
		$this->load->library('g_tbls');

	}

	public function index()
	{
		$this->load->view('trips_v');
	}

	public function insert()
	{
		// if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('event_children', 'Event_children');
			if ($this->form_validation->run() == FALSE) {
				$data = array('responce' => 'error', 'message' => validation_errors());
			} else {
				$ajax_data = $this->input->post();
				if ($this->techontech->insert_entry($ajax_data)) {
					$data = array('responce' => 'success', 'message' => 'Record added Successfully');
				} else {
					$data = array('responce' => 'error', 'message' => 'Failed to add record');
				}
			}

			echo json_encode($data);
		// } else {
		// 	echo "No direct script access allowed";
		// }
	}

	public function fetch()
	{
		// if ($this->input->is_ajax_request()) {
			// if ($posts = $this->techontech->get_entries()) {
			// 	$data = array('responce' => 'success', 'posts' => $posts);
			// }else{
			// 	$data = array('responce' => 'error', 'message' => 'Failed to fetch data');
			// }
			$posts = $this->techontech->get_entries();
			$data = array('responce' => 'success', 'posts' => $posts);
			header('Content-Type: application/json');
			echo json_encode($data);
		// } else {
		// 	echo "No direct script access allowed";
		// }

	}

	public function delete()
	{
		// if ($this->input->is_ajax_request()) {
			$del_id = $this->input->post('del_id');

			if ($this->techontech->delete_entry($del_id)) {
				$data = array('responce' => 'success');
			} else {
				$data = array('responce' => 'error');
			}
			header('Content-Type: application/json');
			echo json_encode($data);
		// } else {
		// 	echo "No direct script access allowed";
		// }
	}

	public function edit()
	{
		// if ($this->input->is_ajax_request()) {
			$edit_id = $this->input->post('edit_id');

			if ($post = $this->techontech->edit_entry($edit_id)) {
				$data = array('responce' => 'success', 'post' => $post);
			} else {
				$data = array('responce' => 'error', 'message' => 'failed to fetch record');
			}
			header('Content-Type: application/json');
			echo json_encode($data);
		// } else {
		// 	echo "No direct script access allowed";
		// }
	}

	public function update()
	{
		// if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('edit_name', 'Name', 'required');
			$this->form_validation->set_rules('edit_event_children', 'Event_children');
			if ($this->form_validation->run() == FALSE) {
				$data = array('responce' => 'error', 'message' => validation_errors());
			} else {
				$data['id'] = $this->input->post('edit_record_id');
				$data['name'] = $this->input->post('edit_name');
				$data['event_children'] = $this->input->post('edit_event_children');

				if ($this->techontech->update_entry($data)) {
					$data = array('responce' => 'success', 'message' => 'Record update Successfully');
				} else {
					$data = array('responce' => 'error', 'message' => 'Failed to update record');
				}
			}
			header('Content-Type: application/json');
			echo json_encode($data);
		// } else {
		// 	echo "No direct script access allowed";
		// }
	}
}
