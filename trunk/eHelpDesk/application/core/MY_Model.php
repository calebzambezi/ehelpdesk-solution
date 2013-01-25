<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
	MY_Model contains all frequently used database functionalities.
*/

class MY_Model extends CI_Model {

	protected $_table;
	
	public function __construct() 
	{
		parent::__construct();
		$this->_table = strtolower(str_replace('_model', '', get_class($this)));
	}
	
	/*
	 * @About: insert a single record into a table.
	 * @Params: $values: is an array that carries the values to be inserted.
	 * @Returns: *Success: returns the id of newly inserted record.
	 *			 *Failed: returns false.
	 *
	 ********************SAMPLE************************
	 *	@Note: the snippet below is implemented within a controller inside a method e.g. add()

	   $user_input = array(
			'columnName1' => 1243,
			'columnName2' => 'string value'
		);
		
		$data['insertID'] = $this->anyname_model->create($user_input);
		if($data['insertID']) {
			//do something
		} else {
			//show error
		}
	 *
	 *
	 *
	 *
	 **************************************************
	*/
	public function create($values) 
	{
		$values['date_created'] = $values['date_updated'] = date('Y-m-d H:i:s');
		$this->db->insert($this->_table, $values);
		return (($this->db->affected_rows() > 0) ? $this->db->insert_id() : FALSE);
	}

	/*
	 * @About: delete one or more records.
	 * @Params: $column_name: the column to be used in WHERE clause
	 *			$column_values: array of values that determines the records to be deleted
	 * @Returns: *Success: returns affected row
	 *			 *Failed: returns false
	 *
	 ********************SAMPLE************************
	 *	@Note: the snippet below is implemented within the controller inside a function e.g. remove()
	 
		//we need to delete records that has the id mentioned in the array
		$values = array('4444', '335', '350'); 
	
		$data['affected_rows'] = $this->anyname_model->delete('columname', $values);
		if($data['affected_rows'])
			//do something
		else
			//show the error message
	 *
	 *
	 *
	 *
	 **************************************************
	*/
	public function delete($column_name, $column_values)
	{
		$this->db->where_in($column_name, $column_values)->delete($this->_table);
		return (($this->db->affected_rows() > 0) ? $this->db->affected_rows() : FALSE);
	}
	
	/*
	 * @About: update single record.
	 * @Params: $where: holds a string of where clause
	 *			$new_values: this is an array contains the new values to replace the old values; represents SET section
	 * @Returns: *Success: returns affected row
	 *			 *Failed: returns false
	 *
	 ********************SAMPLE************************
	 *	@Note: the snippet below is implemented within the controller inside a function e.g. edit()

		$updatedValues = array(
			'colName1' => 'the new value',
			'colName2' => 'the new value'
		);
		
		$data['affected_rows'] = $this->site1_model->update('primarykey =349', $updatedValues);
		if($data['affected_rows'])
			//do something
		else
			//error message
	 *
	 *
	 *
	 *
	 **************************************************
	*/
	public function update($where, $new_values)
	{
		$new_values['date_updated'] = date('Y-m-d H:i:s');
		$this->db->where($where)->update($this->_table, $new_values);
		return (($this->db->affected_rows() > 0) ? $this->db->affected_rows() : FALSE);	
	}
	
	/*
	 * @About: update single record by joining tables
	 * @Params: $joined_tables: all tables you need to join
	 *			$where: string of where clause
	 *			$new_values: this is an array contains the new values to replace the old values; represents SET section
	 * @Returns: *Success: returns affected row
	 *			 *Failed: returns false
	 *
	 ********************SAMPLE************************
	 *	@Note: the snippet below is implemented within the controller inside a function e.g. edit()

		$joined_tables = 'post INNER JOIN post_institution ON post.post_id = post_institution.post_id';
		$where = "post.post_id = $post_id AND is_active = 1 AND user_id = ".$this->tank_auth->get_user_id();
		$new_vals = array('image_original' => $post_image_original, 'image_thumb' => $post_image_thumb);
		$this->post_model->update_join($joined_tables, $where, $new_vals);
	 *
	 *
	 *
	 *
	 **************************************************
	*/
	public function update_join($joined_tables, $where, $new_values)
	{
		$new_values['date_updated'] = date('Y-m-d H:i:s');
		$this->db->where($where)->update($joined_tables, $new_values);
		return (($this->db->affected_rows() > 0) ? $this->db->affected_rows() : FALSE);	
	}
	
