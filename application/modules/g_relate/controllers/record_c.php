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
		$body["plural"] = $table;
		$body["singular"] = $overview_table_singular;

		$haystack = "id";
		$needle = $record_id;
		$body["data_endpoint"] = "fetch_where/h/$haystack/n/$needle";
		$body["relation"] = "overview";
		$body["rows"] = $this->g_tbls->table_rows($table);



		foreach ($body["rows"] as $key => $value) {

			$suffix = "_id";
			if ($this->g_migrate->endsWith($key, $suffix)) {
				$body["rows"][$key]["singular"] = $this->suffix_remover($key, $suffix);
				$body["rows"][$key]["plural"] = $this->g_migrate->grammar_plural($body["rows"][$key]["singular"]);


				$haystack = "id";
				$needle = $overview_record[$value["singular"]."_id"];


				$body["rows"][$key]["data_endpoint"] = "fetch_where/h/$haystack/n/$needle";
				$body["rows"][$key]["relation"] = "parent";
				$body["rows"][$key]["rows"] = $this->g_tbls->table_rows($value["plural"]);


			}
			$suffix = "_children";
			if ($this->g_migrate->endsWith($key, $suffix)) {

				$body["rows"][$key]["singular"] = $this->suffix_remover($key, $suffix);
				$body["rows"][$key]["plural"] = $this->g_migrate->grammar_plural($body["rows"][$key]["singular"]);

				if ($this->g_migrate->endsWith($body["rows"][$key]["plural"], "_links")) {


					$haystack = $body["singular"]."_id";
					$needle = $record_id;

					$body["rows"][$key]["data_endpoint"] = "fetch_where/h/$haystack/n/$needle";
					$body["rows"][$key]["relation"] = "shared_children";
					$body["rows"][$key]["rows"] = $this->g_tbls->table_rows($body["rows"][$key]["plural"]);

					$join_singular = $body["rows"][$key]["rows"];
					unset($join_singular["id"]);
					unset($join_singular[$body["singular"]."_id"]);



					// header('Content-Type: application/json');
					// echo json_encode($join_singular, JSON_PRETTY_PRINT);
					// exit;

					$body["rows"][$key]["join"] = array(
						"linking" => "",
						"lookup" => "",
						"" => "fetch_join_where/t/whens/k/when_id/h/$haystack/n/$needle",
					);



					$body["rows"][$key]["rows"] = $this->g_tbls->table_rows($body["rows"][$key]["plural"]);


				} else {

					$haystack = $body["singular"]."_id";
					$needle = $record_id;

					$body["rows"][$key]["data_endpoint"] = "fetch_where/h/$haystack/n/$needle";
					$body["rows"][$key]["relation"] = "dedicated_children";
					$body["rows"][$key]["rows"] = $this->g_tbls->table_rows($value["plural"]);
				}
			}
		}




		header('Content-Type: application/json');
		echo json_encode($body, JSON_PRETTY_PRINT);
		exit;


		$this->load->view('table_header_v', $header);
		$this->load->view('table_block_v', $body);

		foreach ($body["rows"] as $key => $value) {
			if (!empty($value)) {
				// code...
				$this->load->view('table_block_v', $value);
			}
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
