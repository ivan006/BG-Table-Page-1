<?php
class G_tbls {

	function __construct()
	{
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
      if ($this->db->insert('trips', $ajax_data)) {
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
    // if ($posts = $this->db->get('trips')->result()) {
    // 	$data = array('responce' => 'success', 'posts' => $posts);
    // }else{
    // 	$data = array('responce' => 'error', 'message' => 'Failed to fetch data');
    // }
    $posts = $this->db->get('trips')->result();
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

    if ($this->db->delete('trips', array('id' => $del_id))) {
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

    $this->db->select("*");
    $this->db->from("trips");
    $this->db->where("id", $id);
    $query = $this->db->get();
    $post = null;
    if (count($query->result()) > 0) {
      $post = $query->row();
    }
    if ($post) {
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

      if ($this->db->update('trips', $data, array('id' => $data['id']))) {
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
