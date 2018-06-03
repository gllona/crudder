<?php

// use Crudder;   // use this for NetBeans if the PHP debug set is >= 5.5

require_once(APPPATH . 'controllers/' . 'crudder.php');

// put here all the needed classes for integrating the Crudder with external applications
// currently there is only a "Log" class that we use for logging relevant events in a database (see method 

require_once(APPPATH . 'core/Log.php');



/**
 * Crudder configuration core class
 * 
 * This file should reside into the "application/core" directory
 *
 * @package     Crudder
 * @author      Gorka G LLona <gorka@desarrolladores.logicos.org> <gllona@gmail.com>
 * @copyright   Copyright (c) 2014, Gorka G LLona
 * @license     GNU GPL license
 * @link        http://librerias.logicas.org/crudder
 * @version     Version 1.0.0 beta 1
 * @since       Version 1.0.0 beta 1
 * @see         main Crudder class (configuration and limitations)
 */
class Crudderconfig
{

    
    
    //========================
    // INTERNALS - DON'T TOUCH
    //========================

    
    
    private static $strings             = array ();
    private $snippets                   = array ();
    private $validation_error_messages  = array ();
    private static $default_type_values = array ();
    
    const LOG_NOTICE    = 1;
    const LOG_WARNING   = 2;
    const LOG_EXCEPTION = 3;
    const LOG_ERROR     = 4;

    
    
    //================================
    // GENERAL SETTINGS - CUSTOMIZABLE
    //================================
    

    
    /**
     * Defines the minimal threshold for registering events in the logging mechanism
     */
    const LOG_LEVEL = 1;

    
    
    /**
     * Defines if Crudder will function as a standalone application or as a module of an external application
     * 
     * When true, the crudder is configured for running outside any app (standalone mode)
     * 
     * Check that the proper default controller is set in CI routes.php; when standalone, that should be "crudder"
     */
    const STANDALONE = FALSE;   // TRUE FALSE

    
    
    /**
     * When your main application is developed usign other framework than CodeIgniter, session variables are managed in a different way.
     *
     * If this attribute is FALSE, you have to implement your own logic for the "" method in this class.
     * This method should return "admin" for administrator role; "superadmin" for superadministrator role; and any other value for no access allowed
     */
    const CI_BASED_MAIN_APPLICATION = TRUE;   // TRUE FALSE

    
    
    /**
     * CI method for reentering from the Crudder to the main system
     * 
     * The goaway method can not be "crudded/goaway" in order to disallow recursive calling
     * 
     * Sample: GOAWAY_METHOD = 'mainapp/comefrom_crudder';
     */
    const GOAWAY_METHOD = 'example/come_from_crudder';   
    
    
    
    /**
     * CI method for aborting user session for from the main system (and the Crudder); this will be called from Crudder in case of a URI injection attempt
     * 
     * Sample: ABORT_METHOD = 'mainapp/abortfrom_crudder';
     */
    const ABORT_METHOD = 'crudder/abort';
    
    
    
    /**
     * Capabilities of the user that is using the Crudder
     * 
     * This role is overwritted by the persistent session variable "crudder_user_role"; this is useful when, in non-standadalone mode, some users have full edit permissions and others not
     */
    const DEFAULT_USER_ROLE = 'superadmin';   // admin superadmin // admin can't edit metatables; superadmin can do it
    
    
    
    /**
     * True if the tables list should show the crudder metatables for normal administrative user ('admin' role)
     * 
     * This role is overwritted by the persistent session variable "crudder_user_role"; this is useful when, in non-standadalone mode, some users have full edit permissions and others not
     */
    const SHOW_METATABLES = true;   
    
    
    
    /**
     * Default page set to use for look and feel
     * 
     * Current values here can be "BOOTSTRAPPED" and "RAW"
     * 
     * Currently the RAW views don't work with the EN (english) language because all the texts inside are hardwired
     */
    const DEFAULT_PAGES_SET = 'BOOTSTRAPPED';   // RAW BOOTSTRAPPED

    
    
    /**
     * Language to be used for displaying text strings in the Crudder views; check also for the existence of the proper subfolder in the config/language CI directory tree
     * 
     * Currently implemented: ES, EN
     */
    const LANGUAGE_CODE = 'EN';   // EN ES
    
    
    
