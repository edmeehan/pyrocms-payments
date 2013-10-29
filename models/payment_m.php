<?php defined('BASEPATH') or exit('No direct script access allowed');

class Payment_m extends MY_Model {
    
    //create a new item
    public function create()
    {
            $to_insert = array(
                    'value' =>      $this->session->userdata('payment'),
                    'invoice' =>    $this->session->userdata('invoice'),
                    'date' =>       date('Y-m-d', time()),
                    'confirm' =>    $this->session->userdata('transID')
            );
            
            return (int) parent::insert($to_insert);
    }
    
}