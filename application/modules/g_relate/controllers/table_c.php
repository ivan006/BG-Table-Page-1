<?php
class Table_c extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		// $this->load->model('trip');
		// $this->load->library('../modules/trips/controllers/g_tbls');
		$this->load->library('g_tbls');
	}

	public function index($g_tbls_table)
	{
		$data["rows"]["all"] = $this->g_tbls->table_rows($g_tbls_table);
		$data["rows"]["visible"] = array();
		foreach ($data["rows"]["all"] as $key => $value) {
			// if (!$this->g_migrate->endsWith($join_merge_key, "_children") && $parent_name["foreign_singular"]."_id" !== $join_merge_key) {
			if (!$this->g_migrate->endsWith($key, "_children")) {
				$data["rows"]["visible"][$key] = $value;
			}
		}
		$data["overview"]["foreign_plural"] = $g_tbls_table;
		$data["overview"]["foreign_singular"] = $this->g_migrate->grammar_singular($data["overview"]["foreign_plural"]);
		$data["overview"]["rel_name"] = $data["overview"]["foreign_singular"];
		$data["data_endpoint"] = $g_tbls_table."/fetch";
		$data['title'] = $g_tbls_table;
		$this->load->view('table_header_v', $data);
		$this->load->view('table_block_v', $data);
		$this->load->view('table_footer_v');

	}

	public function insert($g_tbls_table)
	{
		$result = $this->g_tbls->insert($g_tbls_table);
		header('Content-Type: application/json');
		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	public function fetch($g_tbls_table)
	{
		$result = $this->g_tbls->fetch($g_tbls_table);
		header('Content-Type: application/json');
		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	public function fetch_where($table, $haystack, $needle)
	{
		$result = $this->g_tbls->fetch_where($table, $haystack, $needle);
		header('Content-Type: application/json');
		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	public function fetch_join_where($table_1, $table_2, $haystack, $needle)
	{
		$result = $this->g_tbls->fetch_join_where($table_1, $table_2, $haystack, $needle);
		header('Content-Type: application/json');
		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	public function delete($g_tbls_table)
	{
		$result = $this->g_tbls->delete($g_tbls_table);
		header('Content-Type: application/json');
		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	public function edit($g_tbls_table)
	{
		$result = $this->g_tbls->edit($g_tbls_table);
		header('Content-Type: application/json');
		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	public function update($g_tbls_table)
	{
		$result = $this->g_tbls->update($g_tbls_table);
		header('Content-Type: application/json');
		echo json_encode($result, JSON_PRETTY_PRINT);
	}
}
