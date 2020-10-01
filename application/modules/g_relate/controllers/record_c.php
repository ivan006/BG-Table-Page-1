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


		$header["title"] = $overview_table_singular." ".$record_id;
		$body = array();
		$body["name"]["plural"] = $table;
		$body["name"]["singular"] = $overview_table_singular;
		$body["data"]["if_one_record"] = $this->g_tbls->fetch_where($body["name"]["plural"], "id", $record_id)["posts"][0];

		$haystack = "id";
		$needle = $record_id;
		$body["data"]["data_endpoint"] = "fetch_where/h/$haystack/n/$needle";
		$body["name"]["type"] = "overview";
		$dont_scan = "";

		$body["rows"] = $this->children($body["name"]["plural"], $body["name"]["singular"], $body["data"]["if_one_record"], $dont_scan);


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

	public function children($parent_plural, $parent_singular, $parent_record, $dont_scan)
	{
		$rows = $this->g_tbls->table_rows($parent_plural);
		foreach ($rows as $key => $value) {
			if ($key !== $dont_scan) {
				if ($this->g_migrate->endsWith($key, "_id")) {

					$suffix = "_id";
					$name["singular"] = $this->suffix_remover($key, $suffix);


					$name["plural"] = $this->g_migrate->grammar_plural($name["singular"]);

					if (!empty($parent_record)) {
						$haystack = "id";
						$needle = $parent_record[$name["singular"]."_id"];
						$data["data_endpoint"] = "fetch_where/h/$haystack/n/$needle";

						// $data["if_one_record"] = $this->g_tbls->fetch_where($name["plural"], $haystack, $needle)["posts"][0];
					} else {
						$data = array();
					}


					$name["type"] = "parent";
					$sub_rows = $this->g_tbls->table_rows($name["plural"]);

					$rows[$key] = array(
						"name" => $name,
						"rows" => $sub_rows,
						"data" => $data,
					);


				} elseif ($this->g_migrate->endsWith($key, "_children")) {

					$suffix = "_children";
					$name["singular"] = $this->suffix_remover($key, $suffix);

					$name["plural"] = $this->g_migrate->grammar_plural($name["singular"]);

					if ($this->g_migrate->endsWith($name["plural"], "_links")) {


						if (!empty($parent_record)) {
							$haystack = $parent_singular."_id";
							$needle = $parent_record["id"];
							$data["data_endpoint"] = "fetch_where/h/$haystack/n/$needle";

							// $data["if_one_record"] = array();
						} else {
							$data = array();
						}

						$name["type"] = "shared_children";
						$sub_rows = $this->g_tbls->table_rows($name["plural"]);

						// $sub_rows = array();
						$dont_scan = $parent_singular."_id";

						$sub_rows = $this->children($name["plural"], $name["singular"], array(), $dont_scan);



						$join_singular = $rows;
						unset($join_singular["id"]);
						unset($join_singular[$parent_singular."_id"]);
						// header('Content-Type: application/json');
						// echo json_encode($join_singular, JSON_PRETTY_PRINT);
						// exit;

						$join = array(
						"linking" => "",
						"lookup" => "",
						"" => "fetch_join_where/t/whens/k/when_id/h/$haystack/n/$needle",
						);


					} else {

						if (!empty($parent_record)) {
							$haystack = $parent_singular."_id";
							$needle = $record_id;

							$data["data_endpoint"] = "fetch_where/h/$haystack/n/$needle";
							// $data["if_one_record"] = array();
						} else {
							$data = array();
						}
						$name["type"] = "dedicated_children";
						$sub_rows = $this->g_tbls->table_rows($name["plural"]);
					}

					$rows[$key] = array(
					"name" => $name,
					"rows" => $sub_rows,
					"data" => $data,
					);

				}
			} else {
				$rows[$key] = array();
			}
		}

		return $rows;

	}


}
