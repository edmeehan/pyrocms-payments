<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Admin extends Admin_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('payment_m');
    }
    
    public function index()
    {
        // Get all the payments
        $payments = $this->payment_m->get_all();

        // Load the view
        $this->template
            ->title($this->module_details['name'])
            ->set('payments',  $payments)
            ->build('admin/index');
    }
}
    