    /**
     * Text value for NULL value in database; shouldn't be used as any other value in database
     */
    const NULL_VALUE = '(NULL)';   

    
    
    /**
     * Length of each page for table pagination
     */
    const PAGER_LENGTH = 50;   
    
    
        
    //=====================================
    // LOCALIZATION SETTINGS - CUSTOMIZABLE
    // INCLUDES INITIALIZER AND CONSTRUCTOR
    //=====================================

    
    
    /**
     * Define folders that codeigniter uses for localization, based in the language code
     * 
     * Put here only the needed localization folders
     */
    public static $codeigniter_languages_folders = array (
        'ES' => 'spanish',
        'EN' => 'english',
    );
    
    
    
    /**
     * Class static initializer
     * 
     * Includes localization info
     * 
     * @access	public
     * @return	void
     */
    static function init ()
    {
        // default values when inserting a new record in a table
        //
        self::$default_type_values = array (
            'INT'       => 0,
            'STRING'    => '',
            'TEXT'      => '',
            'DATE'      => '2000-01-01',
            'DATETIME'  => '2000-01-01 00:00:00', 
            'TIMESTAMP' => '2000-01-01',
        );
        
        // small components for generating HTML snippets for EDITABLE BOOTSTRAPPED views
        // RAW pages set have strings hardcoded; see the views in order to modify the strings
        //
        // initializers for: language = ES
        //
        self::$strings['ES'] = array (
            // used in the views
            'system_tables_title'                      => 'Tablas del sistema',
            'select_operation_tables_subtitle'         => 'Seleccione una operación sobre una tabla.',
            'tables_administrator_title'               => 'Administrador de tablas',
            'table_text_title_part'                    => 'Tabla:',
            'read_only_table_subtitle'                 => 'Esta tabla es de sólo lectura. Use los cuadros de texto de la segunda fila y los botones <i>Filtrar</i> y <i>Borrar</i> para aplicar y deshacer filtros sobre los registros.',
            'editable_table_subtitle'                  => 'Seleccione una operación sobre un registro. Use los cuadros de texto de la segunda fila y los botones <i>Filtrar</i> y <i>Borrar</i> para aplicar y deshacer filtros sobre los registros. El botón <i>Nuevo</i> le permite insertar un nuevo registro.',
            'edit_register_title_part'                 => 'registro en tabla:',
            'edit_register_subtitle'                   => 'Llene los campos del formulario. Si alguno de los campos contiene un error de formato o de valor, aparecerá un mensaje explicativo.',
            'security_alert'                           => 'Alerta de seguridad',
            'delete_record_question'                   => '¿Continuar con la eliminación del registro?',
            'error_abort_session_message'              => 'Error: o ha pasado demasiado tiempo sin interactuar con el sistema, o los privilegios son insuficientes para acceder a la administración del sistema.',
            'go_back_main_system_link'                 => 'Regresar a las operaciones principales del sistema',
            'go_back_tables_list_link'                 => 'Regresar al listado de tablas',
            'go_back_table_content_link'               => 'Regresar al contenido de la tabla',
            'go_back_register_insert_link'             => 'Regresar a insertar el registro',
            'go_back_register_update_link'             => 'Regresar a actualizar el registro',
            'table_id_descriptor'                      => 'ID de la tabla. Debe ser único dentro de las metatablas',
            'table_displayname_descriptor'             => 'Nombre de la tabla',
            'table_metatable_descriptor'               => 'Indica si la tabla contiene metadatos, es decir, datos que sirven para describir a las otras tablas',
            'table_helptext_descriptor'                => 'Descripción del propósito de la tabla',
            'yes_label'                                => 'Sí',
            'no_label'                                 => 'No',
            'id_label'                                 => 'ID',
            'displayname_label'                        => 'Nombre',
            'metatable_label'                          => '¿Metatabla?',
            'helptext_label'                           => 'Descripción',
            'operations_label'                         => 'Operaciones',
            'operations_label_help'                    => 'En esta columna se puede elegir entre crear un nuevo registro, o actualizar o borrar un registro existente',
            'show_label'                               => 'Mostrar',
            'filters_label'                            => 'Filtros',
            'filter_label'                             => 'Filtrar',
            'new_label'                                => 'Nuevo',
            'erase_label'                              => 'Borrar',
            'insert_label'                             => 'Insertar',
            'update_label'                             => 'Actualizar',
            'delete_label'                             => 'Eliminar',
            'pager_page_label'                         => 'Página',
            'pager_of_label'                           => 'de',
            'credits_text_and_links'                   => 'Desarrollado con <a href="http://codeigniter.com" target="_blank">CodeIgniter</a> y <a href="http://getbootstrap.com/" target="_blank">Bootstrap</a>. Iconos de <a href="http://glyphicons.com/" target="_blank">GlyphIcons</a>. Crudder por <a href="http://desarrolladores.logicos.org/gorka/" target="_blank">Gorka Llona</a>.',
            // used in the crudder main code
            'record_updated'                           => 'El registro fue actualizado',
            'record_inserted'                          => 'El registro fue insertado',
            'record_deleted'                           => 'El registro fue eliminado',
            'unable_to_insert_record'                  => 'El registro no pudo ser insertado',
            'unable_to_delete_record'                  => 'El registro no pudo ser eliminado',
            'cant_edit_metatable'                      => 'No está permitido editar una metatabla',
            'cant_modify_metatables'                   => 'No está permitido alterar registros en una metatabla',
            'cant_modify_read_only_table'              => 'No está permitido modificar una tabla de sólo lectura',
            'cant_access_table_single_record'          => 'No se puede acceder al registro único de la tabla',
            'cant_access_single_secondary_table_value' => 'No se puede acceder al registro único de la tabla secundaria #table_for_values#',
            'cant_access_single_map_value'             => 'No se puede acceder al registro único de la tabla que contiene todos los valores del campo #map_for_values_label#',
            // internals
            'is_unique_bad_action'                     => 'Valor de "action" incorrecto en "crudder_is_unique"',
        );
        //
        // initializers for: language = EN
        //
        self::$strings['EN'] = array (
            // used in the views
            'system_tables_title'                      => 'System tables',
            'select_operation_tables_subtitle'         => 'Select a table operation.',
            'tables_administrator_title'               => 'Tables administrative utility',
            'table_text_title_part'                    => 'Table:',
            'read_only_table_subtitle'                 => 'This is a read-only table. Use the text boxes located in the second row and the buttons <i>Filter</i> and <i>Erase</i> to apply and undo filtering over the records.',
            'editable_table_subtitle'                  => 'Choose an record operation. Use the text boxes located in the second row and the buttons <i>Filter</i> and <i>Erase</i> to apply and undo filtering over the records. The <i>New</i> button allows to insert a new record.',
            'edit_register_title_part'                 => 'record in the table:',
            'edit_register_subtitle'                   => 'Fill in the form fields. If any field has a formatting or value error, a explaining message will be shown.',
            'security_alert'                           => 'Security alert',
            'delete_record_question'                   => 'Proceed with record deletion?',
            'error_abort_session_message'              => 'Error: too much time without interaction with the system, or insufficient privileges for accessing the system administration module.',
            'go_back_main_system_link'                 => 'Back to main system operations',
            'go_back_tables_list_link'                 => 'Back to tables listing',
            'go_back_table_content_link'               => 'Back to table content',
            'go_back_register_insert_link'             => 'Back to record insertion',
            'go_back_register_update_link'             => 'Back to record updating',
            'table_id_descriptor'                      => 'Table ID. Must be unique within the metatables',
            'table_displayname_descriptor'             => 'Descriptive name of the table in the system database',
            'table_metatable_descriptor'               => 'Indicates if the table contains metatada (data that describe other tables)',
            'table_helptext_descriptor'                => 'Description of the table purpose',
            'yes_label'                                => 'Yes',
            'no_label'                                 => 'No',
            'id_label'                                 => 'ID',
            'displayname_label'                        => 'Name',
            'metatable_label'                          => 'Metatable?',
            'helptext_label'                           => 'Description',
            'operations_label'                         => 'Operations',
            'operations_label_help'                    => "In this column it's possible to create a new record, or update/delete an existing one",
            'show_label'                               => 'Show',
            'filters_label'                            => 'Filters',
            'filter_label'                             => 'Filter',
            'new_label'                                => 'New',
            'erase_label'                              => 'Erase',
            'insert_label'                             => 'Insert',
            'update_label'                             => 'Update',
            'delete_label'                             => 'Delete',
            'pager_page_label'                         => 'Page',
            'pager_of_label'                           => 'of',
            'credits_text_and_links'                   => 'Developed with <a href="http://codeigniter.com" target="_blank">CodeIgniter</a> and <a href="http://getbootstrap.com/" target="_blank">Bootstrap</a>. Icons from <a href="http://glyphicons.com/" target="_blank">GlyphIcons</a>. Crudder by <a href="http://desarrolladores.logicos.org/gorka/" target="_blank">Gorka Llona</a>.',
            // used in the crudder main code
            'record_updated'                           => 'The record was updated',
            'record_inserted'                          => 'The record was inserted',
            'record_deleted'                           => 'The record was deleted',
            'unable_to_insert_record'                  => 'Could not insert the record',
            'unable_to_delete_record'                  => 'Could not delete the record',
            'cant_edit_metatable'                      => 'Can not edit a metatable',
            'cant_modify_metatables'                   => 'Can not modify records in a metatable',
            'cant_modify_read_only_table'              => 'Can not edit a read-only table',
            'cant_access_table_single_record'          => 'Can not access the single record in the table',
            'cant_access_single_secondary_table_value' => 'Can not access the single record #table_for_values# in the secondary table',
            'cant_access_single_map_value'             => 'Can not access the single record in the table that contains all the values of the #map_for_values_label# field',
            // internals
            'is_unique_bad_action'                     => 'Bad value of "action" in "crudder_is_unique"',
        );
    }


    
    /**
     * Class instance constructor
     * 
     * Includes localization info
     * 
     * @access	public
     * @return	void
     */
    public function __construct ()
    {
        // parent::__construct();   // no parent class

        // user role settings
        //
        if (Crudderconfig::STANDALONE) {
            Crudder::get_instance()->session->set_userdata('crudder_user_role', Crudderconfig::DEFAULT_USER_ROLE);
        }
        else if (Crudderconfig::CI_BASED_MAIN_APPLICATION) {
            $user_role = Crudder::get_instance()->session->userdata("crudder_user_role");
            if ($user_role === false) {
                Crudder::get_instance()->session->set_userdata("crudder_user_role", self::DEFAULT_USER_ROLE);
            }
        } else {
            $external_role = self::check_access_outside_codeigniter();
            Crudder::get_instance()->session->set_userdata("crudder_user_role", $external_role);
        }

        // structures definitions languages and pages_set
        //
        $this->snippets['ES'] = array ( 'RAW' => array(), 'BOOTSTRAPPED' => array() );
        $this->snippets['EN'] = array ( 'RAW' => array(), 'BOOTSTRAPPED' => array() );
        
        // initializers for: language = ES ; pages_set = RAW
        //
        $this->snippets['ES']['RAW']['STATIC'] = array (
            'prefix' => '',
            'posfix' => '',
        );
        $this->snippets['ES']['RAW']['EDITABLE'] = array (
            'form'                       => '',
            'insert_secondary_plus_sign' => '+',
            'select_one_from_list'       => 'Seleccionar...',
            'assign_null_value'          => 'Valor nulo',
            'select_options'             => '',
            'select_options_options'     => '',
            'int_size'                   => 10,
            'int_options'                => '',
            'string_size'                => 40,
            'string_options'             => '',
            'text_cols'                  => 60,
            'text_rows'                  => 5,
            'text_options'               => '',
            'date_size'                  => 10,
            'date_options'               => '',
            'datetime_size'              => 10,
            'datetime_options'           => '',
            'timestamp_size'             => 10,
            'timestamp_options'          => '',
            'prefix'                     => '',
            'posfix'                     => '',
        );
        //
        // initializers for: language = ES ; pages_set = RAW
        //
        $this->snippets['ES']['BOOTSTRAPPED']['STATIC'] = array (
            'prefix' => '<p class="form-control-static">',
            'posfix' => '</p>',
        );
        $this->snippets['ES']['BOOTSTRAPPED']['EDITABLE'] = array (
            'insert_secondary_plus_sign' => 'Agregar un nuevo valor a este menú',
            'nullify_field_sign'         => 'Asignar valor nulo',
            'select_one_from_list'       => 'Seleccionar...',
            'assign_null_value'          => 'Valor nulo',
            'select_options'             => 'class="form-control"',
            'select_options_options'     => '',
            'int_size'                   => 10,
            'int_options'                => 'class="form-control"',
            'string_size'                => 40,
            'string_options'             => 'class="form-control"',
            'text_cols'                  => 60,
            'text_rows'                  => 5,
            'text_options'               => 'class="form-control"',
            'date_size'                  => 10,
            'date_options'               => 'class="form-control"',
            'datetime_size'              => 10,
            'datetime_options'           => 'class="form-control"',
            'timestamp_size'             => 10,
            'timestamp_options'          => 'class="form-control"',
            'date_format'                => 'dd/MM/yyyy',
            'prefix'                     => '',
            'posfix'                     => '',
        );
        //
        // initializers for: language = EN ; pages_set = RAW
        //
        $this->snippets['EN']['RAW']['STATIC'] = array (
            'prefix' => '',
            'posfix' => '',
        );
        $this->snippets['EN']['RAW']['EDITABLE'] = array (
            'form'                       => '',
            'insert_secondary_plus_sign' => '+',
            'select_one_from_list'       => 'Select one...',
            'assign_null_value'          => 'Null value',
            'select_options'             => 'class="form-control"',
            'select_options_options'     => '',
            'int_size'                   => 10,
            'int_options'                => 'class="form-control"',
            'string_size'                => 40,
            'string_options'             => 'class="form-control"',
            'text_cols'                  => 60,
            'text_rows'                  => 5,
            'text_options'               => 'class="form-control"',
            'date_size'                  => 10,
            'date_options'               => 'class="form-control"',
            'datetime_size'              => 10,
            'datetime_options'           => 'class="form-control"',
            'timestamp_size'             => 10,
            'timestamp_options'          => 'class="form-control"',
            'date_format'                => 'dd/MM/yyyy',
            'prefix'                     => '',
            'posfix'                     => '',
        );
        //
        // initializers for: language = EN ; pages_set = BOOTSTRAPPED
        //
        $this->snippets['EN']['BOOTSTRAPPED']['STATIC'] = array (
            'prefix' => '<p class="form-control-static">',
            'posfix' => '</p>',
        );
        $this->snippets['EN']['BOOTSTRAPPED']['EDITABLE'] = array (
            'insert_secondary_plus_sign' => 'Add a new value to this menu',
            'nullify_field_sign'         => 'Assign null value',
            'select_one_from_list'       => 'Select one...',
            'assign_null_value'          => 'Null value',
            'select_options'             => 'class="form-control"',
            'select_options_options'     => '',
            'int_size'                   => 10,
            'int_options'                => 'class="form-control"',
            'string_size'                => 40,
            'string_options'             => 'class="form-control"',
            'text_cols'                  => 60,
            'text_rows'                  => 5,
            'text_options'               => 'class="form-control"',
            'date_size'                  => 10,
            'date_options'               => 'class="form-control"',
            'datetime_size'              => 10,
            'datetime_options'           => 'class="form-control"',
            'timestamp_size'             => 10,
            'timestamp_options'          => 'class="form-control"',
            'date_format'                => 'MM/dd/yyyy',
            'prefix'                     => '',
            'posfix'                     => '',
        );
        
        // error messages for crudder field validation
        // see the get_validation_error() method in this class for additional info
        // this applies only for 'crudder_*' validation methods; not to 'callback_*' native-style validation methods
        // don't delete the NULL entry (but you can modify the message)
        //
        // initializers for: language = ES
        //
        $this->validation_error_messages['ES'] = array (
            'NULL'                  => 'El campo ## no acepta valores nulos',
            'is_unique'             => 'Al insertar o actualizar un registro, el valor de ## debe ser unico en toda la tabla',
            'format_location_check' => 'El valor del campo Codigo tiene un formato incorrecto',
            'full_location_check'   => 'Hay incoherencias entre los códigos de las diferentes ubicaciones',
        );
        //
        // initializers for: language = EN
        //
        $this->validation_error_messages['EN'] = array (
            'NULL'                  => 'The ## field does not accept null values',
            'is_unique'             => 'Value of ## should be unique in the table when inserting or updating a record',
            'format_location_check' => 'The value of the Code field has an incorrect format',
            'full_location_check'   => 'The Codes of locations are inconsistent when comparing one with each other',
        );
    }
        

    
    /**
     * Date/Datetime manipulation method. Converts a database-formatted date/datetime to a localized date/datetime
     * 
     * (look and feel settings)
     * 
     * @access	public
     * @param	string  date/datetime to be preprocessed
     * @return	string  the locale-conform date/datetime
     */
    function locale_datetime ($database_datetime)
    {
        $year  = substr($database_datetime, 0, 4);
        $month = substr($database_datetime, 5, 2);
        $day   = substr($database_datetime, 8, 2);
        $time  = substr($database_datetime, 10, 9);

        switch (self::LANGUAGE_CODE) {
            case 'ES':
                $new_date = "$day/$month/$year";
                break;
            case 'EN':
            default:
                $new_date = "$month/$day/$year";
        }
        return $new_date . $time;
    }
    
    
    
