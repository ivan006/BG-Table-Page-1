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
		$overview_table_singular = $this->g_migrate->grammar_singular($table);
		$overview_record = $this->g_tbls->fetch_where($table, "id", $record_id)["posts"][0];


		$header["title"] = $overview_table_singular." ".$record_id;

		$haystack = "id";
		$needle = $record_id;
		$body["overview"] = array(
			"table_fetch" => "fetch_where/h/$haystack/n/$needle",
			"group_name" => "overview",
			"rows" => $this->g_tbls->table_rows($table),
			"table" => $table,
		);

		$children_groups = $this->relationships($body["overview"]["rows"], "_children");

		$body["overview"]["child_dedi_groups"] = array();
		$body["overview"]["child_shared_groups"] = array();
		foreach ($children_groups as $key => $value) {
			if ($this->g_migrate->endsWith($value["table"], "_links")) {
				$body["overview"]["child_shared_groups"][] = $value;
			} else {
				$body["overview"]["child_dedi_groups"][] = $value;
			}
		}
		$body["overview"]["parent_groups"] = $this->relationships($body["overview"]["rows"], "_id");



		$body["child_shared_groups"] = array();
		foreach ($body["overview"]["child_shared_groups"] as $key => $value) {

			$haystack = $overview_table_singular."_id";
			$needle = $record_id;
			$group_name_suffix = "_shared_children";

			$body["child_shared_groups"][] = array(
				"table_fetch" => "fetch_where/h/$haystack/n/$needle",
				"group_name" => $value['table_singular'].$group_name_suffix,
				"rows" => $this->g_tbls->table_rows($value['table']),
				"table" => $value['table'],
			);
		}
		// header('Content-Type: application/json');
		// echo json_encode($body["overview"]["child_shared_groups"], JSON_PRETTY_PRINT);
		// exit;

		$body["child_dedi_groups"] = array();
		foreach ($body["overview"]["child_dedi_groups"] as $key => $value) {

			$haystack = $overview_table_singular."_id";
			$needle = $record_id;
			$group_name_suffix = "_dedicated_children";

			$body["child_dedi_groups"][] = array(
				"table_fetch" => "fetch_where/h/$haystack/n/$needle",
				"group_name" => $value['table_singular'].$group_name_suffix,
				"rows" => $this->g_tbls->table_rows($value['table']),
				"table" => $value['table'],
			);
		}

		$body["parents"] = array();
		foreach ($body["overview"]["parent_groups"] as $key => $value) {

			$haystack = "id";
			$needle = $overview_record[$value['foreign_key']];
			$group_name_suffix = "_parent";

			$body["parents"][] = array(
				"table_fetch" => "fetch_where/h/$haystack/n/$needle",
				"group_name" => $value['table_singular'].$group_name_suffix,
				"rows" => $this->g_tbls->table_rows($value['table']),
				"table" => $value['table'],
			);
		}

		// header('Content-Type: application/json');
		// echo json_encode($body, JSON_PRETTY_PRINT);
		// exit;

		$this->load->view('table_header_v', $header);
		$this->load->view('table_block_v', $body["overview"]);

		foreach ($body["child_dedi_groups"] as $key => $value) {
			$this->load->view('table_block_v', $value);
		}
		foreach ($body["child_shared_groups"] as $key => $value) {
			$this->load->view('table_block_v', $value);
		}
		foreach ($body["parents"] as $key => $value) {
			$this->load->view('table_block_v', $value);
		}
		$this->load->view('table_footer_v');

	}

	public function relationships($rows, $suffix)
	{

		$result = array();
		foreach ($rows as $key => $value) {
			if ($this->g_migrate->endsWith($value, $suffix)) {
				$suffix_strlen = strlen($suffix);
				$value_singular = substr($value, 0, -$suffix_strlen);
				$relation_table = $this->g_migrate->grammar_plural($value_singular);
				$result[$key]['table'] = $relation_table;
				$result[$key]['table_singular'] = $value_singular;
				$result[$key]['foreign_key'] = $value;
			}
		}
		return $result;

	}


}
