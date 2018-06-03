<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// use Crudderconfig;   // use this for NetBeans if the PHP debug set is >= 5.5

require_once(APPPATH . 'core/' . 'Crudderconfig.php');



/**
 * Crudder controller class
 *
 * This file should reside into the "application/controllers" directory
 * 
 * A class for implementing a CRUD software components with a high degree of customization
 * 
 * Based on and intented to work upon the CodeIgniter PHP framework
 * 
 * Acts both as a model and a self-contained controller for Crudder
 * 
 * Configuration for this class should be made in the core/Crudderconfig class
 * 
 * Limitations:
 * 
 * 1. can't use the 'callback_*' CI validation methods (within Crudder); use instead 'crudder_*' validation methods (more powerful) and implement them in the Crudderconfig class
 * 
 * 2. the special string value "(NULL)" in forms indicates the NULL database value (for fields that can be NULL), so this particular string can't be used as a normal value for text fields; this string is customizable in the Cruderconfig class
 * 
 * 3. all tables managed by the Crudder must have an 'id' field of type INT (or its numeric derivatives), that will work as primary key and can not have the "-1" value assigned; the table can also have any other field with the UNIQUE or INDEX SQL indexes types; if this is the case, this feature should be reflected as a validation rule in the crudder_fields metatable (as crudder_is_unique for example)
 * 
 * 4. can manage 1:N relations, but the Crudder will show it in the table that have the "N" part; in order to this to work, the database should implement the relation with the foreign key spirit (defined or not in this way in the database)
 * 
 * 5. can not manage N:N relations unless these relations are implement as a normal table; in this case the relation values (pairs in that table) will have to be managed as any other SQL table
 * 
 * 6. can not show SELECT MULTIPLE boxes in HTML views
 * 
 * 7. HTML forms must not use fields (hidden or not) whose names begin with "crudder_"; these names are reserver for the Crudder implementation
 * 
 * 8. form DATETIME inputs don't show intelligent controls for setting and modifying (currently Bootstrap doesn't provide them)
 * 
 * 9. names for CI session variables can not begin with the string "crudder_"
 * 
 * 10. the .htaccess should be used for hiding the "index.php" strings in the URI's; a sample is provided with this distribution (remember that names beginning with a dot will not be shown when doing a "ls"; use instead "ls -a"); be sure to blank $config['index_page'] in application/config/config.php and enable mod_rewrite in Apache2; for a local installation add an entry in /etc/hosts pointing to localhost (127.0.0.1) and create the proper virtual host in the web server (a sample of a virtual host configuration files is included here under the "_distrib" directory)
 * 
 * 11. this file should reside into the "application/controllers" directory
 *  
 * 12. Crudder is currently tested only with PHP 5.5.1-2 on Linux Mint Debian Edition and MySQL 14.14 Distrib 5.5.31
 * 
 * 13. Crudder documentation is currently only available in english
 *
 * Configuration:
 * 
 * 1. be sure that the CI "application/config/database.php" file includes the correct information for database access, like:
 * - $db['default']['hostname'] = 'localhost';
 * - $db['default']['username'] = 'crudder_user';
 * - $db['default']['password'] = 'crudder_password';
 * - $db['default']['database'] = 'crudder';
 * - these values should be changed to the needed value of your application
 * 
 * 2. make a symbolic link from "application/views/{pages_set}/templates/{header.php|footer.php}" to the corresponding files in the main application, if you want the Crudder to use the main application header an footer, instead of the Crudder-defined header and footer; note that the Crudder have also a crudder_header and crudder_footer that are are intended to work only by the Crudder
 * 
 * 3. XSS is enabled by default for validation of input fields of forms; can be enabled as a global CI directive with the following setting in "application/config/config.php" file (this can also be set field-by-field through Crudder metatables):
 * - $config['global_xss_filtering'] = TRUE;
 * 
 * 4. CodeIgniter needed modifications for "application/config/autoload.php" file:
 * - $autoload['libraries'] = array('database', 'session', 'form_validation');
 * - $autoload['helper']    = array('url', 'html', 'form', 'language');
 * 
 * 5. must set the proper values in "application/config/routes.php" like this:
 * - $route['default_controller'] = "mainapp"; // (for the integrated sample to work (includes users administration))
 * - $route['default_controller'] = "crudder"; // (in order to work with an isolated, no integrated Crudder work mode (for testing and simple applications))
 * 
 * 6. in the case that you need another language localization, a copy of the "application/languages/english" directory can be used; just change the name of the directory to the proper value; this should be done in order to the Crudder to work with localization; for spanish, a "spanish/form_validation_lang.php" is included with this distribution (only this file is needed by the Crudder)
 * 
 * 7. if you want to reset the sample database included with this distribution, look for the proper SQL scripts under the "_database" directory
 * 
 * 8. this distribution includes a complete CodeIgniter installation in order to work out-of-the-box; however, the php files that compose the Crudder (excluding the sample Mainapp application) are (inside the "application/" directory): controllers/Crudder.php, core/Crudderconfig.php, views/bootstrapped/*, views/raw/*, languages/spanish/form_validation_lang.php (the rest of files inside languages/spanish are a copy of the languages/english directory)
 * 
 * 9. If you plan use Crudder with an external, no CI-based application, look inside the Crudderconfig class for the proper configuration
 * 
 * As standalone:
 * 
 * 1. this Crudder distribution is set, by default, as a non-standalone mode; this permits you to see easily the integration between you main application and the Crudder; if you want to set the Crudder in standalone mode, follow these steps:
 * 
 * - in CrudderConfig.php: set the constant STANDALONE to TRUE
 * 
 * - in CrudderConfig.php: set the constant GOAWAY_METHOD to 'crudder/abort'
 * 
 * - in Crudderconfig.php: set the constant ABORT_METHOD to 'crudder/abort'
 * 
 * - in CrudderConfig.php: set the constant DEFAULT_USER_ROLE to 'superadmin' or 'admin'; remember that the role 'admin' can not edit the Crudder metatables
 * 
 * - in applications/config/routes.php: set the constant $route['default_controller'] to "crudder"
 * 
 * These are all the notes for limitations and configuration; for a complete list of features see the README file or the web page of this library
 * 
 * Comments about bugs, requested feautures or general messages are welcome; just use my email address indicated below
 * 
 * @package     Crudder
 * @author      Gorka G LLona <gorka@desarrolladores.logicos.org> <gllona@gmail.com>
 * @copyright   Copyright (c) 2014, Gorka G LLona
 * @license     GNU GPL license
 * @link        http://librerias.logicas.org/crudder
 * @version     Version 1.0.0 beta 1
 * @since       Version 1.0.0 beta 1
 */
class Crudder extends CI_Controller
{
    


    //================================
    // CRUDDER INITIALIZERS - GENERICS
    //================================
    
    
    
    /**
     * @var    array  accumulative container for validation errors when processing a Crudder form; don't touch
     * @access private
     */
    private $validation_errors            = array ();
    
    /**
     * @var    array  wrappers for each validation error as reported to the Bootstrapped Crudder interface; don't touch in order to avoid breaking the look and feel
     * @access private
     */
    private $validation_error_delimiters  = array ('<p>', '</p>');

    /**
     * @var    object contains the Crudderconfig instance; this is set inside the constructor of this class
     * @access private
     */
    private $configurator;


    
    /**
     * Static initializer
     * 
     * @access	public
     * @return	void
     */
    static function init ()
    {
        // do nothing
    }

    
    
    /**
     * Class constructor
     * 
     * @access	public
     * @return	void
     */
    public function __construct ()
    {
        parent::__construct();
        
        $this->load->database();
        $this->lang->load('db',              Crudderconfig::$codeigniter_languages_folders[Crudderconfig::LANGUAGE_CODE]);
        $this->lang->load('form_validation', Crudderconfig::$codeigniter_languages_folders[Crudderconfig::LANGUAGE_CODE]);
        
        Crudderconfig::init();
        $this->configurator = new Crudderconfig();
    }


    
    /**
     * Main method for the Crudder; calls tables_show
     * 
     * Note that this method will set the error reporting to the most detailed level; this could be disabled (by changing the code) when you are in a production system
     * 
     * @access	public
     * @return	void
     */
    public function index ()
    {
        // standard initializers for CI
        ini_set('display_errors', 'On');
        error_reporting(-1);
        define('MP_DB_DEBUG', true); 

        // call the main method
        Crudderconfig::log(Crudderconfig::LOG_NOTICE, "index", "redirecting to tables_show");
        $this->crudder_redirect('crudder/tables_show');
    }

    
    
    //======================
    // UTILITIES - INTERNALS
    //======================

    
    
    /**
     * Redirects the browser to the specified URI (CI-style)
     * 
     * (internal utilities method)
     * 
     * This method will assign a message intended to be shown in the next view (as a session)
     * 
     * @access	private
     * @param	string  URI (this class' controller method) to redirect to, as used in CI
     * @param	string  optional string message to be shown in the redirected page, passed to the as a session variable to the next method
     * @return	void
     */
    private function crudder_redirect ($uri, $message = false)
    {
        $this->set_message_on_session($message);
        redirect($uri);
    }
    
    

    /**
     * Shows the specified view surrounded with headers and footers
     * 
     * (internal utilities method)
     * 
     * Allows to show domain-specific header and footer that are located in the 'views/templates' subdirectory; inside them, Crudder-specific header and footer will be shown; inside them, the specified view will be shown
     * 
     * Crudder actually implements "raw" and "bootstrapped" views (the second one is built using the Twitter Bootstrap GUI framework); files for each type of view reside in a separate subdirectory, allowing to define headers and footers for each case
     * 
     * @access	private
     * @param	string  view name (as CI implementation of $this->load->view())
     * @param	array   data() variables to be passed to CI view method
     * @param	string  message to be shown in the view, passed to view into the CI data()
     * @return	void
     */
    private function crudder_view ($page_name, $data = array(), $message = false)
    {
        $pages_set = Crudderconfig::DEFAULT_PAGES_SET;
        $pages_set = strtolower($pages_set);
        $complementary_data = array ( 'pages_set' => $pages_set );
        
        // pass also to the views the goaway method name in order to be able to generate the links to the main system
        $this->set_message_on_data($data, $message);
        $goaway_method = Crudderconfig::GOAWAY_METHOD;
        $data['goaway_method'] = $goaway_method;

        // show headers
        $this->load->view($pages_set . '/' . 'templates/header'        , $complementary_data);
        $this->load->view($pages_set . '/' . 'templates/crudder_header', $complementary_data);
        
        // show the view
        $this->load->view($pages_set . '/' . $page_name, $data);
        
        // show footers
        $this->load->view($pages_set . '/' . 'templates/crudder_footer', $complementary_data);
        $this->load->view($pages_set . '/' . 'templates/footer'        , $complementary_data);
    }
    
    
    
