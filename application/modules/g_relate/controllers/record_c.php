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
		$this->load->library('g_migrate');
	}

	public function index($table, $record_id)
	{
		$data['rows'] = $this->g_tbls->table_rows($table);
		$data['table'] = $table;
		$data["record_id"] = $record_id;
		$table_singular = $this->g_migrate->grammar_singular($table);
		$data['title'] = $table_singular." ".$record_id;

		$data['children'] = array();
		foreach ($data['rows'] as $key => $value) {
			if ($this->g_migrate->endsWith($value, "_children" )) {
				$value_singular = substr($value, 0, -9);
				$relation_table = $this->g_migrate->grammar_plural($value_singular);
				$data['children'][$key]['table'] = $relation_table;
				$data['children'][$key]['foreign_key'] = $value;
			}
		}

		// header('Content-Type: application/json');
		// echo json_encode($data['children']);
		// exit;

		$data['parents'] = array();
		foreach ($data['rows'] as $key => $value) {
			if ($this->g_migrate->endsWith($value, "_id" )) {
				$value_singular = substr($value, 0, -3);
				$relation_table = $this->g_migrate->grammar_plural($value_singular);
				$data['parents'][$key]['table'] = $relation_table;
				$data['parents'][$key]['foreign_key'] = $value;
			}
		}


		$this->load->view('table_header_v', $data);

		$data["table_type"] = "overview";
		$haystack = "id";
		$data["table_fetch"] = "fetch_where/h/$haystack/n/$record_id";
		$this->load->view('table_block_v', $data);

		foreach ($data['children'] as $key => $value) {

			$data['rows'] = $this->g_tbls->table_rows($value['table']);
			$data['table'] = $value['table'];
			$data["table_type"] = $value['foreign_key'];
			$haystack = $table_singular."_id";
			$data["table_fetch"] = "fetch_where/h/$haystack/n/$record_id";
			$this->load->view('table_block_v', $data);
		}

		foreach ($data['parents'] as $key => $value) {

			$data['rows'] = $this->g_tbls->table_rows($value['table']);

			$haystack = "id";
			$overview = $this->g_tbls->fetch_where($table, $haystack, $record_id)["posts"][0];
			$parent_id = $overview->$value['foreign_key'];
			$data['table'] = $value['table'];
			// $data["table_type"] = $value['foreign_key'];

			$table_singular = $this->g_migrate->grammar_singular($value['table']);
			$data["table_type"] = $table_singular."_parent";

			$haystack = "id";
			$data["table_fetch"] = "fetch_where/h/$haystack/n/$parent_id";
			$this->load->view('table_block_v', $data);
		}

		$this->load->view('table_footer_v');

	}


}
