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
		$body["overview"]["plural"] = $table;
		$body["overview"]["singular"] = $overview_table_singular;

		$haystack = "id";
		$needle = $record_id;
		$body["overview"]["data_endpoint"] = "fetch_where/h/$haystack/n/$needle";
		$body["overview"]["relation"] = "overview";
		$body["overview"]["rows"] = $this->g_tbls->table_rows($table);


		$suffix = "_id";
		$body["parent"] = array();
		foreach ($body["overview"]["rows"] as $key => $value) {
			if ($this->g_migrate->endsWith($key, $suffix)) {
				$body["parent"][$key]["singular"] = $this->suffix_remover($key, $suffix);
				$body["parent"][$key]["plural"] = $this->g_migrate->grammar_plural($body["parent"][$key]["singular"]);
			}
		}

		$children_groups = array();
		$suffix = "_children";
		foreach ($body["overview"]["rows"] as $key => $value) {
			if ($this->g_migrate->endsWith($key, $suffix)) {
				$children_groups[$key]["singular"] = $this->suffix_remover($key, $suffix);
				$children_groups[$key]["plural"] = $this->g_migrate->grammar_plural($children_groups[$key]["singular"]);
			}
		}

		$body["dedicated_children"] = array();
		$body["shared_children"] = array();
		foreach ($children_groups as $key => $value) {
			if ($this->g_migrate->endsWith($value["plural"], "_links")) {
				$body["shared_children"][$key] = $value;
			} else {
				$body["dedicated_children"][$key] = $value;
			}
		}



		foreach ($body["shared_children"] as $key => $value) {


			$haystack = $body["overview"]["singular"]."_id";
			$needle = $record_id;

			$body["shared_children"][$key]["data_endpoint"] = "fetch_where/h/$haystack/n/$needle";
			$body["shared_children"][$key]["relation"] = "shared_children";
			$body["shared_children"][$key]["rows"] = $this->g_tbls->table_rows($value["plural"]);

			$join_singular = $body["shared_children"][$key]["rows"];
			unset($join_singular["id"]);
			unset($join_singular[$body["overview"]["singular"]."_id"]);



			// header('Content-Type: application/json');
			// echo json_encode($join_singular, JSON_PRETTY_PRINT);
			// exit;

			$body["shared_children"][$key]["join"] = array(
				"linking" => "",
				"lookup" => "",
				"" => "fetch_join_where/t/whens/k/when_id/h/$haystack/n/$needle",
			);



			$body["shared_children"][$key]["rows"] = $this->g_tbls->table_rows($value["plural"]);

		}

		foreach ($body["dedicated_children"] as $key => $value) {

			$haystack = $body["overview"]["singular"]."_id";
			$needle = $record_id;

			$body["dedicated_children"][$key]["data_endpoint"] = "fetch_where/h/$haystack/n/$needle";
			$body["dedicated_children"][$key]["relation"] = "dedicated_children";
			$body["dedicated_children"][$key]["rows"] = $this->g_tbls->table_rows($value["plural"]);
		}

		foreach ($body["parent"] as $key => $value) {

			$haystack = "id";
			$needle = $overview_record[$value["singular"]."_id"];


			$body["parent"][$key]["data_endpoint"] = "fetch_where/h/$haystack/n/$needle";
			$body["parent"][$key]["relation"] = "parent";
			$body["parent"][$key]["rows"] = $this->g_tbls->table_rows($value["plural"]);
		}

		header('Content-Type: application/json');
		echo json_encode($body, JSON_PRETTY_PRINT);
		exit;


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


	public function suffix_remover($value, $suffix)
	{

		$suffix_strlen = strlen($suffix);
		$result = substr($value, 0, -$suffix_strlen);
		return $result;

	}


}