	/*
	 * @About: read records from a single table
	 * @Params: $whereSection: represents the filter section. Optional parameter
	 *			$column_name: string of column names to be put in SELECT
	 * @Returns: *Success: returns records with the count value
	 *			 *Failed: returns false
	 *
	 ********************SAMPLE************************
	 *	@Note: the snippet below is implemented within the controller inside a function e.g. get()
	 
		$whereSec = "name='Joe' AND status='boss' OR status='active'";
		
		$data['records'] = $this->anyname_model->read('customer_id, customer_name', $whereSec);
		
		if($data['records'])
			//do someting
		else
			//error message
	 *
	 *
	 *
	 *
	 **************************************************
	*/
	public function read($column_names = '*', $where_section = NULL) 
	{
		if($where_section)
			$this->db->where($where_section);
			
		$query = $this->db->select($column_names)->get($this->_table);
	
		if($query->num_rows()) 
		{
			$records['rows'] = $query->result();
			$records['count'] = $query->num_rows();
			return $records;	
		}

		return FALSE;
	}

	/*
	 * @About: read records by joining tables
	 * @Params: $join_section: an array contain the linking tables along with common fields
	 *			$column_names: a string of column names to be put on SELECT 
	 *			$where_section: represents the filter section
	 * @Returns: *Success: returns records with the count value
	 *			 *Failed: returns false
	 *
	 ********************SAMPLE************************
	 *	@Note: the snippet below is implemented within a controller inside a function e.g. get_join()
	 
		$selectCols = 'customer.first_name, address.address';
		$joinSec = array (
			'store' => 'store.store_id = customer.store_id',
			'address' => 'address.address_id = customer.address_id'
		);
		
		$whereSec = "name='Joe' AND status='boss' OR status='active'";
		
		$data['records'] = $this->anyname_model->read_join($selectCols, $joinSec, $whereSec);
		if($data['records'])
			//do something
		else
			//print the error message
	 *
	 *
	 *
	 *
	 **************************************************
	*/
	public function read_join($column_names, $join_section, $where_section = NULL) 
	{
		$this->db->select($column_names)->from($this->_table);
		
		foreach ($join_section as $linking_table => $linking_columns)
			$this->db->join($linking_table, $linking_columns);

		if($where_section)
			$this->db->where($where_section);
	
		$query = $this->db->get();
		
		if($query->num_rows()) 
		{
			$arr['rows'] = $query->result();	
			$arr['count'] = $query->num_rows();
			return $arr;	
		}
		
		return FALSE;
	}
	