    /**
     * Generates an associative array from a normal, non-keyed array
     * 
     * @access	private
     * @param	array   base array (non-keyed)
     * @param   string  values of this field will be used as map indexes
     * @param   boolean if not false, the values of the new map won't be arrays but only this single field; defaults to false
     * @return	void
     */
    private function array_to_map (& $base_array, $field_for_index, $single_field_for_entry = false)
    {
        if (count($base_array) == 0) {
            return array ();
        }
        if (! isset($base_array[0][$field_for_index])) {
            return array ();
        }
        if ($single_field_for_entry !== false && ! isset($base_array[0][$single_field_for_entry])) {
            return array ();
        }
        $new_array = array ();
        foreach ($base_array as $entry) {
            $new_array[$entry[$field_for_index]] = $single_field_for_entry === false ? $entry : $entry[$single_field_for_entry];
        }
        return $new_array;
    }


    
    /**
     * Adds a message to the data() array for loading a view method using the CI primitives
     * 
     * (internal utilities method)
     * 
     * This method is intended only for use by the CI $this->load->view() primitive
     * 
     * @access	private
     * @param	array   associative array of variables to be passed to the CI $this->load->view() method; the associative array will have one more element after this method invocation
     * @param	string  message to be shown in the view; this is assigned as a CI session variable)
     * @return	void
     */
    private function set_message_on_data (& $data, $message = false)
    {
        if ($message === false) {
            $message = $this->session->flashdata('crudder_message');
        }
        if ($message !== false) {
            $data['message'] = html_escape($message);
        }
    }

    
    
    /**
     * Adds a message to the CI session variables for displaying that message after a redirect
     * 
     * (internal utilities method)
     * 
     * This method is intended only for use by the CI redirect() primitive
     * 
     * @access	private
     * @param	string  message to be shown in the view
     * @return	void
     */
    private function set_message_on_session ($message = false)
    {
        if ($message !== false) {
            $message = $this->session->set_flashdata('crudder_message', $message);
        }
    }

    
    
    /**
     * Checks access to Crudder based on privileges set in a session variable
     * 
     * (internal utilities method)
     * 
     * For example, CI session variable 'role' should contain 'admin' or 'superadmin' (for proper values check the Crudderconfig class)
     * 
     * When in standalone mode, the session variable will be set from the Crudderconfig DEFAULT_USER_ROLE constant
     * 
     * Intended only for usage by public methods of this class
     * 
     * @access	private
     * @param   boolean if true, only the "superadmin" role will be allowed to use the Crudder; defaults to false
     * @param   boolean if the authentication fails, the Crudder will enforce a logout from the main system; defaults to true
     * @return	boolean true if access is allowed; false otherwise (in this case the Crudder will be redirected to the "goaway" method, as defined in Crudderconfig)
     */
    private function check_access ($only_superadmin = false, $logout_if_fail = true)
    {
        $fail = false;
        $role = $this->session->userdata('crudder_user_role');
        if ($role === false) {
            $fail = true;
        }
        elseif ($role != 'admin' && $role != 'superadmin') {
            $fail = true;
        }
        elseif ($role == 'admin' && $only_superadmin) {
            $fail = true;
        }
        if ($fail && ! $logout_if_fail) {
            // for this case, the redirect logic should be implemented by the callee, but there is not such a case in this class, so this block doesn't have the redirect; this is the default case for failed access
            Crudderconfig::log(Crudderconfig::LOG_EXCEPTION, "check_access", "insufficient privileges");
            return false;
        }
        elseif ($fail) {   // && logout_if_fail
            $this->crudder_redirect(Crudderconfig::GOAWAY_METHOD);
            Crudderconfig::log(Crudderconfig::LOG_EXCEPTION, "check_access", "insufficient privileges");
            return false;
        }
        return true;
    }

    

    /**
     * Embeeds a print_r(string) sentence into a pair of HTML "PRE" tags
     * 
     * (internal utilities method)
     * 
     * This method is used only when it's neccesary to show texts in views for debugging the Crudder
     *
     * @access	public
     * @param	string  the string to be echoed with print_r
     * @return  void
     */
    public function pre_print_r ($what)
    {
        echo "<pre>::"; print_r ($what); echo "::</pre>";
    }



    /**
     * Exits from the Crudder
     * 
     * (method for integration with the main application)
     * 
     * This function will redirect the system flow to the controller and method defined in the Crudderconfig constant 'GOAWAY_METHOD'
     * 
     * The referred method will be normally located in another controller (belonging to the main system), except when using the Crudder in standalone mode
     * 
     * The goaway method can not be "crudder/goaway" in order to avoid recursive calling
     * 
     * @access	public
     * @return	void
     */
    public function goaway ()
    {
        Crudderconfig::log(Crudderconfig::LOG_NOTICE, "goaway", "exiting Crudder normally");
        $this->session->unset_userdata('crudder_user_role');
        $this->crudder_redirect(Crudderconfig::GOAWAY_METHOD);
    }

    

    /**
     * Exits the Crudder by redirecting to the abort_method
     * 
     * (method for integration with the main application)
     * 
     * This case normally occurs when trying to access the Crudder with wrong privileges
     * 
     * Destroys session userdata and the session itself before displaying the abort view or, if not in standalone mode, before redirecting to the main application abort method
     * 
     * @access	public
     * @return	void
     */
    public function abort ()
    {
        $this->session->unset_userdata('crudder_user_role');
        $this->session->sess_destroy();
        Crudderconfig::log(Crudderconfig::LOG_WARNING, "abort", "aborting Crudder - exiting");
        if (Crudderconfig::STANDALONE === true) {
            $this->crudder_view('crudder_abort');
        }
        else {
            $this->crudder_redirect(Crudderconfig::ABORT_METHOD);
        }
    }

    

    /**
     * Crudder callback for checking values of HTML forms fields values
     * 
     * (hardwired method for field value validation)
     * 
     * This method is intended for use in database inserts and updates (more powerful than CI is_unique)
     * 
     * Checks if 'value' is already used in 'field_name' of 'table_name'; this for inserts and also for updates that change the value
     * 
     * If 'action' is 'update' and no 'id_record' is passed, this method can't work properly and will return true (preventing the proper checking of values)
     * 
     * This method, in particular, is called from the Crudderconfig class (method crudder_is_unique), where all the routines for fields validations should reside; because of the structure and logic of this checking, the method is implemented here
     *
     * @access	public
     * @param	array   field validation specs: [ table_name, field_name, field_with_form_action ] (field_with_form_action is 'insert*' or 'update*', without the "crudder_" prefix); validation rule in the crudder_fields metatable should be, for example: crudder_is_unique[cat_estados,code,insert] (without spaces inside the brackets) for checking that 'value' will be checked against all the values of the field 'code' in the table 'cat_estados' using the logic for a SQL 'insert' operation
     * @param   string  value to be checked (assigned by the Crudder logic and primarily sent to the 'crudder_*' validations rules in Crudderconfig)
     * @param	integer ID of the record being checked (assigned by the Crudder logic); if false, the value will be fetched from the database
     * @return  boolean 
     */
    public function crudder_is_unique ($field_validation_specs, $value, $id_record = false)
    {
        list ($table_name, $field_name, $action_form_field) = $field_validation_specs;
        $action = isset($_POST["crudder_$action_form_field"]) ? $_POST["crudder_$action_form_field"] : '';
        $action = substr($action, 0, 6);   // deletes the "_secondary" portion, if it's the case
        
        // fetchs the original value of the field in the database
        $record_data = $id_record   === false ? false : $this->fetch_table_record($table_name, $id_record);
        $orig_value  = $record_data === false ? false : $record_data[$field_name];
        
        // inserts and updates with value changed and old value preserved in the form
        if ($action == 'insert' || ($action == 'update' && $value != $orig_value && $orig_value !== false))
        {
            $value = $value === null ? 'NULL' : "'$value'";
            $query = <<<END
                SELECT COUNT(*) AS counter
                FROM `$table_name`
                WHERE `$field_name` = $value;
END;
            $rs = $this->db->query($query);
            $rows = $rs->result_array();
            $counter = $rows[0]['counter'];
            if ($counter > 0) {
                return false;
            }
        }
        
        // updates with no info about value change
        elseif ($action == 'update')
        {
            // do nothing (can't check properly without the orig value of the field)
        }
        
        // bad action in the action field
        else {
            $this->validation_errors[] = Crudderconfig::get_string('is_unique_bad_action');
            return false;
        }
        
        // defaults to ok
        return true;
    }
    
    
    
    //=======================
    // CRUD GENERATOR METHODS
    //=======================

    
    
    /**
     * Shows a view of all the tables managed by the Crudder with links to the edit form of each one
     * 
     * (CRUD generator method)
     * 
     * The metatables are shown or not depending of the Crudderconfig settings
     * 
     * @access	public
     * @return	void
     */
    public function tables_show ()
    {
        // access control
        if ($this->check_access() === false) {
            return false;
        }

        // fetch tables metadata
        $tables_md = $this->fetch_tables_metadata();

        // if not to show metatables, exclude from the rows
        $tables_md_refined = array ();
        foreach ($tables_md as $table_md) {
            $table_md['with_edit'] = true;
            if ($this->check_access(true, false)) {
                // do nothing
            }
            elseif ($table_md['is_metatable'] == 1 && Crudderconfig::SHOW_METATABLES) {
                $table_md['with_edit'] = false;
            }
            elseif ($table_md['is_metatable'] == 1) {
                continue;
            }
            $tables_md_refined[] = $table_md;
        }
        
        // show view
        $data = array ();
        $data['tables'] = $tables_md_refined;
        $this->crudder_view('crudder_tables_show', $data);
    }



