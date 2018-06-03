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
-- Volcado de datos para la tabla `crudder_fields`
--

INSERT INTO `crudder_fields` (`id`, `ignored`, `id_table`, `name`, `display_name`, `table_name_for_values`, `map_for_values_idkey`, `map_for_values_label`, `where_filter_for_values`, `order_field_for_values`, `on_change`, `type`, `can_be_null`, `validation_rules`, `show_first`, `read_only`, `hidden`, `display_order`, `htmlize_field_name`, `htmlize_values`, `help_text`) VALUES
(71, 0, 5, 'id', 'ID', '', '', '', '', '', '', 'INT', 0, '', 0, 1, 0, 1, 1, 0, 'Identificador único'),
(72, 0, 5, 'code', 'Codigo', '', '', '', '', '', '', 'STRING', 0, 'trim|required|exact_length[3]|crudder_format_location_check|crudder_is_unique[cat_estados,code,action]', 1, 0, 0, 2, 1, 0, 'Código de Estado (único)'),
(73, 0, 5, 'nombre', 'Nombre', '', '', '', '', '', '', 'STRING', 0, 'trim|required|max_length[64]', 1, 0, 0, 3, 1, 0, 'Nombre del Estado'),
(74, 0, 6, 'id', 'ID', '', '', '', '', '', '', 'INT', 0, '', 0, 1, 0, 1, 1, 0, 'Identificador único'),
(75, 0, 6, 'code', 'Codigo', '', '', '', '', '', '', 'STRING', 0, 'trim|required|exact_length[7]|crudder_format_location_check|crudder_full_location_check[code_estado]|crudder_is_unique[cat_municipios,code,action]', 1, 0, 0, 3, 1, 0, 'Código de Municipio (único)'),
(76, 0, 6, 'code_estado', 'Estado', 'cat_estados', 'code', 'CONCAT(`code`, '' - '', `nombre`)', '', 'code', '', 'STRING', 0, 'required|exact_length[3]', 1, 0, 0, 2, 1, 0, 'Código del Estado al cual pertenece el Municipio'),
(77, 0, 6, 'nombre', 'Nombre', '', '', '', '', '', '', 'STRING', 0, 'trim|required|max_length[64]', 1, 0, 0, 4, 1, 0, 'Nombre del Municipio'),
(78, 0, 7, 'id', 'ID', '', '', '', '', '', '', 'INT', 0, '', 0, 1, 0, 1, 1, 0, 'Identificador único'),
(79, 0, 7, 'code', 'Codigo', '', '', '', '', '', '', 'STRING', 0, 'trim|required|exact_length[11]|crudder_format_location_check|crudder_full_location_check[code_municipio]|crudder_is_unique[cat_parroquias,code,action]', 1, 0, 0, 4, 1, 0, 'Código de Parroquia (único)'),
(80, 0, 7, 'code_estado', 'Estado', 'cat_estados', 'code', 'CONCAT(`code`, '' - '', `nombre`)', '', 'code', 'reload', 'STRING', 0, 'required|exact_length[3]', 0, 0, 0, 2, 1, 0, 'Código del Estado al cual pertenece la Parroquia'),
(81, 0, 7, 'code_municipio', 'Municipio', 'cat_municipios', 'code', 'CONCAT(`code`, '' - '', `nombre`)', 'SUBSTR(`code`, 1, 3) = #code_estado#', 'code', '', 'STRING', 0, 'required|exact_length[7]', 1, 0, 0, 3, 1, 0, 'Código del Municipio al cual pertenece la Parroquia'),
(82, 0, 7, 'nombre', 'Nombre', '', '', '', '', '', '', 'STRING', 0, 'trim|required|max_length[64]', 1, 0, 0, 5, 1, 0, 'Nombre de la Parroquia'),
(83, 0, 5, 'deleted', 'Eliminado', '', '', '', '', '', '', 'INT', 0, '', 0, 1, 1, 0, 1, 0, 'El registro ha sido eliminado si el valor es 1'),
(84, 0, 6, 'deleted', 'Eliminado', '', '', '', '', '', '', 'INT', 0, '', 0, 1, 1, 0, 1, 0, 'El registro ha sido eliminado si el valor es 1'),
(85, 0, 7, 'deleted', 'Eliminado', '', '', '', '', '', '', 'INT', 0, '', 0, 1, 1, 0, 1, 0, 'El registro ha sido eliminado si el valor es 1');

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `crudder_tables`
--

INSERT INTO `crudder_tables` (`id`, `ignored`, `name`, `display_name`, `is_metatable`, `read_only`, `soft_delete_field`, `soft_delete_uniques_suffix`, `display_order`, `help_text`) VALUES
(5, 0, 'cat_estados', 'Maestro de Estados', 0, 0, 'deleted', 'code.X', 10, 'Guarda los datos asociados a cada Estado de Venezuela'),
(6, 0, 'cat_municipios', 'Maestro de Municipios', 0, 0, 'deleted', 'code.X', 11, 'Guarda los datos asociados a cada Municipio de Venezuela'),
(7, 0, 'cat_parroquias', 'Maestro de Parroquias', 0, 0, '', '', 12, 'Guarda los datos asociados a cada Parroquia de Venezuela');

