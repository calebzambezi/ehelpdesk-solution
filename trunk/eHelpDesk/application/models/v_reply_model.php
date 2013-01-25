<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  V_reply_model extends MY_Model {
	
	function __construct() {
	
		parent::__construct();
		
	}
	
	//Why Overriding read_with_pagin? Because we do not want to reveal sort order in URL. Replies will always be sorted in ASC order; no choice is given to the user.
	public function read_with_pagin($column_names = '*', $pagin_page, $per_page = 10, $num_links = 7, $offset_value, $offset_loc = 3, $where_section = NULL, $sort_order, $sort_by = 'date_created', $query_str = NULL) 
	{
		$sort_order = ($sort_order == 'asc' || $sort_order == 'desc') ? $sort_order : 'desc'; //validate selected sort. desc is the default
		if($offset_value < 0) $offset_value = 0;

		$config['base_url'] = base_url().$pagin_page; //*** I removed the sort order: base_url().$pagin_page."/$sort_order";
		$config['uri_segment'] = $offset_loc;
		$config['total_rows'] = ($where_section) ?  $this->db->where($where_section)->get($this->_table)->num_rows() : $this->db->get($this->_table)->num_rows();
		$config['per_page'] = $per_page;
		$config['num_links'] = $num_links;
		$config['use_page_numbers'] = FALSE; //Having this to TRUE returns inconsistent records as you paginate: some records in previous records get fetched again in the next page; thus, note that CI pagination doesn't work well with TRUE. It worked fine in previous projects, up to tictalk, but since i updated CI system folder, the TRUE doesn't work as it should. So keep it FALSE. Otherwise, just use your own pagination helper function side_pagin() or so.
				
		$this->pagination->initialize($config);

		if($query_str == NULL)
			$arr['pag_links'] = $this->pagination->create_links();
		else
			$arr['pag_links'] = $this->pagination->create_links($query_str); //tack query string at the end of each href. Didn't tack after $config['base_url'] because offset number will always appear after the query string as: example.com/controller/method/desc?a=1&b=none/30. 30 is the offset, i had to tweak pagination library little bit to place query string at the far end in all cases. Review MY_Pagination.php
			
		$arr['rows'] = ($where_section) ? $this->db->select($column_names)->where($where_section)->order_by($sort_by, $sort_order)->get($this->_table, $config['per_page'], $offset_value)->result() : $this->db->select($column_names)->order_by($sort_by, $sort_order)->get($this->_table, $config['per_page'], $offset_value)->result();
		$arr['count'] = $config['total_rows'];

		return $arr;
	}
}