    /**
     * Shows a specific table with paginated records, header for sorting and filterring, and operations links for each record
     * 
     * (CRUD generator method)
     * 
     * @access	public
     * @param   string  table name
     * @param   mixed   array with column filters as specified in the previous display of the same table; each filter is a string or number that will be considered as part of the value for the field; defaults to false
     * @param	mixed   sort by this field (if triggered by any of the order-by icons); defaults to false
     * @param   mixed   order for records sorting (ASC | DESC) (if triggered by any of the order-by icons); defaults to false
     * @param   mixed   new page number to be shown (reflected in the pager); defaults to false
     * @param   integer not used; skip
     * @return	void
     */
    public function table_show ($id_table, $filters_from_post = false,
                                $new_sort_field_name = false, $new_sort_order = false, $new_pager_page_number = false,
                                $pager_action = 0)
    {
        // access control
        if ($this->check_access() === false) {
            return false;
        }
        
        // get session-saved previous method parameters; if not available then set some default values
        list ($default_sort_field, $default_sort_order) = $this->build_default_sort_specs();
        $prev_sort_field_name   = $this->session->flashdata('crudder_sort_field_name'  ) === false ? 'id'                : $this->session->flashdata('crudder_sort_field_name'  );
        $prev_sort_order        = $this->session->flashdata('crudder_sort_order'       ) === false ? $default_sort_order : $this->session->flashdata('crudder_sort_order'       );
        $prev_pager_page_number = $this->session->flashdata('crudder_pager_page_number') === false ? 1                   : $this->session->flashdata('crudder_pager_page_number');

        // set real method parameters: if not set in the method arguments then use the previous session-saved or defaults
        $sort_field_name   = $new_sort_field_name   !== false ? $new_sort_field_name   : $prev_sort_field_name;
        $sort_order        = $new_sort_order        !== false ? $new_sort_order        : $prev_sort_order;
        $pager_page_number = $new_pager_page_number !== false ? $new_pager_page_number : $prev_pager_page_number;

        // fetch this table metadata
        $table_md = $this->fetch_table_metadata($id_table);
        if ($table_md === false) {
            crudder_redirect('crudder/tables_show', Crudderconfig::get_string('cant_access_table_single_record'));
            return false;
        }
        $table_name         = $table_md['name'];
        $table_display_name = $table_md['display_name'];
        
        // check if this table is a metatable and don't have permissions; if true cancel the edition
        if ($table_md['is_metatable'] == 1 && ! $this->check_access(true, false)) {
            $this->crudder_redirect('crudder/tables_show', Crudderconfig::get_string('cant_edit_metatable'));
            return false;
        }
        
        // fetch this table fields metadata
        $fields_md = $this->fetch_fields_metadata($id_table);

        // build table headers
        $headers = $this->build_headers($fields_md);
        
        // build filters sql
        if ($filters_from_post === false) {
            $filters_from_post = $this->build_empty_filters($fields_md);
        }
        $filters_sql = $this->build_filters_sql($fields_md, $filters_from_post);
        
        // fetch maps for dropdowns (foreign keys described in fields metadata)
        $maps = $this->build_fields_values_maps($id_table, $fields_md);
        
        // calculate pagination data
        $pager_data = $this->build_pager_specs($table_md, $pager_page_number, $pager_action, $filters_sql);
        list ($pager_page_number, $pager_total_pages, $pager_starting_record, $pager_page_length, $pager_is_first_page, $pager_is_last_page) = $pager_data;

        // get records data: build html snippets for each record and field
        $records_htmls = $this->build_records_htmls($table_md, $fields_md, $maps, $sort_field_name, $sort_order, $filters_sql, $pager_data, false);
        
        // save vars for next request (same page POST or GET for insert or update)
        $this->session->set_flashdata('crudder_sort_field_name'  , $sort_field_name  );
        $this->session->set_flashdata('crudder_sort_order'       , $sort_order       );
        $this->session->set_flashdata('crudder_pager_page_number', $pager_page_number);
        
        // show view
        $data = array ();
        $data['id_table']              = $id_table;
        $data['read_only']             = $table_md['read_only'];
        $data['table_name']            = $table_name;
        $data['table_display_name']    = $table_display_name;
        $data['headers']               = $headers;
        $data['sort_field_name']       = $sort_field_name;
        $data['sort_order']            = $sort_order;
        $data['filters']               = $filters_from_post;
        $data['records_htmls']         = $records_htmls;
        $data['pager_page_number']     = $pager_page_number;
        $data['pager_total_pages']     = $pager_total_pages;
        $data['pager_is_first_page']   = $pager_is_first_page;
        $data['pager_is_last_page']    = $pager_is_last_page;
        //$data['pager_starting_record'] = $pager_starting_record;
        //$data['pager_page_length']     = $pager_page_length;
        $this->crudder_view('crudder_table_show', $data);
    }
    
    

    /**
     * Shows a specific table (method called from the POST request)
     * 
     * (CRUD generator method)
     * 
     * This method calls the 'table_show' method after processing the POST values
     * 
     * @access	public
     * @return	string  the value returned by table_show method
     */
    public function table_show_post ()
    {
        // access control
        if ($this->check_access() === false) {
            return false;
        }

        // get method parameters directly from POST values (always will be set (maybe by JS))
        $pager_action      = $_POST['crudder_pager_action'];
        $id_table          = $_POST['crudder_id_table'];

        // set values for vars whose session-based values that can be overrided by POST values
        $sort_field_name   = $_POST['crudder_sort_field_name'] != '' ? $_POST['crudder_sort_field_name'] : $this->session->flashdata('crudder_sort_field_name');
        $sort_order        = $_POST['crudder_sort_order'     ] != '' ? $_POST['crudder_sort_order'     ] : $this->session->flashdata('crudder_sort_order'     );
        
        // get session-saved previous method parameters; don't mind if session vars are not set
        $pager_page_number = $this->session->flashdata('crudder_pager_page_number');

        // filters info
        $erase_filters = isset($_POST['crudder_do_filter_reset']);
        $filters       = array ();
        foreach ($_POST as $key => $value) {
            if (substr($key, 0, 15) != 'crudder_filter_') {
                continue;
            }
            $field_name = substr($key, 15);
            $filters[$field_name] = $erase_filters ? '' : $value;
        }
        
        // erase button extra function: reset table ordering (by id)
        if ($erase_filters) {
            list ($sort_field_name, $sort_order) = $this->build_default_sort_specs();
        }
        
        // calls the main table_show method
        return $this->table_show($id_table, $filters, $sort_field_name, $sort_order, $pager_page_number, $pager_action);
    }
    
    

    /**
     * Fetchs and returns the metadata for all tables
     * 
     * (CRUD generator method)
     * 
     * @access	private
     * @return	array   the tables metadata: an array of a metadata definition for each table (each one is an array as returned by the respective SQL query); the array is ordered as specified in the crudder_tables table
     */
    private function fetch_tables_metadata ()
    {
        $query = <<<END
            SELECT *
            FROM `crudder_tables`
            WHERE ignored = 0
            ORDER BY `display_order`, `display_name` ASC;
END;
        $rs = $this->db->query($query);
        $rows = $rs->result_array();
        return $rows;
    }


    
    /**
     * Fetchs and returns a table metadata
     * 
     * (CRUD generator method)
     * 
     * @access	private
     * @param   integer ID of table as in metadata
     * @param   string  optional; if set, use this as selecion criteria instead of id_table
     * @return	array   the table metadata
     */
    private function fetch_table_metadata ($id_table, $table_name = false)
    {
        $where_part = $id_table < 0 ? "`name` = '$table_name'" : "`id` = $id_table" ;
        $query = <<<END
            SELECT *
            FROM `crudder_tables`
            WHERE ignored = 0 AND ($where_part)
            ORDER BY display_order, display_name ASC;
END;
        $rs = $this->db->query($query);
        $table_md_array = $rs->result_array();
        if (count($table_md_array) == 0 || count($table_md_array) > 1) {
            Crudderconfig::log(Crudderconfig::LOG_EXCEPTION, "fetch_table_metadata", "no metadata for table ($id_table, $table_name)");
            return false;
        }
        return $table_md_array[0];
    }


    
    /**
     * Fetchs and returns a fields metadata for a table
     * 
     * (CRUD generator method)
     * 
     * @access	private
     * @param   integer ID of the table as set in metadata
     * @return	array   the fields metadata: an array of metadata for each field, each one being an array containing the parameters of the fields_metadata as extracted from the database using a SQL query
     */
    private function fetch_fields_metadata ($id_table)
    {
        $query = <<<END
            SELECT *
            FROM `crudder_fields`
            WHERE `id_table` = $id_table
              AND `ignored` = 0
            ORDER BY `display_order`, `display_name` ASC;
END;
        $rs = $this->db->query($query);
        $fields_md_array = $rs->result_array();
        $fields_md = $this->array_to_map($fields_md_array, 'name');
        foreach ($fields_md as $name => $field_md) {
            if ($fields_md[$name]['htmlize_field_name'] == 0) {
                $fields_md[$name]['display_name'] = html_escape($fields_md[$name]['display_name']);
            }
        }
        return $fields_md;
    }    

    

    /**
     * Fetchs and returns a record from a table
     * 
     * (CRUD generator method)
     * 
     * If there are multiple records with the same ID (a case that should not happen), the method will return only the first one
     * 
     * @access	private
     * @param   string  table name
     * @param   integer ID of the record
     * @return	array   an array with the values of the record, as returned by the respective SQL query
     */
    private function fetch_table_record ($table_name, $id_record)
    {
        $query = <<<END
            SELECT *
            FROM `$table_name`
            WHERE `id` = $id_record;
END;
        $rs = $this->db->query($query);
        $rows = $rs->result_array();
        if (count($rows) == 0) {
            Crudderconfig::log(Crudderconfig::LOG_EXCEPTION, "fetch_table_record", "no record found ($table_name, $id_record)");
            return false;
        }
        return $rows[0];
    }

            
            
    /**
     * Returns the number of records for the specified table
     * 
     * (CRUD generator method)
     * 
     * @access	private
     * @param   array   table metadata
     * @param   string  previously generated SQL filter for be applied to the WHERE clause of the count
     * @return	integer records count
     */
    private function count_table_records ($table_md, $filters_sql)
    {
        $table_name = $table_md['name'];
        
        // if soft delete, exclude the deleted fields from the records list
        $soft_delete_field = $table_md['soft_delete_field'];
        $where_sql = $soft_delete_field == '' ? $filters_sql : "( $filters_sql ) AND ( `$soft_delete_field` = 0 )";
        
        // do the query and fetch the count of records
        $query = <<<END
            SELECT COUNT(*) AS total
            FROM `$table_name`
            WHERE $where_sql;
END;
        $rs = $this->db->query($query);
        $rows = $rs->result_array();
        
        // return the count of non-deleted rows
        return $rows[0]['total'];
    }
    
    

    /**
     * Builds the headers info (column names and labels) for a table
     * 
     * (CRUD generator method)
     * 
     * @access	private
     * @param   array   fields metadata
     * @param   boolean if true, generates also the headers for secondary fields (those ones that have zero in the "show_first" metadata entry); default to false
     * @param	boolean if true, generates also the headers for fields that have "1" in the "hidden" metadata entry; defaults to false
     * @return	array   an associative array of fields metadata indexed by ID of the field, each one containing a tuple: [ field name, field display name, help text ]
     */
    private function build_headers (& $fields_md, $with_secondary_fields = false, $with_hidden_fields = false)
    {
        $headers = array ();
        foreach ($fields_md as $field_md) {
            if (! $with_secondary_fields && $field_md['show_first'] == 0) {
                continue;
            }
            if (! $with_hidden_fields && $field_md['hidden'] == 1) {
                continue;
            }
            $headers[$field_md['id']] = array ($field_md['name'], $field_md['display_name'], $field_md['hidden'], html_escape($field_md['help_text']));
        }
        return $headers;
    }
    

    /**
     * Builds and returns a filters specification with empty content
     * 
     * (CRUD generator method)
     * 
     * @access	private
     * @param   array   all fields metadata
     * @return	array   an associative array where each element is the name of the field (not the ID) and the content is the empty string
     */
    private function build_empty_filters (& $fields_md)
    {
        $filters = array ();
        foreach ($fields_md as $field_md) {
            if ($field_md['show_first'] == 0 || $field_md['hidden']) {
                continue;
            }
            $filters[$field_md['name']] = '';
        }
        return $filters;
    }
    


    /**
     * Builds and returns a SQL snippets for a WHERE clause, containing all the conditions derivated from filters form fields, as returned by the POST request
     * 
     * (CRUD generator method)
     * 
     * @access	private
     * @param   array   fields metadata
     * @param   array   filters data (as they come from POST or build_empty_filters)
     * @return	string
     */
    private function build_filters_sql (& $fields_md, $filters_from_post)
    {
        $filters_sql = '1=1';
        
        // no filters case
        if ($filters_from_post === false) {
            return $filters_sql;
        }

        // iterates over each field and check for filters
        foreach ($fields_md as $field_md)
        {
            $field_name            = $field_md['name'];
            $field_type            = $field_md['type'];
            $can_be_null           = $field_md['can_be_null'];
            $table_name_for_values = $field_md['table_name_for_values'];
            $map_for_values_idkey  = $field_md['map_for_values_idkey'];
            $map_for_values_label  = $field_md['map_for_values_label'];
            $filter = isset($filters_from_post[$field_name]) ? html_escape($filters_from_post[$field_name]) : '';

            // filter specs are empty, do nothing
            if ($filter == '') {
                continue;
            }
            
            // pattern for the sql filter for this field
            if ($field_md['table_name_for_values'] == '') {
                $field_ref = " AND (`$field_name` ###)";
            } else {
                $field_ref = " AND (`$field_name` IN " . 
                    "(SELECT `$map_for_values_idkey` FROM `$table_name_for_values` WHERE $map_for_values_label ###))";
            }
            
            // fills the variable info in the pattern
            switch ($field_type) {
                case 'INT':
                    if ($filter != '') {
                        $filters_sql .= str_replace('###', "= $filter", $field_ref);
                    }
                    break;
                case 'STRING':
                    if ($filter != '') {
                        $filters_sql .= str_replace('###', "LIKE '%$filter%'", $field_ref);
                    }
                    break;
                case 'TEXT':
                    if ($filter != '') {
                        $filters_sql .= str_replace('###', "LIKE '%$filter%'", $field_ref);
                    }
                    break;
                case 'DATE':
                    if ($filter != '') {
                        $filters_sql .= str_replace('###', "= '$filter'", $field_ref);
                    }
                    break;
                case 'DATETIME':
                    if ($filter != '') {
                        $filters_sql .= str_replace('###', "= '$filter'", $field_ref);
                    }
                    break;
                case 'TIMESTAMP':
                    if ($filter != '') {
                        $filters_sql .= str_replace('###', "= '$filter'", $field_ref);
                    }
                    break;
            }
        }

        return $filters_sql;
    }        

    

    /**
     * Builds and returns default sort specs
     * 
     * (CRUD generator method)
     * 
     * These default values are used when column order specification have not yet been defined in the form that displays the content of a table
     * 
     * @access	private
     * @return	array (each element is a pair: [ field_name = "id", order_spec = "ASC" ])
     */
    private function build_default_sort_specs ()
    {
        return array ('id', 'ASC');
    }

        

    /**
     * Builds maps (as associative arrays) for fields that have external table references (as for dropdown menus) according to fields metadata
     * 
     * (CRUD generator method)
     * 
     * @access	private
     * @param   array   table ID
     * @param   array   fields metadata
     * @param   boolean if true, get metadata only for fields that should be shown in the table-content form (with show_first as "1")
     * @param   array   exactly one individual record that will used for filtering all the values of external tables; useful when implementing cascading menus in the form for editing a single record (see the method build_field_values_map for explanation about how to reflect this behaviour in the metatables)
     * @return	array   an array with the maps (associative arrays) for all the fields (see the method build_field_values_map for explanation about how is used each map)
     */
    private function build_fields_values_maps ($id_table, & $fields_md, $only_for_first_shown_fields = true, $record_data = false)
    {
        $maps = array ();
        
        // iterates over all fields in order to generate maps for all fields with external table info
        foreach ($fields_md as $field_md)
        {
            // do nothing if secondary field and should not show this time
            if ($only_for_first_shown_fields && $field_md['show_first'] == 0) {
                continue;
            }

            // build the map for this field and add this map to all maps
            $map = $this->build_field_values_map($id_table, $field_md, $record_data);
            if ($map !== false) {
                $maps[$field_md['name']] = $map;
            }
        }

        // returns all the maps
        return $maps;
    }

    

    /**
     * Builds the map for a specific field that have external table info according to fields metadata
     * 
     * (CRUD generator method)
     * 
     * A "map" is an associative array; each key (a field of the external table) defines a display name to be shown, normally in a HTML SELECT dropdown menu
     * 
     * According with the actual values of the records, method uses the value of 'where_filter_for_values' metadata field for filtering the values of the generated map; for example, if this field contains "SUBSTR(`code`, 1, 3) = #code_estado#" (belonging to the another other field "code_municipio"), then the map will only contain the records whose "code" field value matchs the three first characters of the "code_estado" field value
     * 
     * Note that the maps generated for all the table rows will be the same, unless the main_table_record is passed as an argument
     * 
     * @access	private
     * @param   integer table ID
     * @param   array   field metadata
     * @param   array   optional record content as returned by the respective SQL query; the generated map will be filtered by the "where_filter_for_values" metadata value, with a previous substitution of the "#{columnname}#"-like substrings with the proper value of the column "{columnname}" for the field whose map is being generated
     * @return	array   the generated map
     */
    private function build_field_values_map ($id_table, $field_md, $main_table_record = false)
    {
        // do nothing if field has not external table info
        if ($field_md['table_name_for_values'] == '' || $field_md['map_for_values_idkey'] == '' || $field_md['map_for_values_label'] == '') {
            return false;
        }

        // prepare building of the query for extracting idkeys and values from the external table
        $can_be_null           = $field_md['can_be_null'];
        $table_name_for_values = $field_md['table_name_for_values'];
        $map_for_values_idkey  = $field_md['map_for_values_idkey'];
        $map_for_values_label  = $field_md['map_for_values_label'];
        
        // pre-treatment of the query WHERE condition
        $where_filter_for_values = $field_md['where_filter_for_values'];
        if ($where_filter_for_values == '' || $main_table_record === false) {
            $where_filter_for_values = '1=1';
        }
        if ($can_be_null == 0) {
            $where_filter_for_values .= " AND `$map_for_values_idkey` IS NOT NULL";
        }

        // special treatment in this case for substituting #main_table_field_name# occurences in the 'where_filter_for_values' by the respective values
        if ($main_table_record !== false) {
            $names = array ();
            while (preg_match('/\#([A-Za-z0-9_]+)\#/', $where_filter_for_values, $names) == 1) {
                $name = $names[1];
                $value = $main_table_record[$name];
                $where_filter_for_values = str_replace("#$name#", "'$value'", $where_filter_for_values);
                $names = array ();
            }
        }
        
        // check in the external table if should avoid showing soft deleted records; if true then modify the where clause
        $table_for_values_md = $this->fetch_table_metadata(-1, $table_name_for_values);
        if ($table_for_values_md === false) {
            Crudderconfig::log(Crudderconfig::LOG_EXCEPTION, "build_field_values_map", "cant access single map value ($map_for_values_label)");
            $this->crudder_redirect('crudder/tables_show', Crudderconfig::get_string('cant_access_single_map_value', true, $map_for_values_label));
            return false;
        }
        $soft_delete_field = $table_for_values_md['soft_delete_field'];
        if ($soft_delete_field != '') {
            $where_filter_for_values = "( $where_filter_for_values ) AND ( `$soft_delete_field` = 0 )";
        }

        // finish building the query and executes it
        list ($default_sort_field_name, $default_sort_order) = $this->build_default_sort_specs();
        $order_field_for_values = $field_md['order_field_for_values'];
        $sort_order             = $default_sort_order;
        if ($order_field_for_values == '') {
            $order_criteria_for_values = "`$default_sort_field_name` $default_sort_order";
        } else {
            $order_criteria_for_values = "`$order_field_for_values` $sort_order";
        }
        $query = <<<END
            SELECT `$map_for_values_idkey` AS idkey, $map_for_values_label AS label
            FROM `$table_name_for_values`
            WHERE $where_filter_for_values
            ORDER BY $order_criteria_for_values;
END;
        $rs = $this->db->query($query);
        $map_array = $rs->result_array();
        $map = $this->array_to_map($map_array, 'idkey', 'label');
        foreach ($map as $idkey => $label) {
            $map[$idkey] = html_escape($label);
        }
        
        // returns the map
        return $map;
    }

    

    /**
     * Builds the pager specifications according to the previous HTML form content display (initial and ending row) and the choosen pager action
     * 
     * (CRUD generator method)
     * 
     * @access	private
     * @param   array   table metadata
     * @param   integer current page number
     * @param   integer page action (-1 | 0 | +1)
     * @param   string  previously generated (by other method) filter for the WHERE SQL clause
     * @return	array   a tuple containing: [ page number, total of pages, starting record, page length, is first page (boolean), is last page (boolean) ]
     */
    private function build_pager_specs ($table_md, $pager_page_number, $pager_action, $filters_sql)
    {
        $pager_records_count = $this->count_table_records($table_md, $filters_sql);
        $pager_total_pages   = ceil($pager_records_count / Crudderconfig::PAGER_LENGTH);
        if ($pager_total_pages == 0) {
            $pager_total_pages++;
        }
        $pager_page_number += $pager_action;
        if ($pager_page_number < 1) {
            $pager_page_number = 1;
        }
        if ($pager_page_number > $pager_total_pages) {
            $pager_page_number = $pager_total_pages;
        }
        $pager_is_first_page = $pager_page_number == 1;
        $pager_is_last_page  = $pager_page_number == $pager_total_pages;
        $pager_starting_record = ($pager_page_number - 1) * Crudderconfig::PAGER_LENGTH;
        $pager_data = array ($pager_page_number, $pager_total_pages, $pager_starting_record, Crudderconfig::PAGER_LENGTH, $pager_is_first_page, $pager_is_last_page);
        return $pager_data;
    }



    /**
     * Builds and returns a HTML snippets for all the records that will be shown
     * 
     * (CRUD generator method)
     * 
     * @access	private
     * @param   array   table metadata
     * @param   array   fields metadata
     * @param   array   maps for all fields with external table info (array of each field map)
     * @param   string  sorting field name; defaults to "id" (see build_default_sort_specs method)
     * @param   string  sorting order (ASC | DESC) (see build_default_sort_specs method)
     * @param   string  previously generated (by other method) filter for the WHERE SQL clause
     * @param   array   pager data as generated by build_pager_specs; must be passed (not optional)
     * @param   boolean (experimental) if true, make every not-read-only field editable; else (default) as not editable
     * @return	array   an associative array with row_id as the key and another associative array as the value; this value has the form [ "field_name" -> "generated-html" ]
     */
    private function build_records_htmls ($table_md, & $fields_md, & $maps, $sort_field_name = false, $sort_order = false,
                                          $filters_sql = '1=1', $pager_data = false, $editable = false)
    {
        $table_name = $table_md['name'];
        if ($sort_field_name === false) {
            list ($sort_field_name, $sort_order) = $this->build_default_sort_specs();
        }
        list ($pager_page_number, $pager_total_pages, $pager_starting_record, $pager_page_length, $pager_is_first_page, $pager_is_last_page) = $pager_data;

        // if soft delete, exclude the deleted fields from the records list
        $soft_delete_field = $table_md['soft_delete_field'];
        $where_sql = $soft_delete_field == '' ? $filters_sql : "( $filters_sql ) AND ( `$soft_delete_field` = 0 )";
        
        // get the records to be formatted and shown
        $query = <<<END
            SELECT *
            FROM `$table_name`
            WHERE $where_sql 
            ORDER BY $sort_field_name $sort_order
            LIMIT $pager_starting_record, $pager_page_length;
END;
        $rs = $this->db->query($query);
        $records = $rs->result_array();

        // generate the snippets for the records; iterate over them
        $records_htmls = array ();
        foreach ($records as $record)
        {
            // iterate over all fields for this record and generate the snippets
            $record_htmls = array ();
            foreach ($fields_md as $field_md)
            {
                if ($field_md['show_first'] == 0 || $field_md['hidden'] == 1) {
                    continue;
                }
                $snippet_pair = $editable ?
                    $this->build_editable_html_snippet($record, $field_md, $maps) :
                    $this->build_static_html_snippet($record, $field_md, $maps);
                $snippet = $snippet_pair[0];
                $field_name = $field_md['name'];
                $record_htmls[$field_name] = $snippet;
            }
            
            // add to all records snippets
            $records_htmls[] = array ($record['id'], $record_htmls);
        }
        
        // return the array of arrays
        return $records_htmls;
    }
    
    
    
    /**
     * Builds an editable HTML snippets for a record
     *
     * (CRUD generator method)
     * 
     * @access	private
     * @param   array   table metadata
     * @param   array   fields metadata
     * @param   array   headers for columns as generated by build_headers
     * @param   array   maps (an array of associative arrays) with values for each field with external table info according to metadata
     * @param   array   record values for each field (a row as returned by a PHP query)
     * @param   boolean if true, this is a secondary insert (an insert of a "table_2" record that has the values of a dropdown field of a primary record of "table 1"; with this feature a new record for a dropdown menu can be easily generated without abandoning the first insert/update form); defaults to false
     * @return	array   an associative array whose key is a field name and the value is an array with a pair containing: [ HTML snippet, extra HTML ]; these values are generated according with the type of each field
     */
    private function build_record_htmls ($table_md, & $fields_md, $headers, & $maps, & $record_data, $secondary_insert = false)
    {
        $id_table   = $table_md['id'];
        $table_name = $table_md['name'];
        
        // inserting, or updating with re-post of the form due to validation errors
        if ($record_data !== false) {   
            $record = $record_data;
        }
        
        // updating when edition form is called the first time
        else {                 
            $record = $this->fetch_table_record($table_name, $id_record);
        }
        
        // generate the snippets
        $record_htmls = array ();
        foreach ($fields_md as $field_md) {
            $snippet_pair = $this->build_editable_html_snippet($record, $field_md, $maps, true, $secondary_insert === false ? $id_table : false);
            $field_name = $field_md['name'];
            $record_htmls[$field_name] = $snippet_pair;
        }
        
        // return the snippets
        return $record_htmls;
    }
    
    

    /**
     * Builds a static (not editable) HTML snippet for the specified field
     * 
     * (CRUD generator method)
     * 
     * @access	private
     * @param   array   record as extracted from the database using PHP functions
     * @param   array   field metadata (indicates the field to be rendered)
     * @param   array   maps for all fields with external table info (array of maps; each one is an associative array)
     * @return	array   an array with a 2-tuple containing the HTML snippet and an extra HTML; these values are generated according with the type of the field
     */
    private function build_static_html_snippet (& $record, & $field_md, & $maps)
    {
        $name        = $field_md['name'];
        $can_be_null = $field_md['can_be_null'];
        $value       = ! isset($record[$name]) && $can_be_null ? Crudderconfig::NULL_VALUE : ( ! isset($record[$name]) ? false : $record[$name] );
        $type        = $field_md['type'];
        $htmlize     = $field_md['htmlize_values'];
        $read_only   = $field_md['read_only'];
        $hidden      = $field_md['hidden'] || $name == 'id' && $value == -1;   // inserting
        
        // return if the field is defined in the metadata but the database column doesn't exist
        if ($value === false) {
            return array ('', '');
        }
        
        // if must be shown in html, let be free; if not, escape html entities
        if ($htmlize == 0) {
            $value = html_escape($value);
        }
        
        // build the snippet
        $dropdown = $field_md['table_name_for_values'] != '' && $field_md['map_for_values_idkey'] != '' && $field_md['map_for_values_label'] != '';
        switch ($type) {
            case 'INT':
                $html = $dropdown ? $this->build_fixed_value_html($maps[$name], $value) : $value;
                break;
            case 'STRING':
                $html = $dropdown ? $this->build_fixed_value_html($maps[$name], $value) : $value;
                break;
            case 'TEXT':
                $html = $value;
                break;
            case 'DATE':
                $html = $value;
                break;
            case 'DATETIME':
                $html = $value;
                break;
            case 'TIMESTAMP':
                $html = $value;
                break;
            default:
                Crudderconfig::log(Crudderconfig::LOG_WARNING, "build_static_html_snippet", "invalid type ($type)");
                $html = "(Crudder: invalid type: $type)";
        }
        $prefix       = $this->configurator->get_snippet('STATIC', 'prefix', false);
        $posfix       = $this->configurator->get_snippet('STATIC', 'posfix', false);
        $html         = $prefix . $html . $posfix;
        $hidden_field = "<INPUT TYPE=\"hidden\" NAME=\"$name\" VALUE=\"$value\" />";
        
        // returns the snippet with an extra form hidden field for preserving the value between form consecutive displays
        return $hidden ? array ($hidden_field, '') : array ($html, $hidden_field);
    }
    
    

    /**
     * Builds an editable HTML snippet for the specified field
     * 
     * (CRUD generator method)
     * 
     * @access	private
     * @param   array   record as extracted from the database
     * @param   array   field metadata (for the field to be rendered)
     * @param   array   an array of maps (associative arrays) for all fields with external table info (only one of the map will be used: the one for the field to be rendered)
     * @param   boolean (experimental) if true, a read-only field will be rendered as a non-editable snippet; those and hidden fields will get extra html for hidden form fields; defaults to true
     * @param   mixed   if false, this form belongs to a secondary table and the field won't have the "+" link (as defined by the view) for calling again a secondary insert form; else (when not false) this must be set to the ID of the initial table whose full record is being edited (in order to go back to the primary insert/update form); defaults to false
     * @return	arra    an array with a pair containing the HTML snippet and an extra HTML; these values are generated according to the type of the field
     */
    private function build_editable_html_snippet (& $record, & $field_md, & $maps, $read_only_and_hidden_non_editable = true, $id_first_table = false)
    {
        $id                = $field_md['id'];
        $name              = $field_md['name'];
        $can_be_null       = $field_md['can_be_null'];
        $value             = ! isset($record[$name]) && $can_be_null ? Crudderconfig::NULL_VALUE : ( ! isset($record[$name]) ? false : html_escape($record[$name]) );
        $type              = $field_md['type'];
        $read_only         = $field_md['read_only'];
        $hidden            = $field_md['hidden'] || $name == 'id' && $value == -1;   // inserting
        $table_for_values  = $field_md['table_name_for_values'];
        $dropdown          = $table_for_values != '' && $field_md['map_for_values_idkey'] != '' && $field_md['map_for_values_label'] != '';
        
        // return if the field is defined in the metadata but the database column doesn't exist
        if ($value === false) {
            return array ('', '');
        }
        
        // get static snippets; if read only and should be generated as static, return the static snippets
        list ($static_html, $static_extra_html) = $this->build_static_html_snippet($record, $field_md, $maps);
        if ($read_only_and_hidden_non_editable && ($read_only || $hidden)) {
            return array ($static_html, $static_extra_html);
        }
        
        // fetch the secondary table id (if dropdown) so the link can navigate to the second insert form
        $plus_sign_html = $this->configurator->get_snippet('EDITABLE', 'insert_secondary_plus_sign');
        if ($dropdown && $id_first_table !== false)
        {
            $secondary_table_md = $this->fetch_table_metadata(-1, $table_for_values);
            if ($secondary_table_md === false) {
                Crudderconfig::log(Crudderconfig::LOG_EXCEPTION, "build_editable_html_snippet", "cant access single secondary table value ($table_for_values)");
                $this->crudder_redirect('crudder/tables_show', Crudderconfig::get_string('cant_access_single_secondary_table_value', true, $table_for_values));
                return false;
            }
            $id_secondary_table = $secondary_table_md['id'];
            if ($secondary_table_md['read_only'] == 1) {
                $extra_plus_link = "";
            } else {
                $extra_plus_link = anchor("crudder/record_insert_secondary/$id_secondary_table", $plus_sign_html);
            }
        } else {
            $extra_plus_link = "";
        }

        // if this field can have nulls and not a dropdown, generate the proper link
        $nullify_html = $this->configurator->get_snippet('EDITABLE', 'nullify_field_sign');
        if (! $dropdown && $can_be_null) {
            $extra_nullify_link = anchor("#", $nullify_html, "onClick=\"document.forms[0].$name.value='" . Crudderconfig::NULL_VALUE . "'; return false;\"");
        } else {
            $extra_nullify_link = "";
        }
        
        // build the snippets
        $null_spec     = $can_be_null == 1 ? array ( Crudderconfig::NULL_VALUE, $this->configurator->get_snippet('EDITABLE', 'assign_null_value', false) ) : false;
        $should_reload = $field_md['on_change'] == 'reload';
        $onClick       = $should_reload ? "onClick=\"document.forms[0].crudder_action.value='cascading.$name.'+document.forms[0].$name.value+''; document.forms[0].submit()\" " : ' ';
        switch ($type) {
            case 'INT':
                if ($dropdown) {
                    $html = $this->build_dropdown_html($maps[$name], $name, $onClick . $this->configurator->get_snippet('EDITABLE', 'select_options', false), $this->configurator->get_snippet('EDITABLE', 'select_options_options', false), $value, $null_spec) . $extra_plus_link;
                } else {
                    $html = "<INPUT TYPE=\"number\" NAME=\"$name\" VALUE=\"$value\" SIZE=\"" . $this->configurator->get_snippet('EDITABLE', 'int_size', false) . "\" " . $this->configurator->get_snippet('EDITABLE', 'int_options', false) . " />\n" . $extra_nullify_link . "\n";
                }
                break;
            case 'STRING':
                if ($dropdown) {
                    $html = $this->build_dropdown_html($maps[$name], $name, $onClick . $this->configurator->get_snippet('EDITABLE', 'select_options', false), $this->configurator->get_snippet('EDITABLE', 'select_options_options', false), $value, $null_spec) . $extra_plus_link;
                } else {
                    $html = "<INPUT TYPE=\"text\" NAME=\"$name\" VALUE=\"$value\" SIZE=\"" . $this->configurator->get_snippet('EDITABLE', 'string_size', false) . "\" " . $this->configurator->get_snippet('EDITABLE', 'string_options', false) . " />\n" . $extra_nullify_link . "\n";
                }
                break;
            case 'TEXT':
                $html = "<TEXTAREA NAME=\"$name\" COLS=\"" . $this->configurator->get_snippet('EDITABLE', 'text_cols') . "\" ROWS=\"" . $this->configurator->get_snippet('EDITABLE', 'text_rows') . "\" " . $this->configurator->get_snippet('EDITABLE', 'text_options', false) . "\" >$value</TEXTAREA>\n" . $extra_nullify_link . "\n";
                break;
            case 'DATE':
                $html = "<INPUT TYPE=\"date\" NAME=\"$name\" VALUE=\"$value\" SIZE=\"" . $this->configurator->get_snippet('EDITABLE', 'date_size') . "\" " . $this->configurator->get_snippet('EDITABLE', 'date_options', false) . " />\n" . $extra_nullify_link . "\n";
                /*
                // trying to use bootstrap-datetimepicker.js - http://www.eyecon.ro/bootstrap-datepicker - doesn't works with bootstrap 3.0 series
                if (Crudderconfig::DEFAULT_PAGES_SET == 'BOOTSTRAPPED') {
                    $dateformat = $this->configurator->get_snippet('EDITABLE', 'date_format');
                    $date = $this->configurator->locale_datetime($value);
                    $domID = 'date_' . $name . "_" . $id;
                    $html  = '<div id="' . $domID . '" class="input-append date">';
                    //$html .= '<input data-format="' . $dateformat . '" type="text" ' . "NAME=\"$name\" VALUE=\"$date\" SIZE=\"" . $this->configurator->get_snippet('EDITABLE', 'date_size') . "\" " . $this->configurator->get_snippet('EDITABLE', 'date_options', false) . " /></input>\n" . $extra_nullify_link . "\n";
                    $html .= '<input data-format="' . $dateformat . '" type="text" ' . "NAME=\"$name\" VALUE=\"$date\" />\n";
                    $html .= '<span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>';
                    $html .= "</div>\n";
                    $html .= '<script type="text/javascript">' . "\n";
                    $html .= "$(function() { $('#" . $domID . "').datetimepicker( { language: 'pt-BR' } ); } ); " . "\n";
                    $html .= "</script>\n";
                } else {
                    $html = "<INPUT TYPE=\"date\" NAME=\"$name\" VALUE=\"$value\" SIZE=\"" . $this->configurator->get_snippet('EDITABLE', 'date_size') . "\" " . $this->configurator->get_snippet('EDITABLE', 'date_options', false) . " />\n" . $extra_nullify_link . "\n";
                }
                */
                break;
            case 'DATETIME':
                $html = "<INPUT TYPE=\"datetime\" NAME=\"$name\" VALUE=\"$value\" SIZE=\"" . $this->configurator->get_snippet('EDITABLE', 'datetime_size') . "\" " . $this->configurator->get_snippet('EDITABLE', 'datetime_options', false) . " />\n" . $extra_nullify_link . "\n";
                break;
            case 'TIMESTAMP':
                $html = "<INPUT TYPE=\"text\" NAME=\"$name\" VALUE=\"$value\" SIZE=\"" . $this->configurator->get_snippet('EDITABLE', 'timestamp_size') . "\" " . $this->configurator->get_snippet('EDITABLE', 'timestamp_options', false) . " />\n" . $extra_nullify_link . "\n";
                break;
            default:
                Crudderconfig::log(Crudderconfig::LOG_WARNING, "build_editable_html_snippet", "invalid type ($type, $table_for_values)");
                $html = "(Crudder: invalid type: $type)";
        }
        $prefix = $this->configurator->get_snippet('EDITABLE', 'prefix', false);
        $posfix = $this->configurator->get_snippet('EDITABLE', 'posfix', false);
        $html = $prefix . $html . $posfix;
        
        // returns the html snippet with no extra form info
        return array ($html, '');
    }

    

    /**
     * Returns the map value for an idkey, belonging to the map (associative array) that is being passed as argument
     * 
     * (CRUD generator method)
     * 
     * @access	private
     * @param   array   map for this field (if it has external table info)
     * @param   string  idkey of the field
     * @return	string  HTML snippet (or the empty string if idkey is not found in the map)
     */
    private function build_fixed_value_html (& $map, $idkey)
    {
        if ($idkey == Crudderconfig::NULL_VALUE) {   // maps don't contain this value
            return Crudderconfig::NULL_VALUE;
        } else {
            return isset($map[$idkey]) ? html_escape($map[$idkey]) : '';
        }
    }
    
    

    /**
     * Returns a dropdown HTML snippet (SELECT) for an (optional) idkey
     * 
     * (CRUD generator method)
     * 
     * @access	private
     * @param   array   map (associative array) base for this field
     * @param   array   SELECT HTML name
     * @param   array   SELECT HTML attibutes
     * @param   array   OPTION HTML attributes
     * @param   string  optional idkey of the field to be used as SELECTED; defaults to none (false)
     * @param   mixed   (optional) if not false, this pair [ idkey, value ] is intended for including an extra value, for example, for NULL field indication, rendered at top of the list; defaults to false
     * @return	string  the generated HTML snippet
     */
    private function build_dropdown_html ($map, $select_name, $select_attribs, $option_attribs, $default_idkey = false, $can_be_null = false)
    {
        // optionally prepends the pair for NULL values (or other uses)
        if ($can_be_null !== false) {
            list ($idkey, $name) = $can_be_null;
            $map = array_reverse($map, true); 
            $map[$idkey] = html_escape($name); 
            $map = array_reverse($map, true);
        }

        // if the map is empty, adds an element; if there is not a value in the SELECT, the POST request doesn't pass the field to the next method
        if (count($map) == 0) {
            $map['-1'] = html_escape($this->configurator->get_snippet('EDITABLE', 'select_one_from_list'));

        }
        
        // builds ans returns the dropdown field
        $html = "<SELECT NAME=\"" . $select_name . "\" $select_attribs >\n";
        foreach ($map as $idkey => $name) {
            $selected = ($idkey == $default_idkey ? 'SELECTED="SELECTED"' : '');
            $html .= "<OPTION VALUE=\"" . html_escape($idkey) . "\" $selected $option_attribs>" . html_escape($name) . "</OPTION>\n";
        }
        $html .= "</SELECT>" . "\n";
        return $html;
    }
    
    

    /**
     * Generates an associative array with default values for all fields of a record
     * 
     * (CRUD generator method)
     * 
     * @access	private
     * @param   integer ID of the table according to metadata
     * @return	void
     */
    private function build_empty_record ($id_table)
    {
        $fields_md = $this->fetch_fields_metadata($id_table);
        $new_record_data = array ();
        foreach ($fields_md as $field_md) {
            $name = $field_md['name'];
            $type = $field_md['type'];
            switch ($type) {
                case 'INT':
                    $value = $name == 'id' ? -1 : Crudderconfig::get_default_type_value($type);
                    break;
                default:
                    $value = Crudderconfig::get_default_type_value($type);
            }
            $new_record_data[$name] = $value;
        }
        return $new_record_data;
    }
    
    

    /**
     * Shows an empty-values form for inserting a new record in the table
     * 
     * (CRUD generator method)
     * 
     * Calls record_edit method
     * 
     * @access	public
     * @param   integer ID of the table according to metadata
     * @param   mixed   associative array of metadata idkeys and values used for fields population; useful when the previous submit of the same form has validation errors; defaults to false
     * @param   boolean true if this is an insert for a secondary table; defaults to false
     * @return	void
     */
    public function record_insert ($id_table, $old_values = false, $secondary_insert = false)
    {
        // access control
        if ($this->check_access() === false) {
            return false;
        }

        $new_record_data = $old_values == false ? $this->build_empty_record($id_table) : $old_values;
        return $this->record_edit($id_table, false, $new_record_data, $secondary_insert);
    }

    

    /**
     * Shows an empty-values form for inserting a new record into a secondary table
     * 
     * (CRUD generator method)
     * 
     * This method is called from another insert or update form, and allows the insertion of a new record into a dropdown menu field
     * 
     * Calls record_insert method
     * 
     * @access	public
     * @param   integer ID of the table according to metadata
     * @param   array   optional associativa array of values for fields population; useful when the previous submit has validation errors
     * @return	void
     */
    public function record_insert_secondary ($id_table, $old_values = false)
    {
        // access control
        if ($this->check_access() === false) {
            return false;
        }

        $new_record_data = $old_values == false ? $this->build_empty_record($id_table) : $old_values;
        return $this->record_insert($id_table, $old_values, $new_record_data, true);
    }

    

    /**
     * Shows an filled-values form for updating an existing record in the table
     * 
     * (CRUD generator method)
     * 
     * This is a wrapper for the 'record_edit' method
     * 
     * @access	public
     * @param   integer ID of the table according to metadata
     * @param   integer ID of the record to be fetched the for current values
     * @param   mixed   associative array of values for fields population; useful when the previous form submit has validation errors; defaults to false
     * @return	void
     */
    public function record_update ($id_table, $id_record, $old_values = false)
    {
        // access control
        if ($this->check_access() === false) {
            return false;
        }
        
        return $this->record_edit($id_table, $id_record, $old_values);
    }

    

    /**
     * Generates the form that is used for record insertion or updating
     * 
     * This method is called from the methods: insert, insert_secondary and record_update
     * 
     * This method is "reentrant", in the sense that can also be called preserving the current values of the previous view, in case of validation errors of that
     * 
     * @access	private
     * @param   integer ID of the table according to metadata
     * @param   mixed   ID of the record to be edited; use false (default) for inserting
     * @param   mixed   array with the previous record values; use for overriding table values when showing again the form after a non-success fields validation; defaults to false
     * @param   boolean if true, it is assumed that the operation is an insert of a new record of a secondary table (a sub-operation of the main record edition); for example, for adding a value to a dropdown menu; defaults to false
     * @return	void
     */
    private function record_edit ($id_table, $id_record = false, $record_data = false, $secondary_insert = false)
    {
        // repair id_record when it comes from a GET request
        if ($id_record < 0 || $id_record == '') {
            $id_record = false;
        }
        
        // fetch this table metadata
        $table_md = $this->fetch_table_metadata($id_table);
        if ($table_md === false) {
            Crudderconfig::log(Crudderconfig::LOG_EXCEPTION, "record_edit", "cant access table single record ($id_table, $id_record)");
            $this->crudder_redirect("crudder/table_show/$id_table", Crudderconfig::get_string('cant_access_table_single_record'));
            return false;
        }
        $table_name         = $table_md['name'];
        $table_display_name = $table_md['display_name'];
        
        // check if this table is a metatable; if true and no privileges cancel the edition
        if ($table_md['is_metatable'] == 1 && ! $this->check_access(true, false)) {
            Crudderconfig::log(Crudderconfig::LOG_EXCEPTION, "record_edit", "trying to modify metatable with insufficient privileges ($table_name)");
            $this->crudder_redirect("crudder/table_show/$id_table", Crudderconfig::get_string('cant_modify_metatables'));
            return false;
        }
        
        // check if trying to modify a read-only table
        if ($table_md['read_only'] == 1) {
            Crudderconfig::log(Crudderconfig::LOG_EXCEPTION, "record_edit", "trying to modify a read-only table ($table_name)");
            $this->crudder_redirect("crudder/table_show/$id_table", Crudderconfig::get_string('cant_modify_read_only_table'));
            return false;
        }

        // fetch this table fields metadata
        $fields_md = $this->fetch_fields_metadata($id_table);
        
        // build table headers (to be used as fields labels in the first column of the table)
        $headers = $this->build_headers($fields_md, true, true);
        
        // fetch the record, if not in the arguments
        if ($record_data === false) {
            $record_data = $this->fetch_table_record($table_name, $id_record);
        }

        // make all read-only fields editable, when inserting a record
        if ($id_record === false) {
            foreach ($fields_md as $key => $field_md) {
                $fields_md[$key]['read_only'] = 0;
            }
        }            
        
        // fetch maps for dropdowns (foreign keys described in fields metadata)
        $maps = $this->build_fields_values_maps($id_table, $fields_md, false, $record_data);
        
        // get records data: build html snippets for each field
        $record_htmls = $this->build_record_htmls($table_md, $fields_md, $headers, $maps, $record_data, $secondary_insert);
        
        // save session vars for the next POST or GET request (these come from the form content display)
        $this->session->keep_flashdata('crudder_sort_field_name'  );
        $this->session->keep_flashdata('crudder_sort_order'       );
        $this->session->keep_flashdata('crudder_pager_page_number');

        // fix back id_record format
        if ($id_record === false) {
            $id_record = -1;
        }
        
        // save session vars that are needed for coming back from a secondary table record insert
        if (! $secondary_insert) {
            $this->session->set_flashdata("crudder_id_first_table" , $id_table);
            $this->session->set_flashdata("crudder_id_first_record", $id_record);
            $id_first_table  = $id_table;
            $id_first_record = $id_record;
        } else {
            $id_first_table  = $this->session->flashdata("crudder_id_first_table");
            $id_first_record = $this->session->flashdata("crudder_id_first_record");
            $this->session->keep_flashdata("crudder_id_first_table" );
            $this->session->keep_flashdata("crudder_id_first_record");
        }

        // show view
        $data = array ();
        $data['id_table']           = $id_table;
        $data['id_record']          = $id_record === false ? -1 : $id_record;
        $data['table_name']         = $table_name;
        $data['table_display_name'] = $table_display_name;
        $data['headers']            = $headers;
        $data['record_htmls']       = $record_htmls;
        $data['secondary_insert']   = $secondary_insert;
        $data['id_first_table']     = $id_first_table;
        $data['id_first_record']    = $id_first_record;
        $data['form_action']        = $id_record !== -1 ? 'update' : ($secondary_insert ? 'insert_secondary' : 'insert');
        $this->crudder_view('crudder_record_edit', $data);
    }
    
    

