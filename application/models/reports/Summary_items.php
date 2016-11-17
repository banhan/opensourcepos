<?php
require_once("Summary_report.php");
class Summary_items extends Summary_report
{
	function __construct()
	{
		parent::__construct();
	}

	public function getDataColumns()
	{
		return array($this->lang->line('reports_item'), $this->lang->line('reports_quantity'), $this->lang->line('reports_subtotal'), $this->lang->line('reports_total'), $this->lang->line('reports_tax'), $this->lang->line('reports_cost'), $this->lang->line('reports_profit'));
	}
	
	public function getData(array $inputs)
	{
		$this->commonSelect($inputs);

		$this->db->select('
				items.name AS name,
				SUM(sales_items.quantity_purchased) AS quantity_purchased
		');

		$this->commonFrom();

		$this->db->join('items AS items', 'sales_items.item_id = items.item_id', 'inner');

		$this->commonWhere($inputs);

		$this->db->group_by('items.item_id');
		$this->db->order_by('items.name');

		return $this->db->get()->result_array();		
	}
}
?>