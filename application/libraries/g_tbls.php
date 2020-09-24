<?php
class G_tbls {

	function __construct()
	{
	}

  public function controller_insert()
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

  public function controller_fetch()
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

  public function controller_delete()
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

  public function controller_edit()
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

  public function controller_update()
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


  public function model_get_entries()
  {
    $query = $this->db->get('trips');
    // if (count( $query->result() ) > 0) {
    return $query->result();
    // }
  }

  public function model_insert_entry($data)
  {
    return $this->db->insert('trips', $data);
  }

  public function model_delete_entry($id){
    return $this->db->delete('trips', array('id' => $id));
  }

  public function model_edit_entry($id){
    $this->db->select("*");
    $this->db->from("trips");
    $this->db->where("id", $id);
    $query = $this->db->get();
    if (count($query->result()) > 0) {
      return $query->row();
    }
  }

  public function model_update_entry($data)
  {
    return $this->db->update('trips', $data, array('id' => $data['id']));
  }

}
