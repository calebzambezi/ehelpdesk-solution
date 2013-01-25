<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ticket_model extends MY_Model {
	
	function __construct() {
	
		parent::__construct();
		
	}
	
	public function create($values) 
	{
		$values['date_created'] = date('Y-m-d H:i:s'); //I removed the date_updated section: $values['date_created'] = $values['date_updated'] = date('Y-m-d H:i:s');
		$this->db->insert($this->_table, $values);
		return (($this->db->affected_rows() > 0) ? $this->db->insert_id() : FALSE);
	}
	
	//called specifically when we update status: open/closed. In this case, we don't want to trigger date_upated. We are conerned about date_closed.
	//date_closed is set at the controller level rather than setting it here because we have to make sure date_closed is only set when user selects "Closed". If user selects status "Open" no update happens on date_updated nor date_closed.
	public function update_status($where, $new_values)
	{
		$this->db->where($where)->update($this->_table, $new_values);
		return (($this->db->affected_rows() > 0) ? $this->db->affected_rows() : FALSE);	
	}
}
