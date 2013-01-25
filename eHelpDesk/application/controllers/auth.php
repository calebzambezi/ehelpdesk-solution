<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('tank_auth');

		//***** SET A LANGUAGE (START) ******
		if($this->input->post('lang_submit'))
		{
			if(is_selected_lang_valid($this->input->post('language_lookup')) != FALSE)
			{
				if($this->input->post('language_lookup') == 'en')
				{
					$this->session->set_userdata('lang', 'english');
				}
				else
				{
					$this->session->set_userdata('lang', $this->input->post('language_lookup'));
				}
			}
			else
			{
				$this->session->set_userdata('lang', 'english');
			}
		}
		//***** SET A LANGUAGE (END) ******
		
		//load the language files after language is selected
		$this->lang->load('tank_auth', $this->session->userdata('lang')); //*** ADDED 2nd Parameter
		$this->lang->load('ehelpdesk', $this->session->userdata('lang')); //*** ADDED THIS
		$this->lang->load('form_validation', $this->session->userdata('lang')); //*** ADDED THIS
	}

	function index()
	{
		if ($message = $this->session->flashdata('message')) {
			//$this->load->view('auth/general_message', array('message' => $message));
			$data['message'] = $message;
			$this->_load_view($data);
		} else {
			redirect('login');
		}
	}

	/**
	 * Login user on the site
	 *
	 * @return void
	 */
	function login()
	{
		if ($this->tank_auth->is_logged_in()) {									// logged in
			redirect('view-tickets'); //*** ONCE LOGGED, choose which page you want go to? We usually land in '', home page (default controller) Since eHelpDesk default controller is the login page, we've to land to a different page

		} elseif ($this->tank_auth->is_logged_in(FALSE)) {
			// logged in, not activated
			//redirect('resend');
			set_temporary_msg($this->lang->line('auth_message_resend_activation_link').' '.anchor('logout', 'Logout'), 'resend'); //**** ADDED. The problem is the message does not show right away ater redirection. The user has to reaccess the page for the message to appear! don't know why. MOST PROBABLY, the problem is in part of tank_auth implementation because tank_auth has some old version Codeigniter snippets. 

		} else {
			$data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
					$this->config->item('use_username', 'tank_auth'));
			$data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

			$this->form_validation->set_rules('login', $this->lang->line('auth_login_btn_login'), 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', $this->lang->line('auth_login_lbl_password'), 'trim|required|xss_clean');
			$this->form_validation->set_rules('remember', $this->lang->line('auth_login_lbl_remember_me'), 'integer');

			// Get login for counting attempts to login
			if ($this->config->item('login_count_attempts', 'tank_auth') AND
					($login = $this->input->post('login'))) {
				$login = $this->security->xss_clean($login);
			} else {
				$login = '';
			}

			$data['use_recaptcha'] = $this->config->item('use_recaptcha', 'tank_auth');
			if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
				if ($data['use_recaptcha'])
					$this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
				else
					$this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
			}
			
			if($this->input->post('submit')) //*** ADDED THIS LINE: if($this->input->post('submit')) to make sure field validaton does not happen whenever language button is pressed. If you don't add the condition, the login form will be validated automatically as you press any submit button in the page.
			{
				$data['errors'] = array();

				if ($this->form_validation->run()) {								// validation ok
					if ($this->tank_auth->login(
							$this->form_validation->set_value('login'),
							$this->form_validation->set_value('password'),
							$this->form_validation->set_value('remember'),
							$data['login_by_username'],
							$data['login_by_email'])) {								// success
						redirect('view-tickets'); //**** EDITED target

					} else {
						$errors = $this->tank_auth->get_error_message();
						if (isset($errors['banned'])) {								// banned user
							set_temporary_msg($this->lang->line('auth_message_banned').' '.$errors['banned']);

						} elseif (isset($errors['not_activated'])) {				// not activated user
							set_temporary_msg($this->lang->line('auth_message_resend_activation_link').' '.anchor('logout', 'Logout'), 'resend');

						} else {													// fail
							foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
						}
					}
				}
			}
			
			$data['show_captcha'] = FALSE;
			if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
				$data['show_captcha'] = TRUE;
				if ($data['use_recaptcha']) {
					$data['recaptcha_html'] = $this->_create_recaptcha();
				} else {
					$data['captcha_html'] = $this->_create_captcha();
				}
			}
			
			//$this->load->view('auth/login_form', $data);
			$this->_load_view($data); //******* ADDED
		}
	}

	/**
	 * Logout user
	 *
	 * @return void
	 */
	function logout()
	{
		$this->tank_auth->logout();

		redirect(''); //in eHelpDesk login page is our staring page, its where we have to be as long as we are not logged in
		//set_temporary_msg($this->lang->line('auth_message_logged_out')); //ADDED, i chose my own set_temporary_msg for consistency. NOTE: the message "logged out succesully" does not show until you remove "$this->ci->session->sess_destroy();" from logout from tank_auth library; not fully sure why the problem occurs. HECNE, I ALREADY COMMENTED $this->ci->session->sess_destroy(), checkout library Tank_auth, logout() function. NOTE i commented this logout messsage because its unnecessary
	
	}

	/**
	 * Register user on the site
	 *
	 * @return void
	 */
	function register()
	{
		if ($this->tank_auth->is_logged_in()) {									// logged in
			redirect('');

		} elseif ($this->tank_auth->is_logged_in(FALSE)) {						// logged in, not activated
			set_temporary_msg($this->lang->line('auth_message_resend_activation_link').' '.anchor('logout', 'Logout'), 'resend');

		} elseif (!$this->config->item('allow_registration', 'tank_auth')) {	// registration is off
			set_temporary_msg($this->lang->line('auth_message_registration_disabled'));

		} else {
			$use_username = $this->config->item('use_username', 'tank_auth');
			if ($use_username) {
				$this->form_validation->set_rules('username', $this->lang->line('auth_register_lbl_username'), 'trim|required|xss_clean|min_length['.$this->config->item('username_min_length', 'tank_auth').']|max_length['.$this->config->item('username_max_length', 'tank_auth').']|alpha_dash');
			}
			$this->form_validation->set_rules('email', $this->lang->line('auth_register_lbl_username'), 'trim|required|xss_clean|valid_email');
			$this->form_validation->set_rules('password', $this->lang->line('auth_register_lbl_password'), 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
			$this->form_validation->set_rules('confirm_password', $this->lang->line('auth_register_lbl_confirm_password'), 'trim|required|xss_clean|matches[password]');

			$captcha_registration	= $this->config->item('captcha_registration', 'tank_auth');
			$use_recaptcha			= $this->config->item('use_recaptcha', 'tank_auth');
			if ($captcha_registration) {
				if ($use_recaptcha) {
					$this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
				} else {
					$this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
				}
			}
			
			if($this->input->post('register')) //*** ADDED THIS LINE: if($this->input->post('register'))
			{
				$data['errors'] = array();

				$email_activation = $this->config->item('email_activation', 'tank_auth');

				//***** ADDED
				$data['hsoub_captcha_error'] = '';
				if(validate_captcha($this->input->post('hcaptcha_input'), $this->input->post('hcaptcha_challenge'), $this->input->post('hcaptcha_key'), $this->input->post('hcaptcha_language')) == 'false')
				{
					$data['hsoub_captcha_error'] = 'Please Enter a Correct Captcha Value';
				}

				//***** ADDED "&& !$data['hsoub_captcha_error']" means: and hsoub_captcha_error is empty
				if ($this->form_validation->run() && !$data['hsoub_captcha_error']) {								// validation ok
					if (!is_null($data = $this->tank_auth->create_user(
							$use_username ? $this->form_validation->set_value('username') : '',
							$this->form_validation->set_value('email'),
							$this->form_validation->set_value('password'),
							$email_activation, TRUE))) {									// success. *** ADDED: note that TRUE means we need to create particular attachment folder for that user. The folder name is the user's id.

						$data['site_name'] = $this->config->item('website_name', 'tank_auth');

						if ($email_activation) {									// send "activate" email
							$data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;

							$this->_send_email('activate', $data['email'], $data);

							unset($data['password']); // Clear password (just for any case)

							set_temporary_msg($this->lang->line('auth_message_registration_completed_1'));

						} else {
							if ($this->config->item('email_account_details', 'tank_auth')) {	// send "welcome" email

								$this->_send_email('welcome', $data['email'], $data);
							}
							unset($data['password']); // Clear password (just for any case)

							set_temporary_msg($this->lang->line('auth_message_registration_completed_2'), 'login'); //**** ADDED
						}
					} else {
						$errors = $this->tank_auth->get_error_message();
						foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
					}
				}
			}
			
			if ($captcha_registration) {
				if ($use_recaptcha) {
					$data['recaptcha_html'] = $this->_create_recaptcha();
				} else {
					$data['captcha_html'] = $this->_create_captcha();
				}
			}
			$data['use_username'] = $use_username;
			$data['captcha_registration'] = $captcha_registration;
			$data['use_recaptcha'] = $use_recaptcha;
			$data['hsoub_captcha'] = view_captcha(CAPTCHA_KEY, 'en');
			$this->_load_view($data);
		}
	}

	/**
	 * Send activation email again, to the same or new email address
	 *
	 * @return void
	 */
	function send_again()
	{
		if (!$this->tank_auth->is_logged_in(FALSE)) {							// not logged in or activated
			redirect('login');

		} else {
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->change_email(
						$this->form_validation->set_value('email')))) {			// success

					$data['site_name']	= $this->config->item('website_name', 'tank_auth');
					$data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;

					$this->_send_email('activate', $data['email'], $data);

					set_temporary_msg(sprintf($this->lang->line('auth_message_activation_email_sent'), $data['email']));

				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->_load_view($data);
			
		}
	}

	/**
	 * Activate user account.
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	function activate()
	{
		$user_id		= $this->uri->segment(3);
		$new_email_key	= $this->uri->segment(4);

		// Activate user
		if ($this->tank_auth->activate_user($user_id, $new_email_key)) {		// success
			$this->tank_auth->logout();
			set_temporary_msg($this->lang->line('auth_message_activation_completed').' '.anchor('login', 'Login'));

		} else {																// fail
			set_temporary_msg($this->lang->line('auth_message_activation_failed'));
		}
	}

	/**
	 * Generate reset code (to change password) and send it to user
	 *
	 * @return void
	 */
	function forgot_password()
	{
		if ($this->tank_auth->is_logged_in()) {									// logged in
			redirect('');

		} elseif ($this->tank_auth->is_logged_in(FALSE)) {						// logged in, not activated
			set_temporary_msg($this->lang->line('auth_message_resend_activation_link').' '.anchor('logout', 'Logout'), 'resend');

		} else {
			$this->form_validation->set_rules('login', $this->lang->line('auth_forgot_password_lbl_username_or_email'), 'trim|required|xss_clean');

			$data['errors'] = array();
			
			if($this->input->post('reset')) //*** ADDED 
			{
				if ($this->form_validation->run()) {								// validation ok
					if (!is_null($data = $this->tank_auth->forgot_password(
							$this->form_validation->set_value('login')))) {

						$data['site_name'] = $this->config->item('website_name', 'tank_auth');

						// Send email with password activation link
						$this->_send_email('forgot_password', $data['email'], $data);

						set_temporary_msg($this->lang->line('auth_message_new_password_sent'));

					} else {
						$errors = $this->tank_auth->get_error_message();
						foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
					}
				}
			}
			
			$this->_load_view($data);
		}
	}

	/**
	 * Replace user password (forgotten) with a new one (set by user).
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	function reset_password()
	{
		$user_id		= $this->uri->segment(3);
		$new_pass_key	= $this->uri->segment(4);

		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
		$this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');

		$data['errors'] = array();

		if ($this->form_validation->run()) {								// validation ok
			if (!is_null($data = $this->tank_auth->reset_password(
					$user_id, $new_pass_key,
					$this->form_validation->set_value('new_password')))) {	// success

				$data['site_name'] = $this->config->item('website_name', 'tank_auth');

				// Send email with new password
				$this->_send_email('reset_password', $data['email'], $data);

				set_temporary_msg($this->lang->line('auth_message_new_password_activated').' '.anchor('login', 'Login'));

			} else {														// fail
				set_temporary_msg($this->lang->line('auth_message_new_password_failed'));
			}
		} else {
			// Try to activate user by password key (if not activated yet)
			if ($this->config->item('email_activation', 'tank_auth')) {
				$this->tank_auth->activate_user($user_id, $new_pass_key, FALSE);
			}

			if (!$this->tank_auth->can_reset_password($user_id, $new_pass_key)) {
				set_temporary_msg($this->lang->line('auth_message_new_password_failed'));
			}
		}
		$this->_load_view($data);
	}

	/**
	 * Change user password
	 *
	 * @return void
	 */
	function change_password()
	{
		if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
			redirect('login');

		} else {
			$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
			$this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if ($this->tank_auth->change_password(
						$this->form_validation->set_value('old_password'),
						$this->form_validation->set_value('new_password'))) {	// success
					set_temporary_msg($this->lang->line('auth_message_password_changed'));

				} else {														// fail
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->_load_view($data);
		}
	}

	/**
	 * Change user email
	 *
	 * @return void
	 */
	function change_email()
	{
		if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
			redirect('login');

		} else {
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->set_new_email(
						$this->form_validation->set_value('email'),
						$this->form_validation->set_value('password')))) {			// success

					$data['site_name'] = $this->config->item('website_name', 'tank_auth');

					// Send email with new email address and its activation link
					$this->_send_email('change_email', $data['new_email'], $data);

					set_temporary_msg(sprintf($this->lang->line('auth_message_new_email_sent'), $data['new_email']));

				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->_load_view($data);
		}
	}

	/**
	 * Replace user email with a new one.
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	function reset_email()
	{
		$user_id		= $this->uri->segment(3);
		$new_email_key	= $this->uri->segment(4);

		// Reset email
		if ($this->tank_auth->activate_new_email($user_id, $new_email_key)) {	// success
			$this->tank_auth->logout();
			set_temporary_msg($this->lang->line('auth_message_new_email_activated').' '.anchor('login', 'Login'));

		} else {																// fail
			set_temporary_msg($this->lang->line('auth_message_new_email_failed'));
		}
	}

	/**
	 * Delete user from the site (only when user is logged in)
	 *
	 * @return void
	 */
	function unregister()
	{
		if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
			redirect('login');

		} else {
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if ($this->tank_auth->delete_user(
						$this->form_validation->set_value('password'))) {		// success
					set_temporary_msg($this->lang->line('auth_message_unregistered'));

				} else {														// fail
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->_load_view($data);
		}
	}

	/***** ADDED
	 * My custom private method that plays role of load_view() that exists Frontend_Controller
	 *
	 * Whenever you need to load a page, just call: $this->_load_view($data);
	 *
	 */
	private function _load_view($data = array()) 
	{
		$data['main_page'] = $this->router->class.'/'.$this->router->method;
		$this->load->view(FRONTEND_SKELETON, $data); 
	}
	
	/**
	 * Show info message
	 *
	 * @param	string
	 * @return	void
	 */
	function _show_message($message, $target = '') //***** ADDED: SECOND PARAMETER TO ALLOW TARGETING LOCATION. HOWEVER, this function is identical set_temporary_msg so i replaced all $this->_show_message(...) to set_temporary_message(..)
	{
		$this->session->set_flashdata('message', $message);
		redirect($target); //*** ADDED: used to have '/auth/' by default. I changed it $target
	}

	/**
	 * Send email message of given type (activate, forgot_password, etc.)
	 *
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	void
	 */
	function _send_email($type, $email, &$data)
	{
		$this->load->library('email');
		$this->email->from($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->to($email);
		$this->email->subject(sprintf($this->lang->line('auth_subject_'.$type), $this->config->item('website_name', 'tank_auth')));
		$this->email->message($this->load->view('email/'.$type.'-html', $data, TRUE));
		$this->email->set_alt_message($this->load->view('email/'.$type.'-txt', $data, TRUE));
		$this->email->send();
	}

	/**
	 * Create CAPTCHA image to verify user as a human
	 *
	 * @return	string
	 */
	function _create_captcha()
	{
		$this->load->helper('captcha');

		$cap = create_captcha(array(
			'img_path'		=> './'.$this->config->item('captcha_path', 'tank_auth'),
			'img_url'		=> base_url().$this->config->item('captcha_path', 'tank_auth'),
			'font_path'		=> './'.$this->config->item('captcha_fonts_path', 'tank_auth'),
			'font_size'		=> $this->config->item('captcha_font_size', 'tank_auth'),
			'img_width'		=> $this->config->item('captcha_width', 'tank_auth'),
			'img_height'	=> $this->config->item('captcha_height', 'tank_auth'),
			'show_grid'		=> $this->config->item('captcha_grid', 'tank_auth'),
			'expiration'	=> $this->config->item('captcha_expire', 'tank_auth'),
		));

		// Save captcha params in session
		$this->session->set_flashdata(array(
				'captcha_word' => $cap['word'],
				'captcha_time' => $cap['time'],
		));

		return $cap['image'];
	}

	/**
	 * Callback function. Check if CAPTCHA test is passed.
	 *
	 * @param	string
	 * @return	bool
	 */
	function _check_captcha($code)
	{
		$time = $this->session->flashdata('captcha_time');
		$word = $this->session->flashdata('captcha_word');

		list($usec, $sec) = explode(" ", microtime());
		$now = ((float)$usec + (float)$sec);

		if ($now - $time > $this->config->item('captcha_expire', 'tank_auth')) {
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_captcha_expired'));
			return FALSE;

		} elseif (($this->config->item('captcha_case_sensitive', 'tank_auth') AND
				$code != $word) OR
				strtolower($code) != strtolower($word)) {
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * Create reCAPTCHA JS and non-JS HTML to verify user as a human
	 *
	 * @return	string
	 */
	function _create_recaptcha()
	{
		$this->load->helper('recaptcha');

		// Add custom theme so we can get only image
		$options = "<script>var RecaptchaOptions = {theme: 'custom', custom_theme_widget: 'recaptcha_widget'};</script>\n";

		// Get reCAPTCHA JS and non-JS HTML
		$html = recaptcha_get_html($this->config->item('recaptcha_public_key', 'tank_auth'));

		return $options.$html;
	}

	/**
	 * Callback function. Check if reCAPTCHA test is passed.
	 *
	 * @return	bool
	 */
	function _check_recaptcha()
	{
		$this->load->helper('recaptcha');

		$resp = recaptcha_check_answer($this->config->item('recaptcha_private_key', 'tank_auth'),
				$_SERVER['REMOTE_ADDR'],
				$_POST['recaptcha_challenge_field'],
				$_POST['recaptcha_response_field']);

		if (!$resp->is_valid) {
			$this->form_validation->set_message('_check_recaptcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}
		return TRUE;
	}

}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */