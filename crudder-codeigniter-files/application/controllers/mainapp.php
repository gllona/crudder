<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'core/' . 'Estado.php');
require_once(APPPATH . 'core/' . 'Municipio.php');
require_once(APPPATH . 'core/' . 'Parroquia.php');
require_once(APPPATH . 'core/' . 'User.php');
require_once(APPPATH . 'core/' . 'Log.php');

// load the Crudderconfig class (this class should not reside into de "models" directory)
//
require_once(APPPATH . 'core/' . 'Crudderconfig.php');



// this definition affects only the Mainapp; look inside Crudderconfig for setting the Crudder localization language
//
define ('PAGES_SET', 'RAW');   // no BOOTSTRAPPED views have been developed for this sample application



/**
 * Sample application for testing Crudder
 * 
 * @package     Crudder
 * @author      Gorka G LLona <gorka@desarrolladores.logicos.org>
 * @copyright   Copyright (c) 2014, Gorka G LLona
 * @license     GNU GPL license
 * @link        http://librerias.logicas.org/crudder
 * @version     Version 1.0
 * @since       Version 1.0
 */
class Mainapp extends CI_Controller {

    
    
    // initializer and constructor
    
    
    
    static function init ()
    {
        // do nothing (for this app)
    }
    
    
    
    public function __construct ()
    {
        parent::__construct();
        
        // initializers for all the domain-specific core classes
        // they are here instead of the initializer in order to them to be able to access this controller instance from their static methods
        //
        Estado::init();
        Municipio::init();
        Parroquia::init();
        User::init();
        Log::init();
        
        // register this controller in the Log class
        // this is neccesary when working with multiples controllers (in non-standalone mode, for example)
        //
        Log::register_me($this);
        
        $this->load->database();
        $this->lang->load('db', 'spanish');
        $this->lang->load('form_validation', 'spanish');
    }
    

    
    // encapsulated methods for integration with the Crudder
    
    
    
    /**
     * Should be called from the method that redirects the control flow to the Crudder
     * 
     * @access	private
     * @return	void
     */
    function goto_crudder ()
    {
        // $this->session->set_userdata("crudder_user_role", "superadmin");                    // superadmin admin regular // the last one will not be accepted by the Crudder
        $this->session->set_userdata("crudder_user_role", $this->session->userdata("role"));   // assigns to the Crudder the same user role that has the Mainapp user
        redirect('crudder');
    }

    
    
    /**
     * Called from Crudder when the user decides leave it
     * 
     * @access	private
     * @return	void
     */
    function comefrom_crudder ()
    {
        $this->session->unset_userdata('crudder_user_role');
        $message = 'Se acaba de salir del Crudder';
        redirect("mainapp/users_list/$message");
    }

    
    
    /**
     * Called from the Crudder when there is a security breach (URI injection)
     * 
     * The Crudder is designed to destroy the CodeIgniter session set before calling this (using session->sess_destroy()) 
     * 
     * @access	private
     * @return	void
     */
    function abortfrom_crudder ()
    {
        $this->session->unset_userdata('crudder_user_role');   // nothing is really waste here
        $this->session->sess_destroy();                        // same
        redirect("mainapp/logout");
    }

    
    
    // Utilities

    
    
    static function my_view_name ($view_name)
    {
        return strtolower(PAGES_SET) . '/' . $view_name;
    }



    static function my_anchor ($param1, $param2 = null, $param3 = null)
    {
        $url = 'mainapp/' . $param1 . '';
        if ($param2 === null)
            $res = anchor($url);
        elseif ($param3 === null)
            $res = anchor($url, $param2);
        else
            $res = anchor($url, $param2, $param3);
        return $res;
    }



    // CI methods for login and logout from this system
    // these method are application-specific and are not related to the Crudder


    
    public function index ()
    {
        ini_set('display_errors', 'On');
        error_reporting(-1);
        define ('MP_DB_DEBUG', true); 

        // go to the main method for the first screen
        return $this->login();
    }

    
    
    public function login ($user = 'usuario', $message = null)
    {
        $data = array();
        $data['user']   = $user;
        $data['result'] = $message === null ? '' : urldecode($message);
        Log::register('showing login screen');
        $this->load->view(self::my_view_name('templates/header'), $data, FALSE);
        $this->load->view(self::my_view_name('login', $data));
        $this->load->view(self::my_view_name('templates/footer'), $data, FALSE);
    }

    

