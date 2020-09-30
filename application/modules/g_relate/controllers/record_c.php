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

		$body["relationships"] = array();
		$body["relationships"]["overview"]["name"]["plural"] = $table;
		$body["relationships"]["overview"]["name"]["singular"] = $overview_table_singular;

		$haystack = "id";
		$needle = $record_id;
		$body["overview"]["data"] = array(
			"table_fetch" => "fetch_where/h/$haystack/n/$needle",
			"group_name" => "overview",
			"rows" => $this->g_tbls->table_rows($table),
			"table" => $table,
		);

		$children_groups = $this->relationships($body["overview"]["data"]["rows"], "_children");

		$body["relationships"]["parent_groups"] = $this->relationships($body["overview"]["data"]["rows"], "_id");
		$body["relationships"]["child_dedi_groups"] = array();
		$body["relationships"]["child_shared_groups"] = array();
		foreach ($children_groups as $key => $value) {
			if ($this->g_migrate->endsWith($value["name"]["plural"], "_links")) {
				$body["relationships"]["child_shared_groups"][] = $value;
			} else {
				$body["relationships"]["child_dedi_groups"][] = $value;
			}
		}



		// header('Content-Type: application/json');
		// echo json_encode($body, JSON_PRETTY_PRINT);
		// exit;
		foreach ($body["relationships"]["child_shared_groups"] as $key => $value) {

			$haystack = $overview_table_singular."_id";
			$needle = $record_id;
			$group_name_suffix = "_shared_children";


			$body["child_shared_groups"][$key]["data"]["linking"] = array(
				"rows" => $this->g_tbls->table_rows($value["name"]["plural"]),
				"table" => $value["name"]["plural"],
			);

			$body["child_shared_groups"][$key]["data"]["lookup"] = array(
				"rows" => $this->g_tbls->table_rows($value["name"]["plural"]),
				"table" => $value["name"]["plural"],
			);

			$body["child_shared_groups"][$key]["data"]["join"] = array(
				"rows" => "",
			);

			// $body["child_shared_groups"][$key]["data"]["linking"]["rows"];
			// $body["overview"]["name"]["plural"];

			// $body["relationships"]["overview"]["table_singular"];
			// $body["relationships"]["overview"]["name"]["plural"];
			$body["child_shared_groups"][$key]["data"]["table_fetch"] = "fetch_join_where/t/whens/k/when_id/h/$haystack/n/$needle";
			$body["child_shared_groups"][$key]["data"]["group_name"] = $value['table_singular'].$group_name_suffix;
		}

		foreach ($body["relationships"]["child_dedi_groups"] as $key => $value) {

			$haystack = $overview_table_singular."_id";
			$needle = $record_id;
			$group_name_suffix = "_dedicated_children";

			$body["child_dedi_groups"][]["data"] = array(
				"table_fetch" => "fetch_where/h/$haystack/n/$needle",
				"group_name" => $value['table_singular'].$group_name_suffix,
				"rows" => $this->g_tbls->table_rows($value["name"]["plural"]),
				"table" => $value["name"]["plural"],
			);
		}

		foreach ($body["relationships"]["parent_groups"] as $key => $value) {

			$haystack = "id";
			$needle = $overview_record[$value['foreign_key']];
			$group_name_suffix = "_parent";

			$body["parent_groups"][]["data"] = array(
				"table_fetch" => "fetch_where/h/$haystack/n/$needle",
				"group_name" => $value['table_singular'].$group_name_suffix,
				"rows" => $this->g_tbls->table_rows($value["name"]["plural"]),
				"table" => $value["name"]["plural"],
			);
		}

		header('Content-Type: application/json');
		echo json_encode($body, JSON_PRETTY_PRINT);
		exit;

		$this->load->view('table_header_v', $header);
		$this->load->view('table_block_v', $body["overview"]);

		foreach ($body["child_dedi_groups"] as $key => $value) {
			$this->load->view('table_block_v', $value);
		}
		foreach ($body["child_shared_groups"] as $key => $value) {
			$this->load->view('table_block_v', $value);
		}
		foreach ($body["parent_groups"] as $key => $value) {
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
				$result[$key]["name"]["plural"] = $relation_table;
				$result[$key]["name"]["singular"] = $value_singular;
			}
		}
		return $result;

	}


}
