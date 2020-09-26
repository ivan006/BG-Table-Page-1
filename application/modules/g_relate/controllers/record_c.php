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
				$data['children'][$value] = $relation_table;
			}
		}

		$data['parents'] = array();
		foreach ($data['rows'] as $key => $value) {
			if ($this->g_migrate->endsWith($value, "_id" )) {
				$value_singular = substr($value, 0, -3);
				$relation_table = $this->g_migrate->grammar_plural($value_singular);
				$data['parents'][$value] = $relation_table;
			}
		}


		$this->load->view('table_header_v', $data);

		$data["table_type"] = "overview";
		$haystack = "id";
		$data["table_fetch"] = "fetch_where/h/$haystack/n/$record_id";
		$this->load->view('table_block_v', $data);

		foreach ($data['children'] as $key => $value) {

			$data['rows'] = $this->g_tbls->table_rows($value);
			$data['table'] = $value;
			$data["table_type"] = $key;
			$haystack = $table_singular."_id";
			$data["table_fetch"] = "fetch_where/h/$haystack/n/$record_id";
			$this->load->view('table_block_v', $data);
		}

		foreach ($data['parents'] as $key => $value) {

			$data['rows'] = $this->g_tbls->table_rows($value);

			$haystack = "id";
			$overview = $this->g_tbls->fetch_where($table, $haystack, $record_id)["posts"][0];
			$parent_id = $overview->$key;
			$data['table'] = $value;
			// $data["table_type"] = $key;

			$table_singular = $this->g_migrate->grammar_singular($value);
			$data["table_type"] = $table_singular."_parent";

			$haystack = "id";
			$data["table_fetch"] = "fetch_where/h/$haystack/n/$parent_id";
			$this->load->view('table_block_v', $data);
		}

		$this->load->view('table_footer_v');

	}


}
