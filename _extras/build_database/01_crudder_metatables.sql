-- phpMyAdmin SQL Dump
-- version 4.0.5deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 04-04-2014 a las 15:48:44
-- Versión del servidor: 5.5.31-1
-- Versión de PHP: 5.5.1-2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `crudder`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `crudder_fields`
--

DROP TABLE IF EXISTS `crudder_fields`;
CREATE TABLE IF NOT EXISTS `crudder_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ignored` tinyint(4) NOT NULL DEFAULT '0',
  `id_table` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `display_name` varchar(64) NOT NULL,
  `table_name_for_values` varchar(64) NOT NULL,
  `map_for_values_idkey` varchar(255) NOT NULL,
  `map_for_values_label` varchar(64) NOT NULL,
  `where_filter_for_values` varchar(255) NOT NULL,
  `order_field_for_values` varchar(64) NOT NULL,
  `on_change` varchar(64) NOT NULL DEFAULT '',
  `type` enum('INT','STRING','TEXT','DATE','DATETIME','TIMESTAMP') NOT NULL,
  `can_be_null` tinyint(4) NOT NULL DEFAULT '0',
  `validation_rules` varchar(255) NOT NULL,
  `show_first` tinyint(4) NOT NULL DEFAULT '0',
  `read_only` tinyint(4) NOT NULL DEFAULT '0',
  `hidden` tinyint(4) NOT NULL DEFAULT '0',
  `display_order` int(11) NOT NULL,
  `htmlize_field_name` tinyint(4) NOT NULL DEFAULT '1',
  `htmlize_values` tinyint(4) NOT NULL DEFAULT '0',
  `help_text` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `id_table` (`id_table`,`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=91 ;

--
-- Truncar tablas antes de insertar `crudder_fields`
--

TRUNCATE TABLE `crudder_fields`;
--
-- Volcado de datos para la tabla `crudder_fields`
--

INSERT INTO `crudder_fields` (`id`, `ignored`, `id_table`, `name`, `display_name`, `table_name_for_values`, `map_for_values_idkey`, `map_for_values_label`, `where_filter_for_values`, `order_field_for_values`, `on_change`, `type`, `can_be_null`, `validation_rules`, `show_first`, `read_only`, `hidden`, `display_order`, `htmlize_field_name`, `htmlize_values`, `help_text`) VALUES
(1, 0, 1, 'id', 'id', '', '', '', '', '', '', 'INT', 0, 'trim|required|is_numeric', 1, 1, 0, 1, 0, 0, 'Integer. The ID of the record. Normally auto-increment for all tables. A Crudder requisite'),
(2, 0, 1, 'ignored', 'ignored', 'crudder_menu_yesno', 'key', 'value', '', 'ordering', '', 'INT', 0, 'trim|required|is_numeric|exact_length[1]', 0, 0, 0, 2, 0, 0, 'Integer. Tells if the table should be ignored by the Crudder ("1") or not ("0")'),
(3, 0, 1, 'name', 'name', '', '', '', '', '', '', 'STRING', 0, 'trim|required', 1, 0, 0, 3, 0, 0, 'String. The table name in the database'),
(4, 0, 1, 'display_name', 'display_name', '', '', '', '', '', '', 'STRING', 0, 'trim|required', 0, 0, 0, 4, 0, 0, 'String. The name that the Crudder displays for the table. Should not include HTML markups'),
(5, 0, 1, 'is_metatable', 'is_metatable', 'crudder_menu_yesno', 'key', 'value', '', 'ordering', '', 'INT', 0, 'trim|required|is_numeric|exact_length[1]', 0, 0, 0, 5, 0, 0, 'Integer. Tells if the table is a metatable ("1") or not ("0"). There are only three metatable, whose names begin with "crudder_". The "crudder_" prefix should not be used for other table names'),
(6, 0, 1, 'read_only', 'read_only', 'crudder_menu_yesno', 'key', 'value', '', 'ordering', '', 'INT', 0, 'trim|required|is_numeric|exact_length[1]', 0, 0, 0, 6, 0, 0, 'Integer. Tells if the table is read-only ("1") or not ("0"). Read-only tables appear listed in the Crudder but can not be edited'),
(7, 0, 1, 'soft_delete_field', 'soft_delete_field', '', '', '', '', '', '', 'STRING', 0, 'trim', 0, 0, 0, 7, 0, 0, 'If not empty, deletions are "soft"; the affected row is tagged as "1" in the field with the name indicated by this value, so database auditing is possible. Unique-key conflicts can arise when inserting, later, a record with the same key (see next field)'),
(8, 0, 1, 'soft_delete_uniques_suffix', 'soft_delete_uniques_suffix', '', '', '', '', '', '', 'STRING', 0, 'trim', 0, 0, 0, 8, 0, 0, 'String; format [fieldname.suffix]. This solves conflicts that arise when applying soft deletions. This rule directs the Crudder to add "suffix" to the field value when doing the soft deletion. Works only with string-type fields'),
(9, 0, 1, 'display_order', 'display_order', '', '', '', '', '', '', 'INT', 0, 'trim|required|is_numeric', 0, 0, 0, 9, 0, 0, 'Integer. This field indicates the tables listing order (ascending means top to bottom)'),
(10, 0, 1, 'help_text', 'help_text', '', '', '', '', '', '', 'STRING', 0, 'trim|required', 1, 0, 0, 10, 0, 1, 'String. Text to be displayed when doing mouseover on the "question mark" associated to each table. Useful for offering the user a short description of the table purpose'),
(11, 1, 1, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(12, 1, 1, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(13, 1, 1, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(14, 1, 1, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(15, 1, 1, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(16, 1, 1, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(17, 1, 1, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(18, 1, 1, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(19, 1, 1, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(20, 1, 1, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(21, 0, 2, 'id', 'id', '', '', '', '', '', '', 'INT', 0, 'trim|required|is_numeric', 1, 1, 0, 1, 0, 0, 'Integer. The ID of the record; normally auto-increment. A Crudder requisite'),
(22, 0, 2, 'ignored', 'ignored', 'crudder_menu_yesno', 'key', 'value', '', 'ordering', '', 'INT', 0, 'trim|required|is_numeric|exact_length[1]', 0, 0, 0, 2, 0, 0, 'Integer. Tells if the field should be ignored by the Crudder ("1") or not ("0")'),
(23, 0, 2, 'id_table', 'id_table', 'crudder_tables', 'id', 'CONCAT(''['',id,''] '',name)', '', '', '', 'INT', 0, 'trim|required|is_numeric', 1, 0, 0, 3, 0, 0, 'Integer. The ID of the table that includes this field in its structure. Tables IDs are managed in table "crudder_table"'),
(24, 0, 2, 'name', 'name', '', '', '', '', '', '', 'STRING', 0, 'trim|required', 1, 0, 0, 4, 1, 0, 'String. The name of the field as defined in the database'),
(25, 0, 2, 'display_name', 'display_name', '', '', '', '', '', '', 'STRING', 0, 'trim|required', 0, 0, 0, 5, 0, 0, 'String. The name that the Crudder will show when listing the table fields. Should not include HTML markups'),
(26, 0, 2, 'table_name_for_values', 'table_name_for_values', '', '', '', '', '', '', 'STRING', 0, 'trim', 0, 0, 0, 6, 0, 0, 'String. If not empty, the possible values for the field will be extracted from this table (such building a map) and presented as a single-selection menu. The next two fields should also be non-empty'),
(27, 0, 2, 'map_for_values_idkey', 'map_for_values_idkey', '', '', '', '', '', '', 'STRING', 0, 'trim', 0, 0, 0, 7, 0, 0, 'String. When building the menu from the table named as in the "table_name_for_values" field, this field values will be used as menu keys'),
(28, 0, 2, 'map_for_values_label', 'map_for_values_label', '', '', '', '', '', '', 'STRING', 0, 'trim', 0, 0, 0, 8, 0, 0, 'String. When building the menu from the table named as in the "table_name_for_values" field, values generated by this SQL sub-expression will be used as menu labels. Can be compound sub-expressions like "CONCAT(code,''-'',name)"'),
(29, 0, 2, 'where_filter_for_values', 'where_filter_for_values', '', '', '', '', '', '', 'STRING', 0, 'trim', 0, 0, 0, 9, 0, 0, 'String. A extended-syntax WHERE clause for filtering menu values. Ex. "SUBSTR(key,1,3)=#abc#" displays only records of [table_name_for_values] where the first 3 chars of "key" are equal to the "abc" field values for this record. Browse code for more info'),
(30, 0, 2, 'order_field_for_values', 'order_field_for_values', '', '', '', '', '', '', 'STRING', 0, 'trim', 0, 0, 0, 10, 0, 0, 'String. The field that will be used for ordering the menu values. Normally this is the same as [map_for_values_idkey] or [map_for_values_label]. Defaults to "id"'),
(31, 0, 2, 'on_change', 'on_change', '', '', '', '', '', '', 'STRING', 0, 'trim', 0, 0, 0, 11, 0, 0, 'String. Action to be taken when the value of the field is changed. Currently only "reload" is available. This will trigger a complete reload of the view (preserving form values). Combined with the [where_filter_for_values], this simulates an AJAX request'),
(32, 0, 2, 'type', 'type', 'crudder_menu_fieldtypes', 'key', 'value', '', 'ordering', '', 'STRING', 0, 'trim|required', 0, 0, 0, 12, 0, 0, 'ENUM (currently implemented by the Crudder as Integer). Defines the type of the field. Currently only a few, general purpose types are implemented'),
(33, 0, 2, 'can_be_null', 'can_be_null', 'crudder_menu_yesno', 'key', 'value', '', 'ordering', '', 'INT', 0, 'trim|required|is_numeric|exact_length[1]', 0, 0, 0, 13, 0, 0, 'Integer. Tells if the field can be NULL in the database ("1") or not ("0")'),
(34, 0, 2, 'validation_rules', 'validation_rules', '', '', '', '', '', '', 'STRING', 0, 'trim', 0, 0, 0, 14, 0, 0, 'String. CI-style validation rules for the field. Complex rules can be added, beginning with "crudder_". Rule "is_numeric|crudder_chk[code]" for "f1" field will first check "is_numeric" and then call "crudder_chk" with the form values of "code" and "f1"'),
(35, 0, 2, 'show_first', 'show_first', 'crudder_menu_yesno', 'key', 'value', '', 'ordering', '', 'STRING', 0, 'trim|required|is_numeric|exact_length[1]', 0, 0, 0, 15, 0, 0, 'Integer. Directs the Crudder to show the field only when editing a record of the table ("0") or also when showing the table structure ("1")'),
(36, 0, 2, 'read_only', 'read_only', 'crudder_menu_yesno', 'key', 'value', '', 'ordering', '', 'INT', 0, 'trim|required|is_numeric|exact_length[1]', 0, 0, 0, 16, 0, 0, 'Integer. Tells if the field is read-only ("1") or writable ("0")'),
(37, 0, 2, 'hidden', 'hidden', 'crudder_menu_yesno', 'key', 'value', '', 'ordering', '', 'INT', 0, 'trim|required|is_numeric|exact_length[1]', 0, 0, 0, 17, 0, 0, 'Integer. Tells if the field is hidden in the Crudder interface ("1") or not ("0")'),
(38, 0, 2, 'display_order', 'display_order', '', '', '', '', '', '', 'INT', 0, 'trim|required|is_numeric', 0, 0, 0, 18, 0, 0, 'Integer. This field indicates the fields listing order (ascending means top to bottom)'),
(39, 0, 2, 'htmlize_field_name', 'htmlize_field_name', 'crudder_menu_yesno', 'key', 'value', '', 'ordering', '', 'INT', 0, 'trim|required|is_numeric|exact_length[1]', 0, 0, 0, 19, 0, 0, 'Integer. Tells if the Crudder must render the field name using the HTML tags found inside ("1") or displaying them as plain text ("0")'),
(40, 0, 2, 'htmlize_values', 'htmlize_values', 'crudder_menu_yesno', 'key', 'value', '', 'ordering', '', 'STRING', 0, 'trim|required|is_numeric|exact_length[1]', 0, 0, 0, 20, 0, 1, 'Integer. Tells if the Crudder must render the field values using the HTML tags found inside ("1") or displaying them as plain text ("0")'),
(41, 0, 2, 'help_text', 'help_text', '', '', '', '', '', '', 'STRING', 0, 'trim', 1, 0, 0, 21, 0, 0, 'String. Text to be displayed when doing mouseover on the "question mark" associated to each field. Useful for offering the user a short description of the field purpose'),
(42, 1, 2, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(43, 1, 2, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(44, 1, 2, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(45, 1, 2, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(46, 1, 2, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(47, 1, 2, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(48, 1, 2, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(49, 1, 2, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(50, 1, 2, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(51, 0, 3, 'id', 'id', '', '', '', '', '', '', 'INT', 0, 'trim|required|is_numeric', 1, 1, 0, 1, 0, 0, 'Integer. ID of the record. A Crudder requisite'),
(52, 0, 3, 'key', 'key', '', '', '', '', '', '', 'INT', 0, 'trim|required|is_numeric|exact_length[1]|crudder_is_unique[crudder_menu_yesno,key,action]', 1, 0, 0, 2, 0, 0, 'Integer. Key value [0;1] associated with each value of this menu definition [No;Yes]'),
(53, 0, 3, 'value', 'value', '', '', '', '', '', '', 'STRING', 0, 'trim|required|is_string', 1, 0, 0, 3, 0, 0, 'String. A readable version of the "key" field: [No;Yes]'),
(54, 0, 3, 'ordering', 'ordering', '', '', '', '', '', '', 'INT', 0, 'trim|required|is_numeric', 0, 0, 0, 4, 0, 0, 'Integer. Listing order definition for menu building'),
(55, 1, 3, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(56, 0, 4, 'id', 'id', '', '', '', '', '', '', 'INT', 0, 'trim|required|is_numeric', 1, 1, 0, 1, 0, 0, 'Integer. ID of the record. A Crudder requisite'),
(57, 0, 4, 'key', 'key', '', '', '', '', '', '', 'STRING', 0, 'trim|required|crudder_is_unique[crudder_menu_fieldtypes,key,action]', 1, 0, 0, 2, 0, 0, 'String. The key values for this menu. Texts should coincide with the values of the ENUM used for the field "type" in metatable "crudder_fields"'),
(58, 0, 4, 'value', 'value', '', '', '', '', '', '', 'STRING', 0, 'trim|required', 1, 0, 0, 3, 0, 0, 'String. A readable version of the "key" field'),
(59, 0, 4, 'ordering', 'ordering', '', '', '', '', '', '', 'INT', 0, 'trim|required|is_numeric', 0, 0, 0, 4, 0, 0, 'Integer. Listing order definition for menu building'),
(60, 1, 4, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(61, 1, 4, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(62, 1, 4, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(63, 1, 4, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(64, 1, 4, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(65, 1, 4, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(66, 1, 4, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(67, 1, 4, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(68, 1, 4, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(69, 1, 4, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, ''),
(70, 1, 4, '[reserved]', '', '', '', '', '', '', '', 'INT', 0, '', 0, 0, 1, 9999, 1, 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `crudder_menu_fieldtypes`
--

DROP TABLE IF EXISTS `crudder_menu_fieldtypes`;
CREATE TABLE IF NOT EXISTS `crudder_menu_fieldtypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(32) NOT NULL,
  `value` varchar(32) NOT NULL,
  `ordering` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Truncar tablas antes de insertar `crudder_menu_fieldtypes`
--

TRUNCATE TABLE `crudder_menu_fieldtypes`;
--
-- Volcado de datos para la tabla `crudder_menu_fieldtypes`
--

INSERT INTO `crudder_menu_fieldtypes` (`id`, `key`, `value`, `ordering`) VALUES
(1, 'INT', 'Integer', 1),
(2, 'STRING', 'String', 2),
(3, 'TEXT', 'Text', 3),
(4, 'DATE', 'Date', 4),
(5, 'DATETIME', 'DateTime', 5),
(6, 'TIMESTAMP', 'TimeStamp', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `crudder_menu_yesno`
--

DROP TABLE IF EXISTS `crudder_menu_yesno`;
CREATE TABLE IF NOT EXISTS `crudder_menu_yesno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` tinyint(4) NOT NULL,
  `value` varchar(8) NOT NULL,
  `ordering` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Truncar tablas antes de insertar `crudder_menu_yesno`
--

TRUNCATE TABLE `crudder_menu_yesno`;
--
-- Volcado de datos para la tabla `crudder_menu_yesno`
--

INSERT INTO `crudder_menu_yesno` (`id`, `key`, `value`, `ordering`) VALUES
(1, 1, 'Yes', 1),
(2, 0, 'No', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `crudder_tables`
--

DROP TABLE IF EXISTS `crudder_tables`;
CREATE TABLE IF NOT EXISTS `crudder_tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ignored` tinyint(4) DEFAULT '0',
  `name` varchar(64) NOT NULL,
  `display_name` varchar(64) NOT NULL,
  `is_metatable` tinyint(4) NOT NULL DEFAULT '0',
  `read_only` tinyint(4) NOT NULL DEFAULT '0',
  `soft_delete_field` varchar(64) NOT NULL DEFAULT '',
  `soft_delete_uniques_suffix` varchar(16) NOT NULL DEFAULT '',
  `display_order` tinyint(4) NOT NULL DEFAULT '0',
  `help_text` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Truncar tablas antes de insertar `crudder_tables`
--

TRUNCATE TABLE `crudder_tables`;
--
-- Volcado de datos para la tabla `crudder_tables`
--

INSERT INTO `crudder_tables` (`id`, `ignored`, `name`, `display_name`, `is_metatable`, `read_only`, `soft_delete_field`, `soft_delete_uniques_suffix`, `display_order`, `help_text`) VALUES
(1, 0, 'crudder_tables', 'Crudder_Tables', 1, 0, '', '', 1, 'Crudder metatable. Saves other tables definitions'),
(2, 0, 'crudder_fields', 'Crudder_Fields', 1, 0, '', '', 2, 'Crudder metatable. Saves other tables fields definitions'),
(3, 0, 'crudder_menu_yesno', 'Crudder_Menu_Yes/No', 1, 1, '', '', 3, 'Crudder metatable. For menu with Yes/No options'),
(4, 0, 'crudder_menu_fieldtypes', 'Crudder_Menu_FieldTypes', 1, 1, '', '', 4, 'Crudder metatable. For menu with fields types');