    /**
     * Date/Datetime manipulation method. Converts a localized date/datetime to the standard database date/datetime format
     * 
     * (look and feel settings)
     * 
     * @access	public
     * @param	string  date/datetime to be preprocessed
     * @return	string  the database-conform date/datetime
     */
    function database_datetime ($locale_datetime)
    {
        $date = substr($locale_datetime, 0, 10);
        $time = substr($locale_datetime, 10, 9);
        
        switch (self::LANGUAGE_CODE) {
            case 'ES':
                $day   = substr($date, 0, 2);
                $month = substr($date, 3, 2);
                $year  = substr($date, 6, 4);
                break;
            case 'EN':
            default:
                $month = substr($date, 0, 2);
                $day   = substr($date, 3, 2);
                $year  = substr($date, 6, 4);
        }
        $new_date = "$year/$month/$day";
        return $new_date . $time;
    }
    
    
    
    //======================================
    // LOOK AND FEEL SETTINGS - CUSTOMIZABLE
    //======================================
    
    
    
    /**
     * Preprocessor for all the display values that will be shown; intented for visual format changes
     * 
     * (look and feel settings)
     * 
     * Should be called only from the views
     *
     * @access	public
     * @param	string  value to be preprocessed
     * @return	string  the processed string
     */
    //
    // The following, commented code soes NOT work with PHP < 5.3 (lambda functions are not supported)
    /*
    public static function texter ($text)
    {
        $text = preg_replace_callback(
            '/(\>?)(\(NULL\))(\<?)/',
            function ($matches) {
                return $matches[0] . "<i>" . $matches[1] . "</i>" . $matches[2];
            },
            $text
        );        
        return $text;
    }
    */
    //
    // The following code is for converting PHP >= 5.3 code for lambda functions, passed as arguments to other functions
    // Note that encapsulation is maintained because the new named, pseudo-lambda function is defined within the main function
    // 
    public static function texter ($text)
    {
		//$texter_callback = create_function (
		//    '$matches',
		//    'return $matches[0] . "<i>" . $matches[1] . "</i>" . $matches[2];'
		//);
        $text = preg_replace_callback(
            '/(\>?)(\(NULL\))(\<?)/',
            //$texter_callback,
            function($matches) { return $matches[0] . "<i>" . $matches[1] . "</i>" . $matches[2]; },
            $text
        );        
        return $text;
    }


    
    //==================================================================================
    // SECURITY METHODS - CUSTOMIZE IF YOUR MAIN APPLICATION IS NOT BASED ON CODEIGNITER
    //==================================================================================

    
    
