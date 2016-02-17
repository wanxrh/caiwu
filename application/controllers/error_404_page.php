<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error_404_page extends MY_Controller {

	public function __construct()
		{
		    parent::__construct();
		}
	public function index(){
		show_404('errors/error_404',['log_error']);
	}
}