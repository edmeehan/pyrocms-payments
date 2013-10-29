<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Payment extends Module {

    public $version = '1.0';

    public function info()
    {
        return array(
            'name' => array(
                'en' => 'Payment'
            ),
            'description' => array(
                'en' => 'Simple online payment with: Braintree, Dwolla'
            ),
            'frontend' => true,
            'backend' => true,
            'menu' => 'data', // You can also place modules in their top level menu. For example try: 'menu' => 'Sample',
            
            // 'sections' => array(
                // 'items' => array( //"items" will be the same in the Admin controller as protected $section filed
                    // 'name'  => 'sample:items', // These are translated from your language file
                    // 'uri'   => 'admin/sample',
                        // 'shortcuts' => array(
                            // 'create' => array(
                                // 'name'  => 'sample:create',
                                // 'uri'   => 'admin/sample/create',
                                // 'class' => 'add'
                                // )
                            // )
                        // )
                // )
        );
    }

    public function install()
    {
        $this->dbforge->drop_table('payments');
        $this->db->delete('settings', array('module' => 'payment'));

        $tables = array(
            'payments' => array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => '11',
                    'auto_increment' => true,
                    'primary' => true
                ),
                'value' => array(
                    'type' => 'DECIMAL',
                    'constraint' => array(12,2)
                ),
                'invoice' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100'
                ),
                'confirm' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100'
                ),
                'date' => array(
                    'type' => 'DATE'
                )
            )
        );
        
        // Let's try inserting tables
        if ( ! $this->install_tables($tables))
        {
            return false;
        }

        $settings = array(
            array(
                'slug' => 'disable_payments',
                'title' => 'Disable Payments',
                'description' => 'Turn off payments module and redirect users',
                'default' => '0',
                'value' => '0',
                'type' => 'radio',
                'options' => '0=No|1=Yes',
                'is_required' => 1,
                'is_gui' => 1,
                'module' => 'payment',
                'order' => 91
            ),
            array(
                'slug' => 'disable_url',
                'title' => 'Disabled Redirect Page Slug',
                'description' => 'Direct users to a page when payments module is disabled',
                'default' => '/404',
                'value' => '/404',
                'type' => 'text',
                'options' => '',
                'is_required' => 1,
                'is_gui' => 1,
                'module' => 'payment',
                'order' => 82
            ),
            array(
                'slug' => 'braintree_environment',
                'title' => 'Braintree Environment',
                'description' => 'Set the environment value.',
                'default' => 'production',
                'value' => 'production',
                'type' => 'radio',
                'options' => 'production=Production|sandbox=Sandbox',
                'is_required' => 0,
                'is_gui' => 1,
                'module' => 'payment',
                'order' => 73
            ),
            array(
                'slug' => 'braintree_merchantId',
                'title' => 'Braintree Merchant ID',
                'description' => 'Set the merchant Id value.',
                'default' => '',
                'value' => '',
                'type' => 'text',
                'options' => '',
                'is_required' => 0,
                'is_gui' => 1,
                'module' => 'payment',
                'order' => 64
            ),
            array(
                'slug' => 'braintree_publicKey',
                'title' => 'Braintree Public Key',
                'description' => 'Set the public key value.',
                'default' => '',
                'value' => '',
                'type' => 'text',
                'options' => '',
                'is_required' => 0,
                'is_gui' => 1,
                'module' => 'payment',
                'order' => 55
            ),
            array(
                'slug' => 'braintree_privateKey',
                'title' => 'Braintree Private Key',
                'description' => 'Set the private key value.',
                'default' => '',
                'value' => '',
                'type' => 'text',
                'options' => '',
                'is_required' => 0,
                'is_gui' => 1,
                'module' => 'payment',
                'order' => 46
            ),
            array(
                'slug' => 'braintree_clientKey',
                'title' => 'Braintree Client-Side Encryption Key',
                'description' => 'Set the client-side encryption key value - Braintree.js',
                'default' => '',
                'value' => '',
                'type' => 'textarea',
                'options' => '',
                'is_required' => 0,
                'is_gui' => 1,
                'module' => 'payment',
                'order' => 45
            ),
            array(
                'slug' => 'dwolla_id',
                'title' => 'Dwolla ID',
                'description' => 'Dwolla account receiving the funds.',
                'default' => '',
                'value' => '',
                'type' => 'text',
                'options' => '',
                'is_required' => 0,
                'is_gui' => 1,
                'module' => 'payment',
                'order' => 40
            ),
            array(
                'slug' => 'dwolla_test',
                'title' => 'Dwolla Testing',
                'description' => 'Flag if purchase order is for testing purposes only. Does not affect account balances and no emails are sent.',
                'default' => '0',
                'value' => '0',
                'type' => 'radio',
                'options' => '0=No|1=Yes',
                'is_required' => 0,
                'is_gui' => 1,
                'module' => 'payment',
                'order' => 39
            ),
            array(
                'slug' => 'dwolla_key',
                'title' => 'Dwolla Key',
                'description' => 'Set the key value.',
                'default' => '',
                'value' => '',
                'type' => 'text',
                'options' => '',
                'is_required' => 0,
                'is_gui' => 1,
                'module' => 'payment',
                'order' => 37
            ),
            array(
                'slug' => 'dwolla_secret',
                'title' => 'Dwolla Secret',
                'description' => 'Set the secret value.',
                'default' => '',
                'value' => '',
                'type' => 'text',
                'options' => '',
                'is_required' => 0,
                'is_gui' => 1,
                'module' => 'payment',
                'order' => 28
            )
        );
        
        // Let's try inserting some settings
        foreach ($settings as $setting)
        {
            if ( ! $this->db->insert('settings', $setting))
            {
                return false;
            }
        }

        // We made it!
        return true;
    }

    public function uninstall()
    {
        $this->dbforge->drop_table('payments');

        $this->db->delete('settings', array('module' => 'payment'));

        // Put a check in to see if something failed, otherwise it worked
        return true;
    }


    public function upgrade($old_version)
    {
        // Your Upgrade Logic
        return true;
    }

    public function help()
    {
        // Return a string containing help info
        $helpString = '';
        $helpString .= '<p>The payment module is set to use the Braintree and Dwolla for online payments. Set payment options in the admin setting tab.</p><hr/>';
        $helpString .= '<p><strong>Disable Dwolla:</strong> Dwolla ID (leave blank to disable Dwolla payments)</p>';
        $helpString .= '<p><strong>Disable Braintree:</strong> Braintree Merchant ID  (leave blank to disable Braintree payments)</p>';
        $helpString .= '<p><strong>Testing Dwolla:</strong> Dwolla Testing (radio options)</p>';
        $helpString .= '<p><strong>Testing Braintree:</strong> Braintree Environment (radio options)</p>';
        
        return $helpString;

    }
}