    /**
     * Checks access to the Crudder as defined by the non-codeigniter-based main application
     * 
     * (security method)
     * 
     * @access	private
     * @return	string  one of these values: "none", "admin", "superadmin"
     */
    public static function check_access_outside_codeigniter ()
    {
        return "none";   // admin superadmin
    }

    
    
    /**
     * Register each relevant Crudder operation into a whole-application log database (optional feature)
     * 
     * (security method)
     * 
     * Available log levels are: LOG_NOTICE, LOG_WARNING, LOG_EXCEPTION and LOG_ERROR
     * 
     * Granularity of logging is defined with the LOG_LEVEL constant, that is set at the top of this file
     * 
     * @access	private
     * @return	void
     */
    public static function log ($level, $operation, $description)
    {
        // return;   // do nothing if you don't want to log the Crudder operations

        // for this Crudder distribution, we are using the included user-management application Log class
        // is this case we have to include the class "Log.php" in this class header
        // change this logic as you want
        
        if ($level >= self::LOG_LEVEL) {
            switch ($level) {
                case 1:  $level_str = "NOTICE"       ; break;
                case 2:  $level_str = "WARNING"      ; break;
                case 3:  $level_str = "EXCEPTION"    ; break;
                case 4:  $level_str = "ERROR"        ; break;
                default: $level_str = "LEVEL_UNKNOWN";
            }
            $message = "[$level:$level_str] :: $operation :: $description";
            Log::register($message);
        }
    }
    
        
    