    /**
     * POST target method for record updating (only in case of a primary table)
     * 
     * (CRUD generator method)
     * 
     * This method incorporates a special logic for implementing cascading menus; it doesn't use AJAX but the result will almost the same
     * 
     * @access	public
     * @return	void
     */
    public function record_edit_update ()
    {
        // access control
        if ($this->check_access() === false) {
            return false;
        }

        $id_table   = $_POST['crudder_id_table'];
        $table_name = $_POST['crudder_table_name'];
        $id_record  = $_POST['crudder_id_record'];
        $action     = $_POST['crudder_action'];
        
        // fetch this table metadata
        $table_md = $this->fetch_table_metadata($id_table);
        if ($table_md === false) {
            Crudderconfig::log(Crudderconfig::LOG_EXCEPTION, "record_edit_update", "cant access table single record ($table_name, $id_record)");
            $this->crudder_redirect("crudder/table_show/$id_table", Crudderconfig::get_string('cant_access_table_single_record'));
            return false;
        }
        
        // check if this table is a metatable; if true cancel the edition
        if ($table_md['is_metatable'] == 1 && ! $this->check_access(true, false)) {
            Crudderconfig::log(Crudderconfig::LOG_EXCEPTION, "record_edit_update", "trying to modify metatable with insufficient privileges ($table_name)");
            $this->crudder_redirect("crudder/table_show/$id_table", Crudderconfig::get_string('cant_modify_metatables'));
            return false;
        }
        
        // fetch this table fields metadata
        $fields_md = $this->fetch_fields_metadata($id_table);
        
        // logic for cascading menus; the action for the HTML form was changed via JS in the build_editable_html_snippet
        if (substr($action, 0, 9) == 'cascading') {
            list ($bar, $id_field, $value) = explode('.', $action, 3);
            $field_md = $fields_md[$id_field];
            $field_name = $field_md['name'];
            $id_record = $_POST['crudder_id_record'] == '' || $_POST['crudder_id_record'] <= 0 ? false : $_POST['crudder_id_record'];
            $_POST[$field_name] = $value;
            return $this->record_edit($id_table, $id_record, $_POST);
        }

        // validate fields according with metadata specification
        list ($ok, $chainable_old_values) = $this->validate_record_content($fields_md);
        if ($ok !== true)
        {
            // TIP: look the record_edit_insert method for an (inactive) alternative semantics
            return $this->record_update($id_table, $id_record, $chainable_old_values);
        }

        // build sql part for sql
        $update_sql_parts_array = array();
        foreach ($fields_md as $field_md) {
            $field_name  = $field_md['name'];
            $can_be_null = $field_md['can_be_null'];
            if ($field_md['read_only'] || $field_md['hidden'] || $field_name == 'id') {
                continue;
            }
            $value = $chainable_old_values[$field_name];
            $value = ($value == Crudderconfig::NULL_VALUE && $can_be_null == 1) ? 'NULL' : "" . $this->db->escape($value) . "";
            $update_sql_parts_array[] = "`$field_name` = " . $value;
        }
        $update_sql_parts = implode(', ', $update_sql_parts_array);
        
        // do the database updating
        if (count($update_sql_parts_array) != 0) {
            $query = <<<END
                UPDATE `$table_name`
                SET $update_sql_parts
                WHERE `id` = $id_record;
END;
            $rs = $this->db->query($query);
            Crudderconfig::log(Crudderconfig::LOG_NOTICE, "record_edit_update", "database update complete ($table_name, $id_record)");
        }

        // save session vars for the next POST or GET request
        $this->session->keep_flashdata('crudder_sort_field_name'  );
        $this->session->keep_flashdata('crudder_sort_order'       );
        $this->session->keep_flashdata('crudder_pager_page_number');

        // redirects to table content display
        $this->crudder_redirect("crudder/table_show/$id_table", Crudderconfig::get_string('record_updated'));
    }


    
    /**
     * POST request processing method for inserting a record in a main or secondary table
     * 
     * (CRUD generator method)
     * 
     * This method is not invoked directly from any HTML form, but from others methods of this class
     * 
     * "Secondary table" here (and in the whole Crudder) means that the operation is called from an edit view of a record belonging to another table, allowing, when in the first view, the rapid population of values that are not currently present in the secondary table
     * 
     * This method incorporates a special logic for implementing cascading menus; it doesn't use AJAX but the result will almost the same
     * 
     * @access	public
     * @param 	boolean if true, this form corresponds to a secondary table insert; defaults to false
     * @return	void
     */
    public function record_edit_insert ($secondary_insert = false)
    {
        // access control
        if ($this->check_access() === false) {
            return false;
        }

        // vars
        $id_table   = $_POST['crudder_id_table'];
        $table_name = $_POST['crudder_table_name'];
        $id_record  = $_POST['crudder_id_record'];
        $action     = $_POST['crudder_action'];

        // fetch this table metadata
        $table_md = $this->fetch_table_metadata($id_table);
        if ($table_md === false) {
            Crudderconfig::log(Crudderconfig::LOG_EXCEPTION, "record_edit_insert", "cant access table single record ($table_name, $id_record)");
            $this->crudder_redirect("crudder/table_show/$id_table", Crudderconfig::get_string('cant_access_table_single_record'));
            return false;
        }
        
        // check if this table is a metatable; if true cancel the edition
        if ($table_md['is_metatable'] == 1 && ! $this->check_access(true, false)) {
            Crudderconfig::log(Crudderconfig::LOG_EXCEPTION, "record_edit_insert", "trying to modify metatable with insufficient privileges ($table_name)");
            $this->crudder_redirect("crudder/table_show/$id_table", Crudderconfig::get_string('cant_modify_metatables'));
            return false;
        }
        
        // fetch this table fields metadata
        $fields_md = $this->fetch_fields_metadata($id_table);

        // logic for cascading menus; the action for the HTML form was changed via JS in the build_editable_html_snippet
        if (substr($action, 0, 9) == 'cascading') {
            list ($bar, $id_field, $value) = explode('.', $action, 3);
            $field_md = $fields_md[$id_field];
            $field_name = $field_md['name'];
            $id_record = $_POST['crudder_id_record'] == '' || $_POST['crudder_id_record'] <= 0 ? false : $_POST['crudder_id_record'];
            $_POST[$field_name] = $value;
            return $this->record_edit($id_table, $id_record, $_POST);
        }

        // validate fields according with metadata specification
        list ($ok, $chainable_old_values) = $this->validate_record_content($fields_md);
        if ($ok !== true)
        {
            // alternative semantics (inactive)
            /*
            // preserve the hidden 'crudder_old_*' values from the POST request and show them in the next page
            foreach ($_POST as $key => $value) {
                if (substr($key, 0, 13) != 'crudder_orig_' || $value == '') {
                    continue;
                }
                $field_name = substr($key, 13);
                $validation_ok_or_old_values[$field_name] = $value;
            }
            */
            // redisplay the record edit form
            return $this->record_insert($id_table, $chainable_old_values, $secondary_insert);
        }
        
        // build sql part for sql
        $insert_sql_fields_parts_array = array();
        $insert_sql_values_parts_array = array();
        foreach ($fields_md as $field_md) {
            $field_name  = $field_md['name'];
            $can_be_null = $field_md['can_be_null'];
            if ($field_md['read_only'] || $field_md['hidden'] || $field_name == 'id') {
                continue;
            }
            $value = $chainable_old_values[$field_name];
            $value = ($value == Crudderconfig::NULL_VALUE && $can_be_null == 1) ? 'NULL' : "" . $this->db->escape($value) . "";
            $insert_sql_fields_parts_array[] = "`$field_name`";
            $insert_sql_values_parts_array[] = $value;
        }
        $insert_sql_fields_parts = implode(', ', $insert_sql_fields_parts_array);
        $insert_sql_values_parts = implode(', ', $insert_sql_values_parts_array);
        
        // do the database inserting
        if (count($insert_sql_fields_parts_array) != 0) {
            $query = <<<END
                INSERT INTO $table_name
                ( $insert_sql_fields_parts )
                VALUES ( $insert_sql_values_parts );
END;
            $rs = $this->db->query($query);
            if ($this->db->affected_rows() != 1) {   // insertion failure; back to the previous form
                Crudderconfig::log(Crudderconfig::LOG_EXCEPTION, "record_edit_insert", "unable to insert record ($table_name)");
                $this->record_edit_insert_redirect($secondary_insert, Crudderconfig::get_string('unable_to_insert_record'));
                return;
            }
            Crudderconfig::log(Crudderconfig::LOG_NOTICE, "record_edit_insert", "database insert complete ($table_name)");
        }

        // save form-display session vars for the next POST or GET request
        $this->session->keep_flashdata('crudder_sort_field_name'  );
        $this->session->keep_flashdata('crudder_sort_order'       );
        $this->session->keep_flashdata('crudder_pager_page_number');

        // redirects to table content display or primary record edition
        $this->record_edit_insert_redirect($secondary_insert, Crudderconfig::get_string('record_inserted'), $id_table);
    }
    


    /**
     * Process the POST request from a HTML form made for record insertion in a main or secondary table
     * 
     * (CRUD generator method)
     * 
     * In order to derivate the POST processing, this method will redirect to the 'table_show' method in case of a primary table, and either to 'record_insert or record_update for secondary tables'
     * 
     * @access	private
     * @param 	boolean  marks if this form corresponds to a secondary table insert
     * @param 	string   message to be shown in the next page rendering
     * @param 	integer  ID of the table to be shown (only used for coming back to a primary table)
     * @return	void
     */
    private function record_edit_insert_redirect ($secondary_insert, $message, $id_table = -1)
    {
        if ($secondary_insert) {
            $id_table  = $this->session->flashdata("crudder_id_first_table");
            $id_record = $this->session->flashdata("crudder_id_first_record");
            //$this->session->keep_flashdata("crudder_id_first_table");
            //$this->session->keep_flashdata("crudder_id_first_record");
            if ($id_record == -1) {
                $this->crudder_redirect("crudder/record_insert/$id_table", $message);
            } else {
                $this->crudder_redirect("crudder/record_update/$id_table/$id_record", $message);
            }
        } else {
            $this->crudder_redirect("crudder/table_show/$id_table", $message);
        }
    }
    
    
    
