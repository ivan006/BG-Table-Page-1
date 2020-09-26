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

		foreach ($data['rows'] as $key => $value) {
			if ($this->g_migrate->endsWith($value, "_children" )) {
				$value_singular = substr($value, 0, -9);
				$value_plural = $this->g_migrate->grammar_plural($value_singular);
				$data['children'][$value] = $value_plural;
			}
		}


		$this->load->view('table_header_v', $data);

		$data["table_type"] = "overview";
		$haystack = "id";
		$data["table_fetch"] = "$table/fetch_where/h/$haystack/n/$record_id";
		$this->load->view('table_block_v', $data);

		foreach ($data['children'] as $key => $value) {

			$data['rows'] = $this->g_tbls->table_rows($value);
			$data["table_type"] = $key;
			$haystack = $table_singular."_id";
			$data["table_fetch"] = $value."/fetch_where/h/$haystack/n/$record_id";
			$this->load->view('table_block_v', $data);
		}

		$this->load->view('table_footer_v');

	}


}