    //========================================================
    // FIELDS VALIDATION METHODS SPECIFICATIONS - CUSTOMIZABLE
    //========================================================

    
    
    /**
     * Crudder callback that checks the location code format in form fields (estado, municipio, parroquia)
     * 
     * (fields validation specification - application logic implementation)
     * 
     * There is no need to add the validation error in each callback method; this is done automatically
     *
     * This is for: Venezuelan geographical location entities: Estado, Municipio, Parroquia
     * 
     * @access	public
     * @param	string location code for checking (estado, municipio, parroquia); sent directly from the Crudder class
     * @return	boolean
     */
    public function crudder_format_location_check ($code)
    {
        if (strlen($code) == 3) {
            return preg_match('/E[0-9]{2}/', $code) ? true : false;
        }
        elseif (strlen($code) == 7) {
            return preg_match('/E[0-9]{2}-M[0-9]{2}/', $code) ? true : false;
        }
        if (strlen($code) == 11) {
            return preg_match('/E[0-9]{2}-M[0-9]{2}-P[0-9]{2}/', $code) ? true : false;
        }
    }

    
    
    /**
     * Crudder callback that checks the coherence of location codes (estado, municipio, parroquia)
     * 
     * (fields validation specification - application logic implementation)
     * 
     * There is no need to add the validation error in each callback method; this is done automatically
     * 
     * In this case, because validation_specs has only one value, that is passed directly and not as an array
     *
     * This is for: Venezuelan geographical location entities: Estado, Municipio, Parroquia
     * 
     * @access	public
     * @param	string  field_with_base_value; validation rule in fields metatable is like "crudder_full_location_check[code_estado]"; this will check the field against the value of code_estado field
     * @param   string  value to be checked (assigned by the crudder logic)
     * @return	boolean
     */
    public function crudder_full_location_check ($field_with_base_value, $value)
    {
        $base_value = $_POST[$field_with_base_value];
        $len = strlen($base_value);
        return substr($value, 0, $len) == $base_value;
    }

    
    