	/*
	 * @About: read records and associate pagination with the records
	 * @Params: $column_names: allows you to set specific columns - optional
	 *			$pagin_page: the page that pagination links exist e.g. home/products
	 *			$per_page: records per page 
	 *			$num_links: number of links before and after the currently chosen page/link.
	 *			$offset_value: which portion of records we are showoing; the number of page we're in; grab the offset value home/display/1 -> value is one. We target the actual url, not the routed one.
	 *			$offset_loc: location of offset value, the pagination number. By default is in 3rd location home/display/(1) -> location three. 
	*						CRUCIAL NOTE: offset_loc is an exceptional; it must have page number location of the currently displayed URL regardless whether URL, if routed url is http://example.com/desc/5, then offset_loc should be 2
	 *			$where_section: where clause
	 *			$sort_order: type of sort, is it desc or asc.
	 *			$sort_by: column to be sorted. By default, date_created
	 *			$query_str: takes query string i.e. ?a=1&b=hi&x=etc. In all cases, query string will be tacked at the end of the link
	 * @Returns: *Success: returns records with the pagination links along with count
	 *			 *Failed: returns empty array with count 0
	 *
	 ********************SAMPLE************************
	 *	@Note: the snippet below is implemented within a controller inside a function e.g. products_list()
	 *
		$data['paginated_records'] = $this->post_model->read_with_pagin('post_id, title, date_created', $this->_view, 3, 1, $this->uri->segment(4), 4, NULL, $this->uri->segment(3));
		$data['alternative_sort_order'] = ($this->uri->segment(3) == 'asc') ? 'desc' : 'asc';
		$data['maintain_page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : ''; 
		$this->load_view($data);
	 *
	 * IN VIEW, YOU CALL IT AS: foreach ($paginated_records['rows'] as $row) { .. $row->columnName .. }
	 * ALSO: echo $paginated_records['pag_links'];
	 * Regarding sort: the sort toggle looks like: anchor('controller/method/'."$alternative_sort_order/$maintain_page", 'SORT DATE');
	 **************************************************
	*/
	public function read_with_pagin($column_names = '*', $pagin_page, $per_page = 10, $num_links = 7, $offset_value, $offset_loc = 3, $where_section = NULL, $sort_order, $sort_by = 'date_created', $query_str = NULL) 
	{
		$sort_order = ($sort_order == 'asc' || $sort_order == 'desc') ? $sort_order : 'desc'; //validate selected sort. desc is the default
		if($offset_value < 0) $offset_value = 0;

		$config['base_url'] = base_url().$pagin_page."/$sort_order"; //as per how CI pagination is structured, sort order has to always come at the end (just before the page number)
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
	
	/*
	 * @About: read records and associate pagination with the records. Also, show the column to be sorted.
	 *
	 *			$sort_by: in here we'll not have single fixed column i.e. date_created. This parameter will have various column names
	 *					depending on what header is selected. We assume that we gave the user the chance to sort the table by choosing
	 *					various columns, once at a time e.g. user can sort the table by date created or date sold. $sort_by will hold the
	 *					actual column name i.e. date_created rather than the header name: Date Created. The checking whether a header name
	 *					a column name is done at the controller's level via: find_sort_column($selected_table_column); check general helper
	 *					functions for further info about find_sort_column
	 *
	 *			$selected_header: when user selects a header for sorting, the sort header is shown in URL segementation e.g. Date Created will show
	 *							 on URL segemenation as datec: ......com/datec/desc/5. At the application we grab the segmentation and check if it has
	 *							 something; if yes, pass the currently shown header. If no, just pass the default header: datec or whatever.
	 *
	 * @Returns: *Success: returns records with the pagination links along with count
	 *			 *Failed: returns empty array with count 0
	 *
	 ********************SAMPLE************************
	 *	@Note: the snippet below is implemented within a controller:

		$data['posts'] = $this->v_ticket_model->read_with_pagin_multi_order(....
					$this->_find_sort_column($this->uri->rsegment(3)), 
					($this->uri->rsegment(3)) ? $this->uri->rsegment(3) : 'dateop');
					
		since the user can change sorted header from URL, we call $this->_find_sort_column($this->uri->rsegment(3)) at every call
		to confirm user didn't enter random name. In case, he did, we'll return default sory by column i.e. date_created or so.
		
		($this->uri->rsegment(3)) ? $this->uri->rsegment(3) : 'dateop' represents sorted header name thats to be printed in URL. if URL doesn't have
		the segmenation yet, we are going to print the default header i.e. dateop or whatever. Otherwise, print the one shown in segmentation.
		Hence, since we are using route, only header columns specified in route will BE allowed; if header column name doesn't match the one in route,
		you are redirected to page 404. Therefore, i'm not much concerened on redirecting to 404 when header column is bogus because routes.php does the job; major concern to locate the right sort by using
		_find_sort_column as shown above for previous argument. In short, routes will check segement 3, if segement 3 value doesn't exist 
		in route, user is redirect in 404. Therefore, i checked if segement 3 exist, assign it to the variable blindly. Otherwise, if segement 3 
		is not in URL, just assign the default header name dateop or so; user won't have the chance to insert bogus header name (sort column) because route will redirect user to 404
	 
	 *
	 **************************************************
	*/
	public function read_with_pagin_multi_order($column_names = '*', $pagin_page, $per_page = 10, $num_links = 7, $offset_value, $offset_loc = 3, $where_section = NULL, $sort_order, $sort_by = 'date_created', $selected_header, $query_str = NULL) 
	{
		$sort_order = ($sort_order == 'asc' || $sort_order == 'desc') ? $sort_order : 'desc';
		if($offset_value < 0) $offset_value = 0;

		$config['base_url'] = base_url().$pagin_page."/$selected_header/$sort_order"; //******* THAT'S THE DIFFERENCE BETWEEN read_with_pagin_multi_order AND read_with_pagin. In read_with_pagin, i didn't show explicitly the column we are sorting because at all times sorting is dedicated to one column only e.g. date_created or so. Thus, sort column is handled implicitly witin the code and there is no point showing the sorted column.
		$config['uri_segment'] = $offset_loc;
		$config['total_rows'] = ($where_section) ? $this->db->where($where_section)->get($this->_table)->num_rows() : $this->db->get($this->_table)->num_rows();
		$config['per_page'] = $per_page;
		$config['num_links'] = $num_links;
		$config['use_page_numbers'] = FALSE; 
		
		$this->pagination->initialize($config);

		if($query_str == NULL)
			$arr['pag_links'] = $this->pagination->create_links();
		else
			$arr['pag_links'] = $this->pagination->create_links($query_str);
			
		$arr['rows'] = ($where_section) ? $this->db->select($column_names)->where($where_section)->order_by($sort_by, $sort_order)->get($this->_table, $config['per_page'], $offset_value)->result() : $this->db->select($column_names)->order_by($sort_by, $sort_order)->get($this->_table, $config['per_page'], $offset_value)->result();
		$arr['count'] = $config['total_rows'];

		return $arr;
	}
	
	/*
	 * @About: read joined records and associate pagination with the records
	 * @Params: $column_names: allows you to set specific columns - optional
	 *			$pagin_page: the page that pagination links exist e.g. home/products
	 *			$per_page: records per page 
	 *			$num_links: number of links before and after the currently chosen page/link.
	 *			$offset: which portion of records we are showoing; the number of page we're in; grab the offset value home/display/1 -> value is one
	 *			$offset_loc: location of offset value, the pagination number. By default is in 3rd location home/display/(1) -> location three
	 *			$where_section: where clause
	 *			$sort_order: type of sort, is it desc or asc.
	 *			$sort_by: column to be sorted. Not optional, provide the column including its table name when necessary
	 * @Returns: *Success: returns records with the pagination links along with count
	 *			 *Failed: returns empty array with count 0
	 *
	 ********************SAMPLE************************
	 *	@Note: the snippet below is implemented within a controller inside a function e.g. products_list()
	 *
		$join_section = array (
			'post' => 'post_institution.post_id = post.post_id',
			'institution' => 'post_institution.institution_id = institution.institution_id'
		);	

		$data['posts'] = $this->post_institution_model->read_join_with_pagin('institution_name, image_thumb, title, date_raised', $join_section, $this->_view, 2, 2, $this->uri->segment(4), 4, 'post.post_id = 1', $this->uri->segment(3), 'image_thumb');
		$data['alternative_sort_order'] = ($this->uri->segment(3) == 'asc') ? 'desc' : 'asc';
		$data['maintain_page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : '';
		$this->load_view($data);
	*
	* IN VIEW, YOU CALL IT AS: foreach ($posts['rows'] as $row) { .. $row->columnName .. }
	* ALSO: echo $posts['pag_links'];
	* Regarding sort: the sort toggle looks like: anchor('controller/method/'."$alternative_sort_order/$maintain_page", 'SORT IMAGE THUMB');	
	*
	***************************************************
	*/
	public function read_join_with_pagin($column_names = '*', $join_section, $pagin_page, $per_page = 10, $num_links = 7, $offset, $offset_loc = 3, $where_section = NULL, $sort_order, $sort_by)
	{
		//I had to go manual join specifically for counting records and assign it to $config['num_rows']. For some reason,
		//$this->db->get()->num_rows() did not work. I have two get() in this implementation; i had to remove one of them
		//for the impelentation to work. Therefore, i decided to count records manually and keep the other get(). manual_where
		//to be attached to the manual count(*) query.
		$query = '';
		$manual_join = '';
		$manual_where = ($where_section) ? 'WHERE '.$where_section : '';
		
		$sort_order = ($sort_order == 'asc' || $sort_order == 'desc') ? $sort_order : 'desc'; //validate sort type
		
		foreach ($join_section as $linking_table => $linking_columns)
		{
			$query = $this->db->join($linking_table, $linking_columns);
			$manual_join .= ' INNER JOIN '.$linking_table.' ON '.$linking_columns;
		}
		
		if($where_section)
			$query->where($where_section);

		$temp_array = $this->db->query('SELECT count(*) AS total_count FROM '.$this->_table."$manual_join $manual_where")->result();

		if($offset < 0) $offset = 0;
		
		$config['base_url'] = base_url().$pagin_page."/$sort_order";
		$config['total_rows'] = $temp_array[0]->total_count; 
		$config['uri_segment'] = $offset_loc;
		$config['per_page'] = $per_page;
		$config['num_links'] = $num_links;
		$config['use_page_numbers'] = FALSE;
		
		$this->pagination->initialize($config);
		
		$arr['pag_links'] = $this->pagination->create_links();
		$arr['rows'] = $query->select($column_names)->order_by($sort_by, $sort_order)->get($this->_table, $config['per_page'], $offset)->result();
		$arr['count'] = $config['total_rows'];
		
		return $arr;
	}
}