    /**
     * POST target method for record insertion in a secondary table
     * 
     * (CRUD generator method)
     * 
     * This is only a wrapper that calls the record_edit_insert method
     *
     * @access	public
     * @return	void
     */
    public function record_edit_insert_secondary ()
    {
        // access control
        if ($this->check_access() === false) {
            return false;
        }

        return $this->record_edit_insert(true);
    }
    
    
    
    /**
     * Deletes a record from the database (hard or soft way)
     * 
     * (CRUD generator method)
     * 
     * "Soft way" means that the record will not be deleted but tagged as "deleted" (useful for auditing); in order to indicate this, the "soft_delete_field" in the table "crudder_tables" must countain the name of the field that will be used to save the tag (INT type or one of its derivatives)
     * 
     * Note that if a field if deleted, it's neccesary that the values of other fields that are UNIQUE-like (either implemented or not using database restrictions) don't collide with new records inserted of updated by system operations that occur after the soft deletion; the way to do this is by defining it in the "soft_delete_uniques_suffix", that have the following syntax: "{field_name}.{suffix}" where 'field_name' is the field whose values are unique and 'suffix' is a string that will be appended to the current value of the field
     * 
     * For example: the setting 'code.DEL' will take the current value of field 'code', as in 'Res123', and modify it by 'Res123.DEL'
     * 
     * More than one field modification can be set by comma-separated rules
     * 
     * Redirects to the table_show method
     *
     * @access	private
     * @param   integer ID of table (according to the "crudder_tables" metatable)
     * @param   integer ID of record
     * @return	void
     */
    public function record_delete ($id_table, $id_record)
    {
        // access control
        if ($this->check_access() === false) {
            return false;
        }

        // fetch this table metadata
        $table_md = $this->fetch_table_metadata($id_table);
        if ($table_md === false) {
            Crudderconfig::log(Crudderconfig::LOG_EXCEPTION, "record_delete", "cant access table single record ($id_table, $id_record)");
            $this->crudder_redirect("crudder/table_show/$id_table", Crudderconfig::get_string('cant_access_table_single_record'));
            return false;
        }
        $table_name        = $table_md['name'];
        $soft_delete_field = $table_md['soft_delete_field'];
        
        // make the query according to soft or hard delete
        if ($soft_delete_field != '')
        {
            // free the values of unique fields
            $operations = explode(',', $table_md['soft_delete_uniques_suffix']);
            $updates = array ();
            foreach ($operations as $operation) {
                list ($field, $suffix) = explode('.', $operation);
                $updates[] = "`$field` = CONCAT(`$field`, '$suffix')";
            }
            $updates_full = implode(', ', $updates);
            if ($updates_full != '') {
                $query = <<<END
                    UPDATE `$table_name`
                    SET $updates_full
                    WHERE `id` = $id_record
END;
                $rs = $this->db->query($query);
            }
            
            // do the soft delete
            $query = <<<END
                UPDATE `$table_name`
                SET `$soft_delete_field` = 1
                WHERE `id` = $id_record;
END;
        }
        
        // hard delete
        else {
            $query = <<<END
                DELETE FROM `$table_name`
                WHERE `id` = $id_record;
END;
        }

        // executes the query
        $rs = $this->db->query($query);
        if ($this->db->affected_rows() != 1) {
            $this->crudder_redirect("crudder/table_show/$id_table", Crudderconfig::get_string('unable_to_delete_record'));
        }
        if ($soft_delete_field != '') {
            Crudderconfig::log(Crudderconfig::LOG_NOTICE, "record_delete", "soft delete complete ($table_name, $id_record)");
        } else {
            Crudderconfig::log(Crudderconfig::LOG_NOTICE, "record_delete", "hard delete complete ($table_name, $id_record)");
        }

        // save session vars for the next POST or GET request (these come from the form content display)
        $this->session->keep_flashdata('crudder_sort_field_name'  );
        $this->session->keep_flashdata('crudder_sort_order'       );
        $this->session->keep_flashdata('crudder_pager_page_number');

        // show table content view
        $this->crudder_redirect("crudder/table_show/$id_table", Crudderconfig::get_string('record_deleted'));
    }

    
    
    /**
     * Validates content of the submitted POST fields according to fields metadata
     * 
     * (CRUD generator method)
     * 
     * The fields metadata for this validation is specified in the field 'validation_rules' of the 'crudder_fields' table; the cascading rules should be specified as CI-style rules
     * 
     * Can also validate through Crudder-specific rules that are defined like CI callback rules but in the Crudderconfig class; these rules can have zero or more parameters (so they are more powerful than the CI user rules) and must have "crudder_" as prefix of their names
     *
     * @access	private
     * @param   array   fields metadata
     * @return	mixed   true if validation is OK; values of the previous POST fields if a validation error was encountered
     */
    private function validate_record_content (& $fields_md)
    {
        // iterate over all fields and apply CI rules; also get definitions for crudder rules
        $crudder_rules_for_all_fields = array ();
        $ci_rules_found = false;
        foreach ($fields_md as $field_md)
        {
            $field_name       = $field_md['name'];
            $display_name     = $field_md['display_name'];
            $validation_rules = $field_md['validation_rules'];
            
            // don't validate for improper fields
            if ($field_md['read_only'] || $field_md['hidden'] || $validation_rules == '') {
                continue;
            }
            
            // for easy management of rules
            $splitted           = explode('|', $validation_rules);
            $ci_rules           = array ();
            $crudder_base_rules = array ();
            
            // separate crudder and CI validation rules
            foreach ($splitted as $rule) {
                if (substr($rule, 0, 8) == 'crudder_') {
                    $crudder_base_rules[] = $rule; 
                } else {
                    $ci_rules[] = $rule;
                }
            }

            // define standard CI validation rules
            $ci_rules_str = implode('|', $ci_rules);
            if ($ci_rules_str != '') {
                $this->form_validation->set_rules($field_name, $display_name, $ci_rules_str);
                $ci_rules_found = true;
            }

            // process crudder rules: separate rule arguments from the rule name, if present
            $crudder_rules_for_this_field = array ();
            foreach ($crudder_base_rules as $rule) {
                $args = false;
                $matches = array ();
                if (preg_match('/^([^\[]+)\[([^\]]+)\]$/', $rule, $matches) == 1) {
                    $rule = $matches[1];
                    $args = explode(',', $matches[2]);
                }
                $crudder_rules_for_this_field[] = array($rule, $args);
            }
            if (count($crudder_rules_for_this_field) > 0) {
                $crudder_rules_for_all_fields[] = array ($field_name, $display_name, $crudder_rules_for_this_field);
            }
        }

        // get fields values in order to (possiblely) repopulate the form
        $old_values = array ();
        foreach ($fields_md as $field_md) {
            $field_name  = $field_md['name'];
            $value       = $_POST[$field_name];
            $old_values[$field_name] = $value;
        }

        // special validation case for fields that can have NULL values
        $errors_found = false;
        foreach ($fields_md as $field_md) {
            $field_name         = $field_md['name'];
            $field_display_name = $field_md['display_name'];
            $can_be_null        = $field_md['can_be_null'];
            $value              = $_POST[$field_name];
            if ($can_be_null == 0 && $value == Crudderconfig::NULL_VALUE) {
                $errors_found = true;
                $this->validation_add_error('NULL', $field_display_name);
            }
        }
        if ($errors_found) {
            return array (false, $old_values);
        }
        
        // use CI to validate fields content; if there are errors then signal for redisplay the form
        // for prepping rules the content is changed if no errors, but it's impossible to catch it for Crudder rules,
        // so the policy here is to return and don't continue for the latter ones
        if ($ci_rules_found) {
            if ($this->form_validation->run() == false) {
                return array (false, $old_values);
            }
        }
        
        // if CI rules pass, then check all crudder rules; if there are errors then signal for redisplay the form
        $id_record = $_POST['crudder_id_record'] == '' || $_POST['crudder_id_record'] <= 0 ? false : $_POST['crudder_id_record'];
        $errors_found = false;
        foreach ($crudder_rules_for_all_fields as $tuple)
        {
            list ($field_name, $field_display_name, $rules) = $tuple;
            foreach ($rules as $rule)
            {
                // call variable method name (located in CrudderConfig class) for each rule, with (possibly) the defined argument(s) in fields metadata
                list ($method_name, $args) = $rule;
                if ($args === false) {
                    $res = $this->configurator->$method_name($old_values[$field_name], $id_record);
                }
                elseif (count($args) == 1) {
                    $res = $this->configurator->$method_name($args[0], $old_values[$field_name], $id_record);
                }
                else {   // more than 1 parameters in the metadata rule spec
                    $res = $this->configurator->$method_name($args, $old_values[$field_name], $id_record);
                }
                
                // if rule doesn't pass, register the error message for displaying in the next (or same) form
                if ($res === false) {
                    $errors_found = true;
                    $this->validation_add_error($method_name, $field_display_name);
                }
                elseif ($res === true) {
                    // do nothing
                }
                else {
                    $old_values[$field_name] = $res;
                }
            }
        }
        if ($errors_found) {
            return array (false, $old_values);
        }
        
        // validation is ok: return true
        return array (true, $old_values);
    }


    
    /**
     * Adds a new error message to the list of errors that should be shown in the next rendered view
     * 
     * (CRUD generator method)
     * 
     * This method is invoked only when a Crudderconfig validation callback method ('crudder_*') fails the value checking
     * 
     * The method is called only from this class; Crudderconfig validation methods don't need to call this, because the accumulation of errors messages is automatic
     *
     * @access	private
     * @param   string  full name of the callback method in Crudderconfig class
     * @param   string  text that will replace the substring '##' in the message definition for the error; pass the key of Crudderconfig.validation_error_messages
     * @return	void
     */
    private function validation_add_error ($method_name, $variable_content = false)
    {
        $method_name_without_prefix = substr($method_name, 8);
        $error_message = $this->configurator->get_validation_error($method_name_without_prefix, true, $variable_content);
        $this->validation_errors[] = $error_message;
    }
    
    
    
    /**
     * Sets the HTML delimiters for accumulative error messages
     * 
     * The HTML delimiters will work with both types of error messages (CI and Crudder), so don't call the CI-specific method that also does this
     * 
     * (CRUD generator method)
     * 
     * @access	public
     * @param   string  HTML snippet for prefixing the error
     * @param   string  HTML snippet for postfixing the error
     * @return	void
     */
    public function validation_set_error_delimiters ($prev, $next)
    {
        // access control
        if ($this->check_access() === false) {
            return false;
        }
        
        $this->validation_error_delimiters = array ($prev, $next);
        $this->form_validation->set_error_delimiters($prev, $next);
    }

    
    
    /**
     * Returns the validation errors in the form of a HTML snippet ready for echoing in the current view redisplay
     *
     * (CRUD generator method)
     * 
     * @access	public
     * @return	string  the generated HTML snippet
     */
    public function validation_errors_build_snippet ()
    {
        // access control
        if ($this->check_access() === false) {
            return false;
        }

        $str = validation_errors();
        list ($prev, $next) = $this->validation_error_delimiters;
        foreach ($this->validation_errors as $error) {
            $str .= $prev . $error . $next . "\n";
        }
        return $str;
    }
    
    

}