    /**
     * Crudder callback field checking for database inserts and updates (more powerful than CI is_unique)
     * 
     * (fields validation specification - application logic implementation)
     * 
     * There is no need to add the validation error in each callback method; this is done automatically
     * 
     * Checks if 'value' is already used in 'field_name' of 'table_name'; this for inserts and also for updates that change the value
     * 
     * If 'action' is 'update' and no 'orig_value' is passed, this method can't work properly and will return true
     * 
     * This is for: all applications based on Crudder
     * 
     * Important: don't change the code of this method - it's optimized in the main Crudder class
     *
     * @access	public
     * @param	array   validation rule in fields metatable is like "crudder_is_unique[cat_municipios,code,action]"; this will check the "value" for being unique in table "cat_municipios" for the specified "action" (that is assigned by the main Crudder class and can be an insert or an update, with some internals tweaks)
     * @param   string  value to be checked (assigned by the Crudder logic)
     * @param	integer id of the record being checked in the table named as "cat_municipios" in the above example (first argument; assigned by the Crudder logic)
     * @return  boolean 
     */
    public function crudder_is_unique ($field_validation_specs, $value, $id_record = false)
    {
        return Crudder::get_instance()->crudder_is_unique($field_validation_specs, $value, $id_record);
    }

    
    
    //=========================================================================================
    // METHODS FOR ACCESSING LOCALIZATION AND DEFAULT VALUES SETTINGS - INTERNALS - DON'T TOUCH
    //=========================================================================================

    
    
