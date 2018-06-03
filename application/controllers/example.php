<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



require_once(APPPATH . 'core/' . 'Crudderconfig.php');

define ('PAGES_SET', 'BOOTSTRAPPED');



/**
 * Crudder online example
 * 
 * @package     Crudder
 * @author      Gorka G LLona <gorka@desarrolladores.logicos.org>
 * @copyright   Copyright (c) 2014, Gorka G LLona
 * @license     GNU GPL license
 * @link        http://librerias.logicas.org/crudder
 * @version     Version 1.0.0beta1
 * @since       Version 1.0.0beta1
 */
class Example extends CI_Controller {

    
    
    static function init ()
    {
        // do nothing
    }
    

    
    public function __construct ()
    {
        parent::__construct();
    }
    

    
    function index ()
    {
        redirect("example/front_page");
    }    
    
        
    
    function front_page ($message = false)
    {
        $data = array ();
        $data['message'] = $message;
        $this->load->view(self::my_view_name('templates/header'), $data, FALSE);
        $this->load->view(self::my_view_name('front_page'), $data);
        $this->load->view(self::my_view_name('templates/footer'), $data, FALSE);
    }

    
    
    function come_from_crudder ()
    {
        $message = 'Exit from Crudder completed';
        redirect("example/front_page/$message");
    }

    
    
    static function my_view_name ($view_name)
    {
        return strtolower(PAGES_SET) . '/' . $view_name;
    }

    
    
}
