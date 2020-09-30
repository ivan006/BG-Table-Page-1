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

		$body = array();
		$body["overview"]["name"]["plural"] = $table;
		$body["overview"]["name"]["singular"] = $overview_table_singular;

		$haystack = "id";
		$needle = $record_id;
		$body["overview"]["data"] = array(
			"data_endpoint" => "fetch_where/h/$haystack/n/$needle",
			"relation_name" => "overview",
			"rows" => $this->g_tbls->table_rows($table),
		);


		$suffix = "_id";
		$body["parent"] = array();
		foreach ($body["overview"]["data"]["rows"] as $key => $value) {
			if ($this->g_migrate->endsWith($value, $suffix)) {
				$body["parent"][$key]["name"] = $this->foreign_table_guesser($value, $suffix);
			}
		}

		$children_groups = array();
		$suffix = "_children";
		foreach ($body["overview"]["data"]["rows"] as $key => $value) {
			if ($this->g_migrate->endsWith($value, $suffix)) {
				$children_groups[$key]["name"] = $this->foreign_table_guesser($value, $suffix);
			}
		}

		$body["dedicated_children"] = array();
		$body["shared_children"] = array();
		foreach ($children_groups as $key => $value) {
			if ($this->g_migrate->endsWith($value["name"]["plural"], "_links")) {
				$body["shared_children"][$key] = $value;
			} else {
				$body["dedicated_children"][$key] = $value;
			}
		}



		foreach ($body["shared_children"] as $key => $value) {


			$haystack = $body["overview"]["name"]["singular"]."_id";
			$needle = $record_id;
			$relation_name_suffix = "_shared_children";

			$body["shared_children"][$key]["data"] = array(
				"data_endpoint" => "fetch_where/h/$haystack/n/$needle",
				"relation_name" => $value["name"]["singular"].$relation_name_suffix,
				"rows" => $this->g_tbls->table_rows($value["name"]["plural"]),
			);

			$body["shared_children"][$key]["data"]["extra"] = array(
				"linking" => "",
				"lookup" => "",
				"join" => "fetch_join_where/t/whens/k/when_id/h/$haystack/n/$needle",
			);



			$body["shared_children"][$key]["data"]["rows"] = $this->g_tbls->table_rows($value["name"]["plural"]);

		}

		foreach ($body["dedicated_children"] as $key => $value) {

			$haystack = $body["overview"]["name"]["singular"]."_id";
			$needle = $record_id;
			$relation_name_suffix = "_dedicated_children";

			$body["dedicated_children"][$key]["data"] = array(
				"data_endpoint" => "fetch_where/h/$haystack/n/$needle",
				"relation_name" => $value["name"]["singular"].$relation_name_suffix,
				"rows" => $this->g_tbls->table_rows($value["name"]["plural"]),
			);
		}

		foreach ($body["parent"] as $key => $value) {

			$haystack = "id";
			$needle = $overview_record[$value["name"]["singular"]."_id"];
			$relation_name_suffix = "_parent";

			$body["parent"][$key]["data"] = array(
				"data_endpoint" => "fetch_where/h/$haystack/n/$needle",
				"relation_name" => $value["name"]["singular"].$relation_name_suffix,
				"rows" => $this->g_tbls->table_rows($value["name"]["plural"]),
			);
		}

		// header('Content-Type: application/json');
		// echo json_encode($body, JSON_PRETTY_PRINT);
		// exit;


		$this->load->view('table_header_v', $header);
		$this->load->view('table_block_v', $body["overview"]);

		foreach ($body["dedicated_children"] as $key => $value) {
			$this->load->view('table_block_v', $value);
		}
		foreach ($body["shared_children"] as $key => $value) {
			$this->load->view('table_block_v', $value);
		}
		foreach ($body["parent"] as $key => $value) {
			$this->load->view('table_block_v', $value);
		}
		$this->load->view('table_footer_v');

	}

	public function foreign_table_guesser($value, $suffix)
	{

		$suffix_strlen = strlen($suffix);
		$value_singular = substr($value, 0, -$suffix_strlen);
		$relation_table = $this->g_migrate->grammar_plural($value_singular);
		$result["plural"] = $relation_table;
		$result["singular"] = $value_singular;
		return $result;

	}


}