    /**
     * Get a display-intended string, applying localization settings
     * 
     * (default values settings and localized elements access)
     * 
     * Should be called only from the views (use static Crudderconfig::get_string() form of calling)
     *
     * @access	public
     * @param	string  database field type, as defined in the class initializer
     * @return	string  default value for the type
     */
    public static function get_default_type_value ($type)
    {
        return isset(self::$default_type_values[$type]) ? self::$default_type_values[$type] : '';
    }
    
    
    
    /**
     * Get a display-intended string, applying localization settings
     * 
     * (default values settiongs and localized elements access)
     * 
     * Should be called only from the views (use static Crudderconfig::get_string() form of calling)
     *
     * @access	public
     * @param	string  key for the string; all are defined in the class initializer
     * @param   string  wheter to escape the string for avoiding HTML special char, or not
     * @param   string  if set, the substring '##' in the string value will be replaced with this argument
     * @return	string  the localized string value
     */
    public static function get_string ($key, $escape_html = true, $variable_string = false)
    {
        if (! isset(self::$strings[self::LANGUAGE_CODE][$key])) {
            return $escape_html ? html_escape("[[string_not_found::$key]]") : "[[string_not_found::$key]]";
        }
        $string = self::$strings[self::LANGUAGE_CODE][$key];
        if ($variable_string !== false) {
            $string = str_replace('##', $variable_string, $string);
        }
        return $escape_html ? html_escape($string) : $string;
    }

    
    
