<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reply_model extends MY_Model {
	
	function __construct() {
	
		parent::__construct();
		
	}
	
	public function create($values) 
	{
		$values['date_created'] = date('Y-m-d H:i:s');
		$this->db->insert($this->_table, $values);
		return (($this->db->affected_rows() > 0) ? $this->db->insert_id() : FALSE);
	}
}
