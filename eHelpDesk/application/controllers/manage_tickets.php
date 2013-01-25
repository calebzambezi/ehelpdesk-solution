<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_tickets extends Secured_Backend_Controller {

	function __construct() 
	{
		parent::__construct();
	}

	public function index()
	{	
		if($this->input->post('search_submit'))
		{
			//maintain user search results
			$this->session->set_userdata('searched_text', $this->input->post('search_txt', TRUE));

			//prepare the query string ?s=### before redirecting
			$search_txt = $this->input->post('search_txt', TRUE) != '' ? '?s='.$this->input->post('search_txt', TRUE) : '';

			redirect(current_url().strtolower($search_txt)); 
		}

		if(get_query_string() != '')
		{
			$column_names = 'ticket_id, username, title, priority_name, category_name, status_name, date_created, date_closed, 
							(SELECT MAX(date_created) FROM reply WHERE reply.ticket_id = v_ticket.ticket_id) AS latest_reply,
							is_ticket_active,
							(SELECT distinct users_id FROM reply WHERE users_id = '.$this->tank_auth->get_user_id().' AND reply.ticket_id = v_ticket.ticket_id) AS is_replied';
			$pagin_page = "manage-tickets";
			$recs_per_page = 25;
			$num_of_pagin_links = 3;
			$current_page_value = $this->uri->rsegment(5); //the location of page number in the real URL, non-routed
			$loc_of_page_val = 4; //where is it located in the shown routed, in our case, URL
			$where = 'concat(LOWER(title), LOWER(message), LOWER(username), ticket_id) LIKE LOWER("%'.$this->input->get('s', TRUE).'%")';
			$sort_order =  $this->uri->rsegment(4);
			$header_name = ($this->uri->rsegment(3)) ? $this->uri->rsegment(3) : 'title'; //header to be sorted. If user types random header name manually, 404 shows up because of the custom routes in routes.php
			$sort_by = $this->_find_sort_column($header_name); //finds the acutal column that is equivelant to the header name to be sorted.
			$query_string = get_query_string();
			$data['posts'] = $this->v_ticket_model->read_with_pagin_multi_order($column_names, 
																				$pagin_page, $recs_per_page, 
																				$num_of_pagin_links, 
																				$current_page_value, 
																				$loc_of_page_val, 
																				$where, 
																				$sort_order, 
																				$sort_by, 
																				$header_name, 
																				$query_string);
		}
		else
		{
			//In this case use, no query string is provided which user probably clicked home button, so no need to maintain user search values in search fields and return all active posts, no further filteration is needed
			$this->session->unset_userdata('searched_text');
			
			$column_names = 'ticket_id, username, title, priority_name, category_name, status_name, date_created, date_closed, 
							(SELECT MAX(date_created) FROM reply WHERE reply.ticket_id = v_ticket.ticket_id) AS latest_reply,
							is_ticket_active,
							(SELECT distinct users_id FROM reply WHERE users_id = '.$this->tank_auth->get_user_id().' AND reply.ticket_id = v_ticket.ticket_id) AS is_replied';
			$pagin_page = 'manage-tickets';
			$recs_per_page = 25;
			$num_of_pagin_links = 3;
			$current_page_value = $this->uri->rsegment(5);
			$loc_of_page_val = 4; 
			$where = NULL;
			$sort_order =  $this->uri->rsegment(4);
			$header_name = ($this->uri->rsegment(3)) ? $this->uri->rsegment(3) : 'title'; 
			$sort_by = $this->_find_sort_column($header_name);
			$data['posts'] = $this->v_ticket_model->read_with_pagin_multi_order($column_names, 
																				$pagin_page, 
																				$recs_per_page, 
																				$num_of_pagin_links, 
																				$current_page_value, 
																				$loc_of_page_val, 
																				$where, 
																				$sort_order, 
																				$sort_by, 
																				$header_name);
		}
		
		$data['sort_by_dateop'] = 'dateop'; //represents date_created
		$data['sort_by_status'] = 'status'; //represents status
		$data['sort_by_datecl'] = 'datecl'; //represents date_closed
		$data['sort_by_act'] = 'act'; //represents is_ticket_active
		$data['sort_by_lreply'] = 'lreply'; //represents latest_reply
		$data['sort_by_title'] = 'title'; //represents "is_replied DESC, latest_reply"
		
		$data['sort_order'] = ($this->uri->rsegment(4) == 'asc') ? 'desc' : 'asc';
		$data['maintain_page_number'] = ($this->uri->rsegment(5)) ? $this->uri->rsegment(5) : '';
		$data['page_title'] = $this->lang->line('view_tickets_page_title');
		$this->load_view($data);
	}
	
	//grab the sorting header and check its column name equivelance. Return the equivelance. If
	//user types a bogus header name manually within the URL, routes.php will redirect user to 404.
	private function _find_sort_column($selected_table_column)
	{
		$sort_columns = array("date_created" => "dateop", "status_id" => "status", "date_closed" => "datecl", "latest_reply" => "lreply", "is_ticket_active" => "act", "is_replied DESC, latest_reply" => "title"); 
		$sort_by = array_search($selected_table_column, $sort_columns); //returns key i.e. status_id or date_created. If none, false is returned
		$key = (!$sort_by) ? "is_replied DESC, latest_reply" : $sort_by; //"is_replied DESC, latest_reply" default sort
		return $key; //status_id or date_created
	}
}

		
		