    /**
     * Get a display-intended snippet, applying localization settings
     * 
     * (default values settiongs and localized elements access)
     * 
     * Intended for being called from the Crudder class (use $this->configurator->get_string() form of calling)
     *
     * @access	public
     * @param	string  STATIC or EDITABLE
     * @param	string  key for the string; all are defined in the instance constructor
     * @param   string  wheter to escape the string for avoiding HTML special chars (entities), or not
     * @return	string  the localized string value
     */
    public function get_snippet ($type, $key, $escape_html = true)
    {
        
        $pages_set = Crudderconfig::DEFAULT_PAGES_SET;
        if (! isset($this->snippets[self::LANGUAGE_CODE][$pages_set][$type][$key])) {
            return $escape_html ? html_escape("[[snippet_not_found::$type;$key]]") : "[[snippet_not_found::$type;$key]]";
        }
        return $escape_html ? html_escape($this->snippets[self::LANGUAGE_CODE][$pages_set][$type][$key]) : $this->snippets[self::LANGUAGE_CODE][$pages_set][$type][$key];
    }
    
   

    /**
     * Get a display-intended validation error messsage, applying localization settings
     * 
     * (default values settiongs and localized elements access)
     * 
     * There is no need for calling this method, it works automatically
     * 
     * Only be assure that the key definition in the $validation_errors_message array coincides with the name of the validation method
     * 
     * This applies only for 'crudder_*' validation methods; not to 'callback_*' native-style validation methods (that should not be used)
     *
     * @access	public
     * @param	string  key for the validation error; all are defined in the instance constructor
     * @param   string  wheter to escape the string for avoiding HTML special char, or not
     * @param   string  if set, the substring '##' in the validation error string will be replaced with this argument
     * @return	string  the localized error description
     */
    public function get_validation_error ($key, $escape_html = true, $variable_string = false)
    {
        if (! isset($this->validation_error_messages[self::LANGUAGE_CODE][$key])) {
            return $escape_html ? html_escape("[[validation_error_not_found::$key]]") : "[[validation_error_not_found::$key]]";
        }
        $string = $this->validation_error_messages[self::LANGUAGE_CODE][$key];
        if ($variable_string !== false) {
            $string = str_replace('##', $variable_string, $string);
        }
        return $escape_html ? html_escape($string) : $string;
    }

    
    
}



?>