    public function login_verify ()
    {
        $user     = isset($_POST['user'])     ? $_POST['user'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $role     = User::verify($user, $password);
        if ($role !== -1) {
            $this->session->set_userdata('user', $user);
            $this->session->set_userdata('role', $role);
            $message = 'Conexion exitosa';
            Log::register('succesful connecting to system');
            redirect("/mainapp/users_list/$message");
        }
        else {
            $message = 'Error en la conexion al sistema';
            Log::register('error when connecting to system');
            return $this->login($user, $message);
        }
    }

    
    
    public function logout ($from_system = FALSE)
    {
        if ($from_system) {
            Log::register('not autorized access to a function, forcing logout');
            $message = 'Se ha abortado la sesion por acceso no autorizado a funcionalidades privilegiadas';
        } else {
            Log::register('regular logout from the system');
            $message = 'Desconexion exitosa del sistema';
        }
        $this->session->unset_userdata('user');
        $this->session->unset_userdata('role');
        $this->session->sess_destroy();
        redirect("/mainapp/login/usuario/$message");
    }
    
    

    // CI methods for the hand-generated CRUD for users administration
    // this is a handcrafted implementation, but the Crudder could also be used for users administration (better)

    
    
    public function users_list ($message = null)
    {
        // check security in the access (privileged method)
        $role = $this->session->userdata('role');
        if ($role === 'regular')
            return $this->logout(TRUE);

        $data = array();
        $data['users'] = User::retrieve_all();
        if ($message !== null)
            $data['result'] = urldecode($message);
        $this->load->view(self::my_view_name('templates/header'), $data, FALSE);
        $this->load->view(self::my_view_name('users_list'), $data);
        $this->load->view(self::my_view_name('templates/footer'), $data, FALSE);
    }



    public function user_show ($user)
    {
        // check security in the access (privileged method)
        $role = $this->session->userdata('role');
        if ($role === 'regular')
            return $this->logout(TRUE);

        $data = array();
        $result = User::retrieve($user);
        if ($result === -1) {
            $message = 'No se pueden consultar los datos del usuario';
            return $this->users_list($message);
        }
        else {
            $data = array_merge($data, $result);
        $this->load->view(self::my_view_name('templates/header'), $data, FALSE);
        $this->load->view(self::my_view_name('user_show'), $data);
        $this->load->view(self::my_view_name('templates/footer'), $data, FALSE);
        }
    }



    public function user_update ()
    {
        // check security in the access (privileged method)
        $role = $this->session->userdata('role');
        if ($role === 'regular')
            return $this->logout(TRUE);

        $user_old = isset($_POST['user_name_old'])  ? $_POST['user_name_old']  : null;
        $user     = isset($_POST['user_name_edit']) ? $_POST['user_name_edit'] : null;
        $role     = isset($_POST['role_edit'])      ? $_POST['role_edit']      : 'regular';
        $password = isset($_POST['password_edit'])  ? $_POST['password_edit']  : '';
        if ($user == '')
            $message = 'El campo nombre de usuario no puede estar vacio';
        else {
            $result = User::update($user_old, $user, $role, $password);
            if ($result < 0)
                $message = "No se pueden guardar los datos del usuario o sus datos no han sido cambiados";
            else
                $message = 'Los datos del usuario han sido guardados';
        }
        redirect("/mainapp/users_list/$message");
    }



    public function user_generate ()
    {
        // check security in the access (privileged method)
        $role = $this->session->userdata('role');
        if ($role === 'regular')
            return $this->logout(TRUE);

        $data = array();
        $result = User::generate();
        $data = array_merge($data, $result);
        $this->load->view(self::my_view_name('templates/header'), $data, FALSE);
        $this->load->view(self::my_view_name('user_show', $data));
        $this->load->view(self::my_view_name('templates/footer'), $data, FALSE);
    }

    
    
    public function user_insert ()
    {
        // check security in the access (privileged method)
        $role = $this->session->userdata('role');
        if ($role === 'regular')
            return $this->logout(TRUE);

        $user     = isset($_POST['user_name_edit']) ? $_POST['user_name_edit'] : null;
        $role     = isset($_POST['role_edit'])      ? $_POST['role_edit']      : 'regular';
        $password = isset($_POST['password_edit'])  ? $_POST['password_edit']  : '';
        if ($user == '')
            $message = 'El campo nombre de usuario no puede estar vacio';
        else {
            $result = User::insert($user, $role, $password);
            if ($result < 0)
                $message = 'No se pueden insertar los datos del usuario';
            else
                $message = 'Los datos del usuario han sido guardados.';
        }
        redirect("/mainapp/users_list/$message");
    }



    public function user_delete ($user)
    {
        // check security in the access (privileged method)
        $role = $this->session->userdata('role');
        if ($role === 'regular')
            return $this->logout(TRUE);

        $result = User::delete($user);
        if ($result === -3)
            $message = 'No se puede eliminar al ultimo administrador';
        elseif ($result < 0)
            $message = 'Error eliminando al usuario';
        else
            $message = 'El usuario ha sido eliminado.';
        redirect("/mainapp/users_list/$message");
    }

    
    
}
