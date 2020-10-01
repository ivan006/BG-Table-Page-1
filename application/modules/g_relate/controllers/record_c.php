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
		$body["plural"] = $table;
		$body["singular"] = $overview_table_singular;
		$body["record"] = $this->g_tbls->fetch_where($body["plural"], "id", $record_id)["posts"][0];

		$haystack = "id";
		$needle = $record_id;
		$body["data_endpoint"] = "fetch_where/h/$haystack/n/$needle";
		$body["relation"] = "overview";
		$dont_scan = "";

		$body["rows"] = $this->children($body["plural"], $body["singular"], $body["record"], $dont_scan);


		// header('Content-Type: application/json');
		// echo json_encode($body, JSON_PRETTY_PRINT);
		// exit;





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
					$singular = $this->suffix_remover($key, $suffix);


					$plural = $this->g_migrate->grammar_plural($singular);

					if (!empty($parent_record)) {
						$haystack = "id";
						$needle = $parent_record[$singular."_id"];
						$data_endpoint = "fetch_where/h/$haystack/n/$needle";

						$record = $this->g_tbls->fetch_where($plural, $haystack, $needle)["posts"][0];
					} else {
						$data_endpoint = "";

						$record = array();
					}


					$relation = "parent";
					$sub_rows = $this->g_tbls->table_rows($plural);

					$rows[$key] = array(
						"singular" => $singular,
						"plural" => $plural,
						"data_endpoint" => $data_endpoint,
						"relation" => $relation,
						"rows" => $sub_rows,
						"record" => $record,
					);


				} elseif ($this->g_migrate->endsWith($key, "_children")) {

					$suffix = "_children";
					$singular = $this->suffix_remover($key, $suffix);

					$plural = $this->g_migrate->grammar_plural($singular);

					if ($this->g_migrate->endsWith($plural, "_links")) {



						$haystack = $parent_singular."_id";
						$needle = $parent_record["id"];
						$data_endpoint = "fetch_where/h/$haystack/n/$needle";

						$record = array();

						$relation = "shared_children";
						$sub_rows = $this->g_tbls->table_rows($plural);

						// $sub_rows = array();
						$dont_scan = $parent_singular."_id";

						$sub_rows = $this->children($plural, $singular, $record, $dont_scan);



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

						$record = array();

						$haystack = $parent_singular."_id";
						$needle = $record_id;

						$data_endpoint = "fetch_where/h/$haystack/n/$needle";
						$relation = "dedicated_children";
						$sub_rows = $this->g_tbls->table_rows($plural);
					}

					$rows[$key] = array(
					"singular" => $singular,
					"plural" => $plural,
					"data_endpoint" => $data_endpoint,
					"relation" => $relation,
					"rows" => $sub_rows,
					"record" => $record,
					);

				}
			} else {
				$rows[$key] = array();
			}
		}

		return $rows;

	}